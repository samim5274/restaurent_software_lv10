<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cart | {{ $company->name ?? 'Undefined' }}</title>

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
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{url('/kitchen')}}">Kitchen</a></li>
                                <li class="breadcrumb-item" aria-current="page">Cart <span> - INV-{{ $food[0]->reg }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-lg-9 col-md-6">
                    <div class="row g-4" id="printableTable">
                        @if($food->count())
                            @foreach($food as $key => $val)
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="card h-100 border-0 shadow">
                                    <div class="card-body p-4">

                                        <!-- Header -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="fw-bold text-primary m-0">{{ $val->food->name }}</h5>
                                            <span class="badge bg-light text-dark shadow-sm px-3 py-2 border">
                                                #{{ $key + 1 }}
                                            </span>
                                        </div>

                                        <!-- Price -->
                                        <div class="mb-4">
                                            <small class="text-muted">Price per Item</small>
                                            <h4 class="fw-semibold mt-1">
                                                ৳{{ number_format($val->price, 2) }}
                                            </h4>
                                        </div>

                                        <!-- Quantity -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span class="text-muted">Quantity</span>
                                            <span class="badge bg-primary rounded-pill px-3 py-2 fs-6 shadow-sm">
                                                {{ $val->quantity }} Pcs
                                            </span>
                                        </div>

                                        <hr class="my-3">

                                        <!-- Total -->
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-semibold text-muted">Total</span>
                                            <h4 class="fw-bold text-success m-0">
                                                ৳{{ number_format($val->price * $val->quantity, 2) }}
                                            </h4>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            @endforeach

                        @else
                            <!-- No data -->
                            <div class="col-12 text-center py-5">
                                <i class="mdi mdi-cart-outline display-3 text-muted mb-3"></i>
                                <p class="fs-5 text-muted">No items in your cart.</p>
                            </div>
                        @endif

                    </div>

                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow border-0">
                        <div class="card-body p-4">

                            <!-- Invoice Header -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h4 class="fw-bold mb-0">#INV-{{ $order->reg }}</h4>
                                <span class="text-muted">
                                    <i class="mdi mdi-map-marker-outline"></i> {{ $company->address }}
                                </span>
                            </div>

                            <hr>

                            <!-- Summary Section -->
                            <h5 class="fw-bold text-secondary mb-3">Order Summary</h5>

                            <div class="summary-item d-flex justify-content-between align-items-center mb-2">
                                <span>Total</span>
                                <span class="fw-semibold">৳{{ number_format($order->total,2) }}/-</span>
                            </div>

                            <div class="summary-item d-flex justify-content-between align-items-center mb-2">
                                <span>VAT</span>
                                <span class="fw-semibold">৳{{ number_format($order->vat,2) }}/-</span>
                            </div>

                            <div class="summary-item d-flex justify-content-between align-items-center mb-2">
                                <span>Discount</span>
                                <span class="fw-semibold text-danger">৳{{ number_format($order->discount,2) }}/-</span>
                            </div>

                            <hr>

                            <div class="summary-item d-flex justify-content-between align-items-center mb-2">
                                <span>Subtotal</span>
                                <span class="fw-bold">৳{{ number_format($order->payable,2) }}/-</span>
                            </div>

                            <div class="summary-item d-flex justify-content-between align-items-center mb-2">
                                <span>Paid</span>
                                <span class="fw-bold text-success">৳{{ number_format($order->pay,2) }}/-</span>
                            </div>

                            <div class="summary-item d-flex justify-content-between align-items-center mb-3">
                                <span>Due</span>
                                <span class="fw-bold text-danger">৳{{ number_format($order->due,2) }}/-</span>
                            </div>

                            <!-- Due Collection Section -->
                            @if($dueCollection)
                                <hr>
                                <h5 class="fw-bold text-secondary mb-2">Due Collection</h5>

                                @foreach($dueCollection as $val)
                                    <div class="summary-item d-flex justify-content-between align-items-center mb-2">
                                        <span>Collected</span>
                                        <span class="fw-semibold">৳{{ number_format($val->pay,2) }}</span>
                                    </div>

                                    <div class="summary-item d-flex justify-content-between align-items-center mb-2">
                                        <span>Due Discount</span>
                                        <span class="fw-semibold text-danger">৳{{ number_format($val->discount,2) }}</span>
                                    </div>

                                    <div class="summary-item d-flex justify-content-between align-items-center mb-3">
                                        <span>Remaining Due</span>
                                        <span class="fw-bold text-danger">৳{{ number_format($val->due,2) }}</span>
                                    </div>
                                @endforeach
                            @endif
                            
                            <hr>

                            <!-- Payment & Customer Info -->
                            <h5 class="fw-bold text-secondary mb-3">Payment & Customer Info</h5>

                            <div class="info-item d-flex justify-content-between align-items-center mb-2">
                                <span>Payment Method</span>
                                <span class="fw-semibold">{{ $order->payment->name }}</span>
                            </div>

                            <div class="info-item d-flex justify-content-between align-items-center mb-2">
                                <span>Customer Name</span>
                                <span class="fw-semibold">{{ $order->customerName == '0' ? 'N/A' : $order->customerName }}</span>
                            </div>

                            <div class="info-item d-flex justify-content-between align-items-center mb-2">
                                <span>Customer Phone</span>
                                <span class="fw-semibold">+880 {{ $order->customerPhone == '0'  ? 'N/A' : $order->customerPhone }}</span>
                            </div>

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

</body>
</html>
