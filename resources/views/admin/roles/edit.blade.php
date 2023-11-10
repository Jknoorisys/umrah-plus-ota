@extends('admin.layouts.app')

@section('content')
    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg d-flex justify-content-between align-items-center pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">{{ trans('msg.admin.Edit Role') }}</h6>
            </div>
        </div>
        <div class="card-body">
            <div class="p-4 border rounded">
                <form class="row g-3 needs-validation" action="{{ route('role.edit') }}" method="POST" novalidate>
                    @csrf
                    <input type="hidden" name="id" value="{{ $code->id }}">
                    <div class="col-md-12">
                        <label for="role" class="form-label">{{ trans('msg.admin.Role') }}</label>
                        <div class="input-group input-group-outline">
                            <input type="text" class="form-control" id="role" name="role" placeholder="{{ trans('msg.admin.Role') }}" value="{{ $code->role }}" required>
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
                    @foreach($allPrivileges as $privilege => $privilegeName)
                        <div class="col-md-{{ ($privilegeName == 'Cancellation Policies') ? '3' : '2' }} mt-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $privilege }}" name="privilege[]" id="fcustomCheck1"
                                    {{ in_array($privilege, $selectedPrivileges) ? 'checked' : '' }}>
                                <label for="service" class="form-label">
                                    {{ trans('msg.admin.' . $privilegeName) }}
                                </label>
                            </div>
                            <span class="text-danger error">@error('service') {{$message}} @enderror</span>
                            <div class="invalid-feedback">{{ trans('msg.admin.Please select a valid service type') }}.</div>
                        </div>
                    @endforeach

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
    <script>
        function checkAllBoxes(source) {
            var checkboxes = document.querySelectorAll('.form-check-input');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    </script>
@endsection