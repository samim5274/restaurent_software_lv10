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
                                <li class="breadcrumb-item"><a href="{{url('/foods')}}">Foods</a></li>
                                <li class="breadcrumb-item" aria-current="page">Create-Foods</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->
             
            <!-- [ Main Content ] start -->
            <div class="table-responsive">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5>Order Details</h5>
                    <h5 class="m-0 text-primary">
                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#food"><i class="fa-solid fa-circle-plus"></i> Add </button>
                    </h5>
                </div>
                <!-- Table Container with Scroll -->
                <div class="table-responsive" style="max-height: 750px; overflow-y: auto;">
                    <table class="table table-bordered table-hover align-middle shadow-sm mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-center" width="50">SL</th>
                                <th width="120">Image</th>
                                <th>Name</th>
                                <th width="120">Price</th>
                                <th width="120">Stock</th>
                                <th width="280">Ingredients</th>
                                <th width="80" class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody id="food_table_body">
                            @if($foods)
                                @foreach($foods as $key => $val)
                                <tr>
                                    <td class="text-center fw-bold">{{ $key+1 }}</td>

                                    <td>
                                        <a href="{{ url('/specific-food-view/'.$val->id) }}">
                                            <img src="{{ asset('img/food/' . $val->image) }}" 
                                                width="70" height="55" 
                                                style="object-fit: cover; border-radius: 6px;">
                                        </a>
                                    </td>

                                    <td class="fw-bold">
                                        <a href="{{ url('/specific-food-view/'.$val->id) }}" 
                                        class="text-decoration-none text-dark">
                                        {{ $val->name }}
                                        </a>
                                    </td>

                                    <td class="text-success fw-bold fs-6">
                                        ৳{{ $val->price }}/-
                                    </td>

                                    <td class="fw-bold text-primary">
                                        {{ $val->stock }}
                                    </td>

                                    <td>
                                        <span class="text-muted small d-inline-block text-truncate" 
                                            style="max-width: 260px;">
                                            {{ $val->ingredients }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#food{{ $val->id }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>

    <!-- Edit Modal -->
    @if($foods)
        @foreach($foods as $val)
        <div class="modal fade" id="food{{$val->id}}" tabindex="-1" aria-labelledby="editFoodLabel{{$val->id}}" aria-hidden="true">
            <div class="modal-dialog modal-lg"> <!-- Larger modal -->
                <div class="modal-content">
                    <form action="{{ url('/update-food/'.$val->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title" id="editFoodLabel{{$val->id}}">
                                Edit Food - <small>{{ $val->sku }}</small>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <!-- Food Name -->
                            <div class="form-group row mb-3">
                                <label class="col-sm-3 col-form-label">Food Name</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="txtFoodName" value="{{ $val->name }}" required>
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="form-group row mb-3">
                                <label class="col-sm-3 col-form-label">Price</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="txtPrice" value="{{ $val->price }}" required>
                                </div>
                            </div>

                            <!-- Category -->
                            <div class="form-group row mb-3">
                                <label class="col-sm-3 col-form-label">Category</label>
                                <div class="col-sm-9">
                                    <select name="txtCategory" required class="form-control">
                                        <option disabled>-- Select Category --</option>
                                        @foreach($categorys as $cat)
                                            <option value="{{ $cat->id }}" {{ $val->category_id == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Stock -->
                            <div class="form-group row mb-3">
                                <label class="col-sm-3 col-form-label">Stock</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="txtStock" value="{{ $val->stock }}" required min="0">
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="form-group row mb-3">
                                <label class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9 d-flex">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="txtStatus" value="1" {{ $val->status == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label">Active</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="txtStatus" value="2" {{ $val->status == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label">De-active</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Description / Remark -->
                            <div class="form-group row mb-3">
                                <label class="col-sm-3 col-form-label">Remarks</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="remark" rows="3">{{ $val->remark }}</textarea>
                                </div>
                            </div>

                            <!-- Ingredients -->
                            <div class="form-group row mb-3">
                                <label class="col-sm-3 col-form-label">Ingredients</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="txtIngredients" value="{{ $val->ingredients }}" required>
                                </div>
                            </div>

                            <!-- Image Upload -->
                            <div class="form-group row mb-3">
                                <label class="col-sm-3 col-form-label">Food Image</label>
                                <div class="col-sm-9">
                                    <div id="editUploadArea{{$val->id}}" class="border p-3 rounded text-center" style="cursor:pointer;">
                                        <p class="mb-1 text-muted">Click or Drop Image Here</p>
                                        <img id="editPreviewImage{{$val->id}}" class="img-fluid mt-2" style="max-height:150px;" src="{{ asset('img/food/'.$val->image) }}">
                                    </div>
                                    <input type="file" name="image" id="editImageInput{{$val->id}}" class="d-none" accept="image/*">
                                </div>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure you want to update this food item?')">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Image Preview Script for this Modal -->
        <script>
            const editUploadArea{{$val->id}} = document.getElementById("editUploadArea{{$val->id}}");
            const editImageInput{{$val->id}} = document.getElementById("editImageInput{{$val->id}}");
            const editPreviewImage{{$val->id}} = document.getElementById("editPreviewImage{{$val->id}}");

            editUploadArea{{$val->id}}.addEventListener("click", () => editImageInput{{$val->id}}.click());

            editImageInput{{$val->id}}.addEventListener("change", () => {
                const file = editImageInput{{$val->id}}.files[0];
                if(file){
                    const reader = new FileReader();
                    reader.onload = e => editPreviewImage{{$val->id}}.src = e.target.result;
                    reader.readAsDataURL(file);
                }
            });
        </script>
        @endforeach
    @endif



    <!-- Create Modal -->
    <div class="modal fade" id="food" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg"> <!-- modal-lg = width increased -->
            <div class="modal-content">

                <form action="{{ url('/create-new-food') }}" method="POST" enctype="multipart/form-data" class="forms-sample">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Food</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <!-- Food Name -->
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label">Food Name</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="txtFoodName" required placeholder="Food name">
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label">Price</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="txtPrice" required placeholder="Price">
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label">Category</label>
                            <div class="col-sm-9">
                                <select name="cbxCategory" required class="form-control">
                                    <option disabled selected>-- Select Category --</option>
                                    @foreach($categorys as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Stock -->
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label">Stock</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" name="txtStock" required placeholder="Stock Quantity">
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label">Status</label>
                            <div class="col-sm-9 d-flex">
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="radio" name="txtStatus" checked value="1">
                                    <label class="form-check-label">Active</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="txtStatus" value="2">
                                    <label class="form-check-label">De-active</label>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label">Description</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="remark" rows="3" placeholder="Description"></textarea>
                            </div>
                        </div>

                        <!-- Ingredients -->
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label">Ingredients</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="txtIngredients" required placeholder="Ingredients (comma separated)">
                            </div>
                        </div>

                        <!-- Image Upload -->
                        <div class="form-group row mb-3">
                            <label class="col-sm-3 col-form-label">
                                Food Image <small class="text-muted">(max 5MB)</small>
                            </label>

                            <div class="col-sm-9">
                                <div id="uploadArea" class="border p-3 rounded text-center" style="cursor:pointer;">
                                    <p class="mb-1 text-muted">Click or Drop Image Here</p>
                                    <img id="previewImage" class="img-fluid mt-2 d-none" style="max-height:150px;">
                                </div>

                                <input type="file" name="image" id="imageInput" class="d-none" accept="image/*">
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success w-25"
                            onclick="return confirm('Are you sure you want to create this product?')">
                            Save
                        </button>
                    </div>

                </form>

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

    <script>
        // image preview js code
        const uploadArea = document.getElementById("uploadArea");
        const imageInput = document.getElementById("imageInput");
        const previewImage = document.getElementById("previewImage");

        uploadArea.addEventListener("click", () => imageInput.click());

        imageInput.addEventListener("change", () => {
            const file = imageInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => {
                    previewImage.src = e.target.result;
                    previewImage.classList.remove("d-none");
                };
                reader.readAsDataURL(file);
            }
        });
    </script>


</body>
</html>
