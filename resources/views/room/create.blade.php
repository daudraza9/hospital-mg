@extends('layouts.master')
@section('content')

    <div id="layoutSidenav_content">

        <div class="container-fluid px-4">

            <div class="container-fluid px-1 py-5 mx-auto">
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
                        <h3> @if(isset($room)) Update @else  Add  @endif Rooms</h3>
                        <div class="card">
                            <p class="blue-text">Please enter details for room<br>
                            <form enctype="multipart/form-data" class="form-card" id="create_room"
                                @if(isset($room)) action="{{route('room.update',['id'=>$room->id])}}"  @else action="{{route('room.store')}}" @endif
                                  method="post">
                                @csrf
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Floor No</label>
                                        <input type="number" id="floor_no" name="floor_no"
                                               placeholder="Enter Floor Number" data-field-name="Floor Number"
                                                @if(isset($room)) value="{{$room->floor_no}}" @endif
                                              onkeyup="validates(this)"  required >
                                        <span class="text-danger error-text"></span>
                                    </div>

                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Room No </label>
                                        <input type="number" id="room_no" name="room_no"
                                               placeholder="Enter room no" data-field-name="Room No"
                                                @if(isset($room)) value="{{$room->room_no}}" @endif
                                            onkeyup="validates(this)"  required >
                                        <span class="text-danger error-text"></span></div>
                                </div>
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex">
                                        <label class="form-control-label px-3">Total Beds</label>
                                        <input type="number" id="total_bed" name="total_bed" placeholder="Enter Beds" data-field-name="Total Beds"
                                               @if(isset($room)) value="{{$room->total_bed}}" @endif
                                        onkeyup="validates(this)"  required >
                                        <span class="text-danger error-text"></span>
                                    </div>

                                    <div class="row justify-content-end">
                                        <div class="form-group col-sm-6">
                                            <button type="button" class="btn-block btn-primary" style="width: 100px;"
                                                    onclick="saveRooms('create_room');">@if(isset($room)) Update @else Save @endif
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
        function saveRooms(form_id)
        {
            var status = true;
                $("form#" + form_id + " :input").each(function (){
                    status = validates(this,status);

                });
                if(status ===  true) {
                    $.ajax({
                        type: 'POST',
                        url: $('#create_room').attr('action'),
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        data: new FormData($('#create_room')[0]),
                        success: function (response) {
                            if (response.success) {
                                console.log(response.success);
                                window.location = '{{route('room.index')}}';
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

       function validates(object,status)
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
                if(input_id === 'floor_id')
                {
                    status =  validate.room(input, status);
                }
                else if(input_id === 'room_no')
                {
                    status = validate.room(input,status);
                }
                else if(input_id === 'total_bed')
                {
                    status = validate.room(input,status);
                }else {
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

