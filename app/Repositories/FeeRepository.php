<?php

namespace App\Repositories;

use App\Models\Fee;

class FeeRepository
{
    public function __construct(Fee $model)
    {
        $this->model = $model;
    }

    public function getFormFields()
    {
        $fields = ['price' => []];

        foreach ($this->model->get() as $fee) {
            $fields['price'][$fee->fee_age_id][$fee->fee_category_id] = $fee->price;
        }

        return $fields;
    }

    public function update($feeFields)
    {
        foreach ($feeFields['price'] as $feeAgeId => $feeCategories) {
            foreach ($feeCategories as $feeCategoryId => $price) {
                $fee = $this->model->firstOrNew(['fee_age_id' => $feeAgeId, 'fee_category_id' => $feeCategoryId]);
                $fee->price = $price;
                $fee->save();
            }
        }
    }
}
