<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <title>Order Details | {{ $company->name ?? 'Undefined' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bangla:wght@400;700&display=swap" rel="stylesheet">

    <style>
        :root{
            --accent: #0b5ed7;
            --muted: #6c757d;
            --paper-bg: #ffffff;
            --border: #e6e9ee;
            --text: #222;
            --shadow: 0 2px 6px rgba(11,78,215,0.08);
            --max-width: 900px;
        }

        /* Global */
        html,body{
            margin:0;
            padding:0;
            background: #f5f7fa;
            font-family: 'Noto Sans Bangla', DejaVu Sans, Arial, sans-serif;
            color:var(--text);
            -webkit-font-smoothing:antialiased;
            -moz-osx-font-smoothing:grayscale;
            line-height:1.4; /* Slightly increased for better print spacing */
            font-size: 14px; /* Default body font size */
        }
        .container{
            max-width:var(--max-width);
            margin:18px auto;
            background:var(--paper-bg);
            padding:18px 22px;
            box-shadow:var(--shadow);
            border-radius:6px;
            border:1px solid var(--border);
        }

        /* Header */
        .header{
            display:flex;
            gap:16px;
            align-items:center;
            justify-content:space-between;
            margin-bottom:8px;
            border-bottom: 2px solid var(--accent); /* Added a distinct header line */
            padding-bottom: 10px;
        }
        .brand{
            display:flex;
            gap:14px;
            align-items:center;
        }
        .brand img{
            width:72px; /* Slightly reduced logo size for print formality */
            height:72px;
            object-fit:contain;
            border-radius:4px;
            background:#fff;
            border:1px solid var(--border);
            padding:6px;
        }
        .company-info{
            font-size:13px; /* Smaller font size for print efficiency */
        }
        .company-info h1{
            margin:0;
            font-size:18px; /* Slightly smaller main title */
            letter-spacing:0.4px;
        }
        .company-meta{
            font-size:11px; /* Smaller meta info */
            color:var(--muted);
            margin-top:4px;
        }

        /* Title & meta row */
        .title-row{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:12px;
            margin:14px 0;
            padding-bottom: 4px;
            border-bottom: 1px solid var(--border);
        }
        .title-row h2{
            margin:0;
            font-size:16px; /* Slightly smaller section title */
            color:var(--text); /* Changed to text color for formal print */
        }
        .meta-box{
            text-align:right;
            font-size:12px; /* Smaller font size */
            color:var(--muted);
        }
        .meta-box div{ margin-bottom:4px; }

        /* Table */
        .table-wrap{
            overflow:auto;
            margin-top:6px;
        }
        table{
            width:100%;
            border-collapse:collapse;
            font-size:12px; /* Crucial for fitting data on A4 */
            table-layout:auto; /* Auto better handles dynamic content width */
            word-wrap:break-word;
        }
        thead th{
            text-align:left;
            padding:8px 10px; /* Reduced padding */
            background: #f1f5ff; /* Lighter background */
            border:1px solid #d4d8df; /* Solid border for print clarity */
            font-weight:700;
            color:#222;
            font-size:12px;
        }
        tbody td{
            padding:6px 10px; /* Reduced padding */
            border:1px solid #f0f0f0; /* Faint border */
            vertical-align:middle;
        }
        tbody tr:nth-child(even){ background: #fbfcfe; }
        .text-right{ text-align:right; }
        .text-center{ text-align:center; }
        
        /* Removed badge styling since payment status is not in this table, and badges often print poorly in grayscale */

        /* Summary / totals */
        .totals{
            margin-top:16px;
            display:flex;
            justify-content:flex-end;
        }
        .totals .box{
            width:300px; /* Slightly narrower */
            border:1px solid #d4d8df; /* Solid border */
            border-radius:4px;
            padding:10px 14px;
            background:#fafbfd;
        }
        .totals-row{
            display:flex;
            justify-content:space-between;
            padding:5px 0;
            font-size:13px;
            color:var(--muted);
        }
        .totals-row strong{ color:var(--text); }

        /* Signature */
        .signature-section{
            display:flex;
            justify-content:space-between;
            gap:12px;
            margin-top:60px; /* Increased margin for signature space */
            align-items:flex-end;
            page-break-inside:avoid;
        }
        .signature-block{
            width:40%; /* Slightly smaller width */
            text-align:center;
            padding-top:20px;
            border-top:1px solid #a3a3a3; /* Darker border for print */
            font-weight:600;
            color:var(--muted);
            font-size: 13px;
        }

        .note{
            margin-top:30px; /* Increased margin */
            font-size:10px; /* Smaller font for footer note */
            color:var(--muted);
            border-top:1px solid #e0e0e0; /* Solid border for clearer separation */
            padding-top:8px;
        }

        /* Print friendly - A4 Optimization */
        @media print{
            @page {
                size: A4; /* Explicitly set to A4 */
                margin: 1.5cm; /* Standard print margin */
            }
            html,body{ background:#fff; font-size: 12pt; }
            .container{ box-shadow:none; border: none; max-width:100%; margin:0; padding:0; }
            .header{ border-bottom: 2px solid #333; /* Darker print line */ padding-bottom: 8px;}
            
            /* Text color adjustments for better grayscale print */
            body, h1, h2, th, strong { color: #000 !important; }
            .muted, .company-meta, .meta-box, .totals-row span, .signature-block, .note { color: #444 !important; }

            /* Table print styling */
            thead th{ background: #e0e0e0 !important; border: 1px solid #888 !important; }
            tbody td{ border: 1px solid #ddd !important; padding: 6px 10px !important; }
            tbody tr:nth-child(even){ background: #f7f7f7 !important; }

            /* Totals print styling */
            .totals .box{ border: 1px solid #888 !important; background: #f0f0f0 !important; padding: 8px 12px; }
            
            /* Avoid page break inside elements */
            tr, .signature-section { page-break-inside: avoid; break-inside: avoid; }
            thead { display:table-header-group; }
            tfoot { display:table-footer-group; }

            /* Enforce printing background colors */
            * { -webkit-print-color-adjust: exact !important; color-adjust: exact !important; }
        }

        /* Responsive small screens */
        @media (max-width:640px){
            .title-row{ flex-direction:column; align-items:flex-start; gap:6px; }
            .meta-box{ text-align:left; }
            .totals{ justify-content:flex-start; }
            .totals .box{ width:100%; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="brand">
                @if(!empty($company->logo))
                    <img src="{{ asset($company->logo) }}" alt="logo">
                @else
                    <img src="{{ asset('assets/images/favicon.svg') }}" alt="logo">
                @endif

                <div class="company-info">
                    <h1>{{ $company->name ?? 'Company Name' }}</h1>
                    <div class="company-meta">
                        {{ $company->address ?? 'Company address here' }} <br>
                        Email: {{ $company->email ?? 'info@example.com' }} | Phone: {{ $company->phone ?? 'N/A' }} <br>
                        Website: {{ $company->website ?? 'www.example.com' }}
                    </div>
                </div>
            </div>

            <div class="meta-box">
                <div><strong>Total Orders:</strong> {{ $data->count() }}</div>
                <div><strong>Printed:</strong> {{ \Carbon\Carbon::now()->format('d M Y, h:i A') }}</div>
            </div>
        </div>

        <div class="title-row">
            <h2>Total Order / Due List</h2>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:34px;">#</th>
                        <th style="width:110px;">Date</th>
                        <th style="width:70px;">Reg</th>
                        <th style="width:82px;" class="text-right">Total (৳)</th>
                        <th style="width:82px;" class="text-right">Discount (৳)</th>
                        <th style="width:78px;" class="text-right">VAT (৳)</th>
                        <th style="width:90px;" class="text-right">Payable (৳)</th>
                        <th style="width:82px;" class="text-right">Pay (৳)</th>
                        <th style="width:82px;" class="text-right">Due (৳)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $key => $val)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{$val->date}}</td>
                        <td class="text-center">{{$val->reg}}</td>
                        <td class="text-right">৳{{ number_format($val->total, 2) }}/-</td>
                        <td class="text-right">৳{{ number_format($val->discount, 2) }}/-</td>
                        <td class="text-right">৳{{ number_format($val->vat, 2) }}/-</td>
                        <td class="text-right">৳{{ number_format($val->payable, 2) }}/-</td>
                        <td class="text-right">৳{{ number_format($val->pay, 2) }}/-</td>
                        <td class="text-right">৳{{ number_format($val->due, 2) }}/-</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="totals">
            <div class="box">
                <div class="totals-row"><span>Subtotal</span> <strong>৳ {{ number_format($data->sum('total'),2) }}</strong></div>
                <div class="totals-row"><span>Total Discount</span> <strong>৳ {{ number_format($data->sum('discount'),2) }}</strong></div>
                <div class="totals-row"><span>Total VAT</span> <strong>৳ {{ number_format($data->sum('vat'),2) }}</strong></div>
                <div class="totals-row"><span>Total Payable</span> <strong>৳ {{ number_format($data->sum('payable'),2) }}</strong></div>
                <div class="totals-row"><span>Total Paid</span> <strong>৳ {{ number_format($data->sum('pay'),2) }}</strong></div>
                <div class="totals-row" style="border-top:1px solid #d4d8df; padding-top:8px;">
                    <span style="font-size:14px; color:#222;">Net Due</span>
                    <strong style="font-size:14px; color:#dc3545;">৳ {{ number_format($data->sum('due'),2) }}</strong>
                </div>
            </div>
        </div>

        <div class="signature-section">
            <div class="signature-block">
                Manager Signature
            </div>
            <div class="signature-block">
                Admin Signature
            </div>
        </div>

        <p class="note">
            <small style="color:var(--muted);">This document is computer generated and valid without signature unless otherwise specified.</small>
        </p>
    </div>

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