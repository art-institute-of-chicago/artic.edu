<?php

namespace App\Repositories;

use App\Models\DateRule;

class DateRuleRepository extends ModuleRepository
{
    public function __construct(DateRule $model)
    {
        $this->model = $model;
    }

    // public function afterSave($object, $fields)
    // {
    //     // Set days values to individual arrays
    //     if (isset($fields['days'])) {
    //         foreach ($this->model::$days as $index => $value) {
    //             $object->$value = in_array($index, $fields['days']);
    //         }
    //         unset($fields['days']);

    //         $object->save();
    //     }

    //     return parent::afterSave($object, $fields);
    // }
}
