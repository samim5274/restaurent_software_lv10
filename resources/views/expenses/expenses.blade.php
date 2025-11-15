<!DOCTYPE html>
<html lang="en">
<head>
    <title>Expeses | {{ $company->name ?? 'Undefined' }}</title>

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
                        <h2>Expeses Details</h2>
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                                <li class="breadcrumb-item" aria-current="page">Expeses</li>
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
                                <div class="col-lg-8">
                                    <form action="{{ url('/create-expenses') }}" method="POST">
                                        @csrf

                                        <!-- Expense Title -->
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Expense Title <span class="text-danger">*</span></label>
                                            <input type="text" name="title" id="title" class="form-control form-control-lg" placeholder="Enter expense title" required>
                                        </div>

                                        <div class="row g-3">
                                            <!-- Category -->
                                            <div class="col-md-6">
                                                <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                                <select name="category_id" id="category_id" class="form-select form-select-lg" required>
                                                    <option disabled selected>-- Select Category --</option>
                                                    @foreach($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Subcategory -->
                                            <div class="col-md-6">
                                                <label for="subcategory_id" class="form-label">Subcategory <span class="text-danger">*</span></label>
                                                <select name="subcategory_id" id="subcategory_id" class="form-select form-select-lg" required>
                                                    <option disabled selected>-- Select Subcategory --</option>
                                                    <!-- AJAX loaded -->
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Description -->
                                        <div class="mt-3">
                                            <label for="description" class="form-label">Description (optional)</label>
                                            <textarea name="description" id="description" class="form-control form-control-lg" rows="4" placeholder="Enter expense details"></textarea>
                                        </div>

                                        <div class="row g-3 mt-3 mb-3">
                                            <!-- Amount -->
                                            <div class="col-md-12">
                                                <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                                                <input type="number" step="0.01" name="amount" id="amount" class="form-control form-control-lg" min="1" placeholder="Enter amount" required>
                                            </div>
                                        </div>

                                        

                                        <!-- Submit Button -->
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-success btn-md d-flex align-items-center justify-content-center gap-2">
                                                <i class="mdi mdi-plus-circle-outline" style="font-size: 1.5rem;"></i>
                                                <span>Add Expense</span>
                                            </button>
                                        </div>

                                    </form>
                                </div>

                                <!-- Right side (Form) -->
                                <div class="col-md-4">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered align-middle">
                                            <thead class="table-primary text-center">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Title</th>
                                                    <th>Category</th>
                                                    <th>Subcategory</th>
                                                    <th>Amount</th>
                                                    <th>Expense Date</th>
                                                    <th>Description</th>
                                                    <th>Created By</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($expenses as $key => $val)
                                                <tr>
                                                    <td class="text-center">{{ $key + 1 }}</td>
                                                    <td>{{ $val->title }}</td>
                                                    <td>{{ $val->category->name ?? '-' }}</td>
                                                    <td>{{ $val->subcategory->name ?? '-' }}</td>
                                                    <td class="text-end">{{ number_format($val->amount, 2) }}</td>
                                                    <td class="text-center">{{ \Carbon\Carbon::parse($val->expense_date)->format('d-m-Y') }}</td>
                                                    <td>{{ $val->description ?? '-' }}</td>
                                                    <td>{{ $val->user->name ?? '-' }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ url('/expenses/edit/'.$val->id) }}" class="btn btn-sm btn-warning">
                                                            <i class="mdi mdi-pencil"></i>
                                                        </a>
                                                        <form action="{{ url('/expenses/delete/'.$val->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger">
                                                                <i class="mdi mdi-delete"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="9" class="text-center text-danger">No expenses found.</td>
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
        $(document).ready(function() {
            $('#category_id').on('change', function() {
                var categoryId = $(this).val();
                if(categoryId) {
                    $.ajax({
                        url: '/get-subcategories/' + categoryId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#subcategory_id').empty();
                            $('#subcategory_id').append('<option value="">-- Select Subcategory --</option>');
                            $.each(data, function(key, value) {
                                $('#subcategory_id').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                            });
                        }
                    });
                } else {
                    $('#subcategory_id').empty();
                    $('#subcategory_id').append('<option value="">-- Select Subcategory --</option>');
                }
            });
        });
    </script>

</body>
</html>
