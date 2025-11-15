<!DOCTYPE html>
<html lang="en">
<head>
    <title>Expense Invoice | {{ $company->name }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Arial", sans-serif;
    }

    body {
        background: #f5f5f5;
        display: flex;
        justify-content: center; /* horizontal center */
        align-items: flex-start; /* top position */
        min-height: 100vh;
        padding-top: 20px; /* top margin */
    }

    /* Invoice container - Half page */
    .invoice-container {
        width: 50%; /* half width */
        background: #fff;
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        padding: 25px 30px;
    }

    /* Header */
    .header {
        text-align: center;
        margin-bottom: 15px;
    }

    .header h2 {
        font-size: 24px;
        font-weight: bold;
    }

    .header p {
        font-size: 13px;
        color: #555;
    }

    /* Invoice Title */
    .inv-title {
        text-align: center;
        background: #f1f1f1;
        padding: 10px;
        font-weight: bold;
        margin-bottom: 18px;
        border-radius: 4px;
        letter-spacing: 1px;
    }

    /* Table */
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 15px;
    }

    td {
        padding: 8px 6px;
    }

    .label {
        font-weight: bold;
        width: 35%;
        color: #333;
    }

    .value {
        width: 65%;
        color: #444;
    }

    /* Box around table */
    .box {
        border: 1px solid #eee;
        border-radius: 4px;
        background: #fafafa;
        padding: 12px;
        margin-bottom: 15px;
    }

    /* Signature */
    .signature {
        display: flex;
        justify-content: flex-end;
        margin-top: 25px;
    }

    .signature div {
        border-top: 1px solid #000;
        width: 180px;
        text-align: center;
        font-size: 13px;
        padding-top: 5px;
    }

    /* Footer */
    .footer {
        text-align: center;
        margin-top: 20px;
        font-size: 13px;
        color: #666;
        border-top: 1px dashed #ccc;
        padding-top: 10px;
    }

    /* Print adjustments */
    @media print {
        body {
            background: #fff;
            justify-content: center;
            align-items: flex-start;
            padding-top: 0;
        }

        .invoice-container {
            box-shadow: none;
            border: none;
            margin: auto;
        }
    }

</style>
</head>

<body>
<div class="invoice-container">

    <!-- Company Header -->
    <div class="header">
        <h2>{{ $company->name }}</h2>
        <p>{{ $company->address }}<br>Phone: {{ $company->phone }}</p>
    </div>

    <!-- Invoice Title -->
    <div class="inv-title">EXPENSE INVOICE</div>

    <!-- Expense Details -->
    <div class="box">
        <table>
            <tr>
                <td class="label">Invoice No:</td>
                <td class="value">EXP-{{ str_pad($expenses->id, 6, '0', STR_PAD_LEFT) }}</td>
            </tr>
            <tr>
                <td class="label">Title:</td>
                <td class="value">{{ $expenses->title }}</td>
            </tr>
            <tr>
                <td class="label">Category:</td>
                <td class="value">{{ $expenses->category->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Subcategory:</td>
                <td class="value">{{ $expenses->subcategory->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Amount:</td>
                <td class="value"><strong>{{ number_format($expenses->amount, 2) }} Tk</strong></td>
            </tr>
            <tr>
                <td class="label">Date:</td>
                <td class="value">{{ \Carbon\Carbon::parse($expenses->expense_date)->format('d M, Y') }}</td>
            </tr>
            <tr>
                <td class="label">Added By:</td>
                <td class="value">{{ $expenses->user->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Description:</td>
                <td class="value">{{ $expenses->description ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <!-- Signature -->
    <div class="signature">
        <div>Authorized Signature</div>
    </div>

    <!-- Footer -->
    <div class="footer">
        Powered by <strong>SAMIM HOSSEn</strong> • Call: +8801762164746
    </div>

</div>

<script>
    window.onload = function() {
        window.print();
        setTimeout(() => { window.close(); }, 400);
    };
</script>

</body>
</html>
