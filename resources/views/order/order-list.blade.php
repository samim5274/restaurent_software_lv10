<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Details | {{ $company->name ?? 'Undefined' }}</title>

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
                                <li class="breadcrumb-item" aria-current="page">Order-list</li>
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
                                <h5>Order Details</h5>
                                <h5 class="m-0 text-primary">
                                    <a href="{{ route('print-total-daily-order') }}" target="_blank"><i class="fa-solid fa-print"></i> Print </a>
                                </h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover" id="printableTable">
                                    <thead class="table-primary sticky-top">
                                        <tr>
                                            <th class="text-center" style="width: 5%;">#</th>
                                            <th class="text-center" style="width: 10%;">Date</th>
                                            <th style="width: 40%;">C. Name</th>
                                            <th style="width: 25%;">Order ID</th>
                                            <th class="text-center" style="width: 10%;">Status</th>
                                            <th class="text-center" style="width: 15%;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order as $key => $val)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $val->date }}</td>
                                            <td>
                                                <a href="{{ url('/order-item/'. $val->reg) }}" class="text-primary text-decoration-none">{{ $val->customerName == '0' ? 'N/A' : $val->customerName }}</a>
                                            </td>
                                            <td class="fw-bold">
                                                <a href="{{ url('/order-item/'. $val->reg) }}" class="text-primary text-decoration-none">ORD-{{$val->reg}}</a>
                                            </td>
                                            <td class="text-center">
                                                @if($val->status == 1)
                                                    <span class="badge rounded-pill bg-success fw-normal px-2 py-1">Paid</span>
                                                @else
                                                    <span class="badge rounded-pill bg-danger fw-normal px-2 py-1" 
                                                        data-bs-toggle="modal" data-bs-target="#due{{$val->id}}" 
                                                        style="cursor: pointer;">Due</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ url('/order-invoice-print/'.$val->reg) }}" target="_blank" 
                                                class="btn btn-sm btn-outline-primary me-2" title="Print Invoice">
                                                    <i class="fa-solid fa-print"></i>
                                                </a>
                                                
                                                <a href="{{ url('/edit/cart/'.$val->reg) }}" class="btn btn-sm btn-outline-primary me-2" title="Share or View Details">
                                                    <i class="fa-solid fa-pen-to-square"></i>
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
        </div>
    </div>

    <!-- Modal -->
    @foreach($order as $key => $val)
    <div class="modal fade" id="due{{$val->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{url('/due-collection/'.$val->reg)}}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ORD-{{$val->reg}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label for="num1{{$val->id}}" class="col-sm-3 col-form-label">Total Amount:</label>
                            <div class="col-sm-9">
                                <!-- Hidden total input -->
                                <input type="text" class="form-control" id="num1{{$val->id}}" name="txtDue" hidden readonly value="{{ $val->due }}">
                                <!-- Display total as styled text -->
                                <h1 class="display-4 text-danger">৳{{ $val->due }}/-</h1>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="num3{{$val->id}}" class="col-sm-3 col-form-label">Discount:</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="num3{{$val->id}}" name="txtDiscount" value="0" placeholder="Discount" onkeyup="calculateAmount({{$val->id}})" onchange="calculateAmount({{$val->id}})">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="num2{{$val->id}}" class="col-sm-3 col-form-label">Pay:</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="num2{{$val->id}}" name="txtPay" placeholder="Pay" onkeyup="calculateAmount({{$val->id}})" onchange="calculateAmount({{$val->id}})">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="num2" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <p id="result{{$val->id}}" class="display-6 text-danger">Amount (৳): 00/-</p>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btnSave{{$val->id}}" onclick="return confirm('Are you sure you want to collect this due?')">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

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
    <script src="{{ asset('./js/due.js') }}"></script>
    
</body>
</html>
