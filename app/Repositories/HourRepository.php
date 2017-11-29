<?php

namespace App\Repositories;


use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\Hour;

class HourRepository extends ModuleRepository
{
    

    public function __construct(Hour $model)
    {
        $this->model = $model;
    }

    /**
     *
     * Custom filtering with helpers
     *
     * public function filter($query, array $scopes = [])
     * {
     *     return parent::filter($query, $scopes);
     * }
     *
     */

    /**
     *
     * Custom ordering
     *
     * public function order($query, array $orders = [])
     * {
     *     return parent::order($query, $orders);
     * }
     *
     */

    /**
     *
     * Custom form fields
     *
     * public function getFormFields($object)
     * {
     *     $fields = parent::getFormFields($object);
     *
     *     return $fields;
     * }
     *
     */

    /**
     *
     * Before create hook
     *
     * public function prepareFieldsBeforeCreate($fields)
     * {
     *     return parent::prepareFieldsBeforeCreate($fields);
     * }
     *
     */

    /**
     *
     * Before save hook
     *
     * public function prepareFieldsBeforeSave($object, $fields)
     * {
     *     return parent::prepareFieldsBeforeSave($object, $fields);
     * }
     *
     */

    /**
     *
     * After save hook
     *
     * public function afterSave($object, $fields)
     * {
     *     parent::afterSave($object, $fields);
     * }
     *
     */
}
