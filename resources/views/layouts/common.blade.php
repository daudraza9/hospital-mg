@push('scripts')
    <script type="text/javascript">

        function printErrorMsg(msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display', 'block');
            $.each(msg, function (key, value) {
                $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
            });
            setTimeout(function () {
                $(".print-error-msg").fadeOut(3000);
            }, 4000);
        }

        //-----Validate Functions----//

        var validate = {
            email: function (input, status) {
                pattern = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                if (!pattern.test(input.val())) {
                    input.addClass('is-invalid');
                    input.siblings('span.error-text').html((input.data('field-name') !== 'undefined') ? input.data('field-name') + ' must be valid.' : ' must be valid.');
                    status = false;
                } else {
                    input.removeClass('is-invalid');
                    input.siblings('span.error-text').html('');
                }
                return status;
            },
            password_lengths: function (input, status) {
                pattern = /[^ ]{8,}$/g;
                if (!pattern.test(input.val())) {
                    input.addClass('is-invalid');
                    status = false;
                    input.siblings('span.error-text').html((input.data('field-name') !== 'undefined') ? input.data('field-name') + ' should be minimum 8 Characters.' : ' should be minimum 8 Characters.');
                } else {
                    input.removeClass('is-invalid');
                    input.siblings('span.error-text').html('');
                }
                return status;
            },
            first_name: function (input, status) {
                pattern = /^[a-zA-Z\_]{1,50}$/i;
                if (!pattern.test(input.val())) {
                    input.addClass('is-invalid');
                    input.siblings('span.error-text').html((input.data('field-name') !== 'undefined') ? input.data('field-name') + ' must be valid.' : ' must be valid.');
                    status = false;
                } else {
                    input.removeClass('is-invalid');
                    input.siblings('span.error-text').html('');
                }
                return status;
            },
            last_name: function (input, status) {
                pattern = /^[a-zA-Z\_]{1,50}$/i;
                if (!pattern.test(input.val())) {
                    input.addClass('is-invalid');
                    input.siblings('span.error-text').html((input.data('field-name') !== 'undefined') ? input.data('field-name') + ' must be valid.' : ' must be valid.');
                    status = false;
                } else {
                    input.removeClass('is-invalid');
                    input.siblings('span.error-text').html('');
                }
                return status;
            },
            phone_number: function (input, status)
            {
                pattern = /^\d{10}$/g;
                if (!pattern.test(input.val())) {
                    input.addClass('is-invalid');
                    status = false;
                    input.siblings('span.error-text').html((input.data('field-name') !== 'undefined') ? input.data('field-name') + ' must be 10 digit.' : ' must be 10 digit.');
                } else {
                    input.removeClass('is-invalid');
                    input.siblings('span.error-text').html('');
                }
                return status;
            },
            title: function (input,status)
            {
                pattern = /^[a-zA-Z\_]{1,50}$/i;
                if (!pattern.test(input.val())) {
                    input.addClass('is-invalid');
                    status = false;
                    input.siblings('span.error-text').html((input.data('field-name') !== 'undefined') ? input.data('field-name') + ' must valid.' : ' must be valid.');

                } else {
                    input.removeClass('is-invalid');
                    input.siblings('span.error-text').html('');
                }
                return status;
            },
            salary: function (input,status){
                pattern = /[+-]?([0-9]*[.])?[0-9]+/g;
                if (!pattern.test(input.val())) {
                    input.addClass('is-invalid');
                    status = false;
                    input.siblings('span.error-text').html((input.data('field-name') !== 'undefined') ? input.data('field-name') + ' must valid.' : ' must be valid.');

                } else {
                    input.removeClass('is-invalid');
                    input.siblings('span.error-text').html('');
                }
                return status;
            },
            age: function (input,status){
                 age = input.val();
                if (!( age > 1 && age<150 )) {
                    input.addClass('is-invalid');
                    status = false;
                    input.siblings('span.error-text').html((input.data('field-name') !== 'undefined') ? input.data('field-name') + ' must be 10 digit.' : ' must be 10 digit.');
                } else {
                    input.removeClass('is-invalid');
                    input.siblings('span.error-text').html('');
                }
                return status;
            },
            room:function (input, status){

                pattern = /[+-]?([0-9]*[.])?[0-9]+/g;
                if (!pattern.test(input.val())) {
                    input.addClass('is-invalid');
                    status = false;
                    input.siblings('span.error-text').html((input.data('field-name') !== 'undefined') ? input.data('field-name') + ' must valid.' : ' must be valid.');

                } else {
                    input.removeClass('is-invalid');
                    input.siblings('span.error-text').html('');
                }
                return status;
            }

        }
    </script>
@endpush
