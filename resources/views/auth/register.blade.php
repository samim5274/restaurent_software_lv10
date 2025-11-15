<!DOCTYPE html>
<html lang="en">
  <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Restaurant Manager</title>
      <!-- plugins:css -->
      <link rel="stylesheet" href="/dash/assets/vendors/mdi/css/materialdesignicons.min.css">
      <link rel="stylesheet" href="/dash/assets/vendors/flag-icon-css/css/flag-icon.min.css">
      <link rel="stylesheet" href="/dash/assets/vendors/css/vendor.bundle.base.css">
      <!-- endinject -->
      <!-- Plugin css for this page -->
      <link rel="stylesheet" href="/dash/assets/vendors/font-awesome/css/font-awesome.min.css" />
      <link rel="stylesheet" href="/dash/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
      <!-- End plugin css for this page -->
      <!-- inject:css -->
      <!-- endinject -->
      <!-- Layout styles -->
      <link rel="stylesheet" href="/dash/assets/css/style.css">
      <!-- End layout styles -->
      <link rel="shortcut icon" href="/dash/assets/images/favicon.png" />
  </head>
<body>


    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left p-5">
                <div class="brand-logo">
                  <img src="/dash/assets/images/logo-dark.svg">
                </div>
                @include('dashboard.message.message')
                <h4>New here?</h4>
                <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
                <h4 class="m-4 text-center display-5 text-primary"><i class="mdi mdi-account-circle m-2"></i> Register New User</h4><hr>
                <form action="{{url('/new-user')}}" method="POST">
                    @csrf                    
                    <div class="mb-3">
                        <label for="txtName" class="form-label">Full Name</label>
                        <input class="form-control" id="txtName" placeholder="Enter your full name" type="text" name="txtName" required>
                    </div>

                    <div class="mb-3">
                        <label for="txtEmail" class="form-label">Email Address</label>
                        <input class="form-control" id="txtEmail" placeholder="Enter your email" type="email" name="txtEmail" required>
                    </div>

                    <div class="mb-3">
                        <label for="dtpDob" class="form-label">Date of Birth</label>
                        <input class="form-control" id="dtpDob" type="date" name="dtpDob" required>
                    </div>

                    <div class="mb-3">
                        <label for="txtPassword" class="form-label">Password</label>
                        <input class="form-control" id="txtPassword" placeholder="Enter your password" type="password" name="txtPassword" required>
                    </div>

                    <div class="mb-3">
                        <label for="txtConfirmPassword" class="form-label">Retype Password</label>
                        <input class="form-control" id="txtConfirmPassword" placeholder="Retype your password" type="password" required>
                        <div id="matchMessage" class="form-text"></div>
                    </div>

                    <div class="mb-3">
                        <label for="txtPhone" class="form-label">Phone Number</label>
                        <input class="form-control" id="txtPhone" placeholder="Enter your phone" type="number" name="txtPhone" required>
                    </div>

                    <div class="mb-3">
                        <label for="txtAddress" class="form-label">Address</label>
                        <input class="form-control" id="txtAddress" placeholder="Enter your address" type="text" name="txtAddress" required>
                    </div>

                    <div class="mb-4">
                        <label for="cbxRole" class="form-label">Select Role</label>
                        <select name="cbxRole" id="cbxRole" class="form-control" required>
                            <option selected disabled>-- Select Role --</option>
                            <option value="1">Admin</option>
                            <option value="2">Manager</option>
                            <option value="3">Waiter</option>
                            <option value="4">Shafe</option>
                            <option value="5">Other</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="mdi mdi-marker-check me-1"></i> Register
                    </button>
                </form>
                </div>
                  <div class="text-center mt-4 font-weight-light"> Already have an account? <a href="{{url('/login')}}" class="text-primary">Login</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>

    <!-- plugins:js -->
    <script src="/dash/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="/dash/assets/vendors/chart.js/Chart.min.js"></script>
    <script src="/dash/assets/vendors/jquery-circle-progress/js/circle-progress.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="/dash/assets/js/off-canvas.js"></script>
    <script src="/dash/assets/js/hoverable-collapse.js"></script>
    <script src="/dash/assets/js/misc.js"></script>
    <!-- endinject -->

<script>
    const password = document.getElementById('txtPassword');
    const confirmPassword = document.getElementById('txtConfirmPassword');
    const matchMessage = document.getElementById('matchMessage');

    function validatePasswordStrength(pw) {
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?#&^_\-]).{7,}$/;
        return regex.test(pw);
    }

    function validate() {
        const pass = password.value;
        const confirm = confirmPassword.value;

        if (!validatePasswordStrength(pass)) {
            matchMessage.innerHTML = "Password must be at least 7 characters and include uppercase, lowercase, number, and special character.";
            matchMessage.style.color = "orange";
            return false;
        }

        if (pass !== confirm) {
            matchMessage.innerHTML = "Passwords do not match.";
            matchMessage.style.color = "red";
            return false;
        }

        matchMessage.innerHTML = "Passwords match and are strong!";
        matchMessage.style.color = "green";
        return true;
    }

    password.addEventListener('input', validate);
    confirmPassword.addEventListener('input', validate);
</script>

        

</body>
</html>