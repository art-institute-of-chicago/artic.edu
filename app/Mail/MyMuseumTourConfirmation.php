<?php

namespace App\Mail;

use App\Models\CustomTour;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MyMuseumTourConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The tour instance.
     *
     * @var CustomTour
     */
    public $museumTour;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(CustomTour $museumTour)
    {
        $this->museumTour = $museumTour;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Your museum tour confirmation';
        $fromAddress = 'info@artic.edu';
        $fromName = 'My Museum Tours at the Art Institute of Chicago';

        return $this->view('emails.myMuseumTourConfirmation')
            ->from($fromAddress, $fromName)
            ->replyTo($fromAddress, $fromName)
            ->subject($subject)
            ->with([ 'museumTour' => $this->museumTour ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    // public function attachments(): array
    // {
    //     return [
    //         Attachment::fromStorageDisk('pdf_s3', 'download-custom-tours.pdf-layout-' . $this->museumTour->id . '.pdf')
    //             ->as('my-museum-tour-' . $this->museumTour->id . '-.pdf')
    //             ->withMime('application/pdf'),
    //     ];
    // }
}
