<?php

namespace App\Mail;

use App\Models\Form\RyersonClassVisit;

class FormRyersonClassVisit extends FormMailable
{
    /**
     * The order instance.
     *
     * @var RyersonClassVisit
     */
    public $ryersonClassVisit;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(RyersonClassVisit $ryersonClassVisit)
    {
        $this->ryersonClassVisit = $ryersonClassVisit;
        $this->subject = 'Ryerson Class Visit ' . $this->getSubjectTimestamp();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.forms.ryersonClassVisit');
    }
}
