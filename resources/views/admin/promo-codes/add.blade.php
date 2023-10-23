@extends('admin.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="p-4 border rounded">
                <form class="row g-3 needs-validation" action="{{ route('promo-code.add') }}" method="POST" novalidate>
                    @csrf
                    <div class="col-md-4">
                        <label for="service" class="form-label">{{ trans('msg.admin.Service Type') }}</label>
                        <select class="form-select" name="service" id="service" required>
                            <option disabled {{ old('service') == '' ? 'selected' : '' }}>{{ trans('msg.admin.Choose') }}...</option>
                            <option value="hotel">{{ trans('msg.admin.Hotel') }}</option>
                            <option value="flight">{{ trans('msg.admin.Flight') }}</option>
                            <option value="transfer">{{ trans('msg.admin.Transfer') }}</option>
                            <option value="activity">{{ trans('msg.admin.Activities') }}</option>
                            <option value="umrah">{{ trans('msg.admin.Umrah') }}</option>
                            <option value="ziyarat">{{ trans('msg.admin.Ziyarat') }}</option>
                            <option value="visa">{{ trans('msg.admin.Visa') }}</option>
                        </select>
                        <span class="text-danger">@error('service') {{$message}} @enderror</span>
                        <div class="invalid-feedback">{{ trans('msg.admin.Please select a valid service type') }}.</div>
                    </div>
                    <div class="col-md-4">
                        <label for="start_date" class="form-label">{{ trans('msg.admin.Start Date') }}</label>
                        <input type="text" name="start_date" id="start_date" placeholder="{{ trans('msg.admin.Start Date') }}" value="{{ old('start_date') }}" class="form-control datepicker" required />
                        <span class="text-danger">@error('start_date') {{$message}} @enderror</span>
                        <div class="invalid-feedback">{{ trans('msg.admin.Select Valid Start Date') }}</div>
                    </div>
                    <div class="col-md-4">
                        <label for="expire_date" class="form-label">{{ trans('msg.admin.Expire Date') }}</label>
                        <input type="text" name="expire_date" id="expire_date" placeholder="{{ trans('msg.admin.Expire Date') }}" value="{{ old('expire_date') }}" class="form-control datepicker" required />
                        <span class="text-danger">@error('expire_date') {{$message}} @enderror</span>
                        <div class="invalid-feedback">{{ trans('msg.admin.Select Valid Expire Date') }}</div>
                    </div>
                    <div class="col-md-4">
                        <label for="code" class="form-label">{{ trans('msg.admin.Code') }}</label>
                        <input type="text" class="form-control" id="code" name="code" placeholder="{{ trans('msg.admin.Ex FIRST50') }}" value="{{ old('code') }}" oninput="toUppercase()" required>
                        <span class="text-danger">@error('code') {{$message}} @enderror</span>
                        <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid Promo Code') }}</div>
                    </div>
                    <div class="col-md-4">
                        <label for="type" class="form-label">{{ trans('msg.admin.Discount Type') }}</label>
                        <select class="form-select" name="type" id="type" required>
                            <option {{ old('type') == '' ? 'selected' : '' }} disabled>{{ trans('msg.admin.Choose') }}...</option>
                            <option value="flat">{{ trans('msg.admin.Flat') }}</option>
                            <option value="percentage">{{ trans('msg.admin.Percentage') }}</option>
                        </select>
                        <span class="text-danger">@error('type') {{$message}} @enderror</span>
                        <div class="invalid-feedback">{{ trans('msg.admin.Please select a valid discount type') }}.</div>
                    </div>
                    <div class="col-md-4">
                        <label for="discount" class="form-label">{{ trans('msg.admin.Discount') }}</label>
                        <input type="number" class="form-control" step="0.5" min="0" name="discount" id="discount" value="{{ old('discount') }}" placeholder="{{ trans('msg.admin.Discount') }}" required>
                        <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid Discount') }}</div>
                    </div>
                    <div class="col-md-4">
                        <label for="max_discount" class="form-label">{{ trans('msg.admin.Max Discount') }}</label>
                        <input type="number" class="form-control" step="0.5" min="0" name="max_discount" value="{{ old('max_discount') }}" id="max_discount" placeholder="{{ trans('msg.admin.Max Discount') }}" required>
                        <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid Max Discount') }}</div>
                    </div>
                    <div class="col-md-4">
                        <label for="min_purchase" class="form-label">{{ trans('msg.admin.Min Purchase') }}</label>
                        <input type="number" class="form-control" step="0.5" min="0" name="min_purchase" value="{{ old('min_purchase') }}" id="min_purchase" placeholder="{{ trans('msg.admin.Min Purchase') }}" required>
                        <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid Min Purchase') }}</div>
                    </div>
                    <div class="col-md-4">
                        <label for="max_usage_per_user" class="form-label">{{ trans('msg.admin.Max Usage Per User') }}</label>
                        <input type="number" class="form-control" min="0" name="max_usage_per_user" id="max_usage_per_user" value="{{ old('max_usage_per_user') }}" placeholder="{{ trans('msg.admin.Max Usage Per User') }}" required>
                        <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid Max Usage Per User') }}</div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">{{ Str::upper(trans('msg.admin.Save Changes')) }}</button>
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