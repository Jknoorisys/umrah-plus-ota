<!DOCTYPE html>
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
            .card-smp{
                position: absolute;
                width: 430px;
                height: auto;
                left: 50px;
                top: 80px;
                background: #d7f1f9bf;
                box-shadow: 0px 2px 20px rgba(117, 63, 63, 0.1);
                border-radius: 10px;
            }

            .font-style{
                font-weight: 300;
                font-size: 15px;
                color: #38424C;
            }
            
        </style>
    </head>

    <body class="bg-login">
        <!-- wrapper -->
        <div class="wrapper">
            <div class="authentication-forgot d-flex align-items-center justify-content-center">
                <div class="card card-smp">
                    <div class="card-body">
                        <div class="p-4 rounded  border">
                            <div class="text-center">
                                <img src="{{ asset('assets/images/icons/forgot-2.png') }}" width="120" alt="" />
                            </div>
                            <h4 class="mt-5 font-weight-bold">{{ trans('msg.admin.Forgot Password') }}?</h4>
                            <p class="text-muted">{{ trans('msg.admin.Enter your registered Email ID to reset the password') }}</p>

                            @if (isset($error))
                                <div class="alert border-0 border-start border-5 border-danger alert-dismissible fade show py-2">
                                    <div class="d-flex align-items-center">
                                        <div class="font-25 text-danger"><i class='bx bxs-message-square-x'></i></div>
                                        <div class="ms-2">
                                            <div class="text-danger">{{ $error }}</div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

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

                            <form action="{{ route('send-reset-link') }}" method="post">
                                @csrf
                                <div class="my-4">
                                    <label class="form-label font-style">{{ trans('msg.admin.Email') }}</label>
                                    <input type="email" class="form-control form-control-lg font-style" name="email" :value="old('email')" placeholder="example@user.com" />
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">{{ trans('msg.admin.Send') }}</button> 
                                    <a href="{{ route('/') }}" class="btn btn-light btn-lg font-style"><i class='bx bx-arrow-back me-1'></i>{{ trans('msg.admin.Back to Login') }}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end wrapper -->
    </body>

</html>