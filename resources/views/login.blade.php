<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DriveGO - Auth</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0.65)), url("/asset/nwh1.jpeg");
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-family: Arial, sans-serif;
        }

        .card-auth {
            position: relative;
            background: rgba(30, 30, 30, .4);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            width: 100%;
            max-width: 420px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .6);
            transition: height 0.45s cubic-bezier(.4, 0, .2, 1);
        }


        /* radio hidden */
        input[type=radio] {
            display: none;
        }

        /* FORM DEFAULT */
        .form-login,
        .form-register {
            position: absolute;
            inset: 0;
            opacity: 0;
            transform: translateY(12px) scale(0.98);
            transition:
                opacity 0.35s cubic-bezier(.4, 0, .2, 1),
                transform 0.35s cubic-bezier(.4, 0, .2, 1);
            pointer-events: none;
        }

        #login:checked~.form-login,
        #register:checked~.form-register {
            position: relative;
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }

        #login:checked~.form-login {
            display: block;
        }

        #register:checked~.form-register {
            display: block;
        }

        .form-control {
            background: #2e2e2e;
            border: 1px solid #444;
            color: white;
        }

        .form-control:focus {
            background: #1e1e1e;
            color: white;
            box-shadow: 0 0 6px rgba(0, 123, 255, .6);
        }

        .switch {
            color: #00bcd4;
            cursor: pointer;
            text-decoration: none;
        }

        .switch:hover {
            text-decoration: underline;
        }

        .btn-login {
            background: #92c7ff97;
            border: none;
        }

        .btn-register {
            background: #5e6364;
            border: none;
        }

        .close-btn {
            position: absolute;
            top: 12px;
            right: 16px;
            font-size: 26px;
            color: white;
            text-decoration: none;
            opacity: 0.7;
            transition: 0.2s;
        }

        .close-btn:hover {
            opacity: 1;
            color: #ff6b6b;
        }

        /* Placeholder color fix */
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
            /* untuk dark theme */
        }

        /* Support browser lain */
        .form-control::-webkit-input-placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-control:-ms-input-placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        /* Toast position default: bottom-right */
        .toast-container {
            position: fixed;
            bottom: 1.5rem;
            right: 1.5rem;
            z-index: 1055;
        }

        /* Mobile: bottom-center */
        @media (max-width: 576px) {
            .toast-container {
                left: 50%;
                right: auto;
                transform: translateX(-50%);
                bottom: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="card-auth">

        <!-- RADIO CONTROLLER -->
        <input type="radio" name="auth" id="login"
            {{ session('success') || $errors->login->any() ? 'checked' : (!session('open_register') ? 'checked' : '') }}>


        <input type="radio" name="auth" id="register"
            {{ $errors->default->any() || session('open_register') ? 'checked' : '' }}>

        <a href="/" class="close-btn">&times;</a>
        <!-- LOGIN -->
        <form class="form-login" method="POST" action="{{ url('/login') }}">
            @csrf

            <h4 class="text-center mb-3">Login</h4>

            @if ($errors->login->any())
            <div class="alert alert-danger auth-error">
                {{ $errors->login->first('login_error') }}
            </div>
            @endif

            <div class="mb-3">
                <label>Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-control"
                    placeholder="Enter email"
                    required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Enter password"
                    required>
            </div>

            <button type="submit" class="btn btn-login w-100 mb-3">
                Login
            </button>

            <p class="text-center">
                Belum punya akun?
                <label for="register" class="switch">Sign Up</label>
            </p>
        </form>
        <!-- REGISTER -->
        <form class="form-register" method="POST" action="{{ route('register.store') }}">
            @csrf

            <h4 class="text-center mb-3">Create Account</h4>

            @if ($errors->default->any())
            <div class="alert alert-danger auth-error">
                @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
                @endforeach
            </div>
            @endif

            <div class="mb-3">
                <label>Nama Perusahaan</label>
                <input
                    type="text"
                    name="company_name"
                    value="{{ old('company_name') }}"
                    class="form-control"
                    placeholder="Nama perusahaan"
                    required>
            </div>

            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="form-control"
                    placeholder="Nama penanggung jawab"
                    required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-control"
                    placeholder="Email"
                    required>
            </div>

            <div class="mb-3">
                <label>No. Telepon</label>
                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                    class="form-control"
                    inputmode="numeric"
                    pattern="[0-9]*"
                    placeholder="08xxxxxxxxxx"
                    required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Password"
                    required>
            </div>

            <div class="mb-3">
                <label>Confirm Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    class="form-control"
                    placeholder="Confirm Password"
                    required>
            </div>

            <button type="submit" class="btn btn-register w-100 mb-3">
                Sign Up
            </button>

            <p class="text-center">
                Sudah punya akun?
                <label for="login" class="switch">Login</label>
            </p>
        </form>

    </div>
    @if (session('success'))
    <div class="toast-container">
        <div id="successToast"
            class="toast align-items-center text-bg-success border-0"
            role="alert"
            aria-live="assertive"
            aria-atomic="true"
            data-bs-delay="3000">

            <div class="d-flex">
                <div class="toast-body">
                    {{ session('success') }}
                </div>
                <button type="button"
                    class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif

    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toastEl = document.getElementById('successToast');
            if (toastEl) {
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
            }
        });
    </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const errorBox = document.querySelector('.auth-error');
            const card = document.querySelector('.card-auth');
            const loginForm = document.querySelector('.form-login');
            const registerForm = document.querySelector('.form-register');
            const loginRadio = document.getElementById('login');
            const registerRadio = document.getElementById('register');

            if (!errorBox) return;

            const inputs = document.querySelectorAll('.form-control');

            inputs.forEach(input => {
                input.addEventListener('input', () => {
                    errorBox.style.transition = 'opacity 0.3s ease';
                    errorBox.style.opacity = '0';

                    setTimeout(() => {
                        errorBox.remove();
                    }, 300);
                });
            });

            let currentForm = loginRadio.checked ? loginForm : registerForm;
            currentForm.classList.add('active');

            function switchForm(nextForm) {
                if (currentForm === nextForm) return;

                // PHASE 1: fade out current form
                currentForm.classList.remove('active');
                currentForm.classList.add('exiting');

                const oldHeight = currentForm.offsetHeight;
                card.style.height = oldHeight + 'px';

                setTimeout(() => {
                    // cleanup exiting
                    currentForm.classList.remove('exiting');

                    // PHASE 2: switch content & animate card height
                    nextForm.classList.add('active');
                    const newHeight = nextForm.offsetHeight;

                    card.offsetHeight; // force reflow
                    card.style.height = newHeight + 'px';

                    // PHASE 3: show next form
                    setTimeout(() => {
                        card.style.height = 'auto';
                        currentForm = nextForm;
                    }, 400);

                }, 250); // must match fade-out duration
            }

            loginRadio.addEventListener('change', () => {
                if (loginRadio.checked) {
                    switchForm(loginForm);
                }
            });

            registerRadio.addEventListener('change', () => {
                if (registerRadio.checked) {
                    switchForm(registerForm);
                }
            });
        });
    </script>


</body>

</html>