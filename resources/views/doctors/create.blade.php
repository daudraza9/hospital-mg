@extends('layouts.master')
@section('content')

    <div id="layoutSidenav_content">

        <div class="container-fluid px-4">

            <div class="container-fluid px-1 py-5 mx-auto">
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
                        <h3> @if(isset($doctor)) Update @else Add @endif Doctor</h3>

                        <div class="card" id="form-style">
                            <p class="blue-text">Please @if(isset($doctor))Update @else add @endif doctor<br>
                            <form enctype="multipart/form-data" class="form-card" id="create_doctor"
                                  @if(isset($doctor)) action="{{route('doctor.update',['id'=>$doctor->id])}}"
                                  @else action="{{route('doctor.store')}}" @endif method="post">
                                @csrf
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">First name</label>
                                        <input type="text" id="first_name" name="first_name"
                                               placeholder="Enter your first name" data-field-name="First-name"
                                               @if(isset($doctor)) value="{{$doctor->first_name}}"
                                               @endif onkeyup="validates(this)" required>
                                        <span class="text-danger error-text"></span>
                                    </div>

                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Last name </label>
                                        <input type="text" id="last_name" name="last_name"
                                               placeholder="Enter your last name" data-field-name="Last-name"
                                               @if(isset($doctor)) value="{{$doctor->last_name}}"
                                               @endif onkeyup="validates(this)" required>
                                        <span class="text-danger error-text"></span></div>
                                </div>
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Personal Email</label>
                                        <input type="text" id="email" name="email" placeholder="Enter Email"
                                               @if(isset($doctor)) value="{{$doctor->email}}"
                                               @endif data-field-name="Email" onkeyup="validates(this)" required>
                                        <span class="text-danger error-text"></span>
                                    </div>

                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Phone number</label>
                                        <input type="number" id="phone" name="phone" placeholder="Enter Phone Number"
                                               @if(isset($doctor)) value="{{$doctor->phone}}" @endif  data-field-name="Phone-number"
                                               onkeyup="validates(this)" required>
                                        <span class="text-danger error-text"></span>
                                    </div>

                                    <div class="row justify-content-between text-left">
                                        <div class="form-group col-sm-6 flex-column d-flex">
                                            <label class="form-control-label px-3">Dr Title</label>
                                            <input type="text" id="title" name="title" placeholder="Enter title"
                                                   @if(isset($doctor)) value="{{$doctor->title}}" @endif
                                            data-field-name="Title" onkeyup="validates(this)" required >
                                            <span class="text-danger error-text"></span>
                                        </div>
                                        <div class="form-group col-sm-6 flex-column d-flex">
                                            <label class="form-control-label px-3">Adress</label>
                                            <input type="text" id="address" name="address" placeholder="Enter address"
                                                   @if(isset($doctor)) value="{{$doctor->address}}" @endif onkeyup="validates(this)" data-field-name="Address" required>
                                            <span class="text-danger error-text"></span>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between text-left">
                                        <div class="form-group col-sm-6 flex-column d-flex">
                                            <label class="form-control-label px-3">Experience</label>
                                            <input type="text" id="experience" name="experience"
                                                   placeholder="Enter experience"
                                                   @if(isset($doctor)) value="{{$doctor->experience}}" @endif onkeyup="validates(this)" required data-field-name="Experience">
                                            <span class="text-danger error-text"></span>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end">
                                        <div class="form-group col-sm-6">
                                            <button type="button" class="btn-block btn-primary" style="width: 100px;"
                                                    onclick="save('create_doctor');">Save
                                            </button>
                                        </div>
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

        function save(form_id) {
            var status = true;
            $("form#" + form_id + " :input").each(function () {
                status = validates(this, status);
            });
            if (status === true) {

                $.ajax({
                    type: 'POST',
                    url: $('#create_doctor').attr('action'),
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    data: new FormData($('#create_doctor')[0]),
                    success: function (response) {
                        if (response.success) {
                            window.location = '{{route('doctor.index')}}';
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

        function validates(object, status) {

            var input = $(object);
            if (input.prop('required') && !input.val()) {
                input.addClass('is-invalid');
                input.addClass('invalid');
                status = false;
                input.siblings('span.error-text').html((input.data('field-name') !== 'undefined') ? input.data('field-name') + ' is required.' : 'is required.');
            } else if (input.val()) {
                var input_id = input.attr('id');
                if (input_id === 'first_name') {
                    status = validate.first_name(input, status);
                } else if (input_id === 'last_name') {
                    status = validate.last_name(input, status);
                } else if (input_id === 'email') {
                    status = validate.email(input, status);
                } else if (input_id === 'phone') {
                    status = validate.phone_number(input, status);
                }else if(input_id === 'title'){
                    status =validate.title(input,status);
                }
                else {
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
