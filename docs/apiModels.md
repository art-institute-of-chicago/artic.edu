# Art Institute of Chicago

Here we will present the API pseudo models used to consume data from the AIC API, and also a quick-start guide to integrate them  to Twill.

## The Base API model

BaseApiModel.php is a fake Eloquent model that implements many of it's functionality. Amongst them:

* Generate an array
* Use mutators for fields
* Paginate results
* Create entities from an array (hydrate)
* Json serialize
* And much more, please take a look at the code.

We haven't implemented any functionality to update/create data, so for now it works as a consumer type only.

We decided to take this route to allow us to generate a compatible way to work with Twill, emulating Eloquent as far as we can, to avoid modifying the CMS package.

## Where to find the code

Under `app\Libraries\Api` you will find the code related to how we process API data.

Please take a moment to review specially the following files:

* `app/Libraries/Api/Models/Behaviors/HasApiCalls.php`
* `app/Libraries/Api/Models/Behaviors/HasAugmentedModel.php`

These are behaviors used by our API pseudo models and the following are used by the Eloquent regular database models.

* `app/Models/Behaviors/HasApiRelations.php`
* `app/Models/Behaviors/HasApiModel.php`

These are not all, but are the ones that describe better the relationship between Eloquent and Api models.

If you have time take a look to `app/Libraries/Api/Models/BaseApiModel.php`, in there you will find all the 'Eloquent like' functionality we want to emulate: Mutators, scopes, relationships, json and array exporters, dateTime parsers, and much more.


## Grammar

If for any reason the API changes and the parameters names are different, you could easily change the grammar class used to transform a query into a set of parameters.

See: `app/Libraries/Api/Builders/Grammar/AicGrammar.php`

In there you will find a very simple set of functions that transform the API Query Browser class into an array of options.

If you need to use a different one for a specific model you can define that when creating the connection.

You could redefine `getConnection`:

```

public function getConnection()
    {
            $grammar    = new FooBarGrammar();
            $connection = new AicConnection();
        $connection->setQueryGrammar($grammar);

        return $connection;
    }

```

Be sure that FooBarGrammar inherits from `AicGrammar`.



## API Basic usage

Let's now learn how to interact with the API.
We will use artworks as an example.

Load a single element:

`\App\Models\Api\Artwork::query()->find(ID)`

Load a collection by IDs:

`\App\Models\Api\Artwork::query()->find([ID1,ID2])`
or
`\App\Models\Api\Artwork::query()->ids([ID1,ID2])->get()`

Load a collection and paginate (paginate function is the same as a regular model)

`\App\Models\Api\Artwork::query()->paginate($perPage, $columns, etc...)`

Search (Careful because sometimes search won't return all fields)

`\App\Models\Api\Artwork::query()->search('SEARCH_STRING')->get()`

To solve the previous problem, we created this functionality to load the actual models, with complete data.

`\App\Models\Api\Artwork::query()->search('SEARCH_STRING')->getSearch()`

Using a search endpoint returns a smaller version of the object with relevant searching data. Not the full object. `getSearch()` loads the real data.

As a performance note, this generates two API calls, one for search, and one to grab the data.


## Repository usage

Search:

```php
public function index(ArtworkRepository $artworks)
    {
        $artworksResults = $artworks->forSearchQuery(request('query'));
    }
```

Remember that any API repository has to inherit from BaseApiRepository, and the model has to be an api model.

This function will:

* search for the 'query' term
* Load all stats (aggregations, suggestions, pagination)
* Load real models and return a collection of API pseudo models.



## Has Many relationship

We implemented a basic HasMany relationship that works like our Eloquent counterpart. The difference is that this one uses an array of ids (returned by the API) to load the correct elements.

See `App\Models\Api\Exhibition`.
It contains several hasMany relations. These will be taken those Ids returned by the API and loading a collection with the corresponding API model objects.

```php
public function artworks()
    {
        return $this->hasMany(\App\Models\Api\Artwork::class, 'artwork_ids');
    }
```

Here the parameter is artwork_ids (array). From the parent element you can simply call:

`$exhibition->artworks;`

And that will load a collection of related artworks.



## Eager load


You could eager load those artworks with one call in a collection doing the following:

```php
\App\Models\Api\Artwork::query()->with(['artworks', 'any_other_has_many'])->get();
```


## Augmented models

Please take a look to the `HasAugmentedModel` trait.

Here you can see the functions to load augmented models from our CMS using the `datahub_id` field.

For example on exhibitions, if you check `Models\Api\Exhibition`

```php
protected $augmented = true;
protected $augmentedModelClass = 'App\Models\Exhibition';
```

You specify that it has an augmented model.

Let's say you augmented an Exhibition model already. To load it's data just use the API exhibition object and call the method or attribute as you would normally do. If the API model doesn't have that method or attribute, IT WILL BYPASS the call to the augmented model and try to retrieve those automatically.


## How to create an augmented model on Twill CMS.

First, create the Eloquent model, controller, requests, etc. as you would normally do for a regular Twill entity. Ensure it contains the `datahub_id` field.

Then inherit the controller from `BaseApiController` instead of `ModuleController`.

Add `$hasAugmentedModel = true;`.

Create two repositories, one for API requests, and another for Twill. Let's see Artists for example:

`app/Repositories/Api/ArtistRepository.php` Will use the API model as the base, and will be the one used to generate listings, filtering, etc, given that we load everything from the API and we just augment using our CMS.

`app/Repositories/ArtistRepository.php` Will contain Twill functionality to create/update augmented data as usual.

Both should inherit from `App\Repositories\Api\BaseApiRepository`.

Here you can see some Twill overloaded functions like search, or getById. These ones were modified to work with Twill seamlessly.

Don't forget to add an `augment` route so when clicking in a listing, a new Eloquent entity is created behind scenes with the associated datahub_id.

`Route::name('collection.artists.augment')->get('artists/augment/{datahub_id}', 'ArtistController@augment');`



## Related API elements.

Exhibitions for example can be augmented on the CMS, and in there you could add related exhibitions to it.

These related exhibitions are not necessarily augmented entities. This means that the relationship should be directly linked to the API element, not with our database.

To achieve this we should modify how we define our Twill Resource Browsers.

First, include the trait `HasApiRelations` to the Eloquent side model and then define the relationship like this:

```php
public function exhibitions()
    {
        return $this->apiElements()->where('relation', 'exhibitions');
    }
```

The last 'exhibitions' is just the name for our relation. Could be anything. This will save a metamodel containing the related database element, with the related datahub_id and type.

Behind the scenes, we have a polymorphic relationship with the `ApiRelation` model. Here we just save the datahub_id until retrieve time.

To load the ACTUAL related elements, you can use the trait function:

```php
$related_exhibitions = $item->apiModels('exhibitions', 'Exhibition');
```

$item is an exhibition, the first parameter is the relation we passed when defining the relationship, and the second is the API/Model to be loaded.

That's it, this will load a collection of API models coming from that relationship. (Basically it's just a call filtering by all the ids on this relationship).

Now we should call the Twill repository with the functions to save these relationships, to do this we created some handy helpers.

(Please check Exhibitions repository. In there you will find examples of how to load a browser with this data.)

```php
// On afterSave:
$this->updateBrowserApiRelated($object, $fields, ['exhibitions']);

// On getFormFields:
$fields['browsers']['exhibitions'] = $this->getFormFieldsForBrowserApi($object, 'exhibitions', 'App\Models\Api\Exhibition', 'whatson');
```

As a note, `updateBrowserApiRelated` should be called only once with all the API relationships.

The form behaves the same way as with a normal Browser.

```
@formField('browser', [
    'routePrefix' => 'exhibitions_events',
    'max' => 4,
    'name' => 'exhibitions',
    'label' => 'Related exhibitions'
])
```


## Generating links

BaseApiModel implements `UrlRoutable`. If it contains an augmented model with a slug, this will generate a proper `ID/SLUG` string to fill it up.

```php
// Generating an exhibition detail link.

// Load an exhibition with id ID
$item = \App\Models\Api\Exhibition::query()->find(ID);

// Generate the link inside a blade view
route('exhibitions.show', $item)
```


## General Search

A17 created a special model to deal with general searching. `App\Models\Api\Search`.

This one just uses a general endpoint to load ANY entity.
Afterwards it loads all real models trying to keep it efficient using one query per entity (passing by an array of ids).

```php

// This one will prepare a query with any resource
$query = App\Models\Api\Search::search('monet');

// This one just the specified ones (artworks and exhibitions)
$query = App\Models\Api\Search::search('monet')->resources(['artworks', 'exhibitions']);

// This one just monet exhibitions
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

`getSearch` function prototype is:

```php
public function getSearch($perPage = null, $columns = [], $pageName = 'page', $page = null)
```


## Raw Elasticsearch query and Scopes

AIC offers a `query` parameter on which you can pass raw ES parameters to perform a search.

For example, let's search for the upcoming exhibitions for the next 2 weeks:

```php

$params = [
  'bool' => [
    'must' => [
      0 => [
        'range' => [
          'start_at' => [
            'lte' => 'now+2w',
          ],
        ],
      ],
      1 => [
        'range' => [
          'end_at' => [
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


Remember that you could simply build scopes as you would normally do with Eloquent models. Lets create one at the `Exhibition` model:


```php
public function scopeNextTwoWeeks($query) {
    $params = [
      'bool' => [
        'must' => [
          0 => [
            'range' => [
              'start_at' => [
                'lte' => 'now+2w',
              ],
            ],
          ],
          1 => [
            'range' => [
              'end_at' => [
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


This way the controller will be much cleaner:


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


You can move all this to a scope as well. Just add it to the `Search` model as seen before and call it by it's name.



*Something to remember:* Scopes are good for every query on this document, not only searching.


## Default scopes

If you need scopes to be applied by default to every query within a model, just add the static variable $defaultScopes with the scope name as key, and the value as the scope value.

See this very simple implementation with only 1 possible parameter:


```php
protected static $defaultScopes = [
    'include' => ['artist_pivots', 'place_pivots', 'dates', 'catalogue_pivots']
];
```


This lines will apply the 'include' scope passing an array as the parameter. This is used for example in artworks, to always load the pivot elements as those are used when listing and in a detail page.


## Aggregations

To get some aggregations when searching you can use the `aggregations` function in our builder.
For example to get the counts by type while searching 'picasso':

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

If you don't want to use the basic defined endpoints, you could just specify the name for the one you want to use for the current query.

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

Here we added a new `boosted` endpoint to retrieve the most important artworks. To use it, just call the scope `forceEndpoint($name)`.


```php
    \App\Models\Api\Artwork::query()->forceEndpoint('boosted')->search('picasso')->getSearch();
```

## Raw response. Do not parse elements


If you want to get a raw response just use the `getRaw()` function instead of a regular `get` or `getSearch`.
For example the following query will force the 'autocomplete' endpoint, and get a raw response using the parameter 'q' sent on the request.

```php
    $collection = \App\Models\Api\Search::search(request('q'))->forceEndpoint('autocomplete')->getRaw();
```

getRaw just returns an array with the raw responses.
For now it's just intended to be used on the autocomplete.


## Use a custom TTL for a specific call

If you don't want to use the default TTL, just call the `ttl` function and pass the number of seconds you want this to be cached.

```php
// set TTL to 1 hour (3600 seconds)
$collection = \App\Models\Api\Search::search(request('q'))->ttl(3600)->getSearch();
```

