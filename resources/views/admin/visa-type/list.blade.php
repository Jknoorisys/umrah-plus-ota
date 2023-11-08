@extends('admin.layouts.app')

@section('content')
    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg d-flex justify-content-between align-items-center pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">{{ trans('msg.admin.Visa Types') }}</h6>
                <a href="{{ route('visa-type.add-form') }}" class="text-white d-flex align-items-center me-3"><span class="material-icons font-weight-bolder me-1">add</span>{{ trans('msg.admin.Add Visa Type') }}</a>
            </div>
        </div>
        
        <div class="card-body px-0 pb-2">
            <div class="table-responsive p-4">
                <table class="table align-items-center mb-0" id="otaDataTable">
                    <thead>
                        <tr>
                            <th  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.No') }}.</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.Visa Type') }}</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.Fees') }}</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.Featured') }}</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.Status') }}</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($types as $type)
                            <tr id="delete{{ $type->id }}">
                                <td class="text-sm text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ Str::ucfirst($type->country->country) }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $type->type }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $type->fees.' '.$type->currency }}</td>
                                <td>
                                    <span class="btn h4 text-{{ $type->is_featured == 'yes' ? 'warning' : 'secondary' }} material-icons featured-icon" onclick="confirmToggleFeatured(this)" data-type-id="{{ $type->id }}" data-featured="{{ $type->is_featured }}">
                                        grade
                                    </span>
                                </td>
                                <td class="text-sm">
                                    <span class="badge badge-sm bg-gradient-{{ $type->status == 'active' ? 'info' : 'secondary' }}" id="status{{ $loop->iteration }}">{{ $type->status }}</span>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-1"></div>
                                        <div class="col-2">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input btn-lg" type="checkbox" id="flexSwitchCheckChecked{{ $loop->iteration }}" {{ $type->status == 'active' ? 'checked' : '' }} data-type-id="{{ $type->id }}"  data-id="{{ $loop->iteration }}">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <a class="btn btn-outline-info btn-sm" href="{{ route('visa-type.edit-form', ['id' => $type->id]) }}">
                                                <span class="material-icons text-md">
                                                    edit
                                                </span>
                                            </a>
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDeletetype('{{ $type->id }}', {{ $loop->iteration }})">
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
                    let typeId = checkbox.getAttribute('data-type-id');
                    let dataId = checkbox.getAttribute('data-id');
                    let isActive = checkbox.checked ? 'active' : 'inactive';
                    confirmUpdatetypestatus(typeId, isActive, dataId);
                });
            });
        });

        function confirmUpdatetypestatus(typeId, isActive, dataId) {
            Swal.fire({
                title: "{{ trans('msg.alert.Confirmation') }}",
                text: "{{ trans('msg.alert.Are you sure you want to :action this :type', ['action' => 'update', 'type' => 'visa type']) }}?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ trans('msg.alert.Yes') }}",
                cancelButtonText: "{{ trans('msg.alert.No') }}",
                confirmButtonColor: '#1A73E8',
            }).then((result) => {
                if (result.isConfirmed) {
                    updatetypestatus(typeId, isActive, dataId);
                } else {
                    location.reload();
                }
            });
        }

        function updatetypestatus(typeId, isActive, dataId) {
            $.ajax({
                type: 'POST',
                url: '{{ route("visa-type.change-status") }}',
                data: {
                    type_id: typeId,
                    status: isActive,
                    _token: '{{ csrf_token() }}'
                },
                success: function (data) {
                    pos5_success_noti(data.message);
                    let statusElement = document.getElementById('status' + dataId);
                    if (statusElement) {
                        statusElement.textContent = isActive;
                        if (isActive === 'active') {
                            statusElement.classList.remove('bg-gradient-secondary');
                            statusElement.classList.add('bg-gradient-info');
                        } else {
                            statusElement.classList.remove('bg-gradient-info');
                            statusElement.classList.add('bg-gradient-secondary');
                        }
                    }
                },
                error: function (error) {
                    pos4_error_noti(error.responseJSON.message);
                }
            });
        }

        function confirmDeletetype(typeId) {
            Swal.fire({
                title: "{{ trans('msg.alert.Confirmation') }}",
                text: "{{ trans('msg.alert.Are you sure you want to :action this :type', ['action' => 'delete', 'type' => 'visa type']) }}?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ trans('msg.alert.Yes') }}",
                confirmButtonColor: '#1A73E8',
                cancelButtonText: "{{ trans('msg.alert.No') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    deletetype(typeId);
                } else {
                    location.reload();
                }
            });
        }

        // Function to delete the type
        function deletetype(typeId) {
            $.ajax({
                type: 'POST',
                url: '{{ route("visa-type.delete") }}', 
                data: {
                    type_id: typeId,
                    _token: '{{ csrf_token() }}'
                },
                success: function (data) {
                    pos5_success_noti(data.message);
                    let row = document.getElementById('delete' + typeId);
                    if (row) {
                        row.remove();
                    }
                },
                error: function (error) {
                    pos4_error_noti(error.responseJSON.message);
                }
            });
        }

        // Make Featured Functionality
        function confirmToggleFeatured(element) {
            var typeId = element.getAttribute('data-type-id');
            var isFeatured = element.getAttribute('data-featured') === 'yes';
            var newFeaturedStatus = isFeatured ? 'no' : 'yes';

            // Show confirmation dialog
            Swal.fire({
                title: "{{ trans('msg.alert.Confirmation') }}",
                text: "{{ trans('msg.alert.Are you sure you want to :action this :type', ['action' => 'update', 'type' => 'visa type']) }}?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ trans('msg.alert.Yes') }}",
                confirmButtonColor: '#1A73E8',
                cancelButtonText: "{{ trans('msg.alert.No') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    toggleFeatured(typeId, newFeaturedStatus);
                }
            });
        }

        function toggleFeatured(typeId, newFeaturedStatus) {
            $.ajax({
                type: 'POST',
                url: '{{ route("visa-type.toggle-featured") }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'id': typeId,
                    'status': newFeaturedStatus
                },
                success: function (data) {
                    pos5_success_noti(data.message);
                    location.reload();
                },
                error: function (error) {
                    pos4_error_noti(error.responseJSON.message);
                }
            });
        }
    </script>
@endsection
