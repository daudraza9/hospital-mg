<?php

if (!function_exists('DummyFunction')) {

    //Array set of permissions
    define('permissions', [

        'dashboardView' => 'View Dashboard',

        //--Department Permission--//
        'departmentCreate' => ' Create Department',
        'departmentView'=>'View Department',
        'departmentEdit'=>'Edit Department',
        'departmentDelete'=>'Delete Department',

        //--Doctor Permission--//
        'doctorCreate' => ' Create Doctor',
        'doctorView'=>'View Doctor',
        'doctorEdit'=>'Edit Doctor',
        'doctorDelete'=>'Delete Doctor',
        'doctorPatientAdd'=>'Add Doctor Patient',
        'doctorPatientDelete'=>'Delete Doctor Patient',
        'doctorAppointmentView'=>'View Doctor Appointment',

        //--Patient Permission--//
        'patientCreate' => ' Create Patient',
        'patientView'=>'View Patient',
        'patientEdit'=>'Edit Patient',
        'patientDelete'=>'Delete Patient',
        'patientAppointmentView'=>'View Patient Appointment',

        //--Nurses Permission--//
        'nurseCreate' => ' Create Nurse',
        'nurseView'=>'View Nurse',
        'nurseEdit'=>'Edit Nurse',
        'nurseDelete'=>'Delete Nurse',

        //--Staff Permission--//
        'staffCreate' => ' Create Staff',
        'staffView'=>'View Staff',
        'staffEdit'=>'Edit Staff',
        'staffDelete'=>'Delete Staff',

        //--Room Permission--//
        'roomCreate' => ' Create Room',
        'roomView'=>'View Room',
        'roomEdit'=>'Edit Room',
        'roomDelete'=>'Delete Room',
        'roomPatientAdd'=>'Add Patient Room',
        'roomPatientDelete'=>'Delete Patient Room',

        //--Appointment Permission--//
        'appointmentCreate' => ' Create Appointment',
        'appointmentView'=>'View Appointment',
        'appointmentEdit'=>'Edit Appointment',
        'appointmentDelete'=>'Delete Appointment',
        //--Role Permission--//
        'roleCreate'=>'Create Role',
        'roleEdit'=>'Edit Role',
        'roleDelete'=>'DeleteRole',
        'roleView'=>'View Role',
        'managePermission'=>'Add Permission',

        //--Role Users--//
        'viewUser'=>'View User',
        'deleteUser'=>'Delete User',
        'viewProfileUser'=>'View Profile User',

        'addUser'=>'Add User'
    ]);
}
