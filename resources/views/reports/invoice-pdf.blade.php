<!DOCTYPE html>
<html>
<head>
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; color: #333; }
        .header h1 { margin: 0; font-size: 24px; color: #047857; }
        .header p { margin: 2px 0; }
        .invoice-details table { width: 100%; margin-bottom: 20px; }
        .items-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .items-table th, .items-table td { border: 1px solid #ddd; padding: 8px; }
        .items-table th { background-color: #f7f7f7; text-align: left; }
        .totals { float: right; width: 40%; margin-top: 20px; }
        .totals table { width: 100%; }
        .totals td { padding: 5px 0; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .uppercase { text-transform: uppercase; }
        .gray-text { color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $schoolSettings['school_name'] ?? 'GreenField High School' }}</h1>
        <p>{{ $schoolSettings['school_address'] ?? '123 Education Way, Ikeja, Lagos' }}</p>
        <p>{{ $schoolSettings['school_email'] ?? 'info@school.com' }}</p>
    </div>

    <hr style="margin-top: 20px; margin-bottom: 20px;">

    <div class="invoice-details">
        <table>
            <tr>
                <td style="width: 50%;">
                    <h4 class="font-bold">Bill To:</h4>
                    <p class="font-bold">{{ $invoice->student->user->name }}</p>
                    <p class="gray-text">Parent: {{ $invoice->student->parents->first()->name ?? 'N/A' }}</p>
                    <p class="gray-text">Class: {{ $invoice->student->schoolClass->name }} {{ $invoice->student->classArm->name }}</p>
                </td>
                <td style="width: 50%;" class="text-right">
                    <h2 class="font-bold uppercase gray-text">Invoice</h2>
                    <p><strong class="gray-text">#</strong> {{ $invoice->invoice_number }}</p>
                    <p><strong class="gray-text">Date:</strong> {{ $invoice->created_at->format('M d, Y') }}</p>
                    <p><strong class="gray-text">Due:</strong> {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</p>
                    <p><strong class="gray-text">Term:</strong> {{ $invoice->term->name }}</p>
                </td>
            </tr>
        </table>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th>Item Description</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->items as $item)
            <tr>
                <td>{{ $item->item_name }}</td>
                <td class="text-right">₦{{ number_format($item->amount, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td class="gray-text">Subtotal:</td>
                <td class="text-right">₦{{ number_format($invoice->total_amount, 2) }}</td>
            </tr>
            <tr>
                <td class="gray-text">Amount Paid:</td>
                <td class="text-right">- ₦{{ number_format($invoice->amount_paid, 2) }}</td>
            </tr>
            <tr>
                <td class="font-bold">Balance Due:</td>
                <td class="font-bold text-right">₦{{ number_format($invoice->total_amount - $invoice->amount_paid, 2) }}</td>
            </tr>
        </table>
    </div>
</body>
</html>