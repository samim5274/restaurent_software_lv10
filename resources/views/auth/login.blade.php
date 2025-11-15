<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login & Signup | RMS</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link rel="stylesheet" href="./css/style.css" />
</head>
<body>

    {{-- ✅ Flash Messages --}}
    @if(session('success') || session('error') || session('warning') || session('info'))
        <div id="flash-message" class="message">
            @include('layouts.message')
        </div>
    @endif

    <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true" />

        {{-- ✅ Login Form --}}
        <div class="signup">
            <form class="pt-3" action="{{url('/user-login')}}" method="POST">
                @csrf
                <label for="chk" aria-hidden="true">Login</label>

                <input type="email" name="txtEmail" placeholder="User email" value="admin@admin.com" required />
                <input type="password" name="txtPassword" placeholder="Password" value="123456789" required />

                <button type="submit">Login</button>

                <div id="form-text">
                    <p>or login with</p>
                </div>

                <div class="social-login">
                    <a href="#"><i class="fab fa-google"></i></a>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-github"></i></a>
                </div>
            </form>
        </div>

        {{-- ✅ Signup Form --}}
        <div class="login">
            <form action="{{url('/new-user')}}" method="POST" onsubmit="return validate();">
                @csrf
                <label for="chk" aria-hidden="true">Sign Up</label>

                <input id="txtName" placeholder="Full Name" type="text" name="txtName" required>
                <input id="txtEmail" placeholder="Email Address" type="email" name="txtEmail" required>
                <input id="txtPassword" placeholder="Password" type="password" name="txtPassword" required>
                <input id="txtConfirmPassword" placeholder="Confirm Password" type="password" required>

                <div id="matchMessage" class="form-text"></div>        

                <button type="submit">Sign Up</button>

                <div id="form-text">
                    <p>or sign up with</p>
                </div>

                <div class="social-login">
                    <a href="#"><i class="fab fa-google"></i></a>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-github"></i></a>
                </div>
            </form>
        </div>
    </div>

    {{-- ✅ Scripts --}}
    <script>
        // Flash message auto hide
        document.addEventListener("DOMContentLoaded", function () {
            const flashMessage = document.getElementById("flash-message");
            if (flashMessage) {
                setTimeout(() => {
                    flashMessage.classList.add("hide");
                }, 4000);
            }
        });

        // Password validation
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
                matchMessage.innerHTML = "Password must contain A–Z, a–z, 0–9 & symbol, and be 7+ chars.";
                matchMessage.style.color = "orange";
                return false;
            }

            if (pass !== confirm) {
                matchMessage.innerHTML = "Passwords do not match.";
                matchMessage.style.color = "red";
                return false;
            }

            matchMessage.innerHTML = "✅ Passwords match and are strong!";
            matchMessage.style.color = "green";
            return true;
        }

        password.addEventListener('input', validate);
        confirmPassword.addEventListener('input', validate);
    </script>
</body>
</html>
