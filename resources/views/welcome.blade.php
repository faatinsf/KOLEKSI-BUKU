<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
</head>

<body>

<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth text-center">
            <div class="row flex-grow">
                <div class="col-lg-6 mx-auto">

                    <div class="auth-form-light p-5">

                        <div class="brand-logo">
                            <img src="{{ asset('assets/images/logo.svg') }}" alt="logo">
                        </div>

                        <h2 class="font-weight-bold mb-3">
                            Welcome to Your Application
                        </h2>

                        <p class="text-muted mb-4">
                            Sistem Login Laravel dengan Template Purple Admin
                        </p>

                        @auth
                            <div class="d-grid gap-2">
                                <a href="{{ url('/dashboard') }}"
                                   class="btn btn-gradient-primary btn-lg">
                                    Go to Dashboard
                                </a>
                            </div>
                        @else
                            <div class="d-grid gap-2 mb-3">
                                <a href="{{ route('login') }}"
                                   class="btn btn-gradient-primary btn-lg">
                                    Login
                                </a>
                            </div>

                            @if (Route::has('register'))
                                <div class="d-grid gap-2">
                                    <a href="{{ route('register') }}"
                                       class="btn btn-outline-primary btn-lg">
                                        Register
                                    </a>
                                </div>
                            @endif
                        @endauth

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- plugins:js -->
<script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('assets/js/off-canvas.js') }}"></script>
<script src="{{ asset('assets/js/misc.js') }}"></script>
<script src="{{ asset('assets/js/settings.js') }}"></script>
<script src="{{ asset('assets/js/todolist.js') }}"></script>
<script src="{{ asset('assets/js/jquery.cookie.js') }}"></script>

</body>
</html>