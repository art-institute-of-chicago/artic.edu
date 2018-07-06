<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Form\EducatorAdmission;

class FormEducatorAdmission extends Mailable
{
    use Queueable, SerializesModels;

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
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.forms.educatorAdmission');
    }
}
