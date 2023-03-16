<?php

namespace Database\Factories\Api;

/**
 * Ripped nearly wholesale from `Illuminate\Database\Eloquent\Factories\HasFactory`.
 */
trait HasApiFactory
{
    /**
     * Get a new factory instance for the model.
     */
    public static function factory(...$parameters): ApiFactory
    {
        $factory = static::newFactory() ?: ApiFactory::factoryForModel(get_called_class());

        return $factory
                    ->count(is_numeric($parameters[0] ?? null) ? $parameters[0] : null)
                    ->state(is_array($parameters[0] ?? null) ? $parameters[0] : ($parameters[1] ?? []));
    }

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory()
    {
        //
    }
}
