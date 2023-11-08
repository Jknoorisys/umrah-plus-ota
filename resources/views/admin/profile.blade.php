@extends('admin.layouts.app')

@section('content')
  <style type="text/css">
      .avatar-upload {
          position: relative;
          max-width: 205px;
          margin: 10px auto;
      }

      .avatar-edit {
          position: absolute;
          right: 0px;
          left: 60px;
          z-index: 1;
          top: 70px;
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
          left: 11px;
          right: 0;
          text-align: center;
          margin: auto;
      }

      .avatar-preview {
          width: 90px;
          height: 90px;
          border-radius: 10%;
          position: relative;
          /* border: 6px solid #F8F8F8; */
          box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
      }

      .avatar-preview>div {
          width: 100%;
          height: 100%;
          border-radius: 10%;
          background-size: cover;
          background-repeat: no-repeat;
          background-position: center;
      }

  </style>

  <div class="container-fluid px-2 px-md-4">
    <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
      <span class="mask  bg-gradient-info  opacity-6"></span>
    </div>
    <div class="card card-body mx-3 mx-md-4 mt-n6">
      <div class="row gx-4 mb-2">
        <div class="col-auto">
          <div class="avatar avatar-xl position-relative">
                <div class="avatar-upload">
                    <div class="avatar-edit">
                        <input type='file' id="imageUpload" name="thumbnail" class="avatarPic" accept=".png, .jpg, .jpeg" />
                        <input type="hidden" id="old_image" value="{{ $admin->photo ? asset($admin->photo) : asset('assets/images/avatars/no-image.png')}}">
                        <label for="imageUpload"></label>
                    </div>
                    <div class="avatar-preview">
                        <div id="imagePreview" style="background-image: url({{ $admin->photo ? asset($admin->photo) : asset('assets/images/avatars/no-image.png')}});">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-auto my-auto">
          <div class="h-100">
            <h5 class="mb-1">
                {{ $admin->fname. ' '. $admin->lname }}
            </h5>
            <p class="mb-0 font-weight-normal text-sm">
                {{ str_replace('_', ' ', Str::upper($admin->role)) }}
            </p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="row">
          <div class="col-12 col-xl-6">
            <div class="card card-plain h-100">
              <div class="card-header pb-0 p-3">
                <h6 class="mb-0">Profile Details</h6>
              </div>
              <div class="card-body p-3">
                <form id="edit_profile" action="{{ route('update-profile') }}" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="row mb-3">
                    <label for="fname" class="form-label">{{trans('msg.admin.First Name')}}</label>
                    <div class="input-group input-group-outline">
                        <input type="text" class="form-control" name="fname" id="fname" value="{{ $admin->fname }}" placeholder="{{ trans('msg.admin.First Name') }}">
                    </div>
                    <span class="err_fname text-danger"></span>
                  </div>
                  <div class="row mb-3">
                    <label for="lname" class="form-label">{{trans('msg.admin.Last Name')}}</label>
                    <div class="input-group input-group-outline">
                        <input type="text" class="form-control" name="lname" id="lname" value="{{ $admin->lname }}" placeholder="{{ trans('msg.admin.Last Name') }}">
                    </div>
                    <span class="err_lname text-danger"></span>
                  </div>
                  <div class="row mb-3">
                    <label for="email" class="form-label">{{trans('msg.admin.Email')}}</label>
                    <div class="input-group input-group-outline">
                        <input type="email" class="form-control" name="email" id="email" value="{{ $admin->email }}" placeholder="{{ trans('msg.admin.Email') }}" readonly>
                    </div>
                    <span class="err_email text-danger"></span>
                  </div>
                  <div class="row mb-3">
                    <label for="email" class="form-label">{{trans('msg.admin.Phone')}}</label>
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
                  <div class="row">
                      <div class="col-sm-8"></div>
                      <div class="col-sm-4">
                          <button type="submit" class="btn bg-gradient-info">{{ Str::upper(trans('msg.admin.Save Changes')) }}</button>
                      </div>
                  </div>
              </form>
              </div>
            </div>
          </div>
          <div class="col-12 col-xl-6">
            <div class="card card-plain h-100">
              <div class="card-header pb-0 p-3">
                <div class="row">
                  <div class="col-md-8 d-flex align-items-center">
                    <h6 class="mb-0">{{ trans('msg.admin.Change Password') }}</h6>
                  </div>
                </div>
              </div>
              <div class="card-body p-3">
                <form id="change_password" action="{{ route('change-password') }}" method="post">
                  @csrf
                  <div class="col-md-12">
                      <label for="old_password" class="form-label">{{trans('msg.admin.Current Password')}}</label>
                      <div class="input-group" id="show_hide_new_password">
                          <div class="input-group input-group-outline">
                              <input type="password" class="form-control smp-input" style="font-weight: 300;font-size: 15px;color: #38424C;" name="old_password" id="old_password" placeholder="{{ trans('msg.admin.Enter Current Password')}}">
                          </div>
                      </div>
                      <span class="err_old_password text-danger">@error('old_password') {{$message}} @enderror</span>
                  </div>
                  <div class="col-md-12 mt-4">
                      <label for="new_password" class="form-label">{{trans('msg.admin.New Password')}}</label>
                      <div class="input-group" id="show_hide_old_password">
                          <div class="input-group input-group-outline">
                              <input type="password" class="form-control smp-input" style="font-weight: 300;font-size: 15px;color: #38424C;" name="new_password" id="new_password" placeholder="{{ trans('msg.admin.Enter New Password')}}"> 
                          </div>
                      </div>
                      <span class="err_new_password text-danger">@error('new_password') {{$message}} @enderror</span>
                  </div>
                  <div class="col-md-12 mt-4">
                      <label for="password" class="form-label">{{trans('msg.admin.Confirm Password')}}</label>
                      <div class="input-group" id="show_hide_password">
                          <div class="input-group input-group-outline">
                              <input type="password" class="form-control smp-input" style="font-weight: 300;font-size: 15px;color: #38424C;" name="cnfm_password" id="password" placeholder="{{ trans('msg.admin.Confirm Password')}}"> 
                          </div>
                      </div>
                      <span class="err_password text-danger">@error('cnfm_password') {{$message}} @enderror</span>
                  </div>
                  <div class="row mt-4">
                      <div class="col-sm-8"></div>
                      <div class="col-sm-4">
                          <button type="submit" class="btn bg-gradient-info">{{ Str::upper(trans('msg.admin.Save Changes')) }}</button>
                      </div>
                  </div>
              </form>
              </div>
            </div>
          </div>
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
                $(document).on('change', '.avatarPic', function() {
                    var formData = new FormData();
                    var old_pic = $('#old_image').val();
                    var file = $('.avatarPic').prop('files')[0];

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
                            location.reload();
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