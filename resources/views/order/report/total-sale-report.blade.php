<!DOCTYPE html>
<html lang="en">
<head>
    <title>Total Sale Report | {{ $company->name ?? 'Undefined' }}</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="#">
    <meta name="keywords" content="#">
    <meta name="author" content="#">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/favicon.svg') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
          id="main-font-link">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
    <!-- Pre-loader -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    @include('layouts.menu')

    <!-- Header -->
    @include('home')

    <!-- Main Content -->
    <div class="pc-container">
        <div class="pc-content">
           @include('layouts.message')
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <h2>Date Wise Total Sale Report</h2>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{url('/order-details')}}">Order</a></li>
                                <li class="breadcrumb-item" aria-current="page">Reports</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- filter section start -->
            <div class="row ">
                <div class="col-lg-12 col-md-6">

                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('filter-total-sale') }}" target="_blank" method="GET" class="row g-3 align-items-end">

                                <!-- Start Date -->
                                <div class="col-md-6">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control" required>
                                </div>

                                <!-- End Date -->
                                <div class="col-md-6">
                                    <label for="end_date">End Date</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control" required>
                                </div>

                                <!-- Filter Button -->
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fa-solid fa-filter"></i> Filter
                                    </button>
                                </div>

                                <!-- Print Button -->
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-outline-secondary w-100" value="1" name="print">
                                        <i class="fa-solid fa-print"></i> Print
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>

            <!-- filter section end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-lg-12 col-md-6">                    
                    <div class="g-3">  
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-primary text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>Order ID</th>
                                        <th>Order Date</th>
                                        <th class="text-end">Total (৳)</th>
                                        <th class="text-end">Discount (৳)</th>
                                        <th class="text-end">VAT (৳)</th>
                                        <th class="text-end">Payable (৳)</th>
                                        <th class="text-end">Paid (৳)</th>
                                        <th class="text-end">Due (৳)</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $val)                                        
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center"><a href="{{ url('/order-item/'. $val->reg) }}">#ORD-{{ $val->reg }}</a></td>
                                            <td class="text-center">{{ \Carbon\Carbon::parse($val->date)->format('d M, Y') }}</td>
                                            <td class="text-end">৳{{ number_format($val->total, 2) }}</td>
                                            <td class="text-end">৳{{ number_format($val->discount, 2) }}</td>
                                            <td class="text-end">৳{{ number_format($val->vat, 2) }}</td>
                                            <td class="text-end">৳{{ number_format($val->payable ?? 0, 2) }}</td>
                                            <td class="text-end">৳{{ number_format($val->pay ?? 0, 2) }}</td>
                                            <td class="text-end">৳{{ number_format($val->due ?? 0, 2) }}</td>
                                            <td class="text-center">
                                                <a href="{{ url('/order-invoice-print/'.$val->reg) }}" target="_blank" class="text-primary mb-1">
                                                    <i class="fa-solid fa-print"></i> 
                                                </a>                                                
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-danger py-3">No orders found.</td>
                                        </tr>
                                    @endforelse

                                    <tr>
                                        <td colspan="3" class="text-center fw-bold">Total</td>
                                        <td class="text-end fw-bold">৳{{ number_format($totalAmount, 2) }}</td>
                                        <td class="text-end fw-bold">৳{{ number_format($totalDiscount, 2) }}</td>
                                        <td class="text-end fw-bold">৳{{ number_format($totalVat, 2) }}</td>
                                        <td class="text-end fw-bold">৳{{ number_format($totalPayable, 2) }}</td>
                                        <td class="text-end fw-bold">৳{{ number_format($totalPaid, 2) }}</td>
                                        <td class="text-end fw-bold">৳{{ number_format($totalDue, 2) }}</td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Required JS -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>        
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let today = new Date().toISOString().split('T')[0];

            // Set default value to today
            document.getElementById("start_date").value = today;
            document.getElementById("end_date").value = today;

            // Disable future dates
            document.getElementById("start_date").setAttribute("max", today);
            document.getElementById("end_date").setAttribute("max", today);
        });
    </script>
</body>
</html>
