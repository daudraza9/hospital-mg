<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\Patient;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Comment\Doc;
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

    public function exportCsv(Request $request){

        $fileName = 'users.csv';
        $tasks = User::all();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('id', 'name', 'email', 'created_at', 'updated_at');

        $callback = function() use($tasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($tasks as $task) {
                $row['id']  = $task->id;
                $row['name']    = $task->name;
                $row['email']    = $task->email;
                $row['created_at']  = $task->created_at;
                $row['updated_at']  = $task->updated_at;

                fputcsv($file, array($row['id'], $row['name'], $row['email'], $row['created_at'], $row['updated_at']));
            }

            fclose($file);

        };

        return response()->stream($callback, 200, $headers);
    }

    public function test(){
        dd('Hello');
    }
}
