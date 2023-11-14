@extends('admin.layouts.app')

@section('content')
    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg d-flex justify-content-between align-items-center pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">{{ trans('msg.admin.Embassy') }}</h6>
                <a href="{{ route('embassy.add-form') }}" class="text-white d-flex align-items-center me-3"><span class="material-icons font-weight-bolder me-1">add</span>{{ trans('msg.admin.Add Embassy') }}</a>
            </div>
        </div>
        
        <div class="card-body px-0 pb-2">
            <div class="table-responsive p-4">
                <table class="table align-items-center mb-0" id="otaDataTable">
                    <thead>
                        <tr>
                            <th  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.No') }}.</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.Embassy') }}</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.Status') }}</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($embassies as $embassy)
                            <tr id="delete{{ $embassy->id }}">
                                <td class="text-sm text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ Str::ucfirst($embassy->embassy) }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $embassy->address }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-sm">
                                    <span class="badge badge-sm bg-{{ $embassy->status == 'active' ? 'info' : 'secondary' }}" id="status{{ $loop->iteration }}">{{ $embassy->status }}</span>
                                </td>
                                <td>
                                    <div class="row">
                                        <div class="col-1"></div>
                                        <div class="col-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input btn-lg" type="checkbox" id="flexSwitchCheckChecked{{ $loop->iteration }}" {{ $embassy->status == 'active' ? 'checked' : '' }} data-embassy-id="{{ $embassy->id }}" data-id="{{ $loop->iteration }}">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <a class="btn btn-info btn-sm" href="{{ route('embassy.edit-form', ['id' => $embassy->id]) }}">
                                                <span class="material-icons text-md">
                                                    edit
                                                </span>
                                            </a>
                                            <button embassy="button" rel="tooltip" class="btn btn-danger btn-sm" onclick="confirmDeleteEmbassy('{{ $embassy->id }}', {{ $loop->iteration }})">
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
            let checkboxes = document.querySelectorAll('.form-check-input');
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    let embassyId = checkbox.getAttribute('data-embassy-id');
                    let dataId = checkbox.getAttribute('data-id');
                    let isActive = checkbox.checked ? 'active' : 'inactive';
                    confirmUpdateEmbassystatus(embassyId, isActive, dataId);
                });
            });
        });

        function confirmUpdateEmbassystatus(embassyId, isActive, dataId) {
            Swal.fire({
                title: "{{ trans('msg.alert.Confirmation') }}",
                text: "{{ trans('msg.alert.Are you sure you want to :action this :type', ['action' => 'update', 'type' => 'Embassy']) }}?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ trans('msg.alert.Yes') }}",
                cancelButtonText: "{{ trans('msg.alert.No') }}",
                confirmButtonColor: '#4aa4d9',
            }).then((result) => {
                if (result.isConfirmed) {
                    updateEmbassystatus(embassyId, isActive, dataId);
                } else {
                    location.reload();
                }
            });
        }

        function updateEmbassystatus(embassyId, isActive, dataId) {
            $.ajax({
                method: 'POST',
                url: '{{ route("embassy.change-status") }}',
                data: {
                    embassy_id: embassyId,
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

        function confirmDeleteEmbassy(embassyId) {
            Swal.fire({
                title: "{{ trans('msg.alert.Confirmation') }}",
                text: "{{ trans('msg.alert.Are you sure you want to :action this :type', ['action' => 'delete', 'type' => 'Embassy']) }}?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ trans('msg.alert.Yes') }}",
                confirmButtonColor: '#4aa4d9',
                cancelButtonText: "{{ trans('msg.alert.No') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteEmbassy(embassyId);
                } else {
                    location.reload();
                }
            });
        }

        // Function to delete the embassy
        function deleteEmbassy(embassyId) {
            $.ajax({
                method: 'POST',
                url: '{{ route("embassy.delete") }}', 
                data: {
                    embassy_id: embassyId,
                    _token: '{{ csrf_token() }}'
                },
                success: function (data) {
                    pos5_success_noti(data.message);
                    let row = document.getElementById('delete' + embassyId);
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
