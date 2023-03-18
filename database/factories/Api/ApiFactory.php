<?php

namespace Database\Factories\Api;

use App\Libraries\Api\Models\BaseApiModel as ApiModel;
use Closure;
use Faker\Generator as FakerGenerator;
use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Factories\{
    BelongsToManyRelationship, BelongsToRelationship, CrossJoinSequence, Relationship, Sequence,
};
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Support\Traits\Macroable;
use Throwable;

/**
 * Based largly on `Illuminate\Database\Eloquent\Factories\Factory`, so that
 * ApiFactories would behave as similarly as possible.
 *
 * TODO: I have not tried out or tested the relationships or sequences
 * functionality. Caveat emptor!
 */
abstract class ApiFactory
{
    use Conditionable, ForwardsCalls, Macroable {
        __call as macroCall;
    }

    /**
     * The name of the factory's corresponding model.
     */
    protected $model;

    /**
     * The number of models that should be generated.
     */
    protected int|null $count;

    /**
     * The state transformations that will be applied to the model.
     */
    protected Collection $states;

    /**
     * The parent relationships that will be applied to the model.
     */
    protected Collection $has;

    /**
     * The child relationships that will be applied to the model.
     */
    protected Collection $for;

    /**
     * The "after making" callbacks that will be applied to the model.
     */
    protected Collection $afterMaking;

    /**
     * The "after creating" callbacks that will be applied to the model.
     */
    protected Collection $afterCreating;

    /**
     * The name of the database connection that will be used to create the models.
     */
    protected string|null $connection;

    /**
     * The current Faker instance.
     */
    protected FakerGenerator $faker;

    /**
     * The default namespace where factories reside.
     */
    protected static string $namespace = 'Database\\Factories\\Api\\';

    /**
     * The default model name resolver.
     */
    protected static $modelNameResolver;

    /**
     * The factory name resolver.
     */
    protected static $factoryNameResolver;

    /**
     * Create a new factory instance.
     */
    public function __construct(?int $count = null,
                                ?Collection $states = null,
                                ?Collection $has = null,
                                ?Collection $for = null,
                                ?Collection $afterMaking = null,
                                ?Collection $afterCreating = null,
                                ?string $connection = null)
    {
        $this->count = $count;
        $this->states = $states ?: new Collection;
        $this->has = $has ?: new Collection;
        $this->for = $for ?: new Collection;
        $this->afterMaking = $afterMaking ?: new Collection;
        $this->afterCreating = $afterCreating ?: new Collection;
        $this->connection = $connection;
        $this->faker = $this->withFaker();
    }

    /**
     * Define the model's default state.
     */
    abstract public function definition(): array;

    /**
     * Get a new factory instance for the given attributes.
     */
    public static function new(callable|array $attributes = []): static
    {
        return (new static)->state($attributes)->configure();
    }

    /**
     * Get a new factory instance for the given number of models.
     */
    public static function times(int $count): static
    {
        return static::new()->count($count);
    }

    /**
     * Configure the factory.
     */
    public function configure()
    {
        return $this;
    }

    /**
     * Get the raw attributes generated by the factory.
     */
    public function raw(array $attributes = [], ?ApiModel $parent = null): array
    {
        if ($this->count === null) {
            return $this->state($attributes)->getExpandedAttributes($parent);
        }

        return array_map(function () use ($attributes, $parent) {
            return $this->state($attributes)->getExpandedAttributes($parent);
        }, range(1, $this->count));
    }

    /**
     * Create a single model and persist it to the database.
     */
    public function createOne(array $attributes = []): ApiModel
    {
        return $this->count(null)->create($attributes);
    }

    /**
     * Create a single model and persist it to the database.
     */
    public function createOneQuietly(array $attributes = []): ApiModel
    {
        return $this->count(null)->createQuietly($attributes);
    }

    /**
     * Create a collection of models and persist them to the database.
     */
    public function createMany(iterable $records): EloquentCollection
    {
        return new EloquentCollection(
            collect($records)->map(function ($record) {
                return $this->state($record)->create();
            })
        );
    }

    /**
     * Create a collection of models and persist them to the database.
     */
    public function createManyQuietly(iterable $records): EloquentCollection
    {
        return ApiModel::withoutEvents(function () use ($records) {
            return $this->createMany($records);
        });
    }

    /**
     * Create a collection of models and persist them to the database.
     */
    public function create(array $attributes = [], ?ApiModel $parent = null): EloquentCollection|ApiModel
    {
        if (! empty($attributes)) {
            return $this->state($attributes)->create([], $parent);
        }

        $results = $this->make($attributes, $parent);

        if ($results instanceof ApiModel) {
            $this->store(collect([$results]));

            $this->callAfterCreating(collect([$results]), $parent);
        } else {
            $this->store($results);

            $this->callAfterCreating($results, $parent);
        }

        return $results;
    }

    /**
     * Create a collection of models and persist them to the database.
     */
    public function createQuietly(array $attributes = [], ?ApiModel $parent = null): EloquentCollection|ApiModel
    {
        return ApiModel::withoutEvents(function () use ($attributes, $parent) {
            return $this->create($attributes, $parent);
        });
    }

    /**
     * Create a callback that persists a model in the database when invoked.
     */
    public function lazy(array $attributes = [], ?ApiModel $parent = null): Closure
    {
        return function () use ($attributes, $parent) {
            return $this->create($attributes, $parent);
        };
    }

    /**
     * Do NOT store result models.
     */
    protected function store($results)
    {
        // no-op
    }

    /**
     * Create the children for the given model.
     */
    protected function createChildren(ApiModel $model): void
    {
        ApiModel::unguarded(function () use ($model) {
            $this->has->each(function ($has) use ($model) {
                $has->createFor($model);
            });
        });
    }

    /**
     * Make a single instance of the model.
     */
    public function makeOne(callable|array $attributes = []): ApiModel
    {
        return $this->count(null)->make($attributes);
    }

    /**
     * Create a collection of models.
     */
    public function make(array $attributes = [], ?ApiModel $parent = null): EloquentCollection|ApiModel
    {
        if (! empty($attributes)) {
            return $this->state($attributes)->make([], $parent);
        }

        if ($this->count === null) {
            return tap($this->makeInstance($parent), function ($instance) {
                $this->callAfterMaking(collect([$instance]));
            });
        }

        if ($this->count < 1) {
            return $this->newModel()->newCollection();
        }

        $instances = $this->newModel()->newCollection(array_map(function () use ($parent) {
            return $this->makeInstance($parent);
        }, range(1, $this->count)));

        $this->callAfterMaking($instances);

        return $instances;
    }

    /**
     * Make an instance of the model with the given attributes.
     */
    protected function makeInstance(?ApiModel $parent): ApiModel
    {
        return ApiModel::unguarded(function () use ($parent) {
            return tap($this->newModel($this->getExpandedAttributes($parent)), function ($instance) {
                if (isset($this->connection)) {
                    $instance->setConnection($this->connection);
                }
            });
        });
    }

    /**
     * Get a raw attributes array for the model.
     */
    protected function getExpandedAttributes(?ApiModel $parent): mixed
    {
        return $this->expandAttributes($this->getRawAttributes($parent));
    }

    /**
     * Get the raw attributes for the model as an array.
     */
    protected function getRawAttributes(?ApiModel $parent): array
    {
        return $this->states->pipe(function ($states) {
            return $this->for->isEmpty() ? $states : new Collection(array_merge([function () {
                return $this->parentResolvers();
            }], $states->all()));
        })->reduce(function ($carry, $state) use ($parent) {
            if ($state instanceof Closure) {
                $state = $state->bindTo($this);
            }

            return array_merge($carry, $state($carry, $parent));
        }, $this->definition());
    }

    /**
     * Create the parent relationship resolvers (as deferred Closures).
     */
    protected function parentResolvers(): array
    {
        $model = $this->newModel();

        return $this->for->map(function (BelongsToRelationship $for) use ($model) {
            return $for->attributesFor($model);
        })->collapse()->all();
    }

    /**
     * Expand all attributes to their underlying values.
     */
    protected function expandAttributes(array $definition): array
    {
        return collect($definition)->map(function ($attribute, $key) use (&$definition) {
            if (is_callable($attribute) && ! is_string($attribute) && ! is_array($attribute)) {
                $attribute = $attribute($definition);
            }

            if ($attribute instanceof self) {
                $attribute = $attribute->create()->getKey();
            } elseif ($attribute instanceof ApiModel) {
                $attribute = $attribute->getKey();
            }

            $definition[$key] = $attribute;

            return $attribute;
        })->all();
    }

    /**
     * Add a new state transformation to the model definition.
     */
    public function state(callable|array $state): static
    {
        return $this->newInstance([
            'states' => $this->states->concat([
                is_callable($state) ? $state : function () use ($state) {
                    return $state;
                },
            ]),
        ]);
    }

    /**
     * Add a new sequenced state transformation to the model definition.
     */
    public function sequence(...$sequence): static
    {
        return $this->state(new Sequence(...$sequence));
    }

    /**
     * Add a new cross joined sequenced state transformation to the model definition.
     */
    public function crossJoinSequence(...$sequence): static
    {
        return $this->state(new CrossJoinSequence(...$sequence));
    }

    /**
     * Define a child relationship for the model.
     */
    public function has(self $factory, ?string $relationship = null): static
    {
        return $this->newInstance([
            'has' => $this->has->concat([new Relationship(
                $factory, $relationship ?: $this->guessRelationship($factory->modelName())
            )]),
        ]);
    }

    /**
     * Attempt to guess the relationship name for a "has" relationship.
     */
    protected function guessRelationship(string $related): string
    {
        $guess = Str::camel(Str::plural(class_basename($related)));

        return method_exists($this->modelName(), $guess) ? $guess : Str::singular($guess);
    }

    /**
     * Define an attached relationship for the model.
     */
    public function hasAttached(
        ApiFactory|Collection|ApiModel $factory,
        callable|array $pivot = [],
        ?string $relationship = null,
    ): static
    {
        return $this->newInstance([
            'has' => $this->has->concat([new BelongsToManyRelationship(
                $factory,
                $pivot,
                $relationship ?: Str::camel(Str::plural(class_basename(
                    $factory instanceof ApiFactory
                        ? $factory->modelName()
                        : Collection::wrap($factory)->first()
                )))
            )]),
        ]);
    }

    /**
     * Define a parent relationship for the model.
     */
    public function for(ApiFactory|ApiModel $factory, ?string $relationship = null): static
    {
        return $this->newInstance(['for' => $this->for->concat([new BelongsToRelationship(
            $factory,
            $relationship ?: Str::camel(class_basename(
                $factory instanceof ApiFactory ? $factory->modelName() : $factory
            ))
        )])]);
    }

    /**
     * Add a new "after making" callback to the model definition.
     */
    public function afterMaking(Closure $callback): static
    {
        return $this->newInstance(['afterMaking' => $this->afterMaking->concat([$callback])]);
    }

    /**
     * Add a new "after creating" callback to the model definition.
     */
    public function afterCreating(Closure $callback): static
    {
        return $this->newInstance(['afterCreating' => $this->afterCreating->concat([$callback])]);
    }

    /**
     * Call the "after making" callbacks for the given model instances.
     */
    protected function callAfterMaking(Collection $instances): void
    {
        $instances->each(function ($model) {
            $this->afterMaking->each(function ($callback) use ($model) {
                $callback($model);
            });
        });
    }

    /**
     * Call the "after creating" callbacks for the given model instances.
     */
    protected function callAfterCreating(Collection $instances, ?ApiModel $parent = null): void
    {
        $instances->each(function ($model) use ($parent) {
            $this->afterCreating->each(function ($callback) use ($model, $parent) {
                $callback($model, $parent);
            });
        });
    }

    /**
     * Specify how many models should be generated.
     */
    public function count(?int $count): static
    {
        return $this->newInstance(['count' => $count]);
    }

    /**
     * Specify the database connection that should be used to generate models.
     */
    public function connection(string $connection): static
    {
        return $this->newInstance(['connection' => $connection]);
    }

    /**
     * Create a new instance of the factory builder with the given mutated properties.
     */
    protected function newInstance(array $arguments = []): static
    {
        return new static(...array_values(array_merge([
            'count' => $this->count,
            'states' => $this->states,
            'has' => $this->has,
            'for' => $this->for,
            'afterMaking' => $this->afterMaking,
            'afterCreating' => $this->afterCreating,
            'connection' => $this->connection,
        ], $arguments)));
    }

    /**
     * Get a new model instance.
     */
    public function newModel(array $attributes = []): ApiModel
    {
        $model = $this->modelName();

        return new $model($attributes);
    }

    /**
     * Get the name of the model that is generated by the factory.
     */
    public function modelName(): string
    {
        $resolver = static::$modelNameResolver ?: function (self $factory) {
            $namespacedFactoryBasename = Str::replaceLast(
                'Factory', '', Str::replaceFirst(static::$namespace, '', get_class($factory))
            );

            $factoryBasename = Str::replaceLast('Factory', '', class_basename($factory));

            $appNamespace = static::appNamespace();

            return class_exists($appNamespace.'Models\\Api\\'.$namespacedFactoryBasename)
                        ? $appNamespace.'Models\\Api\\'.$namespacedFactoryBasename
                        : $appNamespace.$factoryBasename;
        };

        return $this->model ?: $resolver($this);
    }

    /**
     * Specify the callback that should be invoked to guess model names based on factory names.
     */
    public static function guessModelNamesUsing(callable $callback): void
    {
        static::$modelNameResolver = $callback;
    }

    /**
     * Specify the default namespace that contains the application's model factories.
     */
    public static function useNamespace(string $namespace): void
    {
        static::$namespace = $namespace;
    }

    /**
     * Get a new factory instance for the given model name.
     */
    public static function factoryForModel(string $modelName): static
    {
        $factory = static::resolveFactoryName($modelName);

        return $factory::new();
    }

    /**
     * Specify the callback that should be invoked to guess factory names based on dynamic relationship names.
     */
    public static function guessFactoryNamesUsing(callable $callback): void
    {
        static::$factoryNameResolver = $callback;
    }

    /**
     * Get a new Faker instance.
     */
    protected function withFaker(): FakerGenerator
    {
        return Container::getInstance()->make(FakerGenerator::class);
    }

    /**
     * Get the factory name for the given model name.
     */
    public static function resolveFactoryName(string $modelName): string
    {
        $resolver = static::$factoryNameResolver ?: function (string $modelName) {
            $appNamespace = static::appNamespace();

            $modelName = Str::startsWith($modelName, $appNamespace.'Models\\Api\\')
                ? Str::after($modelName, $appNamespace.'Models\\Api\\')
                : Str::after($modelName, $appNamespace);

            return static::$namespace.$modelName.'Factory';
        };

        return $resolver($modelName);
    }

    /**
     * Get the application namespace for the application.
     */
    protected static function appNamespace(): string
    {
        try {
            return Container::getInstance()
                            ->make(Application::class)
                            ->getNamespace();
        } catch (Throwable $e) {
            return 'App\\';
        }
    }

    /**
     * Proxy dynamic factory methods onto their proper methods.
     */
    public function __call(string $method, array $parameters): mixed
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        if (! Str::startsWith($method, ['for', 'has'])) {
            static::throwBadMethodCallException($method);
        }

        $relationship = Str::camel(Str::substr($method, 3));

        $relatedModel = get_class($this->newModel()->{$relationship}()->getRelated());

        if (method_exists($relatedModel, 'newFactory')) {
            $factory = $relatedModel::newFactory() ?: static::factoryForModel($relatedModel);
        } else {
            $factory = static::factoryForModel($relatedModel);
        }

        if (Str::startsWith($method, 'for')) {
            return $this->for($factory->state($parameters[0] ?? []), $relationship);
        } elseif (Str::startsWith($method, 'has')) {
            return $this->has(
                $factory
                    ->count(is_numeric($parameters[0] ?? null) ? $parameters[0] : 1)
                    ->state((is_callable($parameters[0] ?? null) || is_array($parameters[0] ?? null)) ? $parameters[0] : ($parameters[1] ?? [])),
                $relationship
            );
        }
    }
}
