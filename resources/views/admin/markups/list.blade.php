@extends('admin.layouts.app')

@section('content')
    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-info shadow-info border-radius-lg d-flex justify-content-between align-items-center pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">{{ trans('msg.admin.Markups') }}</h6>
            </div>
        </div>
        
        <div class="card-body px-0 pb-2">
            <div class="table-responsive p-4">
                <table class="table align-items-center mb-0" id="otaDataTable">
                    <thead>
                        <tr>
                            <th  class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.No') }}.</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.Service Type') }}</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ trans('msg.admin.Markup') }}<span style="font-weight: normal"> (editable)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($markups as $markup)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ Str::ucfirst($markup->service) }}</td>
                                <td class="markup input-group input-group-outline" data-id="{{ $markup->id }}" contenteditable>{{ $markup->markup }}</td>
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
        $(document).ready(function() {
            $('td.markup').on('click', function() {
                let id = $(this).data('id');
                let currentCell = $(this);
                let originalMarkup = currentCell.text();
                currentCell.empty().append($('<input>', {
                    val: originalMarkup,
                    type: 'number',
                    class: 'form-control editable-input '
                }));

                let inputField = currentCell.find('input');

                inputField.focus();

                inputField.on('focusout', function() {
                    let newMarkup = inputField.val();
                    convertToTd(currentCell, newMarkup);
                });

                inputField.on('change', function() {
                    let newMarkup = inputField.val();
                    Swal.fire({
                        title: "{{ trans('msg.alert.Confirmation') }}",
                        text: "{{ trans('msg.alert.Are you sure you want to :action this :type', ['action' => 'update', 'type' => 'markup']) }}?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: "{{ trans('msg.alert.Yes') }}",
                        cancelButtonText: "{{ trans('msg.alert.No') }}",
                        confirmButtonColor: '#1A73E8',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('markup.edit') }}",
                                method: 'POST',
                                data: {
                                    id: id,
                                    markup: newMarkup,
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    pos5_success_noti(response.message);
                                    convertToTd(currentCell, newMarkup);
                                },
                                error: function(error) {
                                    pos4_error_noti(data.error);
                                    convertToTd(currentCell, originalMarkup);
                                }
                            });
                        } else {
                            convertToTd(currentCell, originalMarkup);
                        }
                    });
                });
            });

            function convertToTd(cell, content) {
                cell.empty().text(content);
            }
        });
    </script>
@endsection
