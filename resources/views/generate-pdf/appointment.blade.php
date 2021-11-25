@extends('generate-pdf.layout')
@section('content')
    <h2 class="align-content-center">PDF Generator</h2>
    <h1>Appointment Letter </h1>
    Hey
    @if(isset($appointment))
        @if(!empty($appointment->patient))
          Mr/Mrs. {{ $appointment->patient->first_name }} your appointment has been fixed with
        @endif
        @endif

    @if(isset($appointment))
        @if(!empty($appointment->doctor))
          Doctor {{$appointment->doctor->first_name}}.<br>
        @endif
        Please pay your appointment fee, which is {{$appointment->fee}}. <br>
        Please see the appointment schedule <br><br>
        Appointment Date =  {{$appointment->date}} <br> Appointment Time = {{$appointment->time}}<br><br>

    @endif
    <p>Thank you</p>
    <p class="signature">HMS Support</p>
@endsection
<script src="{{asset('assets/js/jquery-3.6.0.js')}}"></script>

    <script>

        {{--$(document).ready(function () {--}}
        {{--    $.ajax({--}}
        {{--        // type: 'GET',--}}
        {{--        ajax: {--}}
        {{--            url: '{{route('appointment.GeneratePdf')}}',--}}
        {{--            data:function (a){--}}
        {{--                a.id = {{$appointment->id}}--}}
        {{--            }--}}
        {{--        },--}}
        {{--        processing: true,--}}
        {{--        serverSide: true,--}}
        {{--        success: function (response) {--}}
        {{--            if (response.success) {--}}
        {{--                console.log(response.success);--}}
        {{--            } else {--}}
        {{--                if (response.success == NULL) {--}}
        {{--                    printErrorMsg(['Something Went Wrong, please Reload or try Again Later!']);--}}
        {{--                } else {--}}
        {{--                    printErrorMsg([response.message]);--}}
        {{--                }--}}
        {{--            }--}}
        {{--        }--}}
        {{--    });--}}
        {{--});--}}
    </script>
