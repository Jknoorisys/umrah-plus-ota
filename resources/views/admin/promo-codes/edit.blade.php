@extends('admin.layouts.app')

@section('content')
    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg d-flex justify-content-between align-items-center pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">{{ trans('msg.admin.Edit Promo Code') }}</h6>
            </div>
        </div>
        <div class="card-body">
            <div class="p-4 border rounded">
                <form class="row g-3 needs-validation" action="{{ route('promo-code.edit') }}" method="POST" novalidate>
                    @csrf
                    <input type="hidden" name="id" value="{{ $code->id }}">
                    <div class="col-md-4">
                        <label for="service" class="form-label">{{ trans('msg.admin.Service Type') }}</label>
                        <div class="input-group input-group-outline">
                            <select class="single-select" name="service" id="service" required>
                                <option value="" {{ $code->service == '' ? 'selected' : '' }} disabled>{{ trans('msg.admin.Choose') }}...</option>
                                <option value="hotel" {{ $code->service == 'hotel' ? 'selected' : '' }}>{{ trans('msg.admin.Hotel') }}</option>
                                <option value="flight" {{ $code->service == 'flight' ? 'selected' : '' }}>{{ trans('msg.admin.Flight') }}</option>
                                <option value="transfer" {{ $code->service == 'transfer' ? 'selected' : '' }}>{{ trans('msg.admin.Transfer') }}</option>
                                <option value="activity" {{ $code->service == 'activity' ? 'selected' : '' }}>{{ trans('msg.admin.Activities') }}</option>
                                <option value="umrah" {{ $code->service == 'umrah' ? 'selected' : '' }}>{{ trans('msg.admin.Umrah') }}</option>
                                <option value="ziyarat" {{ $code->service == 'ziyarat' ? 'selected' : '' }}>{{ trans('msg.admin.Ziyarat') }}</option>
                                <option value="visa" {{ $code->service == 'visa' ? 'selected' : '' }}>{{ trans('msg.admin.Visa') }}</option>
                            </select> 
                        </div>                       
                        <div class="invalid-feedback">{{ trans('msg.admin.Please select a valid service type') }}.</div>
                    </div>
                    <div class="col-md-4">
                        <label for="start_date" class="form-label">{{ trans('msg.admin.Start Date') }}</label>
                        <div class="input-group input-group-outline">
                            <input type="text" name="start_date" id="start_date" placeholder="{{ trans('msg.admin.Start Date') }}" value="{{ $code->start_date }}" class="form-control datepicker" required />
                        </div>
                        <span class="text-danger error">@error('start_date') {{$message}} @enderror</span>
                        <div class="invalid-feedback">{{ trans('msg.admin.Select Valid Start Date') }}</div>
                    </div>
                    <div class="col-md-4">
                        <label for="expire_date" class="form-label">{{ trans('msg.admin.Expire Date') }}</label>
                        <div class="input-group input-group-outline">
                            <input type="text" name="expire_date" id="expire_date" placeholder="{{ trans('msg.admin.Expire Date') }}" value="{{ $code->expire_date }}" class="form-control datepicker" required />
                        </div>
                        <span class="text-danger error">@error('expire_date') {{$message}} @enderror</span>
                        <div class="invalid-feedback">{{ trans('msg.admin.Select Valid Expire Date') }}</div>
                    </div>
                    <div class="col-md-4">
                        <label for="code" class="form-label">{{ trans('msg.admin.Code') }}</label>
                        <div class="input-group input-group-outline">
                            <input type="text" class="form-control" id="code" name="code" placeholder="{{ trans('msg.admin.Ex FIRST50') }}" value="{{ $code->code }}" oninput="toUppercase()" required>
                        </div>
                        <span class="text-danger">@error('code') {{$message}} @enderror</span>
                        <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid Promo Code') }}</div>
                    </div>
                    <div class="col-md-4">
                        <label for="type" class="form-label">{{ trans('msg.admin.Discount Type') }}</label>
                        <div class="input-group input-group-outline">
                            <select class="single-select" name="type" id="type" required>
                                <option value="" {{ $code->type == '' ? 'selected' : '' }} disabled>{{ trans('msg.admin.Choose') }}...</option>
                                <option value="flat" {{ $code->type == 'flat' ? 'selected' : '' }}>{{ trans('msg.admin.Flat') }}</option>
                                <option value="percentage" {{ $code->type == 'percentage' ? 'selected' : '' }}>{{ trans('msg.admin.Percentage') }}</option>
                            </select>
                        </div>                        
                        <div class="invalid-feedback">{{ trans('msg.admin.Please select a valid discount type') }}.</div>
                    </div>
                    <div class="col-md-4">
                        <label for="discount" class="form-label">{{ trans('msg.admin.Discount') }}</label>
                        <div class="input-group input-group-outline">
                            <input type="number" class="form-control" step="0.5" min="0" name="discount" id="discount" value="{{ $code->discount }}" placeholder="{{ trans('msg.admin.Discount') }}" required>
                        </div>
                        <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid Discount') }}</div>
                    </div>
                    <div class="col-md-4">
                        <label for="max_discount" class="form-label">{{ trans('msg.admin.Max Discount') }}</label>
                        <div class="input-group input-group-outline">
                            <input type="number" class="form-control" step="0.5" min="0" name="max_discount" value="{{ $code->max_discount }}" id="max_discount" placeholder="{{ trans('msg.admin.Max Discount') }}" required>
                        </div>
                        <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid Max Discount') }}</div>
                    </div>
                    <div class="col-md-4">
                        <label for="min_purchase" class="form-label">{{ trans('msg.admin.Min Purchase') }}</label>
                        <div class="input-group input-group-outline">
                            <input type="number" class="form-control" step="0.5" min="0" name="min_purchase" value="{{ $code->min_purchase }}" id="min_purchase" placeholder="{{ trans('msg.admin.Min Purchase') }}" required>
                        </div>
                        <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid Min Purchase') }}</div>
                    </div>
                    <div class="col-md-4">
                        <label for="max_usage_per_user" class="form-label">{{ trans('msg.admin.Max Usage Per User') }}</label>
                        <div class="input-group input-group-outline">
                            <input type="number" class="form-control" min="0" name="max_usage_per_user" id="max_usage_per_user" value="{{ $code->max_usage_per_user }}" placeholder="{{ trans('msg.admin.Max Usage Per User') }}" required>
                        </div>
                        <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid Max Usage Per User') }}</div>
                    </div>
                    <div class="col-12">
                        <a href="{{ route('promo-code.list') }}" class="btn btn-outline-secondary px-2">{{ Str::upper(trans('msg.admin.Cancel')) }}</a>
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