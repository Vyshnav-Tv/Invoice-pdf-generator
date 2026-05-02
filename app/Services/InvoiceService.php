<?php

namespace App\Services;
use App\Http\Requests\InvoiceRequest;
use App\Models\INVOICE;
use App\Models\INVOICE_ITEMS;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;


class InvoiceService
{

    public function create_Invoice(InvoiceRequest $request)
    {
        try {
            $sub_total = 0;
            $total_cgst = 0;
            $total_sgst = 0;

            $due_date = $request->due_date;

            foreach ($request->items as $item) {

                $item_total = $item['quantity'] * $item['price'];
                $sub_total += $item_total;
            }

            $discount_amount = $request->discount_amount ?? 0;
            $taxable_amount = $sub_total - $discount_amount;


            $invoice = INVOICE::create([
                'user_id' => auth()->id(),
                'invoice_number' => 'INV-' . strtoupper(Str::random(6)),
                'invoice_date' => now(),
                'due_date'=>$due_date?? now()->addDays(7),
                'customer_id' => $request->customer_id,
                'company_id' => $request->company_id,
                'subtotal' => $sub_total,
                'discount_amount' => $discount_amount,
                'taxable_amount' => $taxable_amount,
                'total_cgst' => 0,
                'total_sgst' => 0,
                'grand_total' => 0,
            ]);
            foreach ($request->items as $item) {
                $item_total = $item['quantity'] * $item['price'];
                $item_taxable_amount = $item_total - ($discount_amount * ($item_total / $sub_total));
                $cgst = $item_taxable_amount * ($item['gst_rate'] / 100) / 2;
                $sgst = $item_taxable_amount * ($item['gst_rate'] / 100) / 2;
                $total= $item_taxable_amount + $cgst + $sgst;

                $total_cgst += $cgst;
                $total_sgst += $sgst;

                INVOICE_ITEMS::create([
                    'invoice_id' => $invoice->id,
                    'item_name' => $item['item_name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'gst_rate' => $item['gst_rate'],
                    'taxable_amount' => $item_taxable_amount,
                    'cgst' => $cgst,
                    'sgst' => $sgst,
                    'total' => $total
                ]);
            }


            $grand_total = $taxable_amount + $total_cgst + $total_sgst;

            $invoice->update([
                'total_cgst' => $total_cgst,
                'total_sgst' => $total_sgst,
                'grand_total'=> $grand_total
            ]);

            $invoice->refresh();

            return
                response()->json([
                    'success' => true,
                    'message' => 'Invoice created successfully',
                    'invoice_id'=> $invoice->id
                ]);
        } 
        catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create invoice: ' . $e->getMessage()
            ]);
        }
    }


    public function download_Pdf($id)
    {
        $invoice = Invoice::with(['items','customer','company'])->find($id);
        
        $pdf = Pdf::loadView('invoice', compact('invoice'));

        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }
}