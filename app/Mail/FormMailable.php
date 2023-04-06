<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FormMailable extends Mailable
{
    use Queueable;
    use SerializesModels;

    protected function getSubjectTimestamp()
    {
        return '(' . now()->toFormattedDateString() . ' at ' . now()->format('g:i A') . ')';
    }
}
