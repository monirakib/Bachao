<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $type;

    public function __construct($appointment, $type)
    {
        $this->appointment = $appointment;
        $this->type = $type;
    }

    public function build()
    {
        return $this->markdown('emails.appointment-confirmation')
                    ->subject($this->type === 'patient' 
                        ? 'Your Appointment Confirmation' 
                        : 'New Patient Appointment');
    }
}