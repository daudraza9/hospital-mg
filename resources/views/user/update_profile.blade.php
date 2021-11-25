@extends('layouts.master')
@section('content')

    <div id="layoutSidenav_content">

        <div class="container-fluid px-4">
            <div class="container-fluid px-1 py-5 mx-auto">
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
                        <h3> Update User</h3>
                        <div class="card" id="form-style">
                            <p class="blue-text">Please  Update user<br>
                            <form enctype="multipart/form-data" class="form-card" id="update-user"
                                  @if(isset($user)) action="{{route('user.update',['id'=>$user->id])}}" @endif
                                  method="post">
                                @csrf
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Name</label>
                                        <input type="text" id="name" name="name"
                                               placeholder="Enter name" data-field-name="Name"
                                                @if(isset($user)) value="{{$user->name}}" @endif onkeyup="validation(this)"
                                               required >
                                        <span class="text-danger error-text"></span>
                                    </div>
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Email </label>
                                        <input type="email" id="email" name="email"
                                               placeholder="Enter Email" data-field-name="Email"
                                                @if(isset($user)) value="{{$user->email}}" @endif onkeyup="validation(this)"
                                               required >
                                        <span class="text-danger error-text"></span></div>

                                    <div class="form-group">
                                        <label for="role">Profile Image</label>
                                        <input type="file" name="avatar" class="form-control">
                                    </div>
                                </div>
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Password</label>
                                        <input type="password" id="password" name="password"
                                               placeholder="Enter Password" data-field-name="Password">
                                        <span class="text-danger error-text"></span>
                                    </div>
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Confirm Password</label>
                                        <input type="password" id="confirm-password" name="password_confirmation"
                                               placeholder="Enter Password" data-field-name="Password"> <span class="text-danger error-text"></span>
                                    </div>

                                </div>
                                <div class="row justify-content-end">
                                    <div class="form-group col-sm-6">
                                        <button type="button" class="btn-block btn-primary" style="width: 100px;"
                                                onclick="updateUser('update-user')">Update
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

        function updateUser(form_id) {
            var status = true;
            $("form#" + form_id + " :input").each(function () {
                status = validation(this, status);
            });
            if (status === true) {
                $.ajax({
                    type: 'POST',
                    url: $('#update-user').attr('action'),
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    data: new FormData($('#update-user')[0]),
                    success: function (response) {
                        if (response.success) {
                            console.log(response.success);
                            window.location = '{{route('index')}}';
                        } else {
                            console.log(response.error);
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
                }
                else if(input_id === 'email')
                {
                    status = validate.email(input,status);
                }

                else {
                    input.removeClass('is-invalid');
                    input.siblings('span.error-text').html('');
                }
            }
            else{
                input.siblings('span.select2-container--default').removeClass('invalid-select');
                input.removeClass('is-invalid');
            }
            return status;
        }

    </script>
@endpush
