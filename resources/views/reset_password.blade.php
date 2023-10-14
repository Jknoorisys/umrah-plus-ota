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
            width: 480px;
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
        
    </style>
</head>

<body class="bg-login">
	<!-- wrapper -->
	<div class="wrapper">
		<div class="authentication-reset-password d-flex align-items-center justify-content-center">
			<div class="row">
				<div class="col-12 col-lg-10 mx-auto">
					<div class="card card-smp">
						<div class="card-body">
                            <div class="p-5">
                                <div class="text-start">
                                    <img src="{{ asset('assets/images/logo-img.png') }}" width="180" alt="">
                                </div>
                                <h4 class="mt-5 font-weight-bold">{{ trans('msg.admin.Genrate New Password') }}</h4>
                                <p class="text-muted">{{ trans('msg.admin.We received your reset password request, Please enter your new password') }}!</p>
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
                                <form action="{{ route('reset-password.post') }}" method="post" id="form_reset">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <input type="hidden" name="email" value="{{ request('email') }}">
                                    <div class="mb-3 mt-5">
                                        <label class="form-label">{{ trans('msg.admin.New Password') }}</label>
                                        {{-- <input type="text" class="form-control" name="new_password" placeholder="{{ trans('msg.admin.Enter new password') }}" /> --}}
                                        <div class="input-group" id="show_hide_password">
                                            <input type="password" class="form-control smp-input border-end-0 font-style" name="password" id="password" placeholder="{{ trans('msg.admin.Enter new password') }}"> <a href="javascript:;" class="input-group-text bg-transparent icon-style"><i class='bx bx-hide'></i></a>
                                        </div>
                                        <span class="err_password text-danger"></span>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">{{ trans('msg.admin.Confirm Password') }}</label>
                                        {{-- <input type="text" class="form-control" name="cnfm_password" placeholder="{{ trans('msg.admin.Confirm Password') }}" /> --}}
                                        <div class="input-group" id="show_hide_password_confirmation">
                                            <input type="password" class="form-control smp-input border-end-0 font-style" name="password_confirmation" id="password_confirmation" placeholder="{{ trans('msg.admin.Confirm Password') }}"> <a href="javascript:;" class="input-group-text bg-transparent icon-style"><i class='bx bx-hide'></i></a>
                                        </div>
                                        <span class="err_password_confirmation text-danger"></span>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary">{{ trans('msg.admin.Change Password') }}</button> <a href="authentication-login.html" class="btn btn-light"><i class='bx bx-arrow-back mr-1'></i>{{ trans('msg.admin.Back to Login') }}</a>
                                    </div>
                                </form>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end wrapper -->

    <!--Password show & hide js -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
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

            $("#show_hide_password_confirmation a").on('click', function (event) {
                event.preventDefault();
                if ($('#show_hide_password_confirmation input').attr("type") == "text") {
                    $('#show_hide_password_confirmation input').attr('type', 'password');
                    $('#show_hide_password_confirmation i').addClass("bx-hide");
                    $('#show_hide_password_confirmation i').removeClass("bx-show");
                } else if ($('#show_hide_password_confirmation input').attr("type") == "password") {
                    $('#show_hide_password_confirmation input').attr('type', 'text');
                    $('#show_hide_password_confirmation i').removeClass("bx-hide");
                    $('#show_hide_password_confirmation i').addClass("bx-show");
                }
            });

            $("#form_reset").on('input', function(e) {
                e.preventDefault();
                let valid = true;
                let form = $(this).get(0);

                let password = $("#password").val();
                let err_password = "{{ trans('msg.admin.Enter Valid Password') }}";

                let password_confirmation = $("#password_confirmation").val();
                let err_password_confirmation = "{{ trans('msg.admin.Confirm Password') }}";
            
                if (password.length === 0) {
                    $(".err_password").text(err_password);
                    $('#password').addClass('is-invalid');
                    valid = false;
                } else {
                    $(".err_password").text('');
                    $('#password').addClass('is-valid');
                    $('#password').removeClass('is-invalid');
                }

                if (password_confirmation.length === 0 || password_confirmation != password) {
                    $(".err_password_confirmation").text(err_password_confirmation);
                    $('#password_confirmation').addClass('is-invalid');
                    valid = false;
                } else {
                    $(".err_password_confirmation").text('');
                    $('#password_confirmation').addClass('is-valid');
                    $('#password_confirmation').removeClass('is-invalid');

                }
            });
        });
    </script>
</body>

</html>