<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Form\FilmingProposal;

class FormFilmingProposal extends Mailable
{
    use Queueable, SerializesModels;

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
