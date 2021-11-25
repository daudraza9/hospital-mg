@extends('layouts.master')
@section('content')
    <div id="layoutSidenav_content">

        <div class="container-fluid px-4">

            <div class="container-fluid px-1 py-5 mx-auto">
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
                        <h3>Uploads File</h3>

                        <div class="card" id="form-style">

                            <form enctype="multipart/form-data" class="form-card" id="file-form"
                                  action="{{route('file.storeMedia')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row justify-content-between text-left">

                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Upload File</label>
                                        <input type="file" id="file" name="file[]"
                                               placeholder="Enter File" data-field-name="File"
                                               required multiple>
                                        <span class="text-danger error-text"></span></div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="form-group col-sm-6">
                                        <button type="button" class="btn-block btn-primary" style="width: 100px;"
                                                onclick="saveFile('file-form');">Save
                                        </button>
                                    </div>
                                </div>
                            </form>


                        </div>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th width="30%">Media</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($file as $key=>$item)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td><img src="{{$item->getFirstMediaUrl('file', 'thumb')}}"></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    @endsection
                    @push('scripts')

                        <script>


                            function saveFile(form_id) {

                                $.ajax({
                                    type: 'POST',
                                    url: '{{route('file.storeMedia')}}',
                                    dataType: "json",
                                    processData: false,
                                    contentType: false,
                                    data: new FormData($('#file-form')[0]),
                                    success: function (response) {
                                        if (response.success) {
                                            document.getElementById('file-form').reset();
                                            filetable.draw();
                                        } else {
                                            if (response.success == NULL) {
                                                printErrorMsg(['Something Went Wrong, please Reload or try Again Later!']);
                                            } else {
                                                printErrorMsg([response.message]);
                                            }
                                        }
                                    }
                                });

                            }

                            function validates(object, status) {
                                var input = $(object);
                                if (input.prop('required') && !input.val()) {
                                    input.addClass('is-invalid');
                                    input.addClass('invalid');
                                    status = false;
                                    input.siblings('span.error-text').html((input.data('field-name') !== 'undefined') ? input.data('field-name') + ' is required.' : 'is required.');
                                } else if (input.val()) {
                                    var input_id = input.attr('id');
                                    if (input_id === 'name') {
                                        status = validate.first_name(input, status);
                                    } else {
                                        input.removeClass('is-invalid');
                                        input.siblings('span.error-text').html('');
                                    }

                                } else {
                                    input.siblings('span.select2-container--default').removeClass('invalid-select');
                                    input.removeClass('is-invalid');
                                }
                                return status;
                            }

                        </script>
    @endpush
