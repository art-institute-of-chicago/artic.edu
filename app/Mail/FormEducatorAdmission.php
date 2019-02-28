<?php

namespace App\Mail;

use App\Models\Form\EducatorAdmission;

class FormEducatorAdmission extends FormMailable
{
    /**
     * The order instance.
     *
     * @var EducatorAdmission
     */
    public $educatorAdmission;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(EducatorAdmission $educatorAdmission)
    {
        $this->educatorAdmission = $educatorAdmission;
        $this->subject = 'Educator Admission ' . $this->getSubjectTimestamp();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('erc@artic.edu')
            ->markdown('emails.forms.educatorAdmission');
    }
}
