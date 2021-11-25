@extends('layouts.master')
@section('content')

    <div id="layoutSidenav_content">

        <div class="container-fluid px-4">

            <div class="container-fluid px-1 py-5 mx-auto">
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
                        <h3>@if(isset($staff)) Update @else Add @endif Staff</h3>
                        <div class="card">
                            <p class="blue-text">Please @if(isset($staff)) Update @else Add  @endif Staff<br>
                            <form enctype="multipart/form-data" class="form-card" id="create_staff"
                                 @if(isset($staff)) action="{{route('staff.update',['id'=>$staff->id])}}" @else action="{{route('staff.store')}}" @endif method="post">
                                @csrf
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">First name</label>
                                        <input type="text" id="first_name" name="first_name"
                                               placeholder="Enter your first name" data-field-name="First-name"
                                               @if(isset($staff)) value="{{$staff->first_name}}" @endif onkeyup="validation(this)"
                                                required>
                                        <span class="text-danger error-text"></span>
                                    </div>

                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Last name </label>
                                        <input type="text" id="last_name" name="last_name"
                                               placeholder="Enter your last name" data-field-name="Last-name"
                                               @if(isset($staff)) value="{{$staff->last_name}}" @endif  onkeyup="validation(this)"
                                                required>
                                        <span class="text-danger error-text"></span></div>
                                </div>
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Personal Email</label>
                                        <input type="text" id="email" name="email" placeholder="Enter Email" data-field-name="Email"
                                               @if(isset($staff)) value="{{$staff->email}}" @endif  onkeyup="validation(this)"
                                               required>
                                        <span class="text-danger error-text"></span>
                                    </div>

                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Phone number</label>
                                        <input type="number" id="phone" name="phone" placeholder="Enter Phone Number" data-field-name="Phone-number"
                                               @if(isset($staff)) value="{{$staff->phone}}" @endif  onkeyup="validation(this)"
                                               required>
                                        <span class="text-danger error-text"></span>
                                    </div>

                                    <div class="row justify-content-between text-left">
                                        <div class="form-group col-sm-6 flex-column d-flex">
                                            <label class="form-control-label px-3">Address</label>
                                            <input type="address" id="address" name="address" placeholder="Enter address" data-field-name="Address"
                                                   @if(isset($staff)) value="{{$staff->address}}" @endif
                                                   required >
                                            <span class="text-danger error-text"></span>
                                        </div>
                                        <div class="form-group col-sm-6 flex-column d-flex">
                                            <label class="form-control-label px-3">Joined At</label>
                                            <input type="date" id="joined_at" name="joined_at" data-field-name="Date"
                                                   @if(isset($staff)) value="{{$staff->joined_at}}" @endif
                                                   required>
                                            <span class="text-danger error-text"></span>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between text-left">
                                        <div class="form-group col-sm-6 flex-column d-flex">
                                            <label class="form-control-label px-3">Salary</label>
                                            <input type="salary" id="salary" name="salary" placeholder="Enter salary" data-field-name="Salary"
                                                   @if(isset($staff)) value="{{$staff->salary}}" @endif onkeyup="validation(this)"
                                                   required >
                                            <span class="text-danger error-text"></span>
                                        </div>
                                        <div class="form-group col-sm-6 flex-column d-flex">
                                            <label class="form-control-label px-3">Department</label>
                                            <input type="department" id="department" name="department" placeholder="Enter department" data-field-name="Department"
                                                   @if(isset($staff)) value="{{$staff->department}}" @endif onkeyup="validation(this)"
                                                   required >
                                            <span class="text-danger error-text"></span>
                                        </div>

                                    </div>


                                    <div class="row justify-content-end">
                                        <div class="form-group col-sm-6">
                                            <button type="button" class="btn-block btn-primary" style="width: 100px;"
                                                    onclick="saveStaff('create_staff');">@if(isset($staff)) Update @else Save @endif
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


            function saveStaff(form_id) {
                var status = true;
                $("form#" + form_id + " :input").each(function (){
                    status = validation(this,status);

                });
                if(status === true) {
                    $.ajax({
                        type: 'POST',
                        url: $('#create_staff').attr('action'),
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        data: new FormData($('#create_staff')[0]),
                        success: function (response) {
                            if (response.success) {
                                console.log(response.success);
                                window.location = '{{route('staff.index')}}';
                            } else if(response.error){
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
                else if(input_id === 'department')
                {
                    status = validate.title(input,status);
                }
                else if(input_id === 'salary'){
                    status = validate.salary(input,status);
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

