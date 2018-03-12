# Art Institute of Chicago

Image at the FE

## API models

Please include the behavior `HasMediasApi` at the models you want to load images.


```php
use App\Models\Behaviors\HasMediasApi;

class Artwork extends BaseApiModel
{
    use HasMediasApi;
}
```

We are trying to use the same functionality to show images from the CMS or the API.

After that you should define your roles and crops, with a little difference:


```php

public $mediasParams = [
    'hero' => [
        'default' => [
        ],
        'thumbnail' => [
            'field'  => 'image_id',
            'width'  => 30,
        ],
        'small' => [
            'field'  => 'image_id',
            'width'  => 30,
            'height'  => 45,
        ],
    ],
];

```


Possible parameters (all optional):

`field`: API field containing the image ID (I have only seen image_id here, but added just in case)
`width`: Width for this image
`height`: Height for this image


## Eloquent Models

Please add the `HasMediasEloquent` trait.


```php
use App\Models\Behaviors\HasMediasEloquent;

class Event extends Model
{
    use HasSlug, HasMediasEloquent;
}
```

This will just add an extra function to access the image and apply the `aic_convertFromImage` image.


## Use


The function is `imageFront($role, $crop)`

This way you can call the same function on any model (API, Eloquent).
This will ensure the statics will keep working and we don't have to treat images differently.
