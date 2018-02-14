# Art Institute of Chicago

API models and connections examples.

#### Base models

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


#### Basic usage

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

`\App\Models\Api\Artwork::query()->search(QUERY)`



#### Repository usage

Search:

```
public function index(ArtworkRepository $artworks)
    {
        $artworksResults = $artworks->forSearchQuery(request('query'));
    }
```

Remember that the repository has to inherit from BaseApiRepository, and the model has to be an api model.

This function will:
1 - search for the 'query' term
2 - Load all stats (aggregations, suggestions, pagination)
3 - Load real models and return a collection of BaseApiModels



#### Advanced usage

Check the `Api\Exhibition` model.
It contains several hasMany relations. These will take those Id's returned by the API and load the collection of models assigned.

```
public function artworks()
    {
        return $this->hasMany(\App\Models\Api\Artwork::class, 'artwork_ids');
    }
```

Here the parameter is artwork_ids (array), so when you have an object from this model you can simply call:

`$exhibition->artworks;`

And that will load all related artworks.



### Eager load


You could eager load those artworks with one call in a collection doing the following:

```
\App\Models\Api\Artwork::query()->with(['artworks', 'any_other_has_many'])->get();
```

