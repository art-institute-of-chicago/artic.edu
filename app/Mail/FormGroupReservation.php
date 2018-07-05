<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Form\GroupReservation;

class FormGroupReservation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var GroupReservation
     */
    public $groupReservation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(GroupReservation $groupReservation)
    {
        $this->groupReservation = $groupReservation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.forms.groupReservation');
    }
}
