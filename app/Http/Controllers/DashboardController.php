<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\Patient;
use App\Models\Staff;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $totalDoctor = Doctor::count();
        $totalNurse = Nurse::count();
        $totalPatient = Patient::count();
        $totalStaff = Staff::count();
        $totalDepartment = Department::count();
        $totalAppointment = Appointment::count();
        return view('index',['appointmentCount'=>$totalAppointment,'count'=>$totalDoctor,'nursecount'=>$totalNurse,'patientCount'=>$totalPatient,'staffCount'=>$totalStaff,'departmentCount'=>$totalDepartment]);
    }
}
