<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

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
        <div class="content-wrapper d-flex align-items-center auth">
            <div class="row flex-grow">
                <div class="col-lg-4 mx-auto">
                    <div class="auth-form-light text-left p-5">

                        <div class="brand-logo">
                            <img src="{{ asset('assets/images/logo.svg') }}">
                        </div>

                        <h4>Welcome Back</h4>
                        <h6 class="font-weight-light">Please login to your account</h6>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="alert alert-success mt-3">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form class="pt-3" method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email -->
                            <div class="form-group">
                                <input type="email"
                                       name="email"
                                       value="{{ old('email') }}"
                                       class="form-control form-control-lg @error('email') is-invalid @enderror"
                                       placeholder="Email"
                                       required autofocus>

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <input type="password"
                                       name="password"
                                       class="form-control form-control-lg @error('password') is-invalid @enderror"
                                       placeholder="Password"
                                       required>

                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Remember Me & Forgot -->
                            <div class="my-2 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input type="checkbox"
                                           name="remember"
                                           class="form-check-input"
                                           id="remember_me">
                                    <label class="form-check-label text-muted" for="remember_me">
                                        Remember me
                                    </label>
                                </div>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}"
                                       class="auth-link text-primary">
                                        Forgot password?
                                    </a>
                                @endif
                            </div>

                            <!-- Login Button -->
                            <div class="mt-3 d-grid gap-2">
                                <button type="submit"
                                        class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                                    LOG IN
                                </button>
                            </div>

                            <!-- Google Login -->
                            <div class="mt-3 d-grid gap-2">
                                <a href="{{ route('google.redirect') }}"
                                   class="btn btn-block btn-google auth-form-btn">
                                    <i class="mdi mdi-google me-2"></i>
                                    Login dengan Google
                                </a>
                            </div>

                            <!-- Register -->
                            <div class="text-center mt-4 font-weight-light">
                                Don't have an account?
                                <a href="{{ route('register') }}" class="text-primary">
                                    Create
                                </a>
                            </div>

                        </form>

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