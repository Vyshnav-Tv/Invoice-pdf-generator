<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 100%; padding: 20px; }
        .flex { display:inline-block; justify-content: space-between; }
        .box { border: 1px solid #ddd; padding: 10px; width: 48%; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: center; }
        .right { text-align: right; }
    </style>
</head>
<body>

<div class="container">

    <h2>Invoice</h2>

    <div class="flex">
        <div>
            <p><strong>Invoice#:</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>Invoice Date:</strong> {{ $invoice->invoice_date }}</p>
            <p><strong>Due Date:</strong> {{ $invoice->due_date }}</p>
        </div>
        <div>
            <h3>Invoice Labs</h3>
        </div>
    </div>

    <div class="flex">
        <div class="box">
            <strong>Billed By</strong>
            <p>{{ $invoice->company->name }}</p>
            <p>{{ $invoice->company->address }}</p>
            <p>GSTIN: {{ $invoice->company->gstin }}</p>
            <p>PAN: {{ $invoice->company->pan }}</p>
        </div>

        <div class="box">
            <strong>Billed To</strong>
            <p>{{ $invoice->customer->name }}</p>
            <p>{{ $invoice->customer->address }}</p>
            <p>GSTIN: {{ $invoice->customer->gstin }}</p>
            <p>PAN: {{ $invoice->customer->pan }}</p>
        </div>
    </div>

    <p><strong>Place of Supply:</strong> {{ $invoice->company->place }}</p>
    <p><strong>Country of Supply:</strong> {{ $invoice->company->country }}</p>

    <!-- ITEMS TABLE -->
    <table>
        <thead>
            <tr>
                <th>item-no:</th>
                <th>item_name</th>
                <th>Qty</th>
                <th>GST</th>
                <th>Taxable</th>
                <th>SGST</th>
                <th>CGST</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->item_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->gst_rate }}%</td>
                <td> {{ $item->taxable_amount }}</td>
                <td> {{ $item->sgst }}</td>
                <td> {{ $item->cgst }}</td>
                <td>{{ $item->total }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="right">
        <p>Sub Total:  {{ $invoice->subtotal }}</p>
        <p>Discount:  {{ $invoice->discount_amount}}</p>
        <p>Taxable Amount: {{ $invoice->taxable_amount }}</p>
        <p>CGST:  {{ $invoice->total_cgst }}</p>
        <p>SGST:  {{ $invoice->total_sgst }}</p>
        <h3>Total: {{ $invoice->grand_total }}</h3>
        <p><strong> Invoice Total(In Words:)</strong> {{ amount_in_words($invoice->grand_total) }}</p>
    </div>


    <h4>Bank & Payment Details</h4>
    <p>Account Holder:{{ $invoice->company->name }}</p>
    <p>Bank Name: {{ $invoice->company->bankDetails->bank_name }}</p>
    <p>Account Number: {{ $invoice->company->bankDetails->account_number }}</p>
    <p>IFSC Code: {{ $invoice->company->bankDetails->ifsc_code }}</p>
    <p>Account Type: {{ $invoice->company->bankDetails->account_type }}</p>
    <p>UPI: invoicedemo@ybl</p>

  
    <h4>Terms and Conditions</h4>
    <p>1. Late payment interest applicable.</p>
    <p>2. Mention invoice number while paying.</p>

  
    <h4>Additional Notes</h4>
    <p>invoicedemo@gmail.com</p>

</div>

</body>
</html>