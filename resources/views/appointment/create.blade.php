@extends('layouts.master')
@section('content')

    <div id="layoutSidenav_content">

        <div class="container-fluid px-4">

            <div class="container-fluid px-1 py-5 mx-auto">
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
                        <h3> @if(isset($appointment)) Update @else Add @endif Appointment</h3>
                        <div class="card" id="form-style">
                            <p class="blue-text">Please @if(isset($appointment)) update @else enter @endif appointment details<br>
                            <form enctype="multipart/form-data" class="form-card" id="appointment-form"
                                  action="{{route('appointment.add')}}"
                                  method="post">
                                @csrf
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label for="patients">Add Patients</label>
                                        <select id="patients" data-field-name="Patients"
                                                class="form-control select2-reset"
                                                name="patient" required style="width: 100%">
                                            <option></option>
                                            @if(isset($appointment))
                                                @if(!empty($appointment->patient))
                                                    <option value="{{$appointment->patient->id}}" selected>{{$appointment->patient->first_name}}</option>
                                                @endif
                                            @endif
                                        </select>
                                        <span class="text-danger error-text"></span>
                                    </div>
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label for="doctor">Add Doctors</label>
                                        <select id="doctor" data-field-name="Doctor"
                                                class="form-control select2-reset"
                                                name="doctor"  required>
                                            <option></option>
                                            @if(isset($appointment))
                                                @if(!empty($appointment->doctor))
                                                    <option value="{{$appointment->doctor->id}}" selected>{{$appointment->doctor->first_name}}</option>
                                                 @endif
                                            @endif
                                        </select>
                                        <span class="text-danger error-text"></span></div>
                                </div>
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Fee</label>
                                        <input type="number" id="fee" name="fee"
                                               placeholder="Enter Fee" data-field-name="Fee"
                                               @if(isset($appointment)) value="{{$appointment->fee}}" @endif
                                               required onkeyup="validation(this)" >
                                        <span class="text-danger error-text"></span>
                                    </div>
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Date </label>
                                        <input type="date" id="date" name="date"
                                               placeholder="Enter date" data-field-name="Date"
                                               @if(isset($appointment)) value="{{$appointment->date}}" @endif
                                               required >
                                        <span class="text-danger error-text"></span></div>
                                </div>
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Time</label>
                                        <input type="time" id="time" name="time"
                                               placeholder="Enter time" data-field-name="Time"
                                               @if(isset($appointment)) value="{{$appointment->time}}" @endif
                                               required  >
                                        <span class="text-danger error-text"></span>
                                    </div>

                                </div>
                                <div class="row justify-content-end">
                                    <div class="form-group col-sm-6">
                                        <button type="button" class="btn-block btn-primary" style="width: 100px;"
                                                onclick="addAppointment('appointment-form');">Save
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

        function addAppointment(form_id)
        {
            var status = true;
            $("form#" + form_id + " :input").each(function (){
                status = validation(this,status);
            });
            if(status === true) {
                $.ajax({
                    type: 'POST',
                    url: $('#appointment-form').attr('action'),
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    data: new FormData($('#appointment-form')[0]),
                    success: function (response) {
                        if (response.success) {
                            console.log(response.success);
                            window.location = '{{route('appointment.index')}}';
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
            }
            else if(input.val())
            {
                var input_id = input.attr('id');
                if(input_id === 'fee')
                {
                    status = validate.salary(input,status);
                }
            }else{
                input.siblings('span.select2-container--default').removeClass('invalid-select');
                input.removeClass('is-invalid');
            }
            return status;
        }

        $(document).ready(function () {
            $('#doctor').select2({
                placeholder: 'Select Doctor',
                ajax: {
                    url: '{{route('appointment.selectDoctor')}}',
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
                                    text: item.first_name+' '+item.last_name+' '+item.email
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

        $(document).ready(function () {
            $('#patients').select2({
                placeholder: 'Select Patient',
                ajax: {
                    url: '{{route('appointment.selectPatient')}}',
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
                                    text: item.first_name+' '+item.last_name+' '+item.email
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
