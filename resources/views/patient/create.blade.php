@extends('layouts.master')
@section('content')

    <div id="layoutSidenav_content">

        <div class="container-fluid px-4">

            <div class="container-fluid px-1 py-5 mx-auto">
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
                        <h3>@if(isset($patient)) Update @else Add @endif Patient</h3>
                        <div class="card">
                            <p class="blue-text">Please @if(isset($patient)) Update @else Add @endif Patient<br>
                            <form enctype="multipart/form-data" class="form-card" id="create_patient"
                                  @if(isset($patient)) action="{{route('patient.update',['id'=>$patient->id])}}" @else action="{{route('patient.store')}}" @endif method="post">
                                @csrf
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">First name</label>
                                        <input type="text" id="first_name" name="first_name"
                                               placeholder="Enter your first name" data-field-name="First-name"
                                               @if(isset($patient)) value="{{$patient->first_name}}" @endif onkeyup="validates(this)"
                                               required>
                                        <span class="text-danger error-text"></span>
                                    </div>

                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Last name </label>
                                        <input type="text" id="last_name" name="last_name"
                                               placeholder="Enter your last name" data-field-name="Last-name"
                                               @if(isset($patient)) value="{{$patient->last_name}}" @endif onkeyup="validates(this)"
                                               required>
                                        <span class="text-danger error-text"></span></div>
                                </div>
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Personal Email</label>
                                        <input type="text" id="email" name="email" placeholder="Enter Email" data-field-name="Email"
                                               @if(isset($patient)) value="{{$patient->email}}" @endif onkeyup="validates(this)"
                                               required>
                                        <span class="text-danger error-text"></span>
                                    </div>

                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Phone number</label>
                                        <input type="number" id="phone" name="phone" placeholder="Enter Phone Number" data-field-name="Phone-number"
                                               @if(isset($patient)) value="{{$patient->phone}}" @endif onkeyup="validates(this)"
                                               required>
                                        <span class="text-danger error-text"></span>
                                    </div>

                                    <div class="row justify-content-between text-left">
                                        <div class="form-group col-sm-6 flex-column d-flex">
                                            <label class="form-control-label px-3">Age</label>
                                            <input type="number" id="age" name="age" placeholder="Enter age" data-field-name="Age"
                                                   @if(isset($patient)) value="{{$patient->age}}" @endif onkeyup="validates(this)"
                                                   required >
                                            <span class="text-danger error-text"></span>
                                        </div>
                                        <div class="form-group col-sm-6 flex-column d-flex">
                                            <label class="form-control-label px-3">Weight</label>
                                            <input type="number" id="weight" name="weight" placeholder="Enter Weight" data-field-name="Weight"
                                                   @if(isset($patient)) value="{{$patient->weight}}" @endif onkeyup="validates(this)"
                                                   required>
                                            <span class="text-danger error-text"></span>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between text-left">
                                        <div class="form-group col-sm-6 flex-column d-flex">
                                            <label class="form-control-label px-3">Address</label>
                                            <input type="text" id="address" name="address" placeholder="Enter address" data-field-name="Address"
                                                   @if(isset($patient)) value="{{$patient->address}}" @endif
                                                   required >
                                            <span class="text-danger error-text"></span>
                                        </div>
                                        <div class="form-group col-sm-6 flex-column d-flex">
                                            <label class="form-control-label px-3">Disease</label>
                                            <input type="text" id="disease" name="disease" placeholder="Enter Disease " data-field-name="Disease"
                                                   @if(isset($patient)) value="{{$patient->disease}}" @endif onkeyup="validates(this)"
                                                   required>
                                            <span class="text-danger error-text"></span>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between text-left">
                                        <div class="form-group col-sm-6 flex-column d-flex">
                                            <label class="form-control-label px-3">Gender</label>
                                            <input type="text" id="gender" name="gender" list="gender-list"
                                                   data-field-name="Gender" placeholder="Select Gender"  @if(isset($patient)) value="{{$patient->gender}}" @endif required>
                                            <span class="text-danger error-text"></span>
                                            <datalist id="gender-list">
                                                <option value="Male"> Male </option>
                                                <option value="Female">Female</option>
                                            </datalist>

                                        </div>

                                    </div>
                                    <div class="row justify-content-end">
                                        <div class="form-group col-sm-6">
                                            <button type="button" class="btn-block btn-primary" style="width: 100px;"
                                                    onclick="savePatient('create_patient');">Save
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


        function savePatient(form_id)
        {
            var status = true;
            $("form#" + form_id + " :input").each(function (){
                status = validates(this,status);
            });
            if(status === true){

                $.ajax({
                    type: 'POST',
                    url: $('#create_patient').attr('action'),
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    data: new FormData($('#create_patient')[0]),
                    success: function (response) {
                        if (response.success) {
                            console.log(response.success);
                            window.location = '{{route('patient.index')}}';
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
            }
            else{
                return status;
            }

        }

        function validates(object,status)
        {
            var input = $(object);
            if(input.prop('required') && !input.val())
            {
                input.addClass('is-invalid');
                input.addClass('invalid');
                status = false;
                input.siblings('span.error-text').html((input.data('field-name') !== 'undefined') ? input.data('field-name') + ' is required.' : 'is required.');
            }else if(input.val()){
                var input_id = input.attr('id');
                if(input_id === 'first_name')
                {
                    status = validate.first_name(input,status);
                }
                    else if(input_id === 'last_name')
                {
                    status = validate.last_name(input, status);
                }else if(input_id === 'email')
                {
                    status = validate.email(input,status);
                }else if(input_id === 'phone')
                {
                    status = validate.phone_number(input,status);
                }
                else if(input_id === 'age')
                {
                    status = validate.age(input,status);
                }
                else if(input_id === 'weight')
                {
                    status = validate.age(input,status);
                }
                else if(input_id === 'disease'){
                    status = validate.last_name(input,status);
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

