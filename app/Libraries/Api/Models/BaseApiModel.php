<?php

/**
 * Pretty much a port from an Eloquent model to a class without a backend
 * Based/copied from https://github.com/jenssegers/model
 *
 */

namespace App\Libraries\Api\Models;

use A17\Twill\Models\Behaviors\HasPresenter;
use App\Libraries\Api\Models\ApiCollection as BaseCollection;
use App\Libraries\Api\Models\Behaviors\HasApiCalls;
use App\Libraries\Api\Models\Behaviors\HasAugmentedModel;
use App\Libraries\Api\Models\Behaviors\HasRelationships;
use ArrayAccess;
use DateTime;
use Illuminate\Contracts\Routing\UrlRoutable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use JsonSerializable;

abstract class BaseApiModel implements ArrayAccess, Arrayable, Jsonable, JsonSerializable, UrlRoutable
{
    use HasApiCalls;
    use HasAugmentedModel;
    use HasRelationships;
    use HasPresenter;

    protected $attributes = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Used to create URL's
     *
     * @var array
     */
    protected $primaryKey = 'id';

    /**
     * Indicates whether attributes are snake cased on arrays.
     *
     * @var bool
     */
    public static $snakeAttributes = true;

    /**
     * Indicates if all mass assignment is enabled.
     *
     * @var bool
     */
    protected static $unguarded = false;

    /**
     * The cache of the mutated attributes for each class.
     *
     * @var array
     */
    protected static $mutatorCache = [];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [];

    /**
     * Endpoints for this entity
     *
     * @var array
     */
    protected $endpoints = [
        'collection' => '',
        'resource' => '',
        'search' => '',
    ];

    /**
     * The number of entities to return for pagination.
     *
     * @var int
     */
    protected $perPage = 15;

    /**
     * Create a new Eloquent model instance.
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
    }

    /**
     * Fill the model with an array of attributes.
     *
     * @return $this
     *
     * @throws MassAssignmentException
     */
    public function fill(array $attributes)
    {
        $totallyGuarded = $this->totallyGuarded();

        foreach ($this->fillableFromArray($attributes) as $key => $value) {
            // The developers may choose to place some attributes in the "fillable"
            // array, which means only those attributes may be set through mass
            // assignment to the model, and all others will just be ignored.
            if ($this->isFillable($key)) {
                $this->setAttribute($key, $value);
            } elseif ($totallyGuarded) {
                throw new MassAssignmentException($key);
            }
        }

        return $this;
    }

    /**
     * Fill the model with an array of attributes. Force mass assignment.
     *
     * @return $this
     */
    public function forceFill(array $attributes)
    {
        // Since some versions of PHP have a bug that prevents it from properly
        // binding the late static context in a closure, we will first store
        // the model in a variable, which we will then use in the closure.
        $model = $this;

        return static::unguarded(function () use ($model, $attributes) {
            return $model->fill($attributes);
        });
    }

    /**
     * Get the fillable attributes of a given array.
     *
     * @return array
     */
    protected function fillableFromArray(array $attributes)
    {
        if (count($this->fillable) > 0 && !static::$unguarded) {
            return array_intersect_key($attributes, array_flip($this->fillable));
        }

        return $attributes;
    }

    /**
     * Create a new instance of the given model.
     *
     * @param  array  $attributes
     * @return \Jenssegers\Model\Model
     */
    public function newInstance($attributes = [])
    {
        $model = new static((array) $attributes);

        return $model;
    }

    /**
     * Create a collection of models from plain arrays.
     *
     * @return array
     */
    public static function hydrate(array $items)
    {
        $instance = new static();

        $items = array_map(function ($item) use ($instance) {
            return $instance->newInstance($item);
        }, $items);

        return $items;
    }

    /**
     * Get the hidden attributes for the model.
     *
     * @return array
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Set the hidden attributes for the model.
     *
     * @return $this
     */
    public function setHidden(array $hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Make the given, typically visible, attributes hidden.
     *
     * @param  array|string|null  $attributes
     * @return $this
     */
    public function makeHidden($attributes = null)
    {
        $attributes = is_array($attributes) ? $attributes : func_get_args();

        $this->hidden = array_merge($this->hidden, $attributes);

        return $this;
    }

    /**
     * Make the given, typically hidden, attributes visible.
     *
     * @param  array|string  $attributes
     * @return $this
     */
    public function withHidden($attributes)
    {
        $this->hidden = array_diff($this->hidden, (array) $attributes);

        return $this;
    }

    /**
     * Get the visible attributes for the model.
     *
     * @return array
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * Set the visible attributes for the model.
     *
     * @return $this
     */
    public function setVisible(array $visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Make the given, typically hidden, attributes visible.
     *
     * @param  array|string|null  $attributes
     * @return $this
     */
    public function makeVisible($attributes = null)
    {
        $attributes = is_array($attributes) ? $attributes : func_get_args();

        $this->visible = array_merge($this->visible, $attributes);

        return $this;
    }

    /**
     * Set the accessors to append to model arrays.
     *
     * @return $this
     */
    public function setAppends(array $appends)
    {
        $this->appends = $appends;

        return $this;
    }

    /**
     * Get the fillable attributes for the model.
     *
     * @return array
     */
    public function getFillable()
    {
        return $this->fillable;
    }

    /**
     * Set the fillable attributes for the model.
     *
     * @return $this
     */
    public function fillable(array $fillable)
    {
        $this->fillable = $fillable;

        return $this;
    }

    /**
     * Get the guarded attributes for the model.
     *
     * @return array
     */
    public function getGuarded()
    {
        return $this->guarded;
    }

    /**
     * Set the guarded attributes for the model.
     *
     * @return $this
     */
    public function guard(array $guarded)
    {
        $this->guarded = $guarded;

        return $this;
    }

    /**
     * Disable all mass assignable restrictions.
     *
     * @param  bool  $state
     * @return void
     */
    public static function unguard($state = true)
    {
        static::$unguarded = $state;
    }

    /**
     * Enable the mass assignment restrictions.
     *
     * @return void
     */
    public static function reguard()
    {
        static::$unguarded = false;
    }

    /**
     * Determine if current state is "unguarded".
     *
     * @return bool
     */
    public static function isUnguarded()
    {
        return static::$unguarded;
    }

    /**
     * Run the given callable while being unguarded.
     *
     * @return mixed
     */
    public static function unguarded(callable $callback)
    {
        if (static::$unguarded) {
            return $callback();
        }

        static::unguard();

        $result = $callback();

        static::reguard();

        return $result;
    }

    /**
     * Determine if the given attribute may be mass assigned.
     *
     * @param  string  $key
     * @return bool
     */
    public function isFillable($key)
    {
        if (static::$unguarded) {
            return true;
        }

        // If the key is in the "fillable" array, we can of course assume that it's
        // a fillable attribute. Otherwise, we will check the guarded array when
        // we need to determine if the attribute is black-listed on the model.
        if (in_array($key, $this->fillable)) {
            return true;
        }

        if ($this->isGuarded($key)) {
            return false;
        }

        return empty($this->fillable);
    }

    /**
     * Determine if the given key is guarded.
     *
     * @param  string  $key
     * @return bool
     */
    public function isGuarded($key)
    {
        return in_array($key, $this->guarded) || $this->guarded == ['*'];
    }

    /**
     * Determine if the model is totally guarded.
     *
     * @return bool
     */
    public function totallyGuarded()
    {
        return count($this->fillable) == 0 && $this->guarded == ['*'];
    }

    /**
     * Convert the model instance to JSON.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->attributesToArray();
    }

    /**
     * Convert the model's attributes to an array.
     *
     * @return array
     */
    public function attributesToArray()
    {
        $attributes = $this->getArrayableAttributes();

        $mutatedAttributes = $this->getMutatedAttributes();

        // We want to spin through all the mutated attributes for this model and call
        // the mutator for the attribute. We cache off every mutated attributes so
        // we don't have to constantly check on attributes that actually change.
        foreach ($mutatedAttributes as $key) {
            if (!array_key_exists($key, $attributes)) {
                continue;
            }

            $attributes[$key] = $this->mutateAttributeForArray(
                $key,
                $attributes[$key]
            );
        }

        // Next we will handle any casts that have been setup for this model and cast
        // the values to their appropriate type. If the attribute has a mutator we
        // will not perform the cast on those attributes to avoid any confusion.
        foreach ($this->casts as $key => $value) {
            if (
                !array_key_exists($key, $attributes) ||
                in_array($key, $mutatedAttributes)
            ) {
                continue;
            }

            $attributes[$key] = $this->castAttribute(
                $key,
                $attributes[$key]
            );
        }

        // Here we will grab all of the appended, calculated attributes to this model
        // as these attributes are not really in the attributes array, but are run
        // when we need to array or JSON the model for convenience to the coder.
        foreach ($this->getArrayableAppends() as $key) {
            $attributes[$key] = $this->mutateAttributeForArray($key, null);
        }

        return $attributes;
    }

    /**
     * Get an attribute array of all arrayable attributes.
     *
     * @return array
     */
    protected function getArrayableAttributes()
    {
        return $this->getArrayableItems($this->attributes);
    }

    /**
     * Get all of the appendable values that are arrayable.
     *
     * @return array
     */
    protected function getArrayableAppends()
    {
        if (!count($this->appends)) {
            return [];
        }

        return $this->getArrayableItems(
            array_combine($this->appends, $this->appends)
        );
    }

    /**
     * Get an attribute array of all arrayable values.
     *
     * @return array
     */
    protected function getArrayableItems(array $values)
    {
        if (count($this->getVisible()) > 0) {
            return array_intersect_key($values, array_flip($this->getVisible()));
        }

        return array_diff_key($values, array_flip($this->getHidden()));
    }

    /**
     * Get an attribute from the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (
            array_key_exists($key, $this->attributes) ||
            $this->hasGetMutator($key)
        ) {
            return $this->getAttributeValue($key);
        }

        return $this->getRelationValue($key);
    }

    /**
     * Get a plain attribute (not a relationship).
     *
     * @param  string  $key
     * @return mixed
     */
    protected function getAttributeValue($key)
    {
        $value = $this->getAttributeFromArray($key);

        // If the attribute has a get mutator, we will call that then return what
        // it returns as the value, which is useful for transforming values on
        // retrieval from the model to a form that is more useful for usage.
        if ($this->hasGetMutator($key)) {
            app('debug')->log(class_basename(get_called_class()), $key, true);

            return $this->mutateAttribute($key, $value);
        }

        // If the attribute exists within the cast array, we will convert it to
        // an appropriate native PHP type dependant upon the associated value
        // given with the key in the pair. Dayle made this comment line up.
        if ($this->hasCast($key)) {
            $value = $this->castAttribute($key, $value);
        }

        app('debug')->log(class_basename(get_called_class()), $key);

        return $value;
    }

    /**
     * Get an attribute from the $attributes array.
     *
     * @param  string  $key
     * @return mixed
     */
    protected function getAttributeFromArray($key)
    {
        if (array_key_exists($key, $this->attributes)) {
            return $this->attributes[$key];
        }
    }

    /**
     * Determine if a get mutator exists for an attribute.
     *
     * @param  string  $key
     * @return bool
     */
    public function hasGetMutator($key)
    {
        return method_exists($this, 'get' . Str::studly($key) . 'Attribute');
    }

    /**
     * Get the value of an attribute using its mutator.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return mixed
     */
    protected function mutateAttribute($key, $value)
    {
        return $this->{'get' . Str::studly($key) . 'Attribute'}($value);
    }

    /**
     * Get the value of an attribute using its mutator for array conversion.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return mixed
     */
    protected function mutateAttributeForArray($key, $value)
    {
        $value = $this->mutateAttribute($key, $value);

        return $value instanceof Arrayable ? $value->toArray() : $value;
    }

    /**
     * Determine whether an attribute should be casted to a native type.
     *
     * @param  string  $key
     * @return bool
     */
    protected function hasCast($key)
    {
        return array_key_exists($key, $this->casts);
    }

    /**
     * Determine whether a value is JSON castable for inbound manipulation.
     *
     * @param  string  $key
     * @return bool
     */
    protected function isJsonCastable($key)
    {
        return $this->hasCast($key) &&
        in_array($this->getCastType($key), ['array', 'json', 'object'], true);
    }

    /**
     * Get the type of cast for a model attribute.
     *
     * @param  string  $key
     * @return string
     */
    protected function getCastType($key)
    {
        return trim(strtolower($this->casts[$key]));
    }

    /**
     * Cast an attribute to a native PHP type.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function castAttribute($key, $value)
    {
        if (is_null($value)) {
            return $value;
        }

        switch ($this->getCastType($key)) {
            case 'int':
            case 'integer':
                return (int) $value;
            case 'real':
            case 'float':
            case 'double':
                return (float) $value;
            case 'string':
                return (string) $value;
            case 'bool':
            case 'boolean':
                return (bool) $value;
            case 'object':
                return $this->fromJson($value, true);
            case 'array':
            case 'json':
                return $this->fromJson($value);
            case 'collection':
                return new BaseCollection($this->fromJson($value));
            case 'datetime':
                return $this->asDateTime($value);
            default:
                return $value;
        }
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        // First we will check for the presence of a mutator for the set operation
        // which simply lets the developers tweak the attribute as it is set on
        // the model, such as "json_encoding" an listing of data for storage.
        if ($this->hasSetMutator($key)) {
            $method = 'set' . Str::studly($key) . 'Attribute';

            return $this->{$method}($value);
        }

        if ($this->isJsonCastable($key) && !is_null($value)) {
            $value = $this->asJson($value);
        }

        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * Determine if a set mutator exists for an attribute.
     *
     * @param  string  $key
     * @return bool
     */
    public function hasSetMutator($key)
    {
        return method_exists($this, 'set' . Str::studly($key) . 'Attribute');
    }

    /**
     * Encode the given value as JSON.
     *
     * @param  mixed  $value
     * @return string
     */
    public function asJson($value)
    {
        return json_encode($value);
    }

    /**
     * Return a timestamp as DateTime object.
     *
     * @param  mixed  $value
     * @return \Illuminate\Support\Carbon
     */
    public function asDateTime($value)
    {
        if ($value instanceof Carbon) {
            return $value;
        }

        if ($value instanceof DateTimeInterface) {
            return new Carbon(
                $value->format('Y-m-d H:i:s.u'),
                $value->getTimezone()
            );
        }

        if (is_numeric($value)) {
            return Carbon::createFromTimestamp($value);
        }

        if ($this->isStandardDateFormat($value)) {
            return Carbon::createFromFormat('Y-m-d', $value)->startOfDay();
        }

        return new Carbon($value);
    }

    public function getClassName()
    {
        return (new \ReflectionClass($this))->getShortName();
    }

    /**
     * Determine if the given value is a standard date format.
     *
     * @param  string  $value
     * @return bool
     */
    protected function isStandardDateFormat($value)
    {
        return preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $value);
    }

    /**
     * Decode the given JSON back into an array or object.
     *
     * @param  string  $value
     * @param  bool  $asObject
     * @return mixed
     */
    public function fromJson($value, $asObject = false)
    {
        return json_decode($value, !$asObject);
    }

    /**
     * Clone the model into a new, non-existing instance.
     *
     * @return \Jenssegers\Model\Model
     */
    public function replicate(array $except = null)
    {
        $except = $except ?: [];

        $attributes = Arr::except($this->attributes, $except);

        return with($instance = new static())->fill($attributes);
    }

    /**
     * Get all of the current attributes on the model.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Get the mutated attributes for a given instance.
     *
     * @return array
     */
    public function getMutatedAttributes()
    {
        $class = get_class($this);

        if (!isset(static::$mutatorCache[$class])) {
            static::cacheMutatedAttributes($class);
        }

        return static::$mutatorCache[$class];
    }

    /**
     * Extract and cache all the mutated attributes of a class.
     *
     * @param string $class
     * @return void
     */
    public static function cacheMutatedAttributes($class)
    {
        $mutatedAttributes = [];

        // Here we will extract all of the mutated attributes so that we can quickly
        // spin through them after we export models to their array form, which we
        // need to be fast. This'll let us know the attributes that can mutate.
        if (preg_match_all('/(?<=^|;)get([^;]+?)Attribute(;|$)/', implode(';', get_class_methods($class)), $matches)) {
            foreach ($matches[1] as $match) {
                if (static::$snakeAttributes) {
                    $match = Str::snake($match);
                }

                $mutatedAttributes[] = lcfirst($match);
            }
        }

        static::$mutatorCache[$class] = $mutatedAttributes;
    }

    /**
     * Create a new Eloquent Collection instance.
     *
     * @param  array  $models
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function newCollection($models = [])
    {
        if ($models instanceof BaseCollection) {
            return $models;
        }

        return new BaseCollection($models);
    }

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string  $key
     */
    public function __get($key): mixed
    {
        $value = $this->getAttribute($key);

        if ($value === null && method_exists($this, 'getAugmentedModel') && $this->getAugmentedModel()) {
            return $this->getAugmentedModel()->{$key};
        }

        return $value;
    }

    /**
     * TODO: Consider adding _isset() here? e.g. for WEB-1245
     */

    /**
     * Dynamically set attributes on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     */
    public function __set($key, $value): void
    {
        $this->setAttribute($key, $value);
    }

    /**
     * Determine if the given attribute exists.
     *
     * @param  mixed  $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->{$offset});
    }

    /**
     * Get the value for a given offset.
     *
     * @param  mixed  $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->{$offset};
    }

    /**
     * Set the value for a given offset.
     *
     * @param  mixed  $offset
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->{$offset} = $value;
    }

    /**
     * Unset the value for a given offset.
     *
     * @param  mixed  $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->{$offset});
    }

    /**
     * Get the number of models to return per page.
     *
     * @return int
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * Set the number of models to return per page.
     *
     * @param  int  $perPage
     * @return $this
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;

        return $this;
    }

    /**
     * Get the endpoint
     *
     * @return string endpoint
     */
    public function getEndpoint($type)
    {
        return $this->endpoints[$type];
    }

    public function getTable()
    {
    }

    /**
     * Implement Basic URLRoutable functions
     *
     */

    public function getRouteKey()
    {
        return $this->getAttribute($this->getRouteKeyName());
    }

    public function getRouteKeyName()
    {
        return $this->getKeyName();
    }

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->entity;
    }

    public function resolveChildRouteBinding($childType, $value, $field)
    {
    }

    public function getKeyName()
    {
        return $this->primaryKey;
    }

    /**
     * Determine if an attribute exists on the model.
     *
     * @param  string  $key
     */
    public function __isset($key): bool
    {
        return (isset($this->attributes[$key]) || isset($this->relations[$key])) ||
            ($this->hasGetMutator($key) && !is_null($this->getAttributeValue($key)));
    }

    /**
     * Unset an attribute on the model.
     *
     * @param  string  $key
     */
    public function __unset($key): void
    {
        unset($this->attributes[$key]);
    }

    /**
     * Handle dynamic static method calls into the method.
     *
     * @param  string  $method
     * @param  array   $parameters
     */
    public static function __callStatic($method, $parameters): mixed
    {
        $instance = new static();

        return call_user_func_array([$instance, $method], $parameters);
    }

    /**
     * Convert the model to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }
}
