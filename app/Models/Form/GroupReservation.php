<?php

namespace App\Models\Form;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class GroupReservation extends Model
{
    protected $table = "form_group_reservations";
    protected $dates = ['visit_date'];
    protected $casts = [
        'needs_foreign_language' => 'boolean',
        'needs_wheelchair_use' => 'boolean',
        'needs_sign_language' => 'boolean',
        'needs_none' => 'boolean',
    ];

    // We don't want to save any data to the database, so we set fillable to empty.
    protected $fillable = [];

    public function toMarkdown()
    {
        $ret = "Field | Value\n";
        $ret .= "--- | ---\n";

        foreach ($this->toArray() as $key => $value)
        {
            switch ($key) {
                case 'visit_date':
                    $ret .= $key ." | " .Carbon::parse($value)->toFormattedDateString() ."\n";
                    break;
                default:
                    $ret .= $key ." | " .$value ."\n";
                    break;
            }
        }

        return $ret;
    }
}
