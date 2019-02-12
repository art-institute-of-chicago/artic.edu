<?php

namespace App\Repositories;

use App\Models\Closure;

class ClosureRepository extends ModuleRepository
{

    public function __construct(Closure $model)
    {
        $this->model = $model;
    }

    // public function getDatesField($fields, $f)
    // {
    //     if (($dateTime = DateTime::createFromFormat("Y-m-d", $fields[$f]))) {
    //         $fields[$f] = $dateTime->format("m/d/Y");
    //     }

    //     return $fields;
    // }

    // public function prepareDatesField($fields, $f)
    // {
    //     dd($fields);
    //     if (($datetime = DateTime::createFromFormat("Y-m-d", $fields[$f]))) {
    //         $fields[$f] = $datetime->format("Y-m-d");
    //     } else {
    //         $fields[$f] = null;
    //     }

    //     return $fields;
    // }
}
