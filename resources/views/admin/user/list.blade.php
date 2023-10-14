@extends('admin.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="otaDataTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ trans('msg.admin.Name') }}</th>
                            <th>{{ trans('msg.admin.Email') }}</th>
                            <th>{{ trans('msg.admin.Phone') }}</th>
                            <th>{{ trans('msg.admin.Status') }}</th>
                            <th>{{ trans('msg.admin.Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->fname. ' ' .$user->lname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->country_code. '-'. $user->phone }}</td>
                                <td><span class="badge bg-{{ $user->status == 'active' ? 'primary' : 'warning' }}">{{ $user->status }}</span></td>
                                <td>
                                    <div class="row">
                                        <div class="col-1"></div>
                                        <div class="col-2">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input btn-lg" type="checkbox" id="flexSwitchCheckChecked" {{ $user->status == 'active' ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-primary btn-sm">
                                                <i class="bx bx-show-alt me-0"></i>
                                            </button>
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger btn-sm">
                                                <i class="bx bx-trash-alt me-0"></i>
                                            </button>
                                        </div>
                                    </div>                                   
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('customJs')

@endsection