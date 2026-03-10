<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edu Faith</title>
    <link rel="icon" type="image/png" href="{{ asset('public/assets/image/edu_logo.png') }}" />

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">


    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">


    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>



</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Faith</b>UZ</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Ro'yhatdan o'ting</p>

            @if($errors->has('success'))
                <div class="h4 p-2 rounded bg-success  text-center d-block">
                    {{ $errors->first('success') }}
                </div>
            @elseif($errors->first())
                <div class="h4 p-2 rounded bg-danger text-center d-block">
                    {{ implode(" ", $errors->all(':message')) }}
                </div>
            @endif

            <form method="POST" action="{{ route('form.store') }}">
                @csrf

                <div class="input-group mb-3">
                    <input id="name" type="text" placeholder="Name" class="form-control" name="name" value="" required autocomplete="name" autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <select name="gender" class="form-control" required autofocus>
                        <option value="" selected disabled>Select gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-male"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input id="date" type="date" class="form-control" name="birth_date" value="" required autofocus>
                </div>

                <div class="input-group mb-3">
                    <input type="number" placeholder="Phone number" class="form-control" name="phone" value="" required aautofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-phone"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="number" placeholder="Parent phone number" class="form-control" name="parent_phone" value="" required aautofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-phone"></span>
                        </div>
                    </div>
                </div>

                <div class="row px-4">
                    <div class="col-6">
                        <div class="icheck-primary">
                            <input class="form-check-input" required type="checkbox" name="remember">
                                <label class="form-check-label" for="remember">
                                {{ __('Check') }}
                            </label>

                        </div>
                    </div>
                    <!-- /.col -->

                    <div class="col-6 ">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ __('Register') }}
                        </button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>




        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->

</body>
</html>
