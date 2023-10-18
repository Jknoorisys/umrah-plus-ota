@extends('admin.layouts.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="otaDataTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ trans('msg.admin.No') }}.</th>
                            <th>{{ trans('msg.admin.Service Type') }}</th>
                            <th>{{ trans('msg.admin.Code') }}</th>
                            <th>{{ trans('msg.admin.Discount Type') }}</th>
                            <th>{{ trans('msg.admin.Discount') }}</th>
                            <th>{{ trans('msg.admin.Status') }}</th>
                            <th>{{ trans('msg.admin.Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($codes as $code)
                            <tr id="delete{{ $code->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ Str::ucfirst($code->service) }}</td>
                                <td>{{ $code->code }}</td>
                                <td>{{ Str::ucfirst($code->type) }}</td>
                                <td>{{ $code->discount }}</td>
                                <td><span class="badge bg-{{ $code->status == 'active' ? 'primary' : 'warning' }}" id="status{{ $loop->iteration }}">{{ $code->status }}</span></td>
                                <td>
                                    <div class="row">
                                        <div class="col-1"></div>
                                        <div class="col-2">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input btn-lg" type="checkbox" id="flexSwitchCheckChecked{{ $loop->iteration }}" {{ $code->status == 'active' ? 'checked' : '' }} data-code-id="{{ $code->id }}"  data-id="{{ $loop->iteration }}">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <a class="btn btn-outline-primary btn-sm" href="{{ route('promo-code.edit-form', ['id' => $code->id]) }}">
                                                <i class="bx bx-show-alt me-0"></i>
                                            </a>
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDeletecode('{{ $code->id }}', {{ $loop->iteration }})">
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
                    let codeId = checkbox.getAttribute('data-code-id');
                    let dataId = checkbox.getAttribute('data-id');
                    let isActive = checkbox.checked ? 'active' : 'inactive';
                    confirmUpdatecodestatus(codeId, isActive, dataId);
                });
            });
        });

        function confirmUpdatecodestatus(codeId, isActive, dataId) {
            Swal.fire({
                title: "{{ trans('msg.alert.Confirmation') }}",
                text: "{{ trans('msg.alert.Are you sure you want to :action this :type', ['action' => 'update', 'type' => 'code']) }}?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ trans('msg.alert.Yes') }}",
                cancelButtonText: "{{ trans('msg.alert.No') }}",
                confirmButtonColor: '#008cff',
            }).then((result) => {
                if (result.isConfirmed) {
                    updatecodestatus(codeId, isActive, dataId);
                } else {
                    location.reload();
                }
            });
        }

        function updatecodestatus(codeId, isActive, dataId) {
            $.ajax({
                type: 'POST',
                url: '{{ route("promo-code.change-status") }}',
                data: {
                    code_id: codeId,
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

        function confirmDeletecode(codeId) {
            Swal.fire({
                title: "{{ trans('msg.alert.Confirmation') }}",
                text: "{{ trans('msg.alert.Are you sure you want to :action this :type', ['action' => 'delete', 'type' => 'code']) }}?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ trans('msg.alert.Yes') }}",
                confirmButtonColor: '#008cff',
                cancelButtonText: "{{ trans('msg.alert.No') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    deletecode(codeId);
                } else {
                    location.reload();
                }
            });
        }

        // Function to delete the code
        function deletecode(codeId) {
            $.ajax({
                type: 'POST',
                url: '{{ route("promo-code.delete") }}', 
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
                    pos4_error_noti(error.responseJSON.error);
                }
            });
        }
    </script>
@endsection