<?php

namespace App\Repositories\Behaviors;

trait HandleRecurrence
{
    public function afterSaveHandleRecurrence($object, $fields)
    {
        $rules = $object->getRules();

        // TODO: Delete all EventMeta elements
        $object->eventMetas()->delete();

        // Create dates in all ocurrences
        foreach($rules as $occurrence) {
            \App\Models\EventMeta::create([
                'date' => $occurrence,
                'event_id' => $object->id]
            );
        }
    }

    public function getByRange($startDate, $endDate)
    {
        $query = $this->model->rightJoin('event_metas', function ($join) {
            $join->on('events.id', '=', 'event_metas.event_id');
        });
        $query->where('event_metas.date', '>', $startDate);
        $query->where('event_metas.date', '<', $endDate);
        $query->orderBy('event_metas.date', 'ASC');

        return $query->get();
    }
}
