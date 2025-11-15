<!DOCTYPE html>
<html lang="en">
<head>
    <title>Expeses-Setting | {{ $company->name ?? 'Undefined' }}</title>

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
                        <h2>Expeses Setting</h2>
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{url('/expenses')}}">Expeses</a></li>
                                <li class="breadcrumb-item" aria-current="page">Expeses-Setting</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
            <div class="row">                    
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-body">                                
                            <div class="row">
                                <!-- Left side (Profile Info) -->
                                <div class="col-lg-6">
                                     <form action="{{ url('/create-expenses-category') }}" method="POST">
                                        @csrf

                                        <!-- Category Name -->
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name" class="form-control form-control-lg" placeholder="Enter category name" required>                                            
                                        </div>

                                        <!-- Description (Optional) -->
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description (Optional)</label>
                                            <textarea name="description" id="description" class="form-control form-control-lg" rows="6" placeholder="Enter description">N/A</textarea>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-success  d-flex align-items-center justify-content-center gap-2">
                                                <i class="mdi mdi-plus-circle-outline" style="font-size: 1.5rem;"></i>
                                                <span>Add Category</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Right side (Form) -->
                                <div class="col-md-6">
                                    <div style="max-height: 400px; overflow-y: auto;">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                @forelse($categories as $key => $val)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex flex-column gap-2 p-3 border rounded shadow-sm">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <strong>#{{ $key + 1 }} - {{ $val->name }}</strong>
                                                            </div>
                                                            @if($val->description)
                                                            <div class="mt-1">
                                                                <em class="text-muted small">Description: {{ $val->description }}</em>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td class="text-center text-danger py-3">No expenses found.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- End inner row -->
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">                    
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-body">                                
                            <div class="row">
                                <!-- Left side (Profile Info) -->
                                <div class="col-md-6">
                                    <div style="max-height: 400px; overflow-y: auto;">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                @forelse($subCategory as $key => $val)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex flex-column gap-2 p-3 border rounded shadow-sm">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <strong>#{{ $key + 1 }} - {{ $val->name }}</strong>
                                                                <span>{{ $val->category->name }}</span>
                                                            </div>
                                                            @if($val->description)
                                                            <div class="mt-1">
                                                                <em class="text-muted small">Description: {{ $val->description }}</em>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td class="text-center text-danger py-3">No expenses found.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Right side (Form) -->
                                
                                <div class="col-lg-6">
                                     <form action="{{ url('/create-sub-category-expenses') }}" method="POST">
                                        @csrf

                                        <!-- Sub Category Name -->
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Sub-Category Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" id="name" class="form-control form-control-lg" placeholder="Enter category name" required>                                            
                                        </div>

                                        <!-- Category Name -->
                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                            <select name="category_id" id="category_id" class="form-select form-select-lg" required>
                                                <option disabled selected>-- Select Category --</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>                                            
                                        </div>

                                        <!-- Description (Optional) -->
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description (Optional)</label>
                                            <textarea name="description" id="description" class="form-control form-control-lg" rows="4" placeholder="Enter description">N/A</textarea>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-success  d-flex align-items-center justify-content-center gap-2">
                                                <i class="mdi mdi-plus-circle-outline" style="font-size: 1.5rem;"></i>
                                                <span>Add Category</span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div> <!-- End inner row -->
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
