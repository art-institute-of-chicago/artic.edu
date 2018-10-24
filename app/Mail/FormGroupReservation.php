<?php

namespace App\Mail;

use App\Models\Form\GroupReservation;

class FormGroupReservation extends FormMailable
{
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
        $this->subject = 'Group Reservation ' . $this->getSubjectTimestamp();
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
