<?php

namespace App\Models\Form;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FormModel extends Model
{
    public function toMarkdown()
    {
        $dates = collect($this->casts)
            ->filter(function ($castType) {
                return in_array($castType, ['date', 'datetime']);
            })
            ->keys()
            ->all();

        $ret = "Field | Value\n";
        $ret .= "--- | ---\n";

        foreach ($this->getAttributes() as $key => $value) {
            if (in_array($key, $dates)) {
                $ret .= $key . ' | ' . ($value ? Carbon::parse($value)->toFormattedDateString() : '') . "\n";
            } else {
                if (is_array($value)) {
                    $ret .= $key . ' | ' . implode(',', $value) . "\n";
                } else {
                    $ret .= $key . ' | ' . $value . "\n";
                }
            }
        }

        return $ret;
    }
}
