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

        .avatar-upload {
            position: relative;
            max-width: 205px;
            margin: 10px auto;
        }

        .avatar-edit {
            position: absolute;
            right: 2px;
            z-index: 1;
            top: 127px;
        }

        .avatar-edit input {
            display: none;
        }

        .avatar-edit label {
            display: inline-block;
            width: 34px;
            height: 34px;
            margin-bottom: 0;
            border-radius: 100%;
            background: #FFFFFF;
            border: 1px solid transparent;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
            cursor: pointer;
            font-weight: bolder;
            transition: all .2s ease-in-out;
        }

        .avatar-edit label:hover {
            background: #f1f1f1;
            border-color: #d6d6d6;
        }

        .avatar-edit label:after {
            content: "\f030";
            font-family: 'FontAwesome';
            color: #38424C;
            position: absolute;
            top: 7px;
            left: 0;
            right: 0;
            text-align: center;
            margin: auto;
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

        .input-group:not(.has-validation)>.dropdown-toggle:nth-last-child(n+3), .input-group:not(.has-validation)>:not(:last-child):not(.dropdown-toggle):not(.dropdown-menu) {
            /* max-width: 70px; */
        }

        .select2-container--bootstrap4 .select2-selection {
            color: black;
            background: #e9ecef;
        }

    </style>

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body mt-4 mb-4">
                    <div class="d-flex flex-column align-items-center text-center">
                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <input type='file' id="imageUpload" name="thumbnail" class="avatar" accept=".png, .jpg, .jpeg" />
                                <input type="hidden" id="old_image" value="{{ $admin->photo ? asset($admin->photo) : asset('assets/images/avatars/no-image.png')}}">
                                <label for="imageUpload"></label>
                            </div>
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
                    <form id="edit_profile" action="{{ route('update-profile') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-sm-2">
                                <h6 class="mb-0">{{ trans('msg.admin.First Name') }}</h6>
                            </div>
                            <div class="col-sm-10 text-secondary">
                                <div class="input-group input-group-outline">
                                    <input type="text" class="form-control" name="fname" id="fname" value="{{ $admin->fname }}" placeholder="{{ trans('msg.admin.First Name') }}">
                                </div>
                                <span class="err_fname text-danger"></span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-2">
                                <h6 class="mb-0">{{ trans('msg.admin.Last Name') }}</h6>
                            </div>
                            <div class="col-sm-10 text-secondary">
                                <div class="input-group input-group-outline">
                                    <input type="text" class="form-control" name="lname" id="lname" value="{{ $admin->lname }}" placeholder="{{ trans('msg.admin.Last Name') }}">
                                </div>
                                <span class="err_lname text-danger"></span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-2">
                                <h6 class="mb-0">{{ trans('msg.admin.Email') }}</h6>
                            </div>
                            <div class="col-sm-10 text-secondary">
                                <div class="input-group input-group-outline">
                                    <input type="email" class="form-control" name="email" id="email" value="{{ $admin->email }}" placeholder="{{ trans('msg.admin.Email') }}" readonly>
                                </div>
                                <span class="err_email text-danger"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-2">
                                <h6 class="mb-0">{{ trans('msg.admin.Phone') }}</h6>
                            </div>
                            <div class="col-sm-10 text-secondary">
                                <div class="input-group phonecode">
                                    <div class="input-group input-group-outline">
                                        <div class="col-sm-2">
                                            <select class="single-select" id="country-select" name="country_code">
                                                @foreach($country as $code)
                                                    <option value="{{ $code->phone_code }}" @if($admin->country_code == $code->phone_code) selected @endif>{{ $code->phone_code }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="phone" id="phone" value="{{ $admin->phone ?? '' }}" placeholder="{{ trans('msg.admin.Phone') }}">
                                        </div>
                                    </div>
                                </div>
                                <span class="err_phone text-danger"></span>
                            </div>                            
                        </div>
                      
                        <div class="row">
                            <div class="col-sm-8"></div>
                            <div class="col-sm-4">
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary px-2">{{ Str::upper(trans('msg.admin.Cancel')) }}</a>
                                <button type="submit" class="btn bg-gradient-info">{{ Str::upper(trans('msg.admin.Save Changes')) }}</button>
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
            // edit profile picture
            function UploadProfilePicture() {
                $(document).on('change', '.avatar', function() {
                    var formData = new FormData();
                    var old_pic = $('#old_image').val();
                    var file = $('.avatar').prop('files')[0];

                    formData.append("profile_pic", file);
                    formData.append("old_image", old_pic);
                    
                    $.ajax({
                        url: "{{ route('upload-image') }}",
                        type: 'POST',
                        dataType: 'json',
                        data: formData,
                        processData: false,
                        contentType: false,
                        cache: false,
                        async: false,

                        success: function(data) {
                            window.location.reload();

                        }
                    });
                });
            }

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                        $('#imagePreview').hide();
                        $('#imagePreview').fadeIn(650);
                    }

                    reader.readAsDataURL(input.files[0]);
                    UploadProfilePicture();
                    // window.location.reload();
                }
            }
            $("#imageUpload").change(function() {
                readURL(this);
            });

            $("#edit_profile").on('submit', function(e) {
                e.preventDefault();
                let valid = true;
                let form = $(this).get(0);
                let emailPattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
                let email = $("#email").val();
                let err_email = "{{ trans('msg.admin.Enter Valid Email Address') }}";
                let fname = $("#fname").val();
                let err_fname = "{{ trans('msg.admin.Enter Valid First Name') }}";
                let lname = $("#lname").val();
                let err_lname = "{{ trans('msg.admin.Enter Valid Last Name') }}";
                
                let phone = $("#phone").val();
                let err_phone = "{{ trans('msg.admin.Enter Mobile Number') }}";
               
                if (fname.length === 0) {
                    $(".err_fname").text(err_fname);
                    $('#fname').addClass('is-invalid');
                    valid = false;
                } else {
                    $(".err_fname").text('');
                    $('#fname').addClass('is-valid');
                    $('#fname').removeClass('is-invalid');
                }

                if (lname.length === 0) {
                    $(".err_lname").text(err_lname);
                    $('#lname').addClass('is-invalid');
                    valid = false;
                } else {
                    $(".err_lname").text('');
                    $('#lname').addClass('is-valid');
                    $('#lname').removeClass('is-invalid');
                }

                if (email.length === 0 || !emailPattern.test(email)) {
                    $(".err_email").text(err_email);
                    $('#email').addClass('is-invalid');
                    valid = false;
                } else {
                    $(".err_email").text('');
                    $('#email').addClass('is-valid');
                    $('#email').removeClass('is-invalid');

                }

                
                if (phone.length === 0) {
                    $(".err_phone").text(err_phone);
                    $('#phone').addClass('is-invalid');
                    valid = false;
                } else {
                    $(".err_phone").text('');
                    $('#phone').addClass('is-valid');
                    $('#phone').removeClass('is-invalid');

                }
               
                if (valid) {
                    form.submit();
                }
            });

        });
        
    </script>
@endsection