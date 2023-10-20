@extends('admin.layouts.app')

@section('content')
    <style type="text/css">
        .text-author {
            border: 1px solid rgba(0, 0, 0, .05);
            max-width: 100%;
            margin: 0 auto;
            padding: 2em;
        }

        .text-author h3 {
            margin-bottom: 0;
        }

        .avatar-preview {
            width: 192px;
            height: 192px;
            position: relative;
            border-radius: 100%;
            border: 6px solid #F8F8F8;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
        }

        .avatar-preview>div {
            width: 100%;
            height: 100%;
            border-radius: 100%;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body mt-4 mb-4">
                    <div class="d-flex flex-column align-items-center text-center">
                        <div class="avatar-upload">
                            <div class="avatar-preview">
                                <div id="imagePreview" style="background-image: url({{ $admin->photo ? asset($admin->photo) : asset('assets/images/avatars/no-image.png')}});">
                                </div>
                            </div>
                        </div>
                        <div class="mt-1 mb-5">
                            <h4>{{ $admin->fname. ' '. $admin->lname }}</h4>
                            <p class="text-secondary mb-1">{{ str_replace('_', ' ', Str::upper($admin->role)) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body mt-3 mb-3">
                    <form id="change_password" action="{{ route('change-password') }}" method="post">
                        @csrf
                        <div class="col-md-12">
                            <label for="old_password" class="form-label">{{trans('msg.admin.Current Password')}}</label>
                            <div class="input-group" id="show_hide_new_password">
                                <input type="password" class="form-control smp-input border-end-0" style="font-weight: 300;font-size: 15px;color: #38424C;" name="old_password" id="old_password" placeholder="{{ trans('msg.admin.Enter Current Password')}}"> <a href="javascript:;" style="font-size:20px;" class="input-group-text bg-transparent"><i class='bx bx-show'></i></a>
                            </div>
                            <span class="err_old_password text-danger">@error('old_password') {{$message}} @enderror</span>
                        </div>
                        <div class="col-md-12 mt-4">
                            <label for="new_password" class="form-label">{{trans('msg.admin.New Password')}}</label>
                            <div class="input-group" id="show_hide_old_password">
                                <input type="password" class="form-control smp-input border-end-0" style="font-weight: 300;font-size: 15px;color: #38424C;" name="new_password" id="new_password" placeholder="{{ trans('msg.admin.Enter New Password')}}"> <a href="javascript:;" style="font-size:20px;" class="input-group-text bg-transparent"><i class='bx bx-show'></i></a>
                            </div>
                            <span class="err_new_password text-danger">@error('new_password') {{$message}} @enderror</span>
                        </div>
                        <div class="col-md-12 mt-4">
                            <label for="password" class="form-label">{{trans('msg.admin.Confirm Password')}}</label>
                            <div class="input-group" id="show_hide_password">
                                <input type="password" class="form-control smp-input border-end-0" style="font-weight: 300;font-size: 15px;color: #38424C;" name="cnfm_password" id="password" placeholder="{{ trans('msg.admin.Confirm Password')}}"> <a href="javascript:;" style="font-size:20px;" class="input-group-text bg-transparent"><i class='bx bx-show'></i></a>
                            </div>
                            <span class="err_password text-danger">@error('cnfm_password') {{$message}} @enderror</span>
                        </div>
                        <div class="row mt-4">
                            <div class="col-sm-8"></div>
                            <div class="col-sm-4">
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary px-2">{{ Str::upper(trans('msg.admin.Cancel')) }}</a>
                                <button type="submit" class="btn btn-primary">{{ Str::upper(trans('msg.admin.Save Changes')) }}</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </div>

    </div>
@endsection

@section('customJs')
    <script>
        $(document).ready(function() {

            // Match Password
            var new_password = document.getElementById("new_password")
            , password = document.getElementById("password")
            , old_password = document.getElementById("old_password");

            function validatePassword(){
                if(password.value != new_password.value) {
                    password.setCustomValidity("Passwords Don't Match");
                } else {
                    password.setCustomValidity('');
                }
            }

            function validateNewPassword(){
                if(old_password.value == new_password.value) {
                    new_password.setCustomValidity("New Password Should'nt be Same as Old Password");
                } else {
                    new_password.setCustomValidity('');
                }
            }

            new_password.onchange = validatePassword;
            password.onkeyup = validatePassword;
            new_password.onkeyup = validateNewPassword;
                
            $("#change_password").on('input', function(e) {
                e.preventDefault();
                let valid = true;
                let form = $(this).get(0);
                let old_password = $("#old_password").val();
                let err_old_password = "{{trans('msg.admin.Enter Current Password')}}";
                let new_password = $("#new_password").val();
                let err_new_password = "{{trans('msg.admin.Enter New Password')}}";
                let password = $("#password").val();
                let err_password = "{{trans('msg.admin.Confirm Password')}}";

                    if (old_password.length === 0) {
                        $(".err_old_password").text(err_old_password);
                        $('#old_password').addClass('is-invalid');
                        valid = false;
                    } else {
                        $(".err_old_password").text('');
                        $('#old_password').addClass('is-valid');
                        $('#old_password').removeClass('is-invalid');
                    }
                    if (new_password.length === 0) {
                        $(".err_new_password").text(err_new_password);
                        $('#new_password').addClass('is-invalid');
                        valid = false;
                    } else {
                        $(".err_new_password").text('');
                        $('#new_password').addClass('is-valid');
                        $('#new_password').removeClass('is-invalid');
                    }
                    if (password.length === 0) {
                        $(".err_password").text(err_password);
                        $('#password').addClass('is-invalid');
                        valid = false;
                    } else {
                        $(".err_password").text('');
                        $('#password').addClass('is-valid');
                        $('#password').removeClass('is-invalid');
                    }
                // if (valid) {
                //     form.submit();
                // }
            });

            $("#show_hide_old_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_old_password input').attr("type") == "text") {
                    $('#show_hide_old_password input').attr('type', 'password');
                    $('#show_hide_old_password i').addClass("bx-hide");
                    $('#show_hide_old_password i').removeClass("bx-show");
                } else if ($('#show_hide_old_password input').attr("type") == "password") {
                    $('#show_hide_old_password input').attr('type', 'text');
                    $('#show_hide_old_password i').removeClass("bx-hide");
                    $('#show_hide_old_password i').addClass("bx-show");
                }
            });

            $("#show_hide_new_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_new_password input').attr("type") == "text") {
                    $('#show_hide_new_password input').attr('type', 'password');
                    $('#show_hide_new_password i').addClass("bx-hide");
                    $('#show_hide_new_password i').removeClass("bx-show");
                } else if ($('#show_hide_new_password input').attr("type") == "password") {
                    $('#show_hide_new_password input').attr('type', 'text');
                    $('#show_hide_new_password i').removeClass("bx-hide");
                    $('#show_hide_new_password i').addClass("bx-show");
                }
            });

            $("#show_hide_password a").on('click', function(event) {
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
@endsection