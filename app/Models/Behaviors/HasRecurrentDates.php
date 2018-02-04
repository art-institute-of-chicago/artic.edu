<?php
use Illuminate\Support\Facades\App;

namespace App\Models\Behaviors;

/**
 * Trait used to manage recurrent dates for an event
 *
 */

trait HasRecurrentDates
{
    // TODO: Move this to a polymorphic approach
    public function dateRules()
    {
        return $this->hasMany(\App\Models\DateRule::class);
    }

    public function eventMetas()
    {
        return $this->hasMany(\App\Models\EventMeta::class);
    }

    public function getAllDatesAttribute()
    {
        return $this->eventMetas()->pluck('date')->map(function($element) {
            return $element->format('Y-m-d');
        });
    }

    public function getRules()
    {
        $ruleObjects = $this->dateRules()->whereNull('deleted_at')->get();

        if (!empty($ruleObjects))
            return $this->buildRRules($ruleObjects);
    }

    protected function buildRRules($ruleObjects)
    {
        $rset = new \RRule\RSet();

        foreach($ruleObjects as $rule)
        {
            switch ($rule->getRuleType()) {
                case 'recurrent':
                    $this->buildRecurrentRule($rset, $rule);
                    break;
                case 'include':
                    $this->buildIncludeRule($rset, $rule);
                    break;
                case 'exclude':
                    $this->buildExcludeRule($rset, $rule);
                    break;
            }
        }

        return $rset;
    }

    protected function buildRecurrentRule(&$rset, $ruleObject)
    {
        // Common options
        $options = [
            'FREQ'     => \RRule\RRule::DAILY,
            'INTERVAL' => $ruleObject->every,
            'DTSTART'  => $ruleObject->start_date,
            'UNTIL'    => $ruleObject->end_date
        ];

        // Options for weekly repeated events
        if ($ruleObject->getRecurringType() == 'WEEKLY') {
            $options['FREQ'] = \RRule\RRule::WEEKLY;
            $options['BYDAY'] = $ruleObject->getDays();
        }

        // // Options for Monthly repeated events
        if ($ruleObject->getRecurringType() == 'MONTHLY') {
            $options['FREQ'] = \RRule\RRule::MONTHLY;

            switch($ruleObject->getMonthlyRepeatType()) {
                case 'numeral':
                    $options['BYMONTHDAY'] = $ruleObject->start_date->day;
                    break;
                case 'first_day':
                    $options['BYDAY'] = '1'. strtoupper(substr($ruleObject->start_date->format('D'), 0, 2));
                    break;
            }
        }

        $rset->addRRule($options);
    }

    protected function buildIncludeRule(&$rset, $ruleObject)
    {
        $rset->addDate($ruleObject->start_date);
    }

    protected function buildExcludeRule(&$rset, $ruleObject)
    {
        $rset->addExDate($ruleObject->start_date);
    }
}
