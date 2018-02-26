# Art Institute of Chicago

API models and connections examples.

## Base models

BaseApiModel.php is a fake Eloquent model that implements many of it's functions. Between them:

* Generate an array
* Use mutators for fields
* Paginate results
* Create them from an array
* Json serialize
* And more, please take a look at the file for a full list.

We don't allow to save or destroy, so for now it's just a read-only model.

It has been done this way to generate a compatible way to work with our CMS, implementing basic filtering functions.

Please check the Exhibitions model, here you can see we can even use our HasPresenter trait, and some other useful Eloquent functionality.


## Basic usage

Let's use artworks to exemplify.

Load a single element:

`\App\Models\Api\Artwork::query()->find(ID)`

Load a collection by IDS:

`\App\Models\Api\Artwork::query()->find([ID1,ID2])`
or
`\App\Models\Api\Artwork::query()->ids([ID1,ID2])->get()`

Load a collection and paginate (paginate function is the same as a regular model)

`\App\Models\Api\Artwork::query()->paginate($perPage, $columns, etc...)`

Search (This will use the search enpoint, which might disable some filters)

`\App\Models\Api\Artwork::query()->search('SEARCH_STRING')->get()`

This one will load the actual models, with the complete data

`\App\Models\Api\Artwork::query()->search('SEARCH_STRING')->getSearch()`

This is because using a search endpoint returns a smaller version of the object with relevant searching data. Not the full object. `getSearch()` loads the real data.


## Repository usage

Search:

```php
public function index(ArtworkRepository $artworks)
    {
        $artworksResults = $artworks->forSearchQuery(request('query'));
    }
```

Remember that the repository has to inherit from BaseApiRepository, and the model has to be an api model.

This function will:

* search for the 'query' term
* Load all stats (aggregations, suggestions, pagination)
* Load real models and return a collection of BaseApiModels



## Advanced usage

Check the `Api\Exhibition` model.
It contains several hasMany relations. These will take those Id's returned by the API and load the collection of models assigned.

```php
public function artworks()
    {
        return $this->hasMany(\App\Models\Api\Artwork::class, 'artwork_ids');
    }
```

Here the parameter is artwork_ids (array), so when you have an object from this model you can simply call:

`$exhibition->artworks;`

And that will load all related artworks.



## Eager load


You could eager load those artworks with one call in a collection doing the following:

```php
\App\Models\Api\Artwork::query()->with(['artworks', 'any_other_has_many'])->get();
```


## Augmented models (working but approach still under dev)

Please take a look to the `HasAugmentedModel` trait.

Here you can see the functions to load augmented models from our CMS using the `datahub_id` field.

For example on exhibitions, if you check `Models\Api\Exhibition`

```php
protected $augmented = true;
protected $augmentedModelClass = 'App\Models\Exhibition';
```

You specify that it has an augmented model.

So to use it just call the method or attribute normally from an API model.
If the API model doesn't have that method or attribute, IT WILL BYPASS the call to the augmented model to load it from the database automatically.


## Related elements coming from the API.

Exhibitions for example can be augmented on the CMS, and in there you can select related exhibitions to it.
These related exhibitions are not necessarily augmented so the relationship should be directly linked to the API.

To achieve this include the trait `HasApiRelations` and then define the relationship like the following:

```php
public function exhibitions()
    {
        return $this->apiElements()->where('relation', 'exhibitions');
    }
```

The last 'exhibitions' is the pluralized type from the API. This will save a metamodel containing the related database element, with the related datahub_id and type.

To load the ACTUAL related elements for the FE you can use the trait function:

```php
$related_exhibitions = $item->apiModels('exhibitions', 'Exhibition');
```

$item is an exhibition, the first parameters is the relation we passed when defining the relationship, and the second is the API/Model to be loaded.

That's it, this will load a collection of API models coming from that relationship.

Please check Exhibitions repository. In there you will find examples of how to load a browser with this data.

```php
// On afterSave:
$this->updateBrowserApiRelated($object, $fields, ['exhibitions']);

// On getFormFields:
$fields['browsers']['exhibitions'] = $this->getFormFieldsForBrowserApi($object, 'exhibitions', 'App\Models\Api\Exhibition', 'whatson');
```

As a note, `updateBrowserApiRelated` should be called only once with all the API relationships.

## Generating links

BaseApiModel implements `UrlRoutable`, which means, you can pass an API model and this will generate a correct link. If it contains an augmented model with a slug, this will generate a proper ID-SLUG string to fill it up.

```php
// Generating an exhibition detail link.

// Load an exhibition with id ID
$item = \App\Models\Api\Exhibition::query()->find(ID);

// Generate the link inside a blade view
route('exhibitions.show', $item)
```

## General Search

I created a special model to deal with general searching. `App\Models\Api\Search`.

This one just uses a general endpoint to load ANY KIND of element.
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
$query->suggestionsData;
$query->aggregationsData;
$query->paginationData;
```

`getSearch` function prototype is:

```php
public function getSearch($perPage = null, $columns = [], $pageName = 'page', $page = null)
```

## Raw Elasticsearch execution

AIC offers a parameter `query` on which you can pass raw ES parameters to perform a search.

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

Here we added a new `boosted` endpoint to retrieve the most important artworks. To use it just call the scope `forceEndpoint($name)`.


```php
    \App\Models\Api\Artwork::query()->forceEndpoint('boosted')->search('picasso')->getSearch();
```
