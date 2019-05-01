<?php

namespace App\Mail;

use App\Models\Form\EmailSubscriptions;

class FormEmailSubscriptions extends FormMailable
{
    /**
     * The order instance.
     *
     * @var EmailSubscriptions
     */
    public $emailSubscriptions;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(EmailSubscriptions $emailSubscriptions)
    {
        $this->emailSubscriptions = $emailSubscriptions;
        $this->subject = 'Email Subscriptions ' . $this->getSubjectTimestamp();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.forms.emailSubscriptions');
    }
}
