<!DOCTYPE html>
<html lang="en">
<head>
    <title>Food Details | {{ $company->name ?? 'Undefined' }}</title>

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
                                <li class="breadcrumb-item" aria-current="page">Foods</li>
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
                        
                @if($foods)
                @foreach($foods as $val)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4 allData">
                    <div class="card h-100 shadow-sm rounded-3">
                        <!-- Image -->
                        <a href="{{ url('/specific-food-view/'.$val->id) }}" class="d-block">
                            <img src="{{ asset('img/food/' . $val->image) }}" class="card-img-top img-fluid" alt="{{ $val->name }}">
                        </a>

                        <!-- Card Body -->
                        <div class="card-body d-flex flex-column">
                            <!-- Food Name -->
                            <h5 class="card-title mb-1 text-truncate">
                                <a href="{{ url('/specific-food-view/'.$val->id) }}" class="text-dark text-decoration-none">
                                    {{ $val->name }}
                                </a>
                            </h5>

                            <!-- Price -->
                            <p class="text-success fw-bold mb-2">৳{{ $val->price }}/-</p>

                            <!-- Ingredients -->
                            <p class="card-text text-muted small mb-3 text-truncate">
                                Ingredients: {{ $val->ingredients }}
                            </p>

                            <!-- Buttons -->
                            <div class="mt-auto d-grid gap-2">
                                <a href="{{ url('/add-to-cart/'.$val->id) }}" class="btn btn-outline-success btn-sm d-flex align-items-center justify-content-center gap-1">
                                    <i class="fa-solid fa-cart-plus"></i> Add Cart
                                </a>
                                <!-- <a href="{{ url('/add-to-cart-ajax/'.$val->id) }}" class="btn btn-outline-warning btn-sm d-flex align-items-center justify-content-center gap-1 addCartBtn" data-url="{{ url('add-to-cart-ajax/'.$val->id)}}">
                                    <i class="fa-solid fa-cart-plus"></i> Ajax
                                </a> -->
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
                <div class="row searchData" id="content"></div>
                <div class="d-flex justify-content-end mt-3">
                    <div class="d-flex justify-content-end mt-3">
                        {{$foods->onEachSide(1)->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <!-- Template Scripts -->
    <script>layout_change('light');</script>
    <script>change_box_container('false');</script>
    <script>layout_rtl_change('false');</script>
    <script>preset_change("preset-1");</script>
    <script>font_change("Public-Sans");</script>

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
                url: '{{URL::to("live-search-food-menu")}}',
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

        // $(document).on('click', '.addCartBtn', function(e) {
        //     e.preventDefault(); 

        //     let url = $(this).data('url');

        //     $.ajax({
        //         type: 'GET',
        //         url: url,
        //         success: function(response) {
        //             console.log(response);
        //             if (response.status === 'success') {
        //                 console.log('Success: ' + response.message); 
        //             } else if (response.status === 'error') {
        //                 alert('Error: ' + response.message);
        //             }
        //         },
        //         error: function(xhr) {
        //             console.log(xhr.responseText);
        //         }
        //     });
        // });

    </script>
</body>
</html>
