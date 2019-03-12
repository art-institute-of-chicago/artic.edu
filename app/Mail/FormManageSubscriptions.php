<?php

namespace App\Mail;

use App\Models\Form\ManageSubscriptions;

class FormManageSubscriptions extends FormMailable
{
    /**
     * The order instance.
     *
     * @var ManageSubscriptions
     */
    public $manageSubscriptions;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ManageSubscriptions $manageSubscriptions)
    {
        $this->manageSubscriptions = $manageSubscriptions;
        $this->subject = 'Manage Subscriptions ' . $this->getSubjectTimestamp();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.forms.manageSubscriptions');
    }
}
