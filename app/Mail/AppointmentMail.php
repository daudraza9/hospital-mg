<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $msg, $first_name,$last_name,$appointment;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($first_name,$last_name,Appointment $appointment)
    {
        $this->first_name =$first_name;
        $this->last_name = $last_name;
        $this->appointment = $appointment;
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Appointment Notification')
            ->view('patient.email',['appointment'=>$this->appointment,'first_name'=>$this->first_name,'last_name'=>$this->last_name]);
    }
}
