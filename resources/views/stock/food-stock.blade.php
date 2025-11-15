<!DOCTYPE html>
<html lang="en">
<head>
    <title>Stock Details | {{ $company->name ?? 'Undefined' }}</title>

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
        
    <!-- Ajax google cdn for live search -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
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
                                <li class="breadcrumb-item" aria-current="page">Stock <i class="fa-solid fa-arrow-right-long"></i> <small>50 (min)</small></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
             
            <!-- [ Main Content ] start -->
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card mt-2">
                        <div class="card-body"> 
                            <h4 class="card-title mb-0">Search Food</h4>
                            <div class="py-2">
                                <form action="#" method="GET">
                                    <input type="search" name="search" id="search" class="form-control" placeholder="Search by food name or category or food ID or sku">
                                </form>
                            </div>
                        </div> 
                    </div>
                </div>
                        
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Stck</th>
                                        <th>Ingredients</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody class="allData">
                                @if($foods)
                                @foreach($foods as $key => $val)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>

                                        <!-- Food Image -->
                                        <td>
                                            <img src="{{ asset('img/food/' . $val->image) }}"
                                                alt="food-img"
                                                width="60" height="45"
                                                style="object-fit: cover; border-radius: 5px;">
                                        </td>

                                        <!-- Food Name -->
                                        <td class="fw-bold">
                                            <a href="{{ url('/specific-food-view/'.$val->id) }}"
                                            class="text-dark text-decoration-none">
                                            {{ $val->name }} - <small>{{ $val->sku }}</small>
                                            </a>
                                        </td>

                                        <!-- Price -->
                                        <td class="text-success fw-bold">
                                            ৳{{ $val->price }}
                                        </td>

                                        <!-- Stock -->
                                        <td class="text-success fw-bold">
                                            {{ $val->stock }}
                                        </td>

                                        <!-- Ingredients -->
                                        <td style="max-width: 220px;">
                                            <span class="text-muted small d-inline-block text-truncate"
                                                style="max-width: 220px;">
                                                {{ $val->ingredients }}
                                            </span>
                                        </td>

                                        <!-- Action Button -->
                                        <td>
                                            <p class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#stock{{$val->id}}">
                                            <i class="fa-solid fa-pen-to-square"></i> View
                                            </p>
                                        </td>
                                    </tr>
                                @endforeach
                                @endif
                                </tbody>
                                <!-- Search Results -->
                                <tbody class="searchData" id="content"></tbody>
                            </table>
                        </div>
                    </div>

                <div class="d-flex justify-content-end mt-3">
                    <div class="d-flex justify-content-end mt-3">
                        {{$foods->onEachSide(1)->links()}}
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->
    @if($foods)
    @foreach($foods as $key => $val)
    <div class="modal fade" id="stock{{$val->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ url('/insert/stock') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Stock - <small>{{ $val->sku }}</small></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="">                                
                                <!-- Display total as styled text -->
                                <h1 class="display-4 text-primary">{{ $val->name }}</h1>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="num2{{$val->id}}" class="col-sm-3 col-form-label">Pay:</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="txtStock" placeholder="Stock" required min="1">
                                <input type="hidden" value="{{ $val->id }}" name="txtFoodId" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btnSave{{$val->id}}" onclick="return confirm('Are you sure you want {{ $val->name }} insert stock?')">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
    @endif

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Page Specific JS -->
    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/dashboard-default.js') }}"></script>

    <!-- Required JS -->
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>


    <script type="text/javascript">        
        //https://www.youtube.com/watch?v=BL0v0pduwPo live search
        $('#search').on('keyup', function() {
            $value = $(this).val(); 
            if($value) {
                $('.allData').hide();
                $('.searchData').show();
            } else {
                $('.allData').show();
                $('.searchData').hide();
            }
            $.ajax({
                type:'get',
                url: '{{URL::to("live-search-food-stock")}}',
                data:{'search':$value},

                success:function(data) {
                    console.log(data);
                    $('#content').html(data);
                },
                error: function(xhr, status, error) {
                    console.error('Search AJAX error:', error);
                }
            });
        });


    </script>
</body>
</html>
