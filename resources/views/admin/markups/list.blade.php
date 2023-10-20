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
                            <th>
                                {{ trans('msg.admin.Markup') }}
                                <span style="font-weight: normal"> (editable)</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($markups as $markup)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ Str::ucfirst($markup->service) }}</td>
                                <td class="markup" data-id="{{ $markup->id }}" contenteditable>{{ $markup->markup }}</td>
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
                    class: 'form-control editable-input'
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
                        confirmButtonColor: '#008cff',
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
                                    pos4_error_noti(error.responseJSON.error);
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
