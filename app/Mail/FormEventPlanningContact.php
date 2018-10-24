<?php

namespace App\Mail;

use App\Models\Form\EventPlanningContact;

class FormEventPlanningContact extends FormMailable
{
    /**
     * The order instance.
     *
     * @var EventPlanningContact
     */
    public $eventPlanningContact;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(EventPlanningContact $eventPlanningContact)
    {
        $this->eventPlanningContact = $eventPlanningContact;
        $this->subject = 'Event Planning ' . $this->getSubjectTimestamp();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.forms.eventPlanningContact');
    }
}
