@extends('admin.layouts.app')

@section('content')
    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg d-flex justify-content-between align-items-center pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">{{ trans('msg.admin.Add Visa Package') }}</h6>
            </div>
        </div>
        <div class="card-body">
            <div class="p-4 border rounded">
                <div class="nav-wrapper position-relative end-0">
                
                    <form class="row g-3 needs-validation" action="{{ route('visa-package.add') }}" method="POST" novalidate>
                        @csrf

                        <ul class="nav nav-pills nav-fill p-1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#details-tabs-icons" role="tab" aria-controls="preview" aria-selected="true">
                                    {{ trans('msg.admin.Process') }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#documnets-tabs-icons" role="tab" aria-controls="code" aria-selected="false">
                                    {{ trans('msg.admin.Documents') }}
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                           
                            <!-- Process Tab Content -->
                            <div class="tab-pane fade show active" id="details-tabs-icons" role="tabpanel" aria-labelledby="details-tab-icons">
                                <div class="col-md-12 mt-2">
                                    <label for="process" class="form-label">{{ trans('msg.admin.Process') }}</label>
                                    <textarea id="process" name="process" rows="4" data-sample="3" data-sample-short></textarea>
                                    <span class="text-danger error">@error('process') {{$message}} @enderror</span>
                                    <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid Process') }}</div>
                                </div>
                            </div>
                    
                            <!-- Documents Tab Content -->
                            <div class="tab-pane fade" id="documnets-tabs-icons" role="tabpanel" aria-labelledby="documnets-tab-icons">
                                <div class="col-md-12 mt-2">
                                    <label for="documents" class="form-label">{{ trans('msg.admin.Documents') }}</label>
                                    <textarea id="documents" name="documents" rows="4" data-sample="3" data-sample-short></textarea>
                                    <span class="text-danger error">@error('documents') {{$message}} @enderror</span>
                                    <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid Documents') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mt-4">
                            <label for="country" class="form-label">{{ trans('msg.admin.Country') }}</label>
                            <div class="input-group input-group-outline">
                                <input type="text" class="form-control" name="country" id="country" placeholder="{{ trans('msg.admin.Country') }}" required>
                            </div>
                            <span class="text-danger error">@error('country') {{$message}} @enderror</span>
                        </div>

                        <div class="col-md-6 mt-4">
                            <label for="processing_time" class="form-label">{{ trans('msg.admin.Processing Time') }}</label>
                            <div class="input-group input-group-outline">
                                <input type="text" class="form-control" name="processing_time" id="processing_time"  placeholder="{{ trans('msg.admin.Ex 5 to 7 Working days') }}" required>
                            </div>
                            <span class="text-danger error">@error('processing_time') {{$message}} @enderror</span>
                        </div>

                        <div class="col-md-12">
                            <label for="embassy" class="form-label">{{ trans('msg.admin.Select Embassy') }}</label>
                            <div class="input-group input-group-outline">
                                <select class="select2 form-control" multiple="multiple" style="height: 36px;width: 100%;" name="embassy[]" id="embassy" required>
                                    @forelse ($embassies as $embassy)
                                        <option value="{{ $embassy->id }}">{{ $embassy->embassy }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <span class="text-danger error">@error('embassy') {{$message}} @enderror</span>
                            <div class="invalid-feedback">{{ trans('msg.admin.Select Valid Embassy') }}.</div>
                        </div>
                    
                        <div class="col-12 mt-4">
                            <a href="{{ route('visa-package.list') }}" class="btn btn-outline-secondary px-2">{{ Str::upper(trans('msg.admin.Cancel')) }}</a>
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
        CKEDITOR.replace('process', {
            height: 200
        });

        CKEDITOR.replace('documents', {
            height: 200
        });
    </script>
    <script>
        var tab = new bootstrap.Tab(document.querySelector('#details-tabs-icons'));
        tab.show();
    </script>
@endsection