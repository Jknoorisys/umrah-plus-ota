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
                            
                        @empty
                            
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('customJs')

@endsection