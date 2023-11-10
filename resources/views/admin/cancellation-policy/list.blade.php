@extends('admin.layouts.app')

@section('content')
    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg d-flex justify-content-between align-items-center pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">{{ trans('msg.admin.Cancellation Policies') }}</h6>
            </div>
        </div>
        
        <div class="card-body px-0 pb-2">
            <div class="table-responsive p-4">
                <table class="table align-items-center mb-0" id="otaDataTable">
                    <thead>
                        <tr>
                            <th  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.No') }}.</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.Cancellation Policy') }}</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.7 Days Before') }}</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.Within 24 Hours') }}</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.Less than 24 Hours') }}</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($policies as $policy)
                        <tr id="delete{{ $policy->id }}">
                            <td class="text-sm text-center">{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex px-2 py-1">
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">{{ Str::ucfirst($policy->service) }}</h6>
                                        <p class="text-xs text-secondary mb-0">
                                            {{ $policy->policy_en ? substr($policy->policy_en, 0, 80) . (strlen($policy->policy_en) > 80 ? '...' : '') : '' }}
                                        </p>                                        
                                    </div>
                                </div>
                            </td>
                            <td>{{ $policy->before_7_days }}%</td>
                            <td>{{ $policy->within_24_hours }}%</td>
                            <td>{{ $policy->less_than_24_hours }}%</td>
                            <td>
                                <a class="btn btn-outline-info btn-sm" href="{{ route('cancellation-policy.edit-form', ['id' => $policy->id]) }}">
                                    <span class="material-icons text-md">
                                        edit
                                    </span>
                                </a>                             
                            </td>
                        </tr>
                    @empty
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection