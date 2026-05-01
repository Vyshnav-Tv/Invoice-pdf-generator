<?php

namespace App\Services;
use App\Http\Requests\InvoiceRequest;
use App\Models\INVOICE;
use App\Models\INVOICE_ITEMS;
use Illuminate\Support\Str;


class InvoiceService
{

    public function create_Invoice(InvoiceRequest $request)
    {
        try {
            $sub_total = 0;
            $total_cgst = 0;
            $total_sgst = 0;

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

                INVOICE_ITEMS::create([
                    'invoice_id' => $invoice->id,
                    'item_name' => $item['item_name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'gst_rate' => $item['gst_rate'],
                    'cgst' => $cgst,
                    'sgst' => $sgst,
                    'total' => $item_total
                ]);
            }

            $grand_total = $taxable_amount + $total_cgst + $total_sgst;

            $invoice->update([
                'total_cgst' => $total_cgst,
                'total_sgst' => $total_sgst,
                'grand_total' => $grand_total
            ]);

            return
                response()->json([
                    'success' => true,
                    'message' => 'Invoice created successfully'
                ]);
        } 
        catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create invoice: ' . $e->getMessage()
            ]);
        }
    }
}