<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Cart | {{ $company->name ?? 'Undefined' }}</title>

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
             
            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-lg-8 col-md-6">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card mt-2">
                            <div class="card-body"> 
                                <div class="py-2">
                                    <form action="{{url('/edit/cart/update')}}" method="post">
                                        @csrf
                                        <input type="hidden" readonly name="reg" value="{{ $cart[0]->reg }}">
                                        <input type="search" name="search" id="search" class="form-control" placeholder="Search by food name or category or food ID or sku">
                                    </form>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="row g-3">
                        @if($cart)
                        @foreach($cart as $key => $val)
                        <div class="col-lg-4 col-md-6 mt-3">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="mb-0 text-primary">{{ $val->food->name }}</h5>
                                        <span class="badge bg-light text-dark">#{{ $key + 1 }}</span>
                                    </div>

                                    <div class="mb-2">
                                        <small class="text-muted">Price per item:</small><br>
                                        <strong class="text-dark" data-price="{{ $val->price }}">৳{{ number_format($val->price, 2) }}</strong>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <small class="text-muted">Quantity:</small>
                                        <div class="input-group input-group-sm" style="width: 120px;">
                                            <button type="button" 
                                                    class="btn btn-outline-secondary btn-minus"
                                                    data-id="{{ $val->id }}">−</button>

                                            <input type="number"
                                                class="form-control text-center qty-input"
                                                value="{{ $val->quantity }}"
                                                min="1"
                                                name="txtStock"                                                    
                                                data-id="{{ $val->id }}">

                                            <button type="button" 
                                                    class="btn btn-outline-secondary btn-plus"
                                                    data-id="{{ $val->id }}">+</button>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="text-muted">Total:</div>
                                        <h6 class="mb-0 text-primary">
                                            <span class="item-subtotal">৳{{ number_format($val->price * $val->quantity, 2) }}</span>
                                        </h6>
                                    </div>
                                </div>

                                <div class="card-footer bg-white border-0 d-flex justify-content-end">
                                    <a href="{{url('/remove-to-cart/'.$val->foodId.'/'.$val->reg)}}"><button class="btn btn-sm btn-outline-danger remove-item-link" title="Remove item"><i class="fa-solid fa-trash"></i></button></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="col-12 text-center py-4 text-muted">
                            <i class="mdi mdi-cart-outline display-4 d-block mb-2"></i>
                            <p class="mb-0">No items in your cart.</p>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mt-2">
                    <div class="card mt-2">
                        <div class="card-body p-2 p-md-4">
                            <form action="{{ url('/modify/order') }}" method="POST" id="myForm">
                                @csrf
                                <div class="card-body p-3 p-md-4">
                                    <input type="hidden" id="cart-total-input" name="txtSubTotal" 
                                        value="{{ $cart->sum(fn($i) => $i->price * $i->quantity) }}">
                                    <input type="text" class="form-control mb-2" hidden value="{{ $cart[0]->reg }}" name="txtInvoice">
                                    <h4>INV-{{ $cart[0]->reg }} <small>(Modify)</small></h4>
                                    <hr>
                                    <h4>Location</h4>
                                    <p><i class="mdi mdi-map-marker"></i>{{$company->address}}</p>
                                    <hr>
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <p class="m-0">Total</p>
                                        <h5 class="card-title m-0">৳<span id="cart-total">{{ number_format($cart->sum(fn($i) => $i->price * $i->quantity), 0) }}</span>/-</h5>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="m-0">VAT %</h5>
                                        <h5 class="card-title m-0">৳<span id="vat-amount">{{ $order->vat }}</span>/-</h5>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="m-0">Discount</h5>
                                        <h5 class="card-title m-0">৳<span id="discount-amount">{{ $order->discount }}</span>/-</h5>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="m-0">Pay</h5>
                                        <h5 class="card-title m-0">৳<span id="discount-amount">{{ $order->pay }}</span>/-</h5>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="m-0">Subtotal ({{ $count }} items)</h5>
                                        <h5 class="card-title m-0">৳<span id="cart-subtotal">{{ number_format($cart->sum(fn($i) => $i->price * $i->quantity), 0) }}</span>/-</h5>
                                    </div>
                                    <!-- payment section -->

                                    <div class="form-group row">
                                        <label for="num4" class="col-sm-3 col-form-label">VAT (%) :</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" id="num4" name="txtVAT" value="0" placeholder="VAT" onkeyup="calculateAmount()" onchange="calculateAmount()" min="0">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="num3" class="col-sm-3 col-form-label">Discount:</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" id="num3" name="txtDiscount" value="{{ $order->discount }}" placeholder="Discount" onkeyup="calculateAmount()" onchange="calculateAmount()" min="0">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="paymentMethods" class="col-sm-3 col-form-label">Payment:</label>
                                        <div class="col-sm-9">
                                            <select name="paymentMethods" id="paymentMethods" class="col-sm-3 form-control">
                                                <option disabled>-- Select Payment Method --</option>
                                                @foreach($payMathod as $val)
                                                <option value="{{$val->id}}">{{ $val->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="num2" class="col-sm-3 col-form-label">Pay:</label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control" id="num2" name="txtPay" placeholder="Pay" onkeyup="calculateAmount()" onchange="calculateAmount()" min="0" required>
                                        </div>
                                    </div><hr>

                                    <div id="customer-info" style="display: none; margin-top: 10px;">
                                        <label for="customerName">Customer Name:</label>
                                        <input type="text" name="txtCustomerName" id="customerName" value="Samim Hossain" placeholder="Enter Name" class="form-control mb-2">

                                        <label for="customerPhone">Customer Phone:</label>
                                        <input type="text" name="txtCustomerPhone" id="customerPhone" value="01762164746" placeholder="Enter Phone" class="form-control">
                                    </div>

                                    <br>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label"></label>
                                        <div class="col-sm-9">
                                            <p id="result" class="display-6 text-danger">Amount: {{ $order->total - $order->pay}}/-</p>
                                        </div>
                                    </div>

                                    

                                    <button type="submit" id="confirmBtn" class="btn btn-outline-success w-100">
                                        <span id="btnText">
                                            <h4 class="m-0">Confirm</h4>
                                        </span>
                                    </button>
                                </div>
                            </form> 
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

    <script src="{{ asset('/js/cart.js') }}"></script>
    <script src="{{ asset('/js/orderPayment.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            if (searchInput) {
                searchInput.focus();
            }
        });
        @if(session('success'))
            const reg = "{{ session('reg') }}";
            const printUrl = `{{ url('/order-invoice-print') }}/${reg}`;
            window.open(printUrl, '_blank');
        @endif
    </script>


</body>
</html>
