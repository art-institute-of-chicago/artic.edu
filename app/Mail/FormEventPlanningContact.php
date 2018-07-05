<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Form\EventPlanningContact;

class FormEventPlanningContact extends Mailable
{
    use Queueable, SerializesModels;

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
