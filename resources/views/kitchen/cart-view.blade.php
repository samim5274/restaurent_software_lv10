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
                <div class="col-12">
                    <div class="row g-4" id="printableTable">

                        @if($food->count())
                            @foreach($food as $key => $val)
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                <div class="card h-100 border-0 shadow-sm rounded-3">
                                    <div class="card-body p-4">

                                        {{-- Header: Name + Index --}}
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h5 class="fw-bold text-primary m-0">{{ $val->food->name }}</h5>
                                            <span class=" text-secondary px-3 py-2">
                                                #{{ $key + 1 }}
                                            </span>
                                        </div>

                                        {{-- Price --}}
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Price per item</small>
                                            <strong class="fs-5 text-dark">৳{{ number_format($val->price, 2) }}</strong>
                                        </div>

                                        {{-- Quantity --}}
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <small class="text-muted">Quantity:</small>
                                            <span class="badge bg-primary rounded-pill px-3 py-2">
                                                {{ $val->quantity }} Pcs
                                            </span>
                                        </div>

                                        <hr>

                                        {{-- Total --}}
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-muted">Total:</span>
                                            <h5 class="fw-bold text-primary">
                                                ৳{{ number_format($val->price * $val->quantity, 2) }}
                                            </h5>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            @endforeach

                        @else
                            <div class="col-12 text-center py-5">
                                <i class="mdi mdi-cart-outline display-3 text-muted mb-3"></i>
                                <p class="fs-5 text-muted">No items in your cart.</p>
                            </div>
                        @endif

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
