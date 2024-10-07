<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SI BKM | Welcome</title>
    <link rel="icon" href="{{ asset('img/Logo FrojenFuud.png') }}" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('source/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('source/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('source/dist/css/adminlte.min.css') }}">
    {{-- Toaster --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
</head>

<body class="hold-transition login-page">
    <img src="{{ asset('img/Logo FrojenFuud.png') }}" alt="Gambar" style="width: 100px; height: auto;">
    <p class="login-box-msg"></p>
    <p class="login-box-msg">Selamat Datang Di FrojenFuud ERP</p>
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-body">
                <p class="login-box-msg">Masuk Ke Dashboard</p>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-12">
                        @if (Route::has('login'))
                            <nav class="-mx-3 flex flex-1 justify-end">
                                @auth
                                    <a href="{{ url('/home') }}" class="btn btn-primary btn-block">
                                        Beranda
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary btn-block">
                                        Log in
                                    </a>

                                    {{-- @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn btn-primary btn-block"">
                                            Register
                                        </a>
                                    @endif --}}
                                @endauth
                            </nav>
                        @endif
                    </div>
                    <!-- /.col -->
                </div>
                </form>
                {{-- <p class="mb-0">
        <a href="#" class="text-center">Register a new membership</a>
      </p> --}}
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('source/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('source/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('source/dist/js/adminlte.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        @if (session('message'))
            toastr.success('{{ session('message') }}');
        @endif
    </script>
</body>

</html>
