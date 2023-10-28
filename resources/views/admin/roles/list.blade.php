@extends('admin.layouts.app')

@section('content')
    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg d-flex justify-content-between align-items-center pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">{{ trans('msg.admin.Roles') }}</h6>
                <a href="{{ route('role.add-form') }}" class="text-white d-flex align-items-center me-3"><span class="material-icons font-weight-bolder me-1">add</span>{{ trans('msg.admin.Add Role') }}</a>
            </div>
        </div>
        
        <div class="card-body px-0 pb-2">
            <div class="table-responsive p-4">
                <table class="table align-items-center mb-0" id="otaDataTable">
                    <thead>
                        <tr>
                            <th  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.No') }}.</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.Role') }}</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.Status') }}</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $role)
                        <tr id="delete{{ $role->id }}">
                            <td class="text-sm text-center">{{ $loop->iteration }}</td>
                            <td>{{ str_replace('_', ' ', Str::upper($role->role))}}</td>
                            <td class="text-sm">
                                <span class="badge badge-sm bg-gradient-{{ $role->status == 'active' ? 'info' : 'secondary' }}" id="status{{ $loop->iteration }}">{{ $role->status }}</span>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-1"></div>
                                    <div class="col-2">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input btn-lg" type="checkbox" id="flexSwitchCheckChecked{{ $loop->iteration }}" {{ $role->status == 'active' ? 'checked' : '' }} data-role-id="{{ $role->id }}"  data-id="{{ $loop->iteration }}">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <a class="btn btn-outline-info btn-sm" href="{{ route('role.edit-form', ['id' => $role->id]) }}">
                                            <span class="material-icons text-md">
                                                edit
                                            </span>
                                        </a>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDeleterole('{{ $role->id }}', {{ $loop->iteration }})">
                                            <span class="material-icons text-md">
                                                delete
                                            </span>
                                        </button>
                                    </div>
                                </div>                                   
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

@section('customJs')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let checkboxes = document.querySelectorAll('.form-check-input');
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    let roleId = checkbox.getAttribute('data-role-id');
                    let dataId = checkbox.getAttribute('data-id');
                    let isActive = checkbox.checked ? 'active' : 'inactive';
                    confirmUpdaterolestatus(roleId, isActive, dataId);
                });
            });
        });

        function confirmUpdaterolestatus(roleId, isActive, dataId) {
            Swal.fire({
                title: "{{ trans('msg.alert.Confirmation') }}",
                text: "{{ trans('msg.alert.Are you sure you want to :action this :type', ['action' => 'update', 'type' => 'role']) }}?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ trans('msg.alert.Yes') }}",
                cancelButtonText: "{{ trans('msg.alert.No') }}",
                confirmButtonColor: '#1A73E8',
            }).then((result) => {
                if (result.isConfirmed) {
                    updaterolestatus(roleId, isActive, dataId);
                } else {
                    location.reload();
                }
            });
        }

        function updaterolestatus(roleId, isActive, dataId) {
            $.ajax({
                type: 'POST',
                url: '{{ route("role.change-status") }}',
                data: {
                    role_id: roleId,
                    status: isActive,
                    _token: '{{ csrf_token() }}'
                },
                success: function (data) {
                    pos5_success_noti(data.message);
                    let statusElement = document.getElementById('status' + dataId);
                    if (statusElement) {
                        statusElement.textContent = isActive;
                        if (isActive === 'active') {
                            statusElement.classList.remove('bg-gradient-warning');
                            statusElement.classList.add('bg-gradient-primary');
                        } else {
                            statusElement.classList.remove('bg-gradient-primary');
                            statusElement.classList.add('bg-gradient-warning');
                        }
                    }
                },
                error: function (error) {
                    pos4_error_noti(error.responseJSON.message);
                }
            });
        }

        function confirmDeleterole(roleId) {
            Swal.fire({
                title: "{{ trans('msg.alert.Confirmation') }}",
                text: "{{ trans('msg.alert.Are you sure you want to :action this :type', ['action' => 'delete', 'type' => 'role']) }}?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ trans('msg.alert.Yes') }}",
                confirmButtonColor: '#1A73E8',
                cancelButtonText: "{{ trans('msg.alert.No') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    deleterole(roleId);
                } else {
                    location.reload();
                }
            });
        }

        // Function to delete the role
        function deleterole(codeId) {
            $.ajax({
                type: 'POST',
                url: '{{ route("role.delete") }}', 
                data: {
                    code_id: codeId,
                    _token: '{{ csrf_token() }}'
                },
                success: function (data) {
                    pos5_success_noti(data.message);
                    let row = document.getElementById('delete' + codeId);
                    if (row) {
                        row.remove();
                    }
                },
                error: function (error) {
                    pos4_error_noti(error.responseJSON.message);
                }
            });
        }
    </script>
@endsection