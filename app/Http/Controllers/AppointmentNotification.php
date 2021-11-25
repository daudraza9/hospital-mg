<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentNotification extends Controller
{
    //
        public function getUsers(Request $request)
        {
            $appointment = Appointment::select('appoinmtents.date','appointments.time');

        }
}
