<?php

namespace App\Repositories\Behaviors;

trait HandleRecurrence
{
    public function afterSaveHandleRecurrence($object, $fields)
    {
        $rules = $object->getRules();

        // Delete all EventMeta elements
        $object->eventMetas()->delete();

        // Create dates in all ocurrences
        foreach($rules as $occurrence) {
            $date = clone ($occurrence);

            // Force rewind the date to the beginning of the day
            $begginingOfDay = \Carbon\Carbon::instance($date)->startOfDay();

            // Generate an Event Meta, add hours to the start and end dates
            \App\Models\EventMeta::create(
                [
                    'date'     => (clone $begginingOfDay)->add(new \DateInterval($object->start_time)),
                    'date_end' => (clone $begginingOfDay)->add(new \DateInterval($object->end_time)),
                    'event_id' => $object->id
                ]
            );
        }
    }

    public function getByRange($startDate, $endDate)
    {
        $query = $this->model->rightJoin('event_metas', function ($join) {
            $join->on('events.id', '=', 'event_metas.event_id');
        });
        $query->where('event_metas.date', '>=', $startDate);
        $query->where('event_metas.date', '<=', $endDate);
        $query->orderBy('event_metas.date', 'ASC');

        return $query->get();
    }
}
