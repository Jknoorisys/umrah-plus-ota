@extends('admin.layouts.app')

@section('content')
    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg d-flex justify-content-between align-items-center pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">{{ trans('msg.admin.Visa Packages') }}</h6>
                <a href="{{ route('visa-package.add-form') }}" class="text-white d-flex align-items-center me-3"><span class="material-icons font-weight-bolder me-1">add</span>{{ trans('msg.admin.Add Visa Package') }}</a>
            </div>
        </div>
      
        <div class="card-body px-0 pb-2">
            <div class="table-responsive p-4">
                <table class="table align-items-center mb-0" id="otaDataTable">
                    <thead>
                        <tr>
                            <th  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.No') }}.</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.Package') }}</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.Status') }}</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.Featured') }}</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($packages as $package)
                            <tr id="delete{{ $package->id }}">
                                <td class="text-sm text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ Str::ucfirst($package->country) }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $package->processing_time }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-sm">
                                    <span class="badge badge-sm bg-{{ $package->status == 'active' ? 'info' : 'secondary' }}" id="status{{ $loop->iteration }}">{{ $package->status }}</span>
                                </td>
                                <td>
                                    <span class="btn h4 text-{{ $package->is_featured == 'yes' ? 'warning' : 'secondary' }} material-icons featured-icon" onclick="confirmToggleFeatured(this)" data-package-id="{{ $package->id }}" data-featured="{{ $package->is_featured }}">
                                        grade
                                    </span>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-1"></div>
                                        <div class="col-2">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input btn-lg change-status" type="checkbox" id="flexSwitchCheckChecked{{ $loop->iteration }}" {{ $package->status == 'active' ? 'checked' : '' }} data-package-id="{{ $package->id }}"  data-id="{{ $loop->iteration }}">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <a class="btn btn-info btn-sm" href="{{ route('visa-package.edit-form', ['id' => $package->id]) }}">
                                                <span class="material-icons text-md">
                                                    edit
                                                </span>
                                            </a>
                                            <button type="button" rel="tooltip" class="btn btn-danger btn-sm" onclick="confirmDeletepackage('{{ $package->id }}', {{ $loop->iteration }})">
                                                <i class="material-icons text-md">close</i>
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
            let checkboxes = document.querySelectorAll('.change-status');
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    let packageId = checkbox.getAttribute('data-package-id');
                    let dataId = checkbox.getAttribute('data-id');
                    let isActive = checkbox.checked ? 'active' : 'inactive';
                    confirmUpdatepackageStatus(packageId, isActive, dataId);
                });
            });
        });

        function confirmUpdatepackageStatus(packageId, isActive, dataId) {
            Swal.fire({
                title: "{{ trans('msg.alert.Confirmation') }}",
                text: "{{ trans('msg.alert.Are you sure you want to :action this :type', ['action' => 'update', 'type' => 'package']) }}?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ trans('msg.alert.Yes') }}",
                cancelButtonText: "{{ trans('msg.alert.No') }}",
                confirmButtonColor: '#4aa4d9',
            }).then((result) => {
                if (result.isConfirmed) {
                    updatepackageStatus(packageId, isActive, dataId);
                } else {
                    location.reload();
                }
            });
        }

        function updatepackageStatus(packageId, isActive, dataId) {
            $.ajax({
                type: 'POST',
                url: '{{ route("visa-package.change-status") }}',
                data: {
                    package_id: packageId,
                    status: isActive,
                    _token: '{{ csrf_token() }}'
                },
                success: function (data) {
                    pos5_success_noti(data.message);
                    let statusElement = document.getElementById('status' + dataId);
                    if (statusElement) {
                        statusElement.textContent = isActive;
                        if (isActive === 'active') {
                            statusElement.classList.remove('bg-secondary');
                            statusElement.classList.add('bg-info');
                        } else {
                            statusElement.classList.remove('bg-info');
                            statusElement.classList.add('bg-secondary');
                        }
                    }
                },
                error: function (error) {
                    pos4_error_noti(error.responseJSON.message);
                }
            });
        }

        function confirmDeletepackage(packageId) {
            Swal.fire({
                title: "{{ trans('msg.alert.Confirmation') }}",
                text: "{{ trans('msg.alert.Are you sure you want to :action this :type', ['action' => 'delete', 'type' => 'package']) }}?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ trans('msg.alert.Yes') }}",
                confirmButtonColor: '#4aa4d9',
                cancelButtonText: "{{ trans('msg.alert.No') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    deletepackage(packageId);
                } else {
                    location.reload();
                }
            });
        }

        // Function to delete the package
        function deletepackage(packageId) {
            $.ajax({
                type: 'POST',
                url: '{{ route("visa-package.delete") }}', 
                data: {
                    package_id: packageId,
                    _token: '{{ csrf_token() }}'
                },
                success: function (data) {
                    pos5_success_noti(data.message);
                    let row = document.getElementById('delete' + packageId);
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
            var packageId = element.getAttribute('data-package-id');
            var isFeatured = element.getAttribute('data-featured') === 'yes';
            var newFeaturedStatus = isFeatured ? 'no' : 'yes';

            // Show confirmation dialog
            Swal.fire({
                title: "{{ trans('msg.alert.Confirmation') }}",
                text: "{{ trans('msg.alert.Are you sure you want to :action this :type', ['action' => 'update', 'type' => 'package']) }}?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ trans('msg.alert.Yes') }}",
                confirmButtonColor: '#4aa4d9',
                cancelButtonText: "{{ trans('msg.alert.No') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    toggleFeatured(packageId, newFeaturedStatus);
                }
            });
        }

        function toggleFeatured(packageId, newFeaturedStatus) {
            $.ajax({
                type: 'POST',
                url: '{{ route("visa-package.toggle-featured") }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'id': packageId,
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