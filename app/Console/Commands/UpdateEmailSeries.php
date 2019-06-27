<?php

namespace App\Console\Commands;

use App\Models\EmailSeries;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use Illuminate\Console\Command;

class UpdateEmailSeries extends Command
{

    protected $signature = 'update:email-series';

    protected $description = 'Prime email series data';

    private $emailSeries = [
        'Save the Date 90' => [
            'published' => true,
            'show_affiliate_member' => true,
            'show_member' => true,
            'show_sustaining_fellow' => true,
            'show_non_member' => true,
            'use_short_description' => true,
        ],
        'Save the Date 60' => [
            'published' => true,
            'show_affiliate_member' => true,
            'show_member' => true,
            'show_sustaining_fellow' => true,
            'show_non_member' => true,
            'use_short_description' => true,
        ],
        'Save the Date 30' => [
            'published' => true,
            'show_affiliate_member' => true,
            'show_member' => true,
            'show_sustaining_fellow' => true,
            'show_non_member' => true,
            'use_short_description' => true,
        ],
        'Affiliate Tickets on Sale/Registration Open' => [
            'published' => true,
            'show_affiliate_member' => true,
            'show_member' => false,
            'show_sustaining_fellow' => false,
            'show_non_member' => false,
            'use_short_description' => false,
            'affiliate_member_copy' => '<p>Tickets are sure to go quickly for this program—be sure to get yours today.</p>',
            'member_copy' => '',
            'sustaining_fellow_copy' => '',
            'non_member_copy' => '',
        ],
        'Member Tickets on Sale/Registration Open' => [
            'published' => true,
            'show_affiliate_member' => false,
            'show_member' => true,
            'show_sustaining_fellow' => false,
            'show_non_member' => false,
            'use_short_description' => false,
            'affiliate_member_copy' => '',
            'member_copy' => '<p>Tickets are sure to go quickly for this program—be sure to get yours today.</p>',
            'sustaining_fellow_copy' => '',
            'non_member_copy' => '',
        ],
        'Sustaining Fellow Tickets on Sale/Registration Open/RSVP' => [
            'published' => true,
            'show_affiliate_member' => false,
            'show_member' => false,
            'show_sustaining_fellow' => true,
            'show_non_member' => false,
            'use_short_description' => false,
            'affiliate_member_copy' => '',
            'member_copy' => '',
            'sustaining_fellow_copy' => '<p>Tickets are sure to go quickly for this program—be sure to get yours today.</p>',
            'non_member_copy' => '',
        ],
        'Nonmember Tickets on Sale/ Registration Open' => [
            'published' => true,
            'show_affiliate_member' => false,
            'show_member' => false,
            'show_sustaining_fellow' => false,
            'show_non_member' => true,
            'use_short_description' => false,
            'affiliate_member_copy' => '',
            'member_copy' => '',
            'sustaining_fellow_copy' => '',
            'non_member_copy' => '<p>Tickets will go fast—so grab yours today!</p>',
        ],
        'Tickets on Sale/Registration Open Reminder' => [
            'published' => true,
            'show_affiliate_member' => true,
            'show_member' => true,
            'show_sustaining_fellow' => true,
            'show_non_member' => true,
            'use_short_description' => false,
            'affiliate_member_copy' => '<p>We’d love to have you join us for this very special event—secure your tickets today.</p>',
            'member_copy' => '<p>We’d love to have you join us for this very special event—secure your tickets today.</p>',
            'sustaining_fellow_copy' => '<p>We’d love to have you join us for this very special event—secure your tickets today.</p>',
            'non_member_copy' => '<p>There are only a few tickets left—don’t miss out!</p>',
        ],
        'Event Reminder' => [
            'published' => true,
            'show_affiliate_member' => true,
            'show_member' => true,
            'show_sustaining_fellow' => true,
            'show_non_member' => true,
            'use_short_description' => false,
            'affiliate_member_copy' => '<p>%FirstName%%, your event, %%EventName%%, is coming up—we look forward to seeing you there.</p>',
            'member_copy' => '<p>%FirstName%%, your event, %%EventName%%, is coming up—we look forward to seeing you there.</p>',
            'sustaining_fellow_copy' => '<p>%FirstName%%, your event, %%EventName%%, is coming up—we look forward to seeing you there.</p>',
            'non_member_copy' => '<p>%FirstName%%, your event, %%EventName%%, is coming up—we look forward to seeing you there.</p>',
        ],
        'Event Thank You' => [
            'published' => true,
            'show_affiliate_member' => true,
            'show_member' => true,
            'show_sustaining_fellow' => true,
            'show_non_member' => true,
            'use_short_description' => false,
            'affiliate_member_copy' => '<p>We’re so happy you were able to join us for %%EventName%% and hope you enjoyed this special program.</p><p>We are so grateful for your support as a %%AffiliateGroup%% member and would love to have you join us for %%EventName%% on %%DisplayStartDate%%.</p>',
            'member_copy' => '<p>We’re so happy you were able to join us for %%EventName%% and hope you enjoyed the event.</p><p>We have a bunch of great member-exclusive programs coming up in the next couple months. Check out <a href="https://www.artic.edu/events?audience=2">our member event calendar</a> to see the full lineup.</p>',
            'sustaining_fellow_copy' => '<p>We’re so happy you were able to join us for %%EventName%% and hope you enjoyed this special program.</p><p>We are so grateful for your support as a Sustaining Fellow and would love to have you join us for more events in the months to come. Check out <a href="https://www.artic.edu/events?audience=8">our calendar</a> to see what’s in store.</p>',
            'non_member_copy' => '<p>We’re so happy you were able to join us for %%EventName%% and hope you enjoyed the event.</p><p>We have a wide range of great programs coming up in the next couple months. Check out <a href="https://www.artic.edu/events">our calendar</a> to see the full lineup.</p>',
        ],
        'Event Please Join Us for a Future Event' => [
            'published' => true,
            'show_affiliate_member' => true,
            'show_member' => true,
            'show_sustaining_fellow' => true,
            'show_non_member' => true,
            'use_short_description' => false,
            'affiliate_member_copy' => '<p>We’re sorry we missed you at %%EventName%%. We hope to see you for another event or simply enjoying the galleries soon.</p>',
            'member_copy' => '<p>We’re sorry we missed you at %%EventName%%. We hope to see you for another event or simply enjoying the galleries soon.</p><p>We have a bunch of great member-exclusive programs coming up in the next couple months. Check out <a href="https://www.artic.edu/events?audience=2">our member event calendar</a> to see what’s in store in the coming months.</p>',
            'sustaining_fellow_copy' => '<p>We’re sorry we missed you at %%EventName%%. We hope to see you for another event or simply enjoying the galleries soon.</p><p>We are so grateful for your support as a Sustaining Fellow and would love to have you join us for more events in the months to come. Check out <a href="https://www.artic.edu/events?audience=8">our calendar</a> to see what’s in store for Sustaining Fellows in the coming months.</p>',
            'non_member_copy' => '<p>We’re sorry we missed you at %%EventName%%. We hope to see you for another event or simply enjoying the galleries soon.</p><p>We have a wide range of great programs coming up in the next couple months. Check out <a href="https://www.artic.edu/events">our calendar</a> to see the full lineup of programs offered in the coming months.</p>',
        ],
    ];

    public function handle()
    {
        if (!$this->confirm('This will delete all email series. Continue?')) {
            exit(1);
        }

        // EmailSeries::withTrashed()->each(function($series) {
        //     $series->forceDelete();
        // });

        Schema::disableForeignKeyConstraints();
        DB::table('event_email_series')->truncate();
        DB::table('email_series')->truncate();
        Schema::enableForeignKeyConstraints();

        foreach ($this->emailSeries as $key => $values)
        {
            $series = EmailSeries::firstOrNew(['title' => $key]);
            $series->fill($values);
            $series->save();
        }
    }

}
