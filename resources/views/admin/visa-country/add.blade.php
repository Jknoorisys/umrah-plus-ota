@extends('admin.layouts.app')

@section('content')
    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg d-flex justify-content-between align-items-center pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">{{ trans('msg.admin.Add Visa Country') }}</h6>
            </div>
        </div>
        <div class="card-body">
            <div class="p-4 border rounded">
                <div class="nav-wrapper position-relative end-0">
                  
                
                    <form class="row g-3 needs-validation" action="{{ route('visa-country.add') }}" method="POST" novalidate>
                        @csrf

                        <ul class="nav nav-pills nav-fill p-1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#profile-tabs-icons" role="tab" aria-controls="preview" aria-selected="true">
                                    English
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#dashboard-tabs-icons" role="tab" aria-controls="code" aria-selected="false">
                                    Arabic
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                           
                            <!-- English Tab Content -->
                            <div class="tab-pane fade show active" id="profile-tabs-icons" role="tabpanel" aria-labelledby="profile-tab-icons">
                                <div class="col-md-12 mt-2">
                                    <label for="policy_en" class="form-label">{{ trans('msg.admin.Cancellation Policy') }}</label>
                                    <textarea id="policy_en" name="policy_en" rows="4" data-sample="3" data-sample-short></textarea>
                                    <span class="text-danger error">@error('policy_en') {{$message}} @enderror</span>
                                    <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid policy_en') }}</div>
                                </div>
                            </div>
                    
                            <!-- Arabic Tab Content -->
                            <div class="tab-pane fade" id="dashboard-tabs-icons" role="tabpanel" aria-labelledby="dashboard-tab-icons">
                                <div class="col-md-12 mt-2">
                                    <label for="policy_ar" class="form-label">{{ trans('msg.admin.Cancellation Policy') }}</label>
                                    <textarea id="policy_ar" name="policy_ar" rows="4" data-sample="3" data-sample-short></textarea>
                                    <span class="text-danger error">@error('policy_ar') {{$message}} @enderror</span>
                                    <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid policy_ar') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mt-4">
                            <label for="service" class="form-label">{{ trans('msg.admin.Service Type') }}</label>
                            <div class="input-group input-group-outline">
                                <select class="single-select" name="service" id="service" required>
                                    <option value="" disabled>{{ trans('msg.admin.Choose') }}...</option>
                                    <option value="hotel" >{{ trans('msg.admin.Hotel') }}</option>
                                    <option value="flight" >{{ trans('msg.admin.Flight') }}</option>
                                    <option value="transfer" >{{ trans('msg.admin.Transfer') }}</option>
                                    <option value="activity" >{{ trans('msg.admin.Activities') }}</option>
                                    <option value="umrah" >{{ trans('msg.admin.Umrah') }}</option>
                                    <option value="ziyarat" >{{ trans('msg.admin.Ziyarat') }}</option>
                                    <option value="visa" >{{ trans('msg.admin.Visa') }}</option>
                                </select> 
                            </div>                       
                            <div class="invalid-feedback">{{ trans('msg.admin.Please select a valid service type') }}.</div>
                        </div>

                        <div class="col-md-6 mt-4">
                            <label for="before_7_days" class="form-label">{{ trans('msg.admin.7 Days Before').' (%)' }}</label>
                            <div class="input-group input-group-outline">
                                <input type="number" class="form-control" step="0.5" min="0" name="before_7_days" id="before_7_days" placeholder="{{ trans('msg.admin.7 Days Before') }}" required>
                            </div>
                            <span class="text-danger error">@error('before_7_days') {{$message}} @enderror</span>
                        </div>

                        <div class="col-md-6 mt-4">
                            <label for="within_24_hours" class="form-label">{{ trans('msg.admin.Within 24 Hours').' (%)' }}</label>
                            <div class="input-group input-group-outline">
                                <input type="number" class="form-control" step="0.5" min="0" name="within_24_hours" id="within_24_hours"  placeholder="{{ trans('msg.admin.7 Days Before') }}" required>
                            </div>
                            <span class="text-danger error">@error('within_24_hours') {{$message}} @enderror</span>
                        </div>

                        <div class="col-md-6 mt-4">
                            <label for="less_than_24_hours" class="form-label">{{ trans('msg.admin.Less than 24 Hours').' (%)' }}</label>
                            <div class="input-group input-group-outline">
                                <input type="number" class="form-control" step="0.5" min="0" name="less_than_24_hours" placeholder="{{ trans('msg.admin.7 Days Before') }}" required>
                            </div>
                            <span class="text-danger error">@error('less_than_24_hours') {{$message}} @enderror</span>
                        </div>
                    
                        <div class="col-12 mt-4">
                            <a href="{{ route('visa-country.list') }}" class="btn btn-outline-secondary px-2">{{ Str::upper(trans('msg.admin.Cancel')) }}</a>
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