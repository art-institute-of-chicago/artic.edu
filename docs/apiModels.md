# API models

To help our website interface with our public API, we've created API pseudo-models to consume data from the API. Here you'll find the details as well as a guide to integrating them with Twill.



## Overview

We've created API models as fake Eloquent models that implement much of their functionality:

* Generate an array
* Use mutators for fields
* Paginate results
* Create entities from an array (hydrate)
* JSON serialize

This allows us to use our API to work with Twill emulating Eloquent as far as we can. Since the API is read-only, we haven't implemented functionality to update/create data.



## Where to find the code

[`BaseApiModel.php`](../app/Libraries/Api/Models/BaseApiModel.php) is a fake Eloquent model that implements much of its functionality, including mutators, scopes, relationships, JSON and array exporters, dateTime parsers, and much more.

Under [`app/Libraries/Api`](../app/Libraries/Api) you will find other code related to how we process API data:

* [`app/Libraries/Api/Models/Behaviors/HasApiCalls.php`](../app/Libraries/Api/Models/Behaviors/HasApiCalls.php)
* [`app/Libraries/Api/Models/Behaviors/HasAugmentedModel.php`](../app/Libraries/Api/Models/Behaviors/HasAugmentedModel.php)

Following are behaviors that describe the relationship between Eloquent and API models:

* [`app/Models/Behaviors/HasApiRelations.php`](../app/Models/Behaviors/HasApiRelations.php)
* [`app/Models/Behaviors/HasApiModel.php`](../app/Models/Behaviors/HasApiModel.php)



## Grammar

If for any reason the API changes and the names of the parameters are different, you can easily change the grammar class used to transform a query into a set of parameters. In [`app/Libraries/Api/Builders/Grammar/AicGrammar.php`](../app/Libraries/Api/Builders/Grammar/AicGrammar.php), you will find a very simple set of functions that transform the API Query Browser class into an array of options. If you need to use a different one for a specific model, you can define that when creating the connection. You could redefine `getConnection`:

```php
public function getConnection() {
    $grammar    = new FooBarGrammar();
    $connection = new AicConnection();
    $connection->setQueryGrammar($grammar);

    return $connection;
}
```

Be sure that FooBarGrammar inherits from `AicGrammar`.



## API basic usage

Here are some basics to interact with the API through these models using artworks as an example.

Load a single element:

```php
\App\Models\Api\Artwork::query()->find($id);
```

Load a collection by IDs:

```php
\App\Models\Api\Artwork::query()->find([$id1,$id2]);
```

or

```php
\App\Models\Api\Artwork::query()->ids([$id1,$id2])->get();
```

Load a collection and paginate (paginate function is the same as a regular model):

```php
\App\Models\Api\Artwork::query()->paginate($perPage, $columns, etc...);
```

Search which returns minimal data, not all fields:

```php
\App\Models\Api\Artwork::query()->search('SEARCH_STRING')->get();
```

To get all fields, this function loads the actual models with complete data:

```php
\App\Models\Api\Artwork::query()->search('SEARCH_STRING')->getSearch();
```

This generates two API calls: one for search, and one to grab the data. So consider performance when using this function.



## Repository usage

Search:

```php
public function index(ArtworkRepository $artworks) {
    $artworksResults = $artworks->forSearchQuery(request('query'));
}
```

Remember that any API repository has to inherit from `BaseApiRepository`, and the model has to be an API model.

This function will:

* Search for the 'query' term
* Load all stats (aggregations, suggestions, pagination)
* Load real models and return a collection of API pseudo models.

## HasMany relationship

We implemented a basic `HasMany` relationship that works like our Eloquent counterpart. The difference is that this one uses an array of IDs (returned by the API) to load the correct elements.

See [`App\Models\Api\Exhibition`](../app/Models/Api/Exhibition.php). It contains several hasMany relations. These will take those IDs returned by the API and load a collection with the corresponding API model objects.

```php
public function artworks() {
    return $this->hasMany(\App\Models\Api\Artwork::class, 'artwork_ids');
}
```

Here the parameter is `artwork_ids` (array). From the parent element you can simply call:

```php
$exhibition->artworks;
```

And that will load a collection of related artworks.



## Eager load

You could eager load artworks with one call in a collection doing the following:

```php
\App\Models\Api\Artwork::query()->with(['artworks', 'any_other_has_many'])->get();
```



## Augmented models

An augmented model is a record represented in our API that the CMS adds content to. In [`HasAugmentedModel`](../app/Libraries/Api/Models/Behaviors/HasAugmentedModel.php) you can see the functions to load augmented models from our CMS using the `datahub_id` field.

For example on exhibitions, in the [`Exhibition`](../app/Models/Api/Exhibition.php) API model you'll see:

```php
protected $augmented = true;
protected $augmentedModelClass = 'App\Models\Exhibition';
```

This specifies that this API model is an augmented model, and which Eloquent model is responsible for extra content. To load an augmented model's data, use the API exhibition object and call the method or attribute as you would normally do. If the API model doesn't have that method or attribute, it will pass the call to the augmented model and retrieve those automatically.



## How to create an augmented model on Twill CMS.

First, [create the Eloquent model](https://twill.io/docs/#crud-modules-3), controller, requests, etc. as you would normally do for a regular Twill entity. Ensure it contains the `datahub_id` field.

Then make some changes to the controller:

* Set it to inherit from `BaseApiController` instead of `ModuleController`
* Add `$hasAugmentedModel = true;`

Create two repositories, one for API requests and another for Twill. Both repositories should inherit from `App\Repositories\Api\BaseApiRepository`. Artists, for example, has two repositories:

* [`app/Repositories/Api/ArtistRepository.php`](../app/Repositories/Api/ArtistRepository.php): Will use the API model as the base, and will be the one used to generate listings, filtering, etc, given that we load everything from the API and we just augment using our CMS.
* [`app/Repositories/ArtistRepository.php`](../app/Repositories/ArtistRepository.php): Will contain Twill functionality to create/update augmented data as usual.

Here you can see some Twill overloaded functions like `search()`, or `getById()`. These were modified to work with Twill seamlessly.

Don't forget to add an `augment` route in the CMS, so that when clicking in a listing, a new Eloquent entity is created behind scenes with the associated `datahub_id`.

```php
Route::name('collection.artists.augment')->get('artists/augment/{datahub_id}', 'ArtistController@augment');
```



## Related API elements.

Some augmented models allow you to add related API content. Exhibitions, for example, have an augmented model that allows you to add other related API exhibitions.

These related exhibitions are not linked to the augmented entities. The relationship is directly linked to the API element. To achieve this, we need to modify how we define our Twill Resource Browsers.

First, include the trait [`HasApiRelations`](../app/Models/Behaviors/HasApiRelations.php) to the Eloquent augmented model and then define the relationship like this:

```php
public function exhibitions() {
    return $this->apiElements()->where('relation', 'exhibitions');
}
```

The last 'exhibitions' is just the name for our relation. It's arbitrary and could be anything. This will save a metamodel containing the related database element, with the related `datahub_id` and `type`.

Behind the scenes, we have a polymorphic relationship with the [`ApiRelation`](../app/Models/ApiRelation.php) model. Here we just save the `datahub_id` until retrieve time.

To load the related elements with full content, you can use the trait function:

```php
$related_exhibitions = $item->apiModels('exhibitions', 'Exhibition');
```

`$item` is an Exhibition object, the first parameter is the relation we passed when defining the relationship, and the second is the API/Model to be loaded.

That's it. This will load a collection of API models coming from that relationship. Basically, it's just a call filtering by all the IDs on this relationship.

Now we should call the Twill repository with the functions to save these relationships, to do this we created some handy helpers. See the [Exhibitions repository](../app/Repositories/Api/ExhibitionRepository.php) for examples of how to load a browser with data.


```php
// On afterSave:
$this->updateBrowserApiRelated($object, $fields, ['exhibitions']);

// On getFormFields:
$fields['browsers']['exhibitions'] = $this->getFormFieldsForBrowserApi($object, 'exhibitions', 'App\Models\Api\Exhibition', 'whatson');
```

As a note, `updateBrowserApiRelated` should be called only once with all the API relationships named in an array in the last parameter.

The form behaves as a normal Browser:

```php
@formField('browser', [
    'routePrefix' => 'exhibitions_events',
    'max' => 4,
    'name' => 'exhibitions',
    'label' => 'Related exhibitions'
])
```



## Generating links

BaseApiModel implements Laravel's `UrlRoutable`. If it contains an augmented model with a slug, this will generate a proper `ID/Slug` string to fill it up. To generate an exhibition detail link:

```php
// Load an exhibition with $id
$item = \App\Models\Api\Exhibition::query()->find($id);

// Generate the link inside a blade view
route('exhibitions.show', $item)
```



## General Search

`App\Models\Api\Search` is a special model to deal with general searching. This uses a general `/search` endpoint to retrieve minimal data on any entity. Then it loads all real models trying to keep it efficient using one query per entity, passing by an array of IDs.

```php
// Prepare a query with any resource
$query = App\Models\Api\Search::search('monet');

// ...or specify entities to search by
$query = App\Models\Api\Search::search('monet')->resources(['artworks', 'exhibitions']);

// ...or search only exhibitions
$query = App\Models\Api\Search::search('monet')->resources(['exhibitions']);

// Run the actual query and get 10 elements
$results = $query->getSearch(10);

// Useful data loaded after execution
$results->getMetadata('aggregations');
$results->getMetadata('pagination');
$results->getMetadata('suggestions');

// All metadata
$results->getMetadata();
```

The `getSearch()` function prototype is:

```php
public function getSearch($perPage = null, $columns = [], $pageName = 'page', $page = null)
```



## Raw Elasticsearch query and Scopes

Our APIO offers a `query` parameter with which you can pass raw Elasticsearch parameters to perform a search.

For example, let's search for the upcoming exhibitions for the next 2 weeks:

```php
$params = [
  'bool' => [
    'must' => [
      0 => [
        'range' => [
          'aic_start_at' => [
            'lte' => 'now+2w',
          ],
        ],
      ],
      1 => [
        'range' => [
          'aic_end_at' => [
            'gte' => 'now',
          ],
        ],
      ],
    ],
    'must_not' => [
      'term' => [
        'status' => 'Closed',
      ],
    ],
  ],
];

$results = \App\Models\Api\Exhibition::query()->rawSearch($params)->getSearch();
```

Remember that you could simply build scopes as you would normally do with Eloquent models. Let's use the above query as a scope on the `Exhibition` model:

```php
public function scopeNextTwoWeeks($query) {
    $params = [
      'bool' => [
        'must' => [
          0 => [
            'range' => [
              'aic_start_at' => [
                'lte' => 'now+2w',
              ],
            ],
          ],
          1 => [
            'range' => [
              'aic_end_at' => [
                'gte' => 'now',
              ],
            ],
          ],
        ],
        'must_not' => [
          'term' => [
            'status' => 'Closed',
          ],
        ],
      ],
    ];

    return $query->rawSearch($params);
}
```

Now the controller will be much cleaner:

```php
$results = \App\Models\Api\Exhibition::query()->nextTwoWeeks()->getSearch();
```

In case you don't want to use a specific model and you prefer to perform a general search, you can still use the `Search` model as explained before:

```php
// Let's search artworks from 1812-1815
$params = [
  'bool' => [
    'must' => [
      0 => [
        'range' => [
          'date_start' => [
            'gte' => 1812,
          ],
        ],
      ],
      1 => [
        'range' => [
          'date_end' => [
            'lte' => 1815,
          ],
        ],
      ],
    ],
  ],
];

$results = \App\Models\Api\Search::query()->rawSearch($params)->resources(['artworks'])->getSearch();
```

You can move all this to a scope as well. Just add it to the `Search` model as seen before and call it by its name.

*Something to remember:* Scopes are good for every query on this document, not only searching.



## Default scopes

If you need scopes to be applied by default to every query within a model, just add the static class property `$defaultScopes` with an array keyed with the scope name. This example will apply the 'include' scope passing an array as the parameter:

```php
protected static $defaultScopes = [
    'include' => ['artist_pivots', 'place_pivots', 'dates']
];
```

This is used in artworks to always load the pivot elements as those are used on listings and in detail pages.



## Aggregations

To get some aggregations when searching you can use the `aggregations` function in our builder. For example, to get the counts by type while searching 'picasso':

```php
$aggs = [
    'types' => [
        'terms' => [
            'field' => 'api_model'
        ]
    ]
];

$results = \App\Models\Api\Search::query()
    ->search('picasso')
    ->aggregations($aggs);
    ->getSearch();

// Results metadata are stored at the query.
$query->getMetadata('aggregations');

// Also pagination and suggestions
$query->getMetadata('pagination');
$query->getMetadata('suggestions');

// All of them at once
$query->getMetadata();
```

You could also use scopes directly:

```php
// This is the scope on the search model
public function scopeAggregationType($query)
{
    $aggs = [
        'types' => [
            'terms' => [
                'field' => 'api_model'
            ]
        ]
    ];

    return $query->aggregations($aggs);
}

$query = \App\Models\Api\Search::query()->search($string)->aggregationType();
$results = $query->getSearch();
```



## Force a custom endpoint

If you don't want to use the general endpoints, you can specify the name for the one you want to use in the `$endpoints` property:

```php
class Artwork extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/artworks',
        'resource'   => '/api/v1/artworks/{id}',
        'search'     => '/api/v1/artworks/search',
        'boosted'    => '/api/v1/artworks/boosted'
    ];
}
```

Here we added a new `boosted` endpoint to retrieve the most important artworks. To use it, just call the scope `forceEndpoint($name)`:

```php
    \App\Models\Api\Artwork::query()->forceEndpoint('boosted')->search('picasso')->getSearch();
```



## Raw response

If you want to get a raw response that does not parse elements, use the `getRaw()` function instead of a regular `get()` or `getSearch()`. For example, the following query will force the 'autocomplete' endpoint, and get a raw response using the parameter 'q' sent on the request.

```php
$collection = \App\Models\Api\Search::search(request('q'))->forceEndpoint('autocomplete')->getRaw();
```

`getRaw()` just returns an array with the raw response.

## Use a custom TTL for a specific call

If you don't want to use the default TTL, call the `ttl()` function and pass the number of seconds you want this to be cached.

```php
// set TTL to 1 hour (3600 seconds)
$collection = \App\Models\Api\Search::search(request('q'))->ttl(3600)->getSearch();
```
