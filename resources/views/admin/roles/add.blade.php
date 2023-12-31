@extends('admin.layouts.app')

@section('content')
    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg d-flex justify-content-between align-items-center pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">{{ trans('msg.admin.Add Role') }}</h6>
            </div>
        </div>
        <div class="card-body">
            <div class="p-4 border rounded">
                <form class="row g-3 needs-validation" action="{{ route('role.add') }}" method="POST" novalidate>
                    @csrf
                    <div class="col-md-12">
                        <label for="role" class="form-label">{{ trans('msg.admin.Role') }}</label>
                        <div class="input-group input-group-outline">
                            <input type="text" class="form-control" id="role" name="role" placeholder="{{ trans('msg.admin.Role') }}" value="{{ old('role') }}" required>
                        </div>
                        <span class="text-danger error">@error('role') {{$message}} @enderror</span>
                        <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid Role') }}</div>
                    </div>
                    <div class="d-flex flex-wrap select--all-checkes mt-4">
                        <h5 class="input-label m-0 text-capitalize">{{ trans('msg.admin.System Module Permissions') }} : </h5>
                        <div class="check-item pb-0 w-auto">
                            <div class="form-group form-check form--check m-0 ml-2">
                                <input type="checkbox" name="modules[]" value="collect_cash" class="form-check-input" id="checkAll" onclick="checkAllBoxes(this)">
                                <label class="form-check-label ml-2" for="select-all">Select all</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 mt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="privilege[]" id="fcustomCheck1">
                            <label for="service" class="form-label">{{ trans('msg.admin.Users') }}</label>
                        </div>
                    </div>
                    <div class="col-md-2 mt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="2" name="privilege[]" id="fcustomCheck1">
                            <label for="service" class="form-label">{{ trans('msg.admin.Sub Admin') }}</label>
                        </div>
                    </div>
                    <div class="col-md-2 mt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="3" name="privilege[]" id="fcustomCheck1">
                            <label for="service" class="form-label">{{ trans('msg.admin.Roles') }}</label>
                        </div>
                    </div>
                    <div class="col-md-2 mt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="4" name="privilege[]" id="fcustomCheck1">
                            <label for="service" class="form-label">{{ trans('msg.admin.Promo Codes') }}</label>
                        </div>
                    </div>
                    <div class="col-md-2 mt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="5" name="privilege[]" id="fcustomCheck1">
                            <label for="service" class="form-label">{{ trans('msg.admin.Markups') }}</label>
                        </div>
                    </div>
                    <div class="col-md-2 mt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="6" name="privilege[]" id="fcustomCheck1">
                            <label for="service" class="form-label">{{ trans('msg.admin.Send Notification') }}</label>
                        </div>
                    </div>
                    <div class="col-md-2 mt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="7" name="privilege[]" id="fcustomCheck1">
                            <label for="service" class="form-label">{{ trans('msg.admin.Embassy') }}</label>
                        </div>
                    </div>
                    <div class="col-md-2 mt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="8" name="privilege[]" id="fcustomCheck1">
                            <label for="service" class="form-label">{{ trans('msg.admin.Visa Packages') }}</label>
                        </div>
                    </div>
                    <div class="col-md-2 mt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="9" name="privilege[]" id="fcustomCheck1">
                            <label for="service" class="form-label">{{ trans('msg.admin.Visa Types') }}</label>
                        </div>
                    </div>
                    <div class="col-md-2 mt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="10" name="privilege[]" id="fcustomCheck1">
                            <label for="service" class="form-label">{{ trans('msg.admin.Notifications') }}</label>
                        </div>
                    </div>
                    <div class="col-md-3 mt-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="11" name="privilege[]" id="fcustomCheck1">
                            <label for="service" class="form-label">{{ trans('msg.admin.Cancellation Policies') }}</label>
                        </div>
                    </div>
                    
                    <div class="col-12 mt-4">
                        <a href="{{ route('role.list') }}" class="btn btn-outline-secondary px-2">{{ Str::upper(trans('msg.admin.Cancel')) }}</a>
                        <button class="btn bg-gradient-info" type="submit">{{ Str::upper(trans('msg.admin.Save Changes')) }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('customJs')
    <script>
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
    <script>
        function checkAllBoxes(source) {
            var checkboxes = document.querySelectorAll('.form-check-input');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    </script>
@endsection