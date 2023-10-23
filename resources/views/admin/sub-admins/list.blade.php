@extends('admin.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="otaDataTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ trans('msg.admin.No') }}.</th>
                            <th>{{ trans('msg.admin.Name') }}</th>
                            <th>{{ trans('msg.admin.Email') }}</th>
                            <th>{{ trans('msg.admin.Phone') }}</th>
                            <th>{{ trans('msg.admin.Role') }}</th>
                            <th>{{ trans('msg.admin.Status') }}</th>
                            <th>{{ trans('msg.admin.Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($admins as $admin)
                            <tr id="delete{{ $admin->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $admin->fname. ' ' .$admin->lname }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>{{ $admin->country_code. '-'. $admin->phone }}</td>
                                <td>{{ str_replace('_', ' ', Str::ucfirst($admin->role)) }}</td>
                                <td><span class="badge bg-{{ $admin->status == 'active' ? 'primary' : 'warning' }}" id="status{{ $loop->iteration }}">{{ $admin->status }}</span></td>
                                <td>
                                    <div class="row">
                                        <div class="col-1"></div>
                                        <div class="col-2">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input btn-lg" type="checkbox" id="flexSwitchCheckChecked{{ $loop->iteration }}" {{ $admin->status == 'active' ? 'checked' : '' }} data-admin-id="{{ $admin->id }}"  data-id="{{ $loop->iteration }}">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <a class="btn btn-outline-primary btn-sm" href="{{ route('sub-admin.edit-form', ['id' => $admin->id]) }}">
                                                <i class="bx bx-pencil me-0"></i>
                                            </a>
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDeleteadmin('{{ $admin->id }}', {{ $loop->iteration }})">
                                                <i class="bx bx-trash-alt me-0"></i>
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
                    let adminId = checkbox.getAttribute('data-admin-id');
                    let dataId = checkbox.getAttribute('data-id');
                    let isActive = checkbox.checked ? 'active' : 'inactive';
                    confirmUpdateadminStatus(adminId, isActive, dataId);
                });
            });
        });

        function confirmUpdateadminStatus(adminId, isActive, dataId) {
            Swal.fire({
                title: "{{ trans('msg.alert.Confirmation') }}",
                text: "{{ trans('msg.alert.Are you sure you want to :action this :type', ['action' => 'update', 'type' => 'admin']) }}?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ trans('msg.alert.Yes') }}",
                cancelButtonText: "{{ trans('msg.alert.No') }}",
                confirmButtonColor: '#008cff',
            }).then((result) => {
                if (result.isConfirmed) {
                    updateadminStatus(adminId, isActive, dataId);
                } else {
                    location.reload();
                }
            });
        }

        function updateadminStatus(adminId, isActive, dataId) {
            $.ajax({
                type: 'POST',
                url: '{{ route("sub-admin.change-status") }}',
                data: {
                    admin_id: adminId,
                    status: isActive,
                    _token: '{{ csrf_token() }}'
                },
                success: function (data) {
                    pos5_success_noti(data.message);
                    let statusElement = document.getElementById('status' + dataId);
                    if (statusElement) {
                        statusElement.textContent = isActive;
                        if (isActive === 'active') {
                            statusElement.classList.remove('bg-warning');
                            statusElement.classList.add('bg-primary');
                        } else {
                            statusElement.classList.remove('bg-primary');
                            statusElement.classList.add('bg-warning');
                        }
                    }
                },
                error: function (error) {
                    pos4_error_noti(error.responseJSON.error);
                }
            });
        }

        function confirmDeleteadmin(adminId) {
            Swal.fire({
                title: "{{ trans('msg.alert.Confirmation') }}",
                text: "{{ trans('msg.alert.Are you sure you want to :action this :type', ['action' => 'delete', 'type' => 'admin']) }}?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ trans('msg.alert.Yes') }}",
                confirmButtonColor: '#008cff',
                cancelButtonText: "{{ trans('msg.alert.No') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteadmin(adminId);
                } else {
                    location.reload();
                }
            });
        }

        // Function to delete the admin
        function deleteadmin(adminId) {
            $.ajax({
                type: 'POST',
                url: '{{ route("sub-admin.delete") }}', 
                data: {
                    admin_id: adminId,
                    _token: '{{ csrf_token() }}'
                },
                success: function (data) {
                    pos5_success_noti(data.message);
                    let row = document.getElementById('delete' + adminId);
                    if (row) {
                        row.remove();
                    }
                },
                error: function (error) {
                    pos4_error_noti(error.responseJSON.error);
                }
            });
        }
    </script>
@endsection