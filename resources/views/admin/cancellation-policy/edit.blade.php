@extends('admin.layouts.app')

@section('content')


    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg d-flex justify-content-between align-items-center pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">{{ trans('msg.admin.Edit Cancellation Policy') }}</h6>
            </div>
        </div>
        <div class="card-body">
            <div class="p-4 border rounded">
                <div class="nav-wrapper position-relative end-0">
                  
                
                    <form class="row g-3 needs-validation" action="{{ route('cancellation-policy.edit') }}" method="POST" novalidate>
                        @csrf
                        <input type="hidden" name="id" value="{{ $policy->id }}">

                        <ul class="nav nav-pills nav-fill p-1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#profile-tabs-icons" role="tab" aria-controls="preview" aria-selected="true">
                                    {{ trans('msg.admin.English') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#dashboard-tabs-icons" role="tab" aria-controls="code" aria-selected="false">
                                    {{ trans('msg.admin.Arabic') }}
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                           
                            <!-- English Tab Content -->
                            <div class="tab-pane fade show active" id="profile-tabs-icons" role="tabpanel" aria-labelledby="profile-tab-icons">
                                <div class="col-md-12 mt-2">
                                    <label for="policy_en" class="form-label">{{ trans('msg.admin.Cancellation Policy') }}</label>
                                    {{-- <div class="input-group input-group-outline">
                                        <input type="text" class="form-control" id="policy_en" name="policy_en" placeholder="{{ trans('msg.admin.Cancellation Policy') }}" value="{{ $policy->policy_en }}" required>
                                    </div> --}}
                                    <textarea id="policy_en" name="policy_en" rows="4" data-sample="3" data-sample-short>{{ $policy->policy_en ?  $policy->policy_en : '' }}</textarea>
                                    <span class="text-danger error">@error('policy_en') {{$message}} @enderror</span>
                                    <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid policy_en') }}</div>
                                </div>
                            </div>
                    
                            <!-- Arabic Tab Content -->
                            <div class="tab-pane fade" id="dashboard-tabs-icons" role="tabpanel" aria-labelledby="dashboard-tab-icons">
                                <div class="col-md-12 mt-2">
                                    <label for="policy_ar" class="form-label">{{ trans('msg.admin.Cancellation Policy') }}</label>
                                    {{-- <div class="input-group input-group-outline">
                                        <input type="text" class="form-control" id="policy_ar" name="policy_ar" placeholder="{{ trans('msg.admin.Cancellation Policy') }}" value="{{ $policy->policy_ar }}" required>
                                    </div> --}}
                                    <textarea id="policy_ar" name="policy_ar" rows="4" data-sample="3" data-sample-short>{{ $policy->policy_ar ?  $policy->policy_ar : '' }}</textarea>
                                    <span class="text-danger error">@error('policy_ar') {{$message}} @enderror</span>
                                    <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid policy_ar') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mt-4">
                            <label for="service" class="form-label">{{ trans('msg.admin.Service Type') }}</label>
                            <div class="input-group input-group-outline">
                                <select class="single-select" name="service" id="service" required>
                                    <option value="" {{ $policy->service == '' ? 'selected' : '' }} disabled>{{ trans('msg.admin.Choose') }}...</option>
                                    <option value="hotel" {{ $policy->service == 'hotel' ? 'selected' : '' }}>{{ trans('msg.admin.Hotel') }}</option>
                                    <option value="flight" {{ $policy->service == 'flight' ? 'selected' : '' }}>{{ trans('msg.admin.Flight') }}</option>
                                    <option value="transfer" {{ $policy->service == 'transfer' ? 'selected' : '' }}>{{ trans('msg.admin.Transfer') }}</option>
                                    <option value="activity" {{ $policy->service == 'activity' ? 'selected' : '' }}>{{ trans('msg.admin.Activities') }}</option>
                                    <option value="umrah" {{ $policy->service == 'umrah' ? 'selected' : '' }}>{{ trans('msg.admin.Umrah') }}</option>
                                    <option value="ziyarat" {{ $policy->service == 'ziyarat' ? 'selected' : '' }}>{{ trans('msg.admin.Ziyarat') }}</option>
                                    <option value="visa" {{ $policy->service == 'visa' ? 'selected' : '' }}>{{ trans('msg.admin.Visa') }}</option>
                                </select> 
                            </div>                       
                            <div class="invalid-feedback">{{ trans('msg.admin.Please select a valid service type') }}.</div>
                        </div>

                        <div class="col-md-6 mt-4">
                            <label for="before_7_days" class="form-label">{{ trans('msg.admin.7 Days Before').' (%)' }}</label>
                            <div class="input-group input-group-outline">
                                <input type="number" class="form-control" step="0.5" min="0" name="before_7_days" id="before_7_days" value="{{ $policy->before_7_days }}" placeholder="{{ trans('msg.admin.7 Days Before') }}" required>
                            </div>
                            <span class="text-danger error">@error('before_7_days') {{$message}} @enderror</span>
                        </div>

                        <div class="col-md-6 mt-4">
                            <label for="within_24_hours" class="form-label">{{ trans('msg.admin.Within 24 Hours').' (%)' }}</label>
                            <div class="input-group input-group-outline">
                                <input type="number" class="form-control" step="0.5" min="0" name="within_24_hours" id="within_24_hours" value="{{ $policy->within_24_hours }}" placeholder="{{ trans('msg.admin.7 Days Before') }}" required>
                            </div>
                            <span class="text-danger error">@error('within_24_hours') {{$message}} @enderror</span>
                        </div>

                        <div class="col-md-6 mt-4">
                            <label for="less_than_24_hours" class="form-label">{{ trans('msg.admin.Less than 24 Hours').' (%)' }}</label>
                            <div class="input-group input-group-outline">
                                <input type="number" class="form-control" step="0.5" min="0" name="less_than_24_hours" id="less_than_24_hours" value="{{ $policy->less_than_24_hours }}" placeholder="{{ trans('msg.admin.7 Days Before') }}" required>
                            </div>
                            <span class="text-danger error">@error('less_than_24_hours') {{$message}} @enderror</span>
                        </div>
                    
                        <div class="col-12 mt-4">
                            <a href="{{ route('cancellation-policy.list') }}" class="btn btn-outline-secondary px-2">{{ Str::upper(trans('msg.admin.Cancel')) }}</a>
                            <button class="btn bg-gradient-info" type="submit">{{ Str::upper(trans('msg.admin.Save Changes')) }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customJs')
    <script data-sample="3">
        CKEDITOR.replace('policy_en', {
            height: 200
        });

        CKEDITOR.replace('policy_ar', {
            height: 200
        });
    </script>
    <script>
        var tab = new bootstrap.Tab(document.querySelector('#profile-tabs-icons'));
        tab.show();
    </script>
@endsection