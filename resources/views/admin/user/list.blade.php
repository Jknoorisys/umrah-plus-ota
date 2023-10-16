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
                            <th>{{ trans('msg.admin.Status') }}</th>
                            <th>{{ trans('msg.admin.Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr id="delete{{ $user->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->fname. ' ' .$user->lname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->country_code. '-'. $user->phone }}</td>
                                <td><span class="badge bg-{{ $user->status == 'active' ? 'primary' : 'warning' }}" id="status{{ $loop->iteration }}">{{ $user->status }}</span></td>
                                <td>
                                    <div class="row">
                                        <div class="col-1"></div>
                                        <div class="col-2">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input btn-lg" type="checkbox" id="flexSwitchCheckChecked{{ $loop->iteration }}" {{ $user->status == 'active' ? 'checked' : '' }} data-user-id="{{ $user->id }}"  data-id="{{ $loop->iteration }}">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-primary btn-sm">
                                                <i class="bx bx-show-alt me-0"></i>
                                            </button>
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDeleteUser('{{ $user->id }}', {{ $loop->iteration }})">
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
                    let userId = checkbox.getAttribute('data-user-id');
                    let dataId = checkbox.getAttribute('data-id');
                    let isActive = checkbox.checked ? 'active' : 'inactive';
                    confirmUpdateUserStatus(userId, isActive, dataId);
                });
            });
        });

        function confirmUpdateUserStatus(userId, isActive, dataId) {
            Swal.fire({
                title: "{{ trans('msg.alert.Confirmation') }}",
                text: "{{ trans('msg.alert.Are you sure you want to :action this user', ['action' => 'update']) }}?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ trans('msg.alert.Yes') }}",
                cancelButtonText: "{{ trans('msg.alert.No') }}",
                confirmButtonColor: '#008cff',
            }).then((result) => {
                if (result.isConfirmed) {
                    updateUserStatus(userId, isActive, dataId);
                } else {
                    location.reload();
                }
            });
        }

        function updateUserStatus(userId, isActive, dataId) {
            $.ajax({
                type: 'POST',
                url: '{{ route("user.change-status") }}',
                data: {
                    user_id: userId,
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

        function confirmDeleteUser(userId) {
            Swal.fire({
                title: "{{ trans('msg.alert.Confirmation') }}",
                text: "{{ trans('msg.alert.Are you sure you want to :action this user', ['action' => 'delete']) }}?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ trans('msg.alert.Yes') }}",
                cancelButtonText: "{{ trans('msg.alert.No') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteUser(userId);
                } else {
                    location.reload();
                }
            });
        }

        // Function to delete the user
        function deleteUser(userId) {
            $.ajax({
                type: 'POST',
                url: '{{ route("user.delete") }}', 
                data: {
                    user_id: userId,
                    _token: '{{ csrf_token() }}'
                },
                success: function (data) {
                    pos5_success_noti(data.message);
                    let row = document.getElementById('delete' + userId);
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