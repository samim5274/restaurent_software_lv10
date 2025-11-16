<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Total Sale Report | {{ $company->name ?? 'Undefined' }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 20px;
        }

        h1, h3, h5 {
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .company-info p {
            text-align: center;
            margin: 2px 0;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            font-size: 14px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        th {
            font-weight: bold;
            background: #e9ecef;
        }

        tfoot td {
            font-weight: bold;
        }

        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 100px;
            page-break-inside: avoid;
        }

        .signature-block {
            width: 45%;
            text-align: center;
            border-top: 1px solid #000;
            padding-top: 5px;
            font-weight: bold;
        }

        .note {
            margin-top: 40px;
            font-size: 12px;
            text-align: center;
        }

        @media print {
            a { display: none !important; } /* hide action links */
        }
    </style>
</head>

<body>

    <div class="company-info">
        <h1>{{ $company->name }}</h1>
        <p>{{ $company->address }}</p>
        <p>Mobile: {{ $company->phone }} | Website: {{ $company->website }}</p>
    </div>

    <h3>Date Wise Sale Return Report</h3>
    <h5>Start: {{ $start }} &nbsp; | &nbsp; End: {{ $end }}</h5>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Order ID</th>
                <th>Date</th>
                <th>Total (৳)</th>
                <th>Discount (৳)</th>
                <th>VAT (৳)</th>
                <th>Payable (৳)</th>
                <th>Paid (৳)</th>
                <th>Due (৳)</th>
            </tr>
        </thead>

        <tbody>
            @forelse($orders as $val)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>#ORD-{{ $val->reg }}</td>
                <td>{{ \Carbon\Carbon::parse($val->date)->format('d M, Y') }}</td>
                <td>{{ number_format($val->total, 2) }}</td>
                <td>{{ number_format($val->discount, 2) }}</td>
                <td>{{ number_format($val->vat, 2) }}</td>
                <td>{{ number_format($val->payable ?? 0, 2) }}</td>
                <td>{{ number_format($val->pay ?? 0, 2) }}</td>
                <td>{{ number_format($val->due ?? 0, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="color:red; font-weight:bold;">No Orders Found</td>
            </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr>
                <td colspan="3">Total</td>
                <td>{{ number_format($totalAmount, 2) }}</td>
                <td>{{ number_format($totalDiscount, 2) }}</td>
                <td>{{ number_format($totalVat, 2) }}</td>
                <td>{{ number_format($totalPayable, 2) }}</td>
                <td>{{ number_format($totalPaid, 2) }}</td>
                <td>{{ number_format($totalDue, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="signature-section">
        <div class="signature-block">Manager Signature</div>
        <div class="signature-block">Admin Signature</div>
    </div>

    <p class="note">
        <strong>Note:</strong> Software Developed by <strong>BGMIT</strong>, Created by <strong>SAMIM HOSSEIN</strong>.  
        Call: +8801762164746 — Thank You!
    </p>

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
