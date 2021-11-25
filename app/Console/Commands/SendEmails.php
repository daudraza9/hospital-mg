<?php

namespace App\Console\Commands;
use App\Mail\AppointmentMail;
use App\Models\Appointment;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointment:sendNotify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify Patients 1 day before the appointment';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $appointments =Appointment::where('appointments.date','=',Carbon::tomorrow())->get();


        foreach ($appointments as $appointment)
        {
           echo $appointment->patient_id;
            $patient = Patient::where('patients.id','=',$appointment->patient_id)
                ->first();
             Mail::to([['email'=>$patient->email,'name'=>$patient->first_name." ".$patient->last_name]])->send(new AppointmentMail($patient->first_name,$patient->last_name,$appointment));
        }
    }
}
