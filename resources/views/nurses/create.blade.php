@extends('layouts.master')
@section('content')

    <div id="layoutSidenav_content">

        <div class="container-fluid px-4">

            <div class="container-fluid px-1 py-5 mx-auto">
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
                        <h3>@if(isset($nurse)) Update @else Add @endif Nurse</h3>
                        <div class="card">
                            <p class="blue-text">Please @if(isset($nurse)) Update @else  add @endif nurse<br>
                            <form enctype="multipart/form-data" class="form-card" id="create_nurse"
                               @if(isset($nurse)) action="{{route('nurse.update',['id'=>$nurse->id])}}"
                                  @else action="{{route('nurse.store')}}" @endif method="post">
                                @csrf
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">First name</label>
                                        <input type="text" id="first_name" name="first_name"
                                               placeholder="Enter your first name" data-field-name="First-name" @if(isset($nurse)) value="{{$nurse->first_name}}" @endif
                                                  onkeyup="validation(this)" required>
                                        <span class="text-danger error-text"></span>
                                    </div>

                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Last name </label>
                                        <input type="text" id="last_name" name="last_name"
                                               placeholder="Enter your last name" data-field-name="Last-name" @if(isset($nurse)) value="{{$nurse->last_name}}" @endif
                                              onkeyup="validation(this)" required>
                                        <span class="text-danger error-text"></span></div>
                                </div>
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Personal Email</label>
                                        <input type="text" id="email" name="email" placeholder="Enter Email"
                                                @if(isset($nurse)) value="{{$nurse->email}}" @endif
                                                data-field-name="Email" onkeyup="validation(this)"   required>
                                        <span class="text-danger error-text"></span>
                                    </div>

                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Phone number</label>
                                        <input type="number" id="phone" name="phone" placeholder="Enter Phone Number"
                                               @if(isset($nurse)) value="{{$nurse->phone}}" @endif
                                               data-field-name="Phone-number" onkeyup="validation(this)" required>
                                        <span class="text-danger error-text"></span>
                                    </div>

                                    <div class="row justify-content-between text-left">
                                        <div class="form-group col-sm-6 flex-column d-flex">
                                            <label class="form-control-label px-3">Position</label>
                                            <input type="position" id="position" name="position" placeholder="Enter position"
                                                @if(isset($nurse)) value="{{$nurse->position}}" @endif
                                                   data-field-name="Position" onkeyup="validation(this)"  required >
                                            <span class="text-danger error-text"></span>
                                        </div>
                                        <div class="form-group col-sm-6 flex-column d-flex">
                                            <label class="form-control-label px-3">Joined At</label>
                                            <input type="date" id="joined_at" name="joined_at"   @if(isset($nurse))  value="{{\Carbon\Carbon::parse($nurse->joined_at)->format('Y-m-d')}}" @endif
                                                  data-field-name="Date" required>
                                            <span class="text-danger error-text"></span>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between text-left">
                                        <div class="form-group col-sm-6 flex-column d-flex">
                                            <div class="form-group">
                                                <label for="department">Add Department</label>
                                                <select id="department" data-field-name="Department"
                                                        class="form-control select2-reset"
                                                        name="department"  required>

                                                    <option></option>
                                                    @if(isset($nurse))
                                                        @if(!empty($nurse->department))
                                                            <option value="{{$nurse->department->id}}" selected>{{$nurse->department->name}}</option>
                                                        @endif
                                                    @endif
                                                </select>
                                                <span class="text-danger error-text"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end">
                                        <div class="form-group col-sm-6">
                                            <button type="button" class="btn-block btn-primary" style="width: 100px;"
                                                    onclick="save('create_nurse');">Save
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
    function save(form_id)
    {
        var status = true;
        $("form#" + form_id + " :input").each(function (){
            status = validation(this,status);
        });
        if(status === true) {
            $.ajax({
                type: 'POST',
                url: $('#create_nurse').attr('action'),
                dataType: "json",
                processData: false,
                contentType: false,
                data: new FormData($('#create_nurse')[0]),
                success: function (response) {
                    if (response.success) {
                        console.log(response.success);
                        window.location = '{{route('nurse.index')}}';
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
        }else if(input.val()){
            var input_id = input.attr('id');
            if(input_id === 'first_name')
            {
                status = validate.first_name(input,status);
            }else if(input_id === 'last_name')
            {
                status = validate.last_name(input, status);
            }else if(input_id === 'email')
            {
                status = validate.email(input,status);
            }else if(input_id === 'phone')
            {
                status = validate.phone_number(input,status);
            }
            else if(input_id === 'position')
            {
                status = validate.title(input,status);
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

    $(document).ready(function () {
        $('#department').select2({
            placeholder: 'Select Department',
            ajax: {
                url: '{{route('nurse.selectDepartment')}}',
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

