<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile | {{ $company->name ?? 'Undefined' }}</title>

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
                        <h2>{{ $user->name }}</h2>
                        <div class="col-md-12">
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
                                <li class="breadcrumb-item" aria-current="page">Profile</li>
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
                                <div class="col-md-4 text-center mb-4 mb-md-0">
                                    <img src="{{ asset('/img/employee/' . $user->photo) }}" 
                                        class="rounded-circle mb-3 shadow" 
                                        width="250" height="250" 
                                        alt="Profile Image"
                                        style="border: 3px solid rgb(61, 255, 93);">
                                        <br><br>

                                    <h5 class="mb-1">{{ $user->name }}</h5>
                                    <p class="mb-1 text-muted">{{ $user->email }}</p>
                                    <p class="mb-1 text-muted">+880 {{ $user->phone }}</p>
                                    <p class="mb-1">
                                        <strong>Role:</strong>
                                        @php
                                            $roles = [1 => 'Admin', 2 => 'Manager', 3 => 'Waiter', 4 => 'Shafe', 5 => 'Other'];
                                        @endphp
                                        {{ $roles[$user->role] ?? 'Unknown' }}
                                    </p>
                                    <p class="mb-1">
                                        <strong>Status:</strong>
                                        @php
                                            $statuses = [
                                                0 => 'Inactive',
                                                1 => 'Active',
                                            ];
                                        @endphp
                                        {{ $statuses[$user->status] ?? 'Unknown' }}
                                    </p>

                                </div>

                                <!-- Right side (Form) -->
                                <div class="col-md-8">
                                    <form action="{{url('/edit-profile/'.$user->id)}}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <div class="form-group">
                                            <label for="name">Full Name</label>
                                            <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email Address</label>
                                            <input type="email" name="email" class="form-control" readonly value="{{ $user->email }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="phone">Phone Number</label>
                                            <input type="text" name="phone" class="form-control" maxlength="10" pattern="\d{11}" value="{{ $user->phone }}" placeholder="Enter 10-digit phone number without zero '0'">
                                        </div>

                                        <div class="form-group">
                                            <label for="dob">Date of Birth</label>
                                            <input type="date" name="dob" class="form-control" value="{{ $user->dob }}">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="photo">Profile Image (Max: 2MB)</label>
                                            <div class="image-upload-wrapper position-relative border rounded p-3 text-center"
                                                id="imageWrapper"
                                                style="cursor: pointer; background-size: cover; background-position: center; background-repeat: no-repeat; height: 200px; width: 200px; margin: auto; border: 2px solid #dee2e6;">
                                                <p id="placeholderText" class="m-0 pt-5 text-muted">Click or Drag & Drop image here</p>
                                                <input type="file" name="photo" id="photoInput" class="d-none" accept="image/*">
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-success btn-sm w-100 d-flex align-items-center justify-content-center" onclick="return confirm('{{ $user->name }} ! Are you sure you want Change your information?')">
                                            <i class="mdi mdi-pencil-box-outline m-0" style="font-size: 1.5rem;"></i> 
                                            <span> <strong>Update</strong></span>
                                        </button>

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
    
    <script>
        const photoInput = document.getElementById('photoInput');
        const wrapper = document.getElementById('imageWrapper');
        const placeholderText = document.getElementById('placeholderText');

        // Click on wrapper opens file input
        wrapper.addEventListener('click', () => {
            photoInput.click();
        });

        // Function to set background image
        function setBackground(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                wrapper.style.backgroundImage = `url(${e.target.result})`;
                placeholderText.style.display = 'none';
            }
            reader.readAsDataURL(file);
        }

        // Preview selected image
        photoInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if(file && file.type.startsWith('image/') && file.size <= 2 * 1024 * 1024) {
                setBackground(file);
            } else if(file) {
                alert("File must be an image and less than 2MB");
                photoInput.value = ""; // reset
            }
        });

        // Drag & Drop
        wrapper.addEventListener('dragover', (e) => {
            e.preventDefault();
            wrapper.style.borderColor = '#0d6efd';
            wrapper.style.backgroundColor = '#e9f5ff';
        });

        wrapper.addEventListener('dragleave', (e) => {
            e.preventDefault();
            wrapper.style.borderColor = '#dee2e6';
            wrapper.style.backgroundColor = '';
        });

        wrapper.addEventListener('drop', (e) => {
            e.preventDefault();
            wrapper.style.borderColor = '#dee2e6';
            wrapper.style.backgroundColor = '';

            const file = e.dataTransfer.files[0];
            if(file && file.type.startsWith('image/') && file.size <= 2 * 1024 * 1024) {
                photoInput.files = e.dataTransfer.files; // set input files
                setBackground(file);
            } else if(file) {
                alert("File must be an image and less than 2MB");
            }
        });
    </script>

</body>
</html>
