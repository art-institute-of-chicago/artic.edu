<?php

namespace App\Mail;

use App\Models\Form\FilmingProposal;

class FormFilmingProposal extends FormMailable
{
    /**
     * The order instance.
     *
     * @var FilmingProposal
     */
    public $filmingProposal;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(FilmingProposal $filmingProposal)
    {
        $this->filmingProposal = $filmingProposal;
        $this->subject = 'Filming Proposal ' . $this->getSubjectTimestamp();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.forms.filmingProposal');
    }
}
