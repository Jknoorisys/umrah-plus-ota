@extends('admin.layouts.app')

@section('content')
    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg d-flex justify-content-between align-items-center pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">{{ trans('msg.admin.Edit Embassy') }}</h6>
            </div>
        </div>
        <div class="card-body">
            <div class="p-4 border rounded">
                <form class="row g-3 needs-validation" action="{{ route('embassy.edit') }}" method="POST" novalidate>
                    @csrf
                    <input type="hidden" name="id" value="{{ $embassy->id }}">
                    <div class="col-md-12">
                        <label for="embassy" class="form-label">{{ trans('msg.admin.Embassy') }}</label>
                        <div class="input-group input-group-outline">
                            <input embassy="text" class="form-control" id="embassy" name="embassy" value="{{ $embassy->embassy }}" placeholder="{{ trans('msg.admin.Embassy') }}" required>
                        </div>
                        <span class="text-danger error">@error('embassy') {{$message}} @enderror</span>
                        <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid Embassy') }}</div>
                    </div>
                    <div class="col-md-12">
                        <label for="address" class="form-label">{{ trans('msg.admin.Address') }}</label>
                        <div class="input-group input-group-outline">
                            <textarea rows="6" name="address" id="address" placeholder="{{ trans('msg.admin.Enter Address Here') }}..." class="form-control" required >{{ $embassy->address ? $embassy->address : ''  }}</textarea>
                        </div>
                        <span class="text-danger error">@error('address') {{$message}} @enderror</span>
                        <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid Address') }}</div>
                    </div>
                    <div class="col-12">
                        <a href="{{ route('embassy.list') }}" class="btn btn-outline-secondary px-2">{{ Str::upper(trans('msg.admin.Cancel')) }}</a>
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
@endsection