@extends('admin.layouts.app')

@section('content')

    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg d-flex justify-content-between align-items-center pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">{{ trans('msg.admin.Send Notification') }}</h6>
            </div>
        </div>
        <div class="card-body">
            <div class="p-4 border rounded">
                <form id="send_notification" action="{{ route('user.send-notification') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="col-md-12">
                                <label for="title" class="form-label">{{ trans('msg.admin.Title') }}</label>
                                <div class="input-group input-group-outline">
                                    <input type="text" class="form-control" id="title" name="title" placeholder="{{ trans('msg.admin.Notification Title') }}">
                                </div>
                                <span class="err_title error text-danger">@error('title') {{$message}} @enderror</span>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label for="type" class="form-label">{{ trans('msg.admin.Select User') }}</label>
                                <div class="input-group input-group-outline">
                                    <select class="single-select" id="type" name="type">
                                        <option selected disabled value="">{{ trans('msg.admin.Choose') }}...</option>
                                        <option value="user">{{ trans('msg.admin.Users') }}</option>
                                        @forelse ($roles as $role)
                                            <option value="{{ $role->role }}">{{ Str::ucfirst(str_replace('_', ' ', $role->role)) }}</option>
                                        @empty
                                            
                                        @endforelse
                                        {{-- <option value="admin">{{ trans('msg.admin.Sub Admins') }}</option>
                                        <option value="user">{{ trans('msg.admin.Users') }}</option> --}}
                                    </select>
                                </div>
                                <span class="err_type error text-danger">@error('type') {{$message}} @enderror</span>
                            </div>
                            <div class="col-md-12 mt-4">
                                <label for="message" class="form-label">{{ trans('msg.admin.Message') }}</label>
                                <div class="input-group input-group-outline">
                                    <textarea rows="5" class="form-control" id="message" name="message" placeholder="{{ trans('msg.admin.Notification Message') }}"></textarea>
                                </div>
                                <span class="err_message error text-danger">@error('message') {{$message}} @enderror</span>
                            </div>
                        </div>
                        <div class="col-lg-4 mt-4">
                            <div class="col-md-12">
                                <div id="uploadArea" class="upload-area">
                                    <!-- Header -->
                                    <div class="upload-area__header">
                                      <h1 class="upload-area__title">Upload your file</h1>
                                      <p class="upload-area__paragraph">
                                        File should be an image
                                        <strong class="upload-area__tooltip">
                                          Like
                                          <span class="upload-area__tooltip-data"></span> <!-- Data Will be Comes From Js -->
                                        </strong>
                                      </p>
                                    </div>
                                    <!-- End Header -->
                                  
                                    <!-- Drop Zoon -->
                                    <div id="dropZoon" class="upload-area__drop-zoon drop-zoon">
                                      <span class="drop-zoon__icon">
                                        <i class='bx bxs-file-image'></i>
                                      </span>
                                      <p class="drop-zoon__paragraph">Drop your file here or Click to browse</p>
                                      <span id="loadingText" class="drop-zoon__loading-text">Please Wait</span>
                                      <img src="" alt="Preview Image" id="previewImage" class="drop-zoon__preview-image" draggable="false">
                                      <input type="file" id="fileInput" name="image" class="drop-zoon__file-input" accept="image/*">
                                    </div>
                                    <!-- End Drop Zoon -->
                                  
                                    <!-- File Details -->
                                    <div id="fileDetails" class="upload-area__file-details file-details d-none">
                                      {{-- <h3 class="file-details__title">Uploaded File</h3> --}}
                                  
                                      <div id="uploadedFile" class="uploaded-file d-none">
                                        <div class="uploaded-file__icon-container">
                                          <i class='bx bxs-file-blank uploaded-file__icon'></i>
                                          <span class="uploaded-file__icon-text"></span> <!-- Data Will be Comes From Js -->
                                        </div>
                                  
                                        <div id="uploadedFileInfo" class="uploaded-file__info d-none">
                                          <span class="uploaded-file__name">Proejct 1</span>
                                          <span class="uploaded-file__counter">0%</span>
                                        </div>
                                      </div>
                                    </div>
                                    <!-- End File Details -->
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-4">
                            <button class="btn bg-gradient-info" type="submit">{{ trans('msg.admin.Send Notification') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
   
@endsection

@section('customJs')
    <script src="{{ asset('assets/js/file-upload.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#send_notification").on('change', function(e) {
                e.preventDefault();
                let valid = true;
                let form = $(this).get(0);
                let title = $("#title").val();
                let err_title = "{{ trans('msg.admin.Enter Valid Title') }}";
                let type = $("#type").val();
                let err_type = "{{ trans('msg.admin.Please Select Valid User Type') }}";
                let message = $("#message").val();
                let err_message = "{{ trans('msg.admin.Enter Valid Message') }}";

                    if (title.length === 0) {
                        $(".err_title").text(err_title);
                        $('#title').addClass('is-invalid');
                        valid = false;
                    } else {
                        $(".err_title").text('');
                        $('#title').addClass('is-valid');
                        $('#title').removeClass('is-invalid');
                    }
                    if (type.length === 0) {
                        $(".err_type").text(err_type);
                        $('#type').addClass('is-invalid');
                        valid = false;
                    } else {
                        $(".err_type").text('');
                        $('#type').addClass('is-valid');
                        $('#type').removeClass('is-invalid');
                    }
                    if (message.length === 0) {
                        $(".err_message").text(err_message);
                        $('#message').addClass('is-invalid');
                        valid = false;
                    } else {
                        $(".err_message").text('');
                        $('#message').addClass('is-valid');
                        $('#message').removeClass('is-invalid');
                    }
                // if (valid) {
                //     form.submit();
                // }
            });
        });
    </script>
@endsection