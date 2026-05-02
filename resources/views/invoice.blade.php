
<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; font-size: 12px; line-height: 1.4; }
        .container { width: 100%; padding: 10px; }
        
        h2 { font-size: 28px; margin-bottom: 5px; color: #000; }
        h3 { font-size: 18px; margin: 0; }
        h4 { font-size: 14px; border-bottom: 1px solid #eee; padding-bottom: 5px; margin-top: 20px; }
        p { margin: 2px 0; }
        
        .w-100 { width: 100%; }
        .no-border td { border: none; }
        .header-table td { vertical-align: top; }
        
        .address-box { background-color: #f8f9fa; padding: 15px; border-radius: 4px; }
        
        .items-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .items-table th { background-color: #444; color: #fff; padding: 10px; text-align: left; text-transform: uppercase; font-size: 10px; }
        .items-table td { padding: 10px; border-bottom: 1px solid #eee; }
        
        .totals-table { width: 40%; margin-left: auto; margin-top: 20px; }
        .totals-table td { padding: 5px; }
        .grand-total { font-size: 18px; font-weight: bold; border-top: 2px solid #eee; padding-top: 10px; }
        
        .right { text-align: right; }
        .text-muted { color: #777; font-size: 11px; }
    </style>
</head>
<body>

<div class="container">

    <table class="w-100 no-border header-table">
        <tr>
            <td style="width: 50%;">
                <h2>Invoice</h2>
                <p><strong>Invoice#:</strong> {{ $invoice->invoice_number }}</p>
                <p><strong>Invoice Date:</strong> {{ $invoice->invoice_date }}</p>
                <p><strong>Due Date:</strong> {{ $invoice->due_date }}</p>
            </td>
            <td class="right" style="width: 50%;">
                <h3 style="text-transform: uppercase; letter-spacing: 2px;">{{ $invoice->company->name }}</h3>
            </td>
        </tr>
    </table>

    <br>

    <table class="w-100 no-border" style="border-spacing: 15px 0;">
        <tr>
            <td class="address-box" style="width: 50%; vertical-align: top;">
                <strong style="color: #666;">Billed by</strong><br>
                <p><strong>{{ $invoice->company->name }}</strong></p>
                <p>{{ $invoice->company->address }}</p>
                <p><strong>GSTIN:</strong> {{ $invoice->company->gstin }}</p>
                <p><strong>PAN:</strong> {{ $invoice->company->pan }}</p>
            </td>
            <td class="address-box" style="width: 50%; vertical-align: top;">
                <strong style="color: #666;">Billed to</strong><br>
                <p><strong>{{ $invoice->customer->name }}</strong></p>
                <p>{{ $invoice->customer->address }}</p>
                <p><strong>GSTIN:</strong> {{ $invoice->customer->gstin }}</p>
                <p><strong>PAN:</strong> {{ $invoice->customer->pan }}</p>
            </td>
        </tr>
    </table>

    <table class="w-100 no-border" style="margin-top: 10px; font-size: 11px;">
        <tr>
            <td class="right">Place of Supply: <strong>{{ $invoice->company->place }}</strong></td>
            <td class="right" style="width: 150px;">Country of Supply: <strong>{{ $invoice->company->country }}</strong></td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th>Item # / Description</th>
                <th class="right">Qty</th>
                <th class="right">GST</th>
                <th class="right">Taxable</th>
                <th class="right">SGST</th>
                <th class="right">CGST</th>
                <th class="right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}. {{ $item->item_name }}</td>
                <td class="right">{{ $item->quantity }}</td>
                <td class="right">{{ $item->gst_rate }}%</td>
                <td class="right">{{ number_format($item->taxable_amount, 2) }}</td>
                <td class="right">{{ number_format($item->sgst, 2) }}</td>
                <td class="right">{{ number_format($item->cgst, 2) }}</td>
                <td class="right"><strong>{{ number_format($item->total, 2) }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="w-100 no-border">
        <tr>
            <td style="width: 50%; vertical-align: top;">
                <h4>Bank & Payment Details</h4>
                <p class="text-muted">Account Holder: {{ $invoice->company->name }}</p>
                <p class="text-muted">Bank Name: {{ $invoice->company->bankDetails->bank_name }}</p>
                <p class="text-muted">A/C: {{ $invoice->company->bankDetails->account_number }}</p>
                <p class="text-muted">IFSC: {{ $invoice->company->bankDetails->ifsc_code }}</p>
                <p class="text-muted">UPI ID: invoicedemo@ybl</p>
            </td>
            <td style="width: 50%;">
                <table class="totals-table w-100">
                    <tr>
                        <td>Sub Total</td>
                        <td class="right">{{ number_format($invoice->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Discount</td>
                        <td class="right">- {{ number_format($invoice->discount_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td>SGST</td>
                        <td class="right">{{ number_format($invoice->total_sgst, 2) }}</td>
                    </tr>
                    <tr>
                        <td>CGST</td>
                        <td class="right">{{ number_format($invoice->total_cgst, 2) }}</td>
                    </tr>
                    <tr class="grand-total">
                        <td>Total</td>
                        <td class="right">{{ number_format($invoice->grand_total, 2) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div style="margin-top: 20px;">
        <p class="text-muted">Invoice Total (in words):</p>
        <p><strong>{{ amount_in_words($invoice->grand_total) }} Only</strong></p>
    </div>

    <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 10px;">
        <p class="text-muted"><strong>Terms and Conditions:</strong> 1. Late payment interest applicable. 2. Mention invoice number while paying.</p>
    </div>

</div>

</body>
</html>