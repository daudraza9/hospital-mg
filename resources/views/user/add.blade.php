@extends('layouts.master')
@section('content')

    <div id="layoutSidenav_content">
        <main>
            <a href="{{route('user.view')}}"><button>View All Users</button></a>
            <div class="container-fluid px-1 py-5 mx-auto">
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
                        <h3> Add User</h3>

                        <div class="card" id="form-style">
                            <p class="blue-text">Please enter details for user<br>
                            <form enctype="multipart/form-data" class="form-card" id="create_user"
                                  action="{{route('user.create')}}"
                                  method="post">
                                @csrf
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Name</label>
                                        <input type="text" id="name" name="name"
                                               placeholder="Enter your name" data-field-name="Name"
                                               onkeyup="validation(this)"
                                               required>
                                        <span class="text-danger error-text"></span>
                                    </div>

                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Email</label>
                                        <input type="email" id="email" name="email"
                                               placeholder="Enter your email" data-field-name="Email"
                                               onkeyup="validation(this)"
                                               required>
                                        <span class="text-danger error-text"></span></div>
                                </div>
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Password</label>
                                        <input type="password" id="password" name="password"
                                               placeholder="Enter Password"
                                               onkeyup="validation(this)"
                                               data-field-name="Password" required>
                                        <span class="text-danger error-text"></span>
                                    </div>
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <div class="form-group">
                                            <label for="role">Add Role</label>
                                            <select class="form-control select-multiple select2-reset"
                                                    id="role" data-field-name="Role"
                                                    name="role[]" multiple="multiple" required>
                                                <option></option>
                                                @if(isset($user))
                                                    @foreach($user->roles as $key)
                                                        <option value="{{$key->name}}" selected>{{$key->name}}</option>
                                                    @endforeach
                                                @endif

                                            </select>
                                            <span class="text-danger error-text"></span>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <div class="form-group">
                                            <label for="role">Profile Image</label>
                                            <input type="file" name="avatar" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="form-group col-sm-6">
                                        <button type="button" class="btn-block btn-primary" style="width: 100px;"
                                                onclick="save('create_user');">Save
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>

@endsection

@push('scripts')
    <script>
        function save(form_id) {
            var status = true;
            $("form#" + form_id + " :input").each(function () {
                status = validation(this, status);
            });
            if (status === true) {
                $.ajax({
                    type: 'POST',
                    url: $('#create_user').attr('action'),
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    data: new FormData($('#create_user')[0]),
                    success: function (response) {
                        if (response.success) {
                            window.location = '{{route('index')}}';
                        } else {
                            if (response.success == NULL) {
                                printErrorMsg(['Something Went Wrong, please Reload or try Again Later!']);
                            } else {
                                printErrorMsg([response.message]);
                            }
                        }
                    }
                });
            } else {
                return status;
            }

        }

        function validation(object, status) {
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
                } else if (input_id === 'email') {
                    status = validate.email(input, status);
                } else if (input_id === 'password') {
                    status = validate.password_lengths(input, status);
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

        $(document).ready(function () {
            $('#role').select2({
                placeholder: 'Select Role',
                ajax: {
                    url: '{{route('role.roleSelect')}}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data.data, function (item) {
                                return {
                                    id: item.id,
                                    text: item.name
                                }
                            }),
                            pagination: {
                                more: (data.current_page < data.last_page)
                            }
                        };
                    },
                    cache: true
                }

            });
        });
    </script>
@endpush

