<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
<p>Hey {{ $first_name }}  {{$last_name}} your appointment has been fixed with
    @if(isset($appointment))
        @if(!empty($appointment->doctor))
            {{$appointment->doctor->first_name}}<br>
        @endif
    Please pay your appointment fee, which is {{$appointment->fee}} <br>
    Please see the appointment schedule <br>
    Appointment Date =  {{$appointment->date}} Appointment Time {{$appointment->time}}<br>

    @endif,</p>
<p>Thank you</p>
<p class="signature">HMS Support</p>
</body>
</html>
