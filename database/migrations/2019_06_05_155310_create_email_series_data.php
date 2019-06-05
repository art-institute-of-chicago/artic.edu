<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\EmailSeries;

class CreateEmailSeriesData extends Migration
{

    private $emailSeries = [
        'Save the Date 90' => [
            'show_affiliate_member' => true,
            'show_member' => true,
            'show_sustaining_fellow' => true,
            'show_non_member' => true,
        ],
        'Save the Date 60' => [
            'show_affiliate_member' => true,
            'show_member' => true,
            'show_sustaining_fellow' => true,
            'show_non_member' => true,
        ],
        'Save the Date 30' => [
            'show_affiliate_member' => true,
            'show_member' => true,
            'show_sustaining_fellow' => true,
            'show_non_member' => true,
        ],
        'Affiliate Member - Tickets on Sale' => [
            'show_affiliate_member' => true,
            'show_member' => false,
            'show_sustaining_fellow' => false,
            'show_non_member' => false,
        ],
        'Member - Tickets on Sale' => [
            'show_affiliate_member' => false,
            'show_member' => true,
            'show_sustaining_fellow' => true,
            'show_non_member' => false,
        ],
        'Non-member - Tickets on Sale' => [
            'show_affiliate_member' => false,
            'show_member' => false,
            'show_sustaining_fellow' => false,
            'show_non_member' => true,
        ],
        'Tickets on Sale Reminder' => [
            'show_affiliate_member' => true,
            'show_member' => true,
            'show_sustaining_fellow' => true,
            'show_non_member' => true,
        ],
        'Event Reminder' => [
            'show_affiliate_member' => true,
            'show_member' => true,
            'show_sustaining_fellow' => true,
            'show_non_member' => true,
        ],
        'Event Thank You' => [
            'show_affiliate_member' => true,
            'show_member' => true,
            'show_sustaining_fellow' => true,
            'show_non_member' => true,
        ],
        'Event Please Join Us for a Future Event' => [
            'show_affiliate_member' => true,
            'show_member' => true,
            'show_sustaining_fellow' => true,
            'show_non_member' => true,
        ],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        foreach ($this->emailSeries as $key => $values)
        {
            $series = EmailSeries::firstOrNew(['title' => $key]);
            $series->fill($values);
            $series->save();
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        foreach ($this->emailSeries as $key => $values)
        {
            $series = EmailSeries::where('title', $key)->first();

            if ($series)
            {
                $series->delete();
            }
        }

    }
}
