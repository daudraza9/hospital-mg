@extends('auth.layouts.auth-master')

@section('content')
    <div class="limiter">
        <div class="container-login100" style="background-image: url({{asset('assets/images/bg-01.jpg')}});">
            <div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
					Account Login
				</span>
                <div class="card-body">
                    <div id="login_errors">
                        @include('partials.js-validation')
                    </div>
                    <form id="login-form" class="login100-form p-b-33 p-t-5" enctype="multipart/form-data"
                          method="POST" action="{{route('login')}}">
                        @csrf
                        <div class="wrap-input100" data-validate="Enter Email">
                            <input id="email" class="input100" type="email" name="email" data-field-name="Email"
                                   placeholder="Enter Email" onkeyup="validation(this)" required autocomplete="off"
                                   autofocus>
                            <span class="text-danger error-text"></span>
                        </div>
                        <div class="wrap-input100 " data-validate="Enter password">
                            <input id="password" class="input100" type="password" name="password"
                                   data-field-name="password"
                                   placeholder="Password" onkeyup="validation(this)" autocomplete="off"
                                   autofocus required>
                            <span class="text-danger error-text"></span>
                        </div>


                        <div class="container-login100-form-btn m-t-32">
                            <button aria-label="Close" class=" login100-form-btn" type="button"
                                    onclick="logins('login-form');">
                                Login
                            </button>
                            <a href="login/google" aria-label="Close" class=" login100-form-btn btn-primary mt-3"  >
                                Login with Google
                            </a>
                            <a href="login/github" aria-label="Close" class="btn btn-primary mt-3"  >
                                Login with Github
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>

        function logins(form_id) {
            var status = true;
            $("form#" + form_id + " :input").each(function () {
                status = validation(this, status);
                console.log($(this));
                console.log(status);
            });
            if (status === true) {

                $.ajax({
                    type: 'POST',
                    url: '{{route('login')}}',
                    data: new FormData($('#login-form')[0]),
                    processData: false,
                    contentType: false,
                    dataType: "json",

                    success: function (response) {
                        if (response.success) {
                            window.location = '{{route('index')}}';
                        } else {
                            if (response.success == null) {
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
                status = false;
                input.siblings('span.error-text').html((input.data('field-name') !== 'undefined') ? input.data('field-name') + ' is required.' : 'is required.');
            }
            else if (input.val())
            {
                var input_id = input.attr('id');
                if (input_id === 'email') {
                     status = validate.email(input,status);
                } else if (input_id === 'password') {
                    status = validate.password_lengths(input,status);
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
