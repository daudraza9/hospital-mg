@extends('layouts.master')
@section('content')

    <div id="layoutSidenav_content">

        <div class="container-fluid px-4">

            <div class="container-fluid px-1 py-5 mx-auto">
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
                        <h3>Please @if(isset($role)) Update @else Add @endif Role</h3>
                        <div class="card" id="form-style">
                            <p class="blue-text">Please Enter Role Details<br>
                            <form enctype="multipart/form-data" class="form-card" id="role-form"
                             @if(isset($role)) action="{{route('role.update',['id'=>$role->id])}}"  @else action="{{route('role.store')}}" @endif
                                 method="post">
                                @csrf
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Name</label>
                                        <input type="text" id="name" name="name"
                                               placeholder="Enter Role name" data-field-name="Role-name"
                                               @if(isset($role)) value="{{$role->name}}" @endif
                                            onkeyup="validation(this)"
                                               required>
                                        <span class="text-danger error-text"></span>
                                    </div>

                                </div>
                                <div class="row justify-content-end">
                                    <div class="form-group col-sm-6">
                                        <button type="button" class="btn-block btn-primary" style="width: 100px;"
                                                onclick="saveRole('role-form');">Save
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
@push('scripts')
    <script>

        function saveRole(form_id) {
            var status = true;
            $("form#" + form_id + " :input").each(function () {
                status = validation(this, status);
            });
            if (status === true) {
                $.ajax({
                    type: 'POST',
                    url: $('#role-form').attr('action'),
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    data: new FormData($('#role-form')[0]),
                    success: function (response) {
                        if (response.success) {
                            window.location = '{{route('role.index')}}';
                        } else {
                            if (response.success == NULL) {
                                printErrorMsg(['Something Went Wrong, please Reload or try Again Later!']);
                            } else {
                                printErrorMsg([response.message]);
                            }
                        }
                    }
                });
            }else{
                return status;
            }

        }
        function validation(object,status)
        {
            var input = $(object);
            if(input.prop('required') && !input.val())
            {
                input.addClass('is-invalid');
                input.addClass('invalid');
                status = false;
                input.siblings('span.error-text').html((input.data('field-name') !== 'undefined') ? input.data('field-name') + ' is required.' : 'is required.');
            }else if(input.val())
            {
                var input_id = input.attr('id');
                if(input_id === 'name')
                {
                    status = validate.first_name(input,status);
                }else{
                    input.removeClass('is-invalid');
                    input.siblings('span.error-text').html('');
                }
            }else{
                input.siblings('span.select2-container--default').removeClass('invalid-select');
                input.removeClass('is-invalid');
            }
            return status;
        }


    </script>
@endpush
