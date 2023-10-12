<!doctype html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--favicon-->
        <link rel="icon" href="{{ asset('assets/images/logo-icon.png') }}" type="image/png" />
        <!--plugins-->
        <link rel="stylesheet" href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}">

        <link href="{{ asset('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
        <link href="{{ asset('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
        <!-- loader-->
        <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
        <script src="{{ asset('assets/js/pace.min.js') }}"></script>
        <!-- Bootstrap CSS -->
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
        {{-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet"> --}}
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
        <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">
        <title>OTA</title>

        <style> 
            .btn-login {
              color: #fff;
              background-color: #124fa0;
              border-color: #3685d4;
            }

            .btn-login-smp {
              color: #fff;
              box-sizing: border-box;
              position: absolute;
              width: 300px;
              height: 40px;
              /* left: 129px; */
              /* top: 768px; */
              background: #008cff;
              border: 1px solid #008cff;
              box-shadow: 0px 4px 10px rgba(240, 90, 100, 0.25);
              border-radius: 7px;
              text-align: center;
              font-weight: 500;
              font-size: 20px;
              color: #FFFFFF;
            }

            .btn-login-smp:hover {
              color: #fff;
              background-color:#008cff;
              border-color: #008cff;
            }

            .btn-login:hover {
              color: #fff;
              background-color:#3685d3;
              border-color: #3685d4;
            }

            .btn-check:focus + .btn-login,
            .btn-login:focus {
              color: #fff;
              background-color:#3685d3;
              border-color: #3685d4;
              box-shadow: 0 0 0 0.25rem #551a1a;
            }

            .btn-check:active + .btn-login,
            .btn-check:checked + .btn-login,
            .btn-login.active,
            .btn-login:active,
            .show > .btn-login.dropdown-toggle {
              color: #fff;
              background-color: #551a1a;
              border-color: #3685d4;
            }

            .btn-check:active + .btn-login:focus,
            .btn-check:checked + .btn-login:focus,
            .btn-login.active:focus,
            .btn-login:active:focus,
            .show > .btn-login.dropdown-toggle:focus {
              box-shadow: 0 0 0 0.25rem #551a1a;
            }

            .btn-login.disabled,
            .btn-login:disabled {
              color: #fff;
              background-color: #551a1a;
              border-color: #551a1a;
            }
            
            .card-smp{
                position: absolute;
                width: 380px;
                height: 490px;
                left: 60px;
                top: 120px;
                background: #d7f1f9bf;
                box-shadow: 0px 2px 20px rgba(117, 63, 63, 0.1);
                border-radius: 10px;
            }
            
            .text-smp{
                position: absolute;
                width: 100px;
                height: 55px;
                left: 29px;
                top: 30px;
                font-weight: 500;
                font-size: 30px;
                /* line-height: 55px; */
                /* identical to box height */
                text-align: center;
                color: #38424C;
            
            }
            
            .smp-input{
                box-sizing: border-box;
                width: 300px;
                height: 40px;
                background: #d7f1f9bf;
                border: 1px solid #008cff;
                box-shadow: 0px 4px 4px #d7f1f9bf;
                border-radius: 7px;
                font-weight: 300;
                font-size: 18px;
                display: flex;
                align-items: center;
                color: #9197B3;
            }
            
            .input-group-text {
                padding: 0.0rem 0.0rem;
            }

            .icon-style{
                font-weight: 300;
                font-size: 20px;
                line-height: 38px;
                align-items: center;
                color: #9197B3;
                border: 1px solid #008cff;
                background: #d7f1f9bf;            
            }

            .font-style{
                font-weight: 300;
                font-size: 15px;
                color: #38424C;
            }
            
        </style>
    </head>

    <body class="bg-login">
        <!--wrapper-->
        <div class="wrapper">
            <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
                <div class="container-fluid">
                    <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                        <div class="col mx-auto">
                            <div class="card-smp">
                                <div class="card-body">
                                    <div class="p-4 rounded">
                                        <div class="pb-4 pt-4 text-left">
                                            <h3 class="text-smp" >{{ trans('msg.admin.Login') }}</h3>
                                            <p style="font-size: 15px;color: #008cff; margin-top:10px;" >{{ trans('msg.admin.Welcome Back!') }}</p>
                                        </div>    

                                        @if (session('error'))
                                            <div class="alert border-0 border-start border-5 border-danger alert-dismissible fade show py-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="font-25 text-danger"><i class='bx bxs-message-square-x'></i></div>
                                                    <div class="ms-2">
                                                        <!-- <h6 class="mb-0 text-danger">Danger Alerts</h6> -->
                                                        <div class="text-danger">{{ session('error') }}</div>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif

                                        @if (session('success'))
                                            <div class="alert border-0 border-start border-5 border-success alert-dismissible fade show py-2">
                                                <div class="d-flex align-items-center">
                                                    <div class="font-25 text-success"><i class='bx bxs-check-circle'></i></div>
                                                    <div class="ms-2">
                                                        <!-- <h6 class="mb-0 text-success">Success Alerts</h6> -->
                                                        <div class="text-success">{{ session('success') }}</div>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
                                        @endif

                                        <div class="form-body">
                                            <form action="{{ route('login') }}" method="POST" class="row g-3" id="form_login">
                                                @csrf
                                                <div class="col-md-12">
                                                    <label for="email" class="form-label font-style">{{ trans('msg.admin.Email') }}</label>
                                                    <div class="input-group"><input type="email" class="form-control smp-input border-end-0 font-style" name="email" id="email" placeholder="Email Address" required><a href="javascript:;" class="input-group-text bg-transparent icon-style"><i class='bx bx-envelope'></i></a></div>
                                                    <span class="err_email text-danger"></span>
                                                </div>
                                                <div class="col-md-12">
                                                    <label for="password" class="form-label font-style" >{{ trans('msg.admin.Password') }}</label>
                                                    <div class="input-group" id="show_hide_password">
                                                        <input type="password" class="form-control smp-input border-end-0 font-style" name="password" id="password" placeholder="Enter Password" required> <a href="javascript:;" class="input-group-text bg-transparent icon-style"><i class='bx bx-hide'></i></a>
                                                    </div>
                                                    <span class="err_password text-danger"></span>
                                                </div>
                                                <a class="text-end" href="#" style="color: #008cff; " >{{ trans('msg.admin.Forgot Password') }}?</a>
                                                <div class="pb-4 pt-4 col-md-12">
                                                    <div class="d-grid">
                                                        <button type="submit" class="btn btn-login-smp">{{ Str::upper(trans('msg.admin.Login')) }} <i class="lni lni-arrow-right"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end row-->
                </div>
            </div>
        </div>
        <!--end wrapper-->
        <!-- Bootstrap JS -->
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <!--plugins-->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
        <!--Password show & hide js -->
        <script>
            $(document).ready(function () {
                $("#show_hide_password a").on('click', function (event) {
                    event.preventDefault();
                    if ($('#show_hide_password input').attr("type") == "text") {
                        $('#show_hide_password input').attr('type', 'password');
                        $('#show_hide_password i').addClass("bx-hide");
                        $('#show_hide_password i').removeClass("bx-show");
                    } else if ($('#show_hide_password input').attr("type") == "password") {
                        $('#show_hide_password input').attr('type', 'text');
                        $('#show_hide_password i').removeClass("bx-hide");
                        $('#show_hide_password i').addClass("bx-show");
                    }
                });
            });
        </script>
        <!--app JS-->
        <script src="{{ asset('assets/js/app.js') }}"></script>
    </body>

</html>