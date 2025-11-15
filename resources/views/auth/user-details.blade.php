<!DOCTYPE html>
<html lang="en">
<head>
    <title>Users Details | {{ $company->name ?? 'Undefined' }}</title>

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
                        <h2>Users Details</h2>
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                                <li class="breadcrumb-item" aria-current="page">Users</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <div class="container">
                <div class="row">                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3 align-items-stretch">
                                    <div class="col-md-10">
                                        <form class="d-flex h-100" method="GET" action="#">
                                            <input type="search" class="form-control mt-2" id="search" name="search" placeholder="Search">
                                            <button type="submit" class="btn btn-success btn-sm w-100 mt-2 text-light" style="max-width: 100px;">                                                
                                                <i class="fa-solid fa-magnifying-glass" style="font-size: 1.5rem;"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="#" target="_blank" class="d-flex h-100">
                                            <button type="button" class="btn btn-primary btn-sm w-100 mt-2">
                                                <i class="fa-solid fa-print" style="font-size: 1.5rem;"></i>
                                            </button>
                                        </a>
                                    </div>
                                </div><hr class="m-0">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Photo</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Role</th>
                                            <th>DOB</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <!-- <th>Actions</th> -->
                                        </tr>
                                    </thead>
                                    <tbody class="allData">
                                        @forelse($users as $user)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">
                                                    @if($user->photo)
                                                        <img src="{{ asset('img/employee/'.$user->photo) }}" alt="Photo" width="50" height="50" class="rounded-circle">
                                                    @else
                                                        <img src="{{ asset('images/default-user.png') }}" alt="Photo" width="50" height="50" class="rounded-circle">
                                                    @endif
                                                </td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->phone ?? '-' }}</td>
                                                <td>
                                                    @if($user->role == 1)
                                                        <span class="badge bg-success">Admin</span>
                                                    @elseif($user->role == 2)
                                                        <span class="badge bg-primary">Manager</span>
                                                    @elseif($user->role == 3)
                                                        <span class="badge bg-warning text-dark">Waiter</span>
                                                    @elseif($user->role == 4)
                                                        <span class="badge bg-info text-dark">Chef</span>
                                                    @else
                                                        <span class="badge bg-secondary">Unknown</span>
                                                    @endif
                                                </td>
                                                <td>{{ $user->dob ?? '-' }}</td>
                                                <td>{{ $user->address ?? '-' }}</td>
                                                <td>
                                                    @if($user->status == 1)
                                                        <a href="{{url('/update-employee-status/'.$user->id)}}"><span class="badge bg-success">Active</span></a>
                                                    @else
                                                        <a href="{{url('/update-employee-status/'.$user->id)}}"><span class="badge bg-danger">Inactive</span></a>
                                                    @endif                                                   
                                                </td>  
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center">No users found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tbody id="content" class="searchData"></tbody>
                                </table>
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

    <script type="text/javascript">
            $(document).ready(function () {
            $('#search').on('keyup', function () {
                let value = $(this).val();

                if (value.trim() !== "") {
                    $('.allData').hide();
                    $('.searchData').show();
                } else {
                    $('.allData').show();
                    $('.searchData').hide();
                }

                $.ajax({
                    type: 'GET',
                    url: '{{ URL::to("live-search-employee") }}',
                    data: { 'search': value },
                    success: function (data) {
                        console.log(data);
                        $('#content').html(data);
                    },
                    error: function (xhr, status, error) {
                        console.error('Search AJAX error:', error);
                    }
                });
            });

            $('form').on('submit', function(e) {
                e.preventDefault();
            });
        });
    </script>
    
</body>
</html>
