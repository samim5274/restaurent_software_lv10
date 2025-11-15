<!DOCTYPE html>
<html lang="en">
<head>
    <title>Kitchen Details | {{ $company->name ?? 'Undefined' }}</title>

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
                                <li class="breadcrumb-item"><a href="{{url('/foods')}}">Foods</a></li>
                                <li class="breadcrumb-item"><a href="{{url('/cart')}}">Cart</a></li>
                                <li class="breadcrumb-item" aria-current="page">Kitchen</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-lg-12 col-md-6">                    
                    <div class="row g-3">
                        <div class="container mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5>Kitchen Order Details</h5>
                                <h5 class="m-0 text-primary">
                                    <a href="{{ route('print-total-daily-order') }}" target="_blank"><i class="fa-solid fa-print"></i> Print </a>
                                </h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover" id="printableTable">
                                    <thead class="table-primary sticky-top">
                                        <tr>
                                            <th class="text-center" style="width: 5%;">#</th>
                                            <th style="width: 25%;">Order ID</th>
                                            <th class="text-center" style="width: 25%;">Status</th>
                                            <th class="text-center" style="width: 15%;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order as $key => $val)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="fw-bold">
                                                <a href="{{ url('/order-item/'. $val->reg) }}" class="text-primary text-decoration-none">ORD-{{$val->reg}}</a>
                                            </td> 
                                            <td class="text-center">
                                                @php
                                                    switch ($val->kitchen) {
                                                        case 0: $status = '<span class="badge bg-secondary">Pending</span>'; break;
                                                        case 1: $status = '<span class="badge bg-warning text-dark">Preparing</span>'; break;
                                                        case 2: $status = '<span class="badge bg-info text-dark">Ready</span>'; break;
                                                        case 3: $status = '<span class="badge bg-success">Served</span>'; break;
                                                        default: $status = '<span class="badge bg-dark">Unknown</span>';
                                                    }
                                                @endphp

                                                <p >{!! $status !!}</p>
                                            </td>                                           
                                            <td class="text-center">                                                  
                                                <button class="btn btn-outline-primary btn-sm" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#exampleModal{{ $val->id }}">
                                                    <i class="fa-solid fa-utensils"></i>
                                                </button>  
                                                <a href="{{ url('/order-invoice-print/'.$val->reg) }}" target="_blank" 
                                                class="btn btn-sm btn-outline-primary me-2" title="Print Invoice">
                                                    <i class="fa-solid fa-print"></i>
                                                </a>                                            
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <div class="d-flex justify-content-end mt-3">
                                    {{$order->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal -->
            @if($order)
            @foreach($order as $key => $val)
            <div class="modal fade" id="exampleModal{{ $val->id }}" tabindex="-1" aria-labelledby="exampleModalLabel{{ $val->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <form action="{{ route('update-kitchen-status', $val->reg) }}" method="POST">
                            @csrf

                            <div class="modal-header">
                                <h5 class="modal-title">Reg: ORD-{{ $val->reg }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <h4 class="mb-4 text-dark">Order Status: 
                                    <span class="text-primary">ORD-{{ $val->reg }}</span>
                                </h4>

                                <div class="form-group row align-items-center mb-3">
                                    <label class="col-sm-3 col-form-label">Status:</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="cbxStatus">
                                            <option disabled selected>-- Select Status --</option>
                                            <option value="0" {{ $val->status == 0 ? 'selected' : '' }}>Pending</option>
                                            <option value="1" {{ $val->status == 1 ? 'selected' : '' }}>Preparing</option>
                                            <option value="2" {{ $val->status == 2 ? 'selected' : '' }}>Ready</option>
                                            <option value="3" {{ $val->status == 3 ? 'selected' : '' }}>Served</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    Close
                                </button>

                                <button type="submit" class="btn btn-success"
                                    onclick="return confirm('Are you sure you want to change this order status?')">
                                    Update
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            @endforeach
            @endif
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
