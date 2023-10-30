@extends('admin.layouts.app')

@section('content')
    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg d-flex justify-content-between align-items-center pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">{{ trans('msg.admin.Visa Countries') }}</h6>
            </div>
        </div>
        <div class="container my-auto mt-4">
            <div class="row">
              <div class="col-lg-12 col-md-8 col-12 mx-auto">
                <div class="card z-index-0 fadeIn3 fadeInBottom">
                    <div class="card-body">
                        <h6 class="input-label text-capitalize" id="formTitle">
                            <span class="material-icons font-weight-bolder me-1" id="formIcon">add_to_photos</span>
                            {{ trans('msg.admin.Add/Edit Visa Country') }} : 
                        </h6>
                        <form country="form" id="countryForm" class="text-start" action="{{ isset($country) ? route('visa-country.update', $country->id) : route('visa-country.add') }}" method="{{ isset($country) ? 'PUT' : 'POST' }}" novalidate>
                            @csrf
                            @if (isset($country))
                                @method('PUT')
                            @endif
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="input-group input-group-outline" id="emailInput">
                                        <label class="form-label">{{ trans('msg.admin.Enter Country Name') }}</label>
                                        <input type="text" name="country" id="country" value="{{ isset($country) ? $country->country : old('country') }}" class="form-control" required>
                                    </div>
                                    <span class="text-danger error">@error('code') {{$message}} @enderror</span>
                                    <div class="invalid-feedback">{{ trans('msg.admin.Enter Valid Visa Country') }}</div>
                                </div>
                        
                                <div class="col-md-2">
                                    <button class="btn bg-gradient-info" type="submit">{{ isset($country) ? Str::upper(trans('msg.admin.Update Country')) : Str::upper(trans('msg.admin.Save Changes')) }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
              </div>
            </div>
          </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive p-4">
                <table class="table align-items-center mb-0" id="otaDataTable">
                    <thead>
                        <tr>
                            <th  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.No') }}.</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.Country') }}</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.Status') }}</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.Featured') }}</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($countries as $country)
                            <tr id="delete{{ $country->id }}">
                                <td class="text-sm text-center">{{ $loop->iteration }}</td>
                                <td id="countryValue">{{ $country->country }}</td>
                                <td class="text-sm">
                                    <span class="badge badge-sm bg-gradient-{{ $country->status == 'active' ? 'info' : 'secondary' }}" id="status{{ $loop->iteration }}">{{ $country->status }}</span>
                                </td>
                                <td>
                                    <span class="btn h4 text-{{ $country->is_featured == 'yes' ? 'warning' : 'secondary' }} material-icons featured-icon" onclick="confirmToggleFeatured(this)" data-country-id="{{ $country->id }}" data-featured="{{ $country->is_featured }}">
                                        star
                                    </span>
                                </td>
                                
                                <td>
                                    <div class="row">
                                        <div class="col-1"></div>
                                        <div class="col-2">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input btn-lg change-status" type="checkbox" id="flexSwitchCheckChecked{{ $loop->iteration }}" {{ $country->status == 'active' ? 'checked' : '' }} data-country-id="{{ $country->id }}"  data-id="{{ $loop->iteration }}">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-info btn-sm" onclick="editCountry('{{ $country->id }}')">
                                                <span class="material-icons text-md">edit</span>
                                            </button>
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDeleteCountry('{{ $country->id }}', {{ $loop->iteration }})">
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
        var editMode = false; 
        var editId = null; 

        function editCountry(id) {
            editMode = true;
            editId = id;
            $.ajax({
                type: 'GET',
                url: "{{ url('visa-country/edit') }}" + "/" + id,
                success: function (data) {
                    $('#country').val(data.country.country);
                    $('#country').focus();
                },
                error: function (error) {
                    pos4_error_noti(error.responseJSON.message);
                }
            });
        }

        $(document).ready(function () {
            $('#countryForm').submit(function (e) {
                e.preventDefault();
                var country = $('#country').val();
                var url = editMode ? "{{ url('visa-country/update') }}" : "{{ route('visa-country.add') }}";
                var method = editMode ? 'PUT' : 'POST';

                $.ajax({
                    type: method,
                    url: url,
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'country': country,
                        'id' : editId
                    },
                    success: function (response) {
                        if (editMode == true) {
                            $('#country').val('');
                            $('#countryValue').text(country);
                            pos5_success_noti(response.message);
                        } else {
                            pos5_success_noti(response.message);
                            location.reload();
                        }

                        editMode = false; 
                        editId = null; 
                    },
                    error: function (error) {
                        pos4_error_noti(error.responseJSON.message);
                    }
                });
            });
        });
    
        document.addEventListener("DOMContentLoaded", function() {
            let checkboxes = document.querySelectorAll('.change-status');
            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    let countryId = checkbox.getAttribute('data-country-id');
                    let dataId = checkbox.getAttribute('data-id');
                    let isActive = checkbox.checked ? 'active' : 'inactive';
                    confirmUpdateCountryStatus(countryId, isActive, dataId);
                });
            });
        });

        function confirmUpdateCountryStatus(countryId, isActive, dataId) {
            Swal.fire({
                title: "{{ trans('msg.alert.Confirmation') }}",
                text: "{{ trans('msg.alert.Are you sure you want to :action this :type', ['action' => 'update', 'type' => 'country']) }}?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ trans('msg.alert.Yes') }}",
                cancelButtonText: "{{ trans('msg.alert.No') }}",
                confirmButtonColor: '#1A73E8',
            }).then((result) => {
                if (result.isConfirmed) {
                    updateCountryStatus(countryId, isActive, dataId);
                } else {
                    location.reload();
                }
            });
        }

        function updateCountryStatus(countryId, isActive, dataId) {
            $.ajax({
                type: 'POST',
                url: '{{ route("visa-country.change-status") }}',
                data: {
                    country_id: countryId,
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

        function confirmDeleteCountry(countryId) {
            Swal.fire({
                title: "{{ trans('msg.alert.Confirmation') }}",
                text: "{{ trans('msg.alert.Are you sure you want to :action this :type', ['action' => 'delete', 'type' => 'country']) }}?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ trans('msg.alert.Yes') }}",
                confirmButtonColor: '#1A73E8',
                cancelButtonText: "{{ trans('msg.alert.No') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteCountry(countryId);
                } else {
                    location.reload();
                }
            });
        }

        // Function to delete the country
        function deleteCountry(countryId) {
            $.ajax({
                type: 'POST',
                url: '{{ route("visa-country.delete") }}', 
                data: {
                    country_id: countryId,
                    _token: '{{ csrf_token() }}'
                },
                success: function (data) {
                    pos5_success_noti(data.message);
                    let row = document.getElementById('delete' + countryId);
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
            var countryId = element.getAttribute('data-country-id');
            var isFeatured = element.getAttribute('data-featured') === 'yes';
            var newFeaturedStatus = isFeatured ? 'no' : 'yes';

            // Show confirmation dialog
            Swal.fire({
                title: "{{ trans('msg.alert.Confirmation') }}",
                text: "{{ trans('msg.alert.Are you sure you want to :action this :type', ['action' => 'update', 'type' => 'country']) }}?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: "{{ trans('msg.alert.Yes') }}",
                confirmButtonColor: '#1A73E8',
                cancelButtonText: "{{ trans('msg.alert.No') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    toggleFeatured(countryId, newFeaturedStatus);
                }
            });
        }

        function toggleFeatured(countryId, newFeaturedStatus) {
            $.ajax({
                type: 'POST',
                url: '{{ route("visa-country.toggle-featured") }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'id': countryId,
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