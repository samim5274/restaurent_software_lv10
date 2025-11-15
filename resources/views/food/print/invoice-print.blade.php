<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $company->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: 80mm auto;
            margin: 0;
        }

        body {
            font-family: 'Consolas', 'Courier New', monospace;
            font-size: 10px;
            width: 70mm;
            margin: 0 auto;
            line-height: 1.3;
        }

        .invoice-header {
            text-align: center;
            padding: 5px 0;
            border-bottom: 1px dashed #000;
            margin-bottom: 8px;
        }

        .invoice-header h2 {
            font-size: 14px;
            margin: 2px 0;
            text-transform: uppercase;
        }

        .invoice-header p {
            margin: 0;
            font-size: 9px;
        }

        .invoice-header .order-title {
            font-size: 11px;
            font-weight: bold;
            margin-top: 5px;
        }

        .invoice-subheader {
            margin-bottom: 8px;
            font-size: 10px;
        }

        .invoice-subheader .info-line {
            display: flex;
            justify-content: space-between;
            margin: 1px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            /* Adjusted Font Size */
            font-size: 9.5px; 
        }

        table th, table td {
            padding: 2px 0;
            border: none;
            text-align: right;
            white-space: pre-wrap;
        }

        table thead {
            border-bottom: 1px dashed #000;
        }

        /* Optimized Column Widths */
        table th:nth-child(1), table td:nth-child(1) { width: 5%; text-align: left; }
        table th:nth-child(2), table td:nth-child(2) { width: 40%; text-align: left; } /* Reduced */
        table th:nth-child(3), table td:nth-child(3) { width: 10%; text-align: right; }
        table th:nth-child(4), table td:nth-child(4) { width: 20%; text-align: right; }
        table th:nth-child(5), table td:nth-child(5) { width: 25%; text-align: right; } /* Increased for 'Total' */

        /* -------- Totals Section -------- */
        .totals-table {
            width: 100%;
            border-collapse: collapse;
            /* Adjusted Font Size */
            font-size: 9.5px; 
            margin-bottom: 10px;
        }

        .totals-table tr td {
            padding: 2px 0;
        }

        .totals-table td:first-child {
            text-align: left;
            width: 50%;
        }

        .totals-table td:last-child {
            text-align: right;
            width: 50%;
        }

        .separator {
            border-top: 1px dashed #000;
        }

        .final-total {
            font-weight: bold;
            font-size: 11px;
        }

        .note {
            text-align: center;
            margin-top: 5px;
            font-size: 9px;
            color: #000;
            padding-top: 5px;
        }
    </style>
</head>
<body>

    <div class="invoice-header">
        <h2>{{ $company->name }}</h2>
        <p>{{ $company->address }}</p>
        <p>{{ $company->email }} || {{ $company->phone }}</p>
        <p class="order-title">INVOICE</p>
    </div>

    <div class="invoice-subheader">
        <div class="info-line">
            <span><strong>Bill Officer:</strong> {{ $order->user->name }} </span>
            <span><strong>Customer:</strong> {{ $order->customerName }}</span>
        </div>
        <div class="info-line">
            <span><strong>C.Phone:</strong> {{ $order->customerPhone }}</span>
            <span><strong>Date:</strong> {{ $order->created_at->format('d-m-Y') }}</span>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Item</th>
                <th>Qty</th>
                <th>৳/Unit</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart as $key => $val)
            <tr>
                <td>{{ $loop->iteration }}.</td>
                <td>{{ $val->food->name }}</td>
                <td>{{ $val->quantity }}</td>
                <td>{{ number_format($val->price, 2) }}</td>
                <td>{{ number_format($val->price * $val->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals-table">
        <tr class="separator">
            <td>Subtotal:</td>
            <td>৳{{ number_format($order->total, 2) }}</td>
        </tr>
        <tr>
            <td>Discount:</td>
            <td>- ৳{{ number_format($order->discount, 2) }}</td>
        </tr>
        <tr>
            <td>VAT:</td>
            <td>+ ৳{{ number_format($order->vat, 2) }}</td>
        </tr>
        <tr class="separator final-total">
            <td>Payable:</td>
            <td>৳{{ number_format($order->payable, 2) }}</td>
        </tr>
        <tr>
            <td>Paid:</td>
            <td>৳{{ number_format(($order->pay ?? 0) + ($dueCollection->pay ?? 0), 2) }}</td>
        </tr>
        <tr>
            <td class="final-total">Due:</td>
            <td class="final-total">৳{{ number_format(($order->due ?? 0) - ($dueCollection->pay ?? 0) - ($dueCollection->discount ?? 0), 2) }}</td>
        </tr>
    </table>

    <p class="note">Developed by <strong>SAMIM-HosseN</strong> || +8801762164746</p>

    <script>
        window.onload = function() {
            window.print();
            setTimeout(() => {
                window.close();
            }, 300);
        };
    </script>
</body>
</html>