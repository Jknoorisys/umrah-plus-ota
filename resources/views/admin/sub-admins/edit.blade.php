@extends('admin.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="p-4 border rounded">
                <form class="row g-3 needs-validation" action="{{ route('sub-admin.add') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-md-4 mt-4">
                                <label for="fname" class="form-label">{{ trans('msg.admin.First Name') }}</label>
                                <div class="input-group input-group-outline">
                                    <input type="text" class="form-control" id="fname" name="fname" value="{{ $subadmin->fname }}" placeholder="{{ trans('msg.admin.First Name') }}" required>
                                </div>
                                <span class="text-danger error">@error('fname') {{$message}} @enderror</span>
                                <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid First Name') }}</div>
                            </div>
                            <div class="col-md-4 mt-4">
                                <label for="lname" class="form-label">{{ trans('msg.admin.Last Name') }}</label>
                                <div class="input-group input-group-outline">
                                    <input type="text" class="form-control" id="lname" name="lname" value="{{ $subadmin->lname }}" placeholder="{{ trans('msg.admin.Last Name') }}" required>
                                </div>
                                <span class="text-danger error">@error('lname') {{$message}} @enderror</span>
                                <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid Last Name') }}</div>
                            </div>
                            <div class="col-md-4 mt-4">
                                <label for="role" class="form-label">{{ trans('msg.admin.Select Role') }}</label>
                                <div class="input-group input-group-outline">
                                    <select class="single-select" id="role" name="role" required>
                                        <option selected disabled value="">{{ trans('msg.admin.Choose') }}...</option>
                                        @forelse ($roles as $role)
                                            <option value="{{ $role->role }}">{{ str_replace('_', ' ', Str::ucfirst($role->role)) }}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                </div>
                                <span class="text-danger error">@error('role') {{$message}} @enderror</span>
                                <div class="invalid-feedback">{{ trans('msg.admin.Please Select Valid Role') }}</div>
                            </div>
                            <div class="col-md-6 mt-4">
                                <label for="email" class="form-label">{{ trans('msg.admin.Email') }}</label>
                                <div class="input-group input-group-outline">
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $subadmin->email }}" placeholder="{{ trans('msg.admin.Email') }}" required>
                                </div>
                                <span class="text-danger error">@error('email') {{$message}} @enderror</span>
                                <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid email') }}</div>
                            </div>
                            <div class="col-md-6 mt-4">
                                <label for="phone" class="form-label">{{ trans('msg.admin.Phone') }}</label>
                                <div class="input-group phonecode">
                                    <div class="input-group input-group-outline">
                                        <div class="col-sm-3">
                                            <select class="single-select" value="{{ old('country_code') }}" id="country-select" name="country_code" required>
                                                @foreach($country as $code)
                                                    <option value="{{ $code->phone_code }}">{{ $code->phone_code }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="tel" class="form-control" name="phone" value="{{ old('phone') }}" id="phone" placeholder="{{ trans('msg.admin.Phone') }}" required>
                                    </div>
                                    <span class="text-danger error">@error('phone') {{$message}} @enderror</span>
                                    <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid Phone Number') }}</div>  
                                </div>                          
                            </div>
                            <div class="col-md-6 mt-4">
                                <label for="password" class="form-label">{{ trans('msg.admin.Password') }}</label>
                                <div class="input-group input-group-outline">
                                    <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" placeholder="{{ trans('msg.admin.Password') }}" required>
                                </div>
                                <span class="text-danger error">@error('password') {{$message}} @enderror</span>
                                <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid Password') }}</div>
                            </div>
                            <div class="col-md-6 mt-4">
                                <label for="cnfm_password" class="form-label">{{ trans('msg.admin.Confirm Password') }}</label>
                                <div class="input-group input-group-outline">
                                    <input type="password" class="form-control" id="cnfm_password" name="cnfm_password" placeholder="{{ trans('msg.admin.Confirm Password') }}" required>
                                </div>
                                <span class="text-danger error">@error('cnfm_password') {{$message}} @enderror</span>
                                <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid Confirm Password') }}</div>
                            </div>                            
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="col-md-12">
                            <div id="uploadArea" class="upload-area">
                                <!-- Header -->
                                <div class="upload-area__header">
                                  <p class="upload-area__title">{{ trans('msg.admin.Image') }}</p>
                                  <p class="upload-area__paragraph">
                                    File should be an image
                                    <strong class="upload-area__tooltip">
                                      Like
                                      <span class="upload-area__tooltip-data"></span> 
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
                                    <input type="file" id="fileInput" name="image" class="drop-zoon__file-input" value="{{ old('image') }}" accept="image/*" required>
                                    <span class="text-danger error">@error('image') {{$message}} @enderror</span>
                                    <div class="invalid-feedback">{{ trans('msg.admin.Select Valid Profile Photo') }}</div>
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
                    <div class="col-md-12">
                        <a href="{{ route('sub-admin.list') }}" class="btn btn-outline-secondary px-2">{{ Str::upper(trans('msg.admin.Cancel')) }}</a>
                        <button class="btn bg-gradient-info" type="submit">{{ trans('msg.admin.Save Changes') }}</button>
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
            $('#cnfm_password').on('keyup', function () {
                if ($('#password').val() != $('#cnfm_password').val()) {
                    $('#cnfm_password').get(0).setCustomValidity('Passwords do not match');
                } else {
                    $('#cnfm_password').get(0).setCustomValidity('');
                }
            });
        });
    </script>
        
    <script>
        function toUppercase() {
            var input = document.getElementById('code');
            input.value = input.value.toUpperCase();
        }

        // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function () {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
                })
            })()
    </script>
@endsection