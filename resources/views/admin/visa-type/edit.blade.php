@extends('admin.layouts.app')

@section('content')
    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg d-flex justify-content-between align-items-center pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">{{ trans('msg.admin.Edit Visa Type') }}</h6>
            </div>
        </div>
        <div class="card-body">
            <div class="p-4 border rounded">
                <form class="row g-3 needs-validation" action="{{ route('visa-type.edit') }}" method="POST" novalidate>
                    @csrf
                    <input type="hidden" name="id" value="{{ $type->id }}">
                    <div class="col-md-3">
                        <label for="country_id" class="form-label">{{ trans('msg.admin.Select Country') }}</label>
                        <div class="input-group input-group-outline">
                            <select class="single-select" name="country_id" id="country_id" required>
                                <option disabled {{ old('country_id') == '' ? 'selected' : '' }}>{{ trans('msg.admin.Choose') }}...</option>
                                @forelse ($countries as $country)
                                    <option value="{{ $country->id }}" {{ $type->country_id == $country->id ? 'selected' : '' }}>
                                        {{ $country->country }}
                                    </option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <span class="text-danger error">@error('country_id') {{$message}} @enderror</span>
                        <div class="invalid-feedback">{{ trans('msg.admin.Select Valid Country') }}.</div>
                    </div>
                    <div class="col-md-9">
                        <label for="type" class="form-label">{{ trans('msg.admin.Visa Type') }}</label>
                        <div class="input-group input-group-outline">
                            <input type="text" class="form-control" id="type" name="type" placeholder="{{ trans('msg.admin.Visa Type') }}" value="{{ $type->type }}" required>
                        </div>
                        <span class="text-danger error">@error('type') {{$message}} @enderror</span>
                        <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid Visa Type') }}</div>
                    </div>
                    <div class="col-md-4">
                        <label for="processing_time" class="form-label">{{ trans('msg.admin.Processing Time') }}</label>
                        <div class="input-group input-group-outline">
                            <input type="text" name="processing_time" id="processing_time" placeholder="{{ trans('msg.admin.Ex Upto 5 days') }}" value="{{ $type->processing_time }}" class="form-control" required />
                        </div>
                        <span class="text-danger error">@error('processing_time') {{$message}} @enderror</span>
                        <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid Processing Time') }}</div>
                    </div>
                    <div class="col-md-4">
                        <label for="stay_period" class="form-label">{{ trans('msg.admin.Stay Period') }}</label>
                        <div class="input-group input-group-outline">
                            <input type="text" class="form-control" id="stay_period" name="stay_period" placeholder="{{ trans('msg.admin.Ex 20 days') }}" value="{{ $type->stay_period }}" required>
                        </div>
                        <span class="text-danger error">@error('stay_period') {{$message}} @enderror</span>
                        <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid Stay Period') }}</div>
                    </div>
                    <div class="col-md-4">
                        <label for="validity" class="form-label">{{ trans('msg.admin.Validity') }}</label>
                        <div class="input-group input-group-outline">
                            <input type="text" class="form-control" id="validity" name="validity" placeholder="{{ trans('msg.admin.Ex 30 days') }}" value="{{ $type->validity }}" required>
                        </div>
                        <span class="text-danger error">@error('validity') {{$message}} @enderror</span>
                        <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid Validity') }}</div>
                    </div>
                    <div class="col-md-4">
                        <label for="entry" class="form-label">{{ trans('msg.admin.Entry Type') }}</label>
                        <div class="input-group input-group-outline">
                            <select class="single-select" name="entry" id="entry" required>
                                <option {{ $type->entry == '' ? 'selected' : '' }} disabled>{{ trans('msg.admin.Choose') }}...</option>
                                <option {{ $type->entry == 'single' ? 'selected' : '' }} value="single">{{ trans('msg.admin.Single') }}</option>
                                <option {{ $type->entry == 'multiple' ? 'selected' : '' }} value="multiple">{{ trans('msg.admin.Multiple') }}</option>
                            </select>
                        </div>
                        <span class="text-danger error">@error('type') {{$message}} @enderror</span>
                        <div class="invalid-feedback">{{ trans('msg.admin.Select Valid Entry Type') }}.</div>
                    </div>
                    <div class="col-md-4">
                        <label for="fees" class="form-label">{{ trans('msg.admin.Fees') }}</label>
                        <div class="input-group input-group-outline">
                            <input type="number" class="form-control" step="1" min="0" name="fees" value="{{ $type->fees }}" id="fees" placeholder="{{ trans('msg.admin.Fees') }}" required>
                        </div>
                        <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid Fees') }}</div>
                    </div>
                    <div class="col-md-4">
                        <label for="currency" class="form-label">{{ trans('msg.admin.Currency') }}</label>
                        <div class="input-group input-group-outline">
                            <input type="text" class="form-control" name="currency" value="{{ $type->currency }}" id="currency" placeholder="{{ trans('msg.admin.Ex INR') }}" required>
                        </div>
                        <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid Currency') }}</div>
                    </div>
                    <div class="col-12">
                        <a href="{{ route('visa-type.list') }}" class="btn btn-outline-secondary px-2">{{ Str::upper(trans('msg.admin.Cancel')) }}</a>
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
@endsection