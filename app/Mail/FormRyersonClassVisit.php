<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Form\RyersonClassVisit;

class FormRyersonClassVisit extends Mailable
{
    use Queueable, SerializesModels;

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
