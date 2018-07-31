# Art Institute of Chicago

Images at the FE

## API models

Please include the behavior `HasMediasApi` at the models you want to load images.
We created a method with the same prototype as Twill so we can show images from the CMS or API models indistinctly.


```php
use App\Models\Behaviors\HasMediasApi;

class Artwork extends BaseApiModel
{
    use HasMediasApi;
}
```

After that you should define your roles and crops, with a little difference from Twill:


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

`field`: API field containing the image ID (We have only seen `image_id` here coming from the API, but added the option nontheless)
`width`: Width for this image
`height`: Height for this image


## Eloquent/Twill Models

Please add the `HasMediasEloquent` trait.


```php
use App\Models\Behaviors\HasMediasEloquent;

class Event extends Model
{
    use HasSlug, HasMediasEloquent;
}
```

This will just add an extra function to access the image and apply the `aic_convertFromImage` image.


## How to use it


The function is `imageFront($role, $crop)`

This way you can call the same function on any model (API, Eloquent).
This will ensure the statics will keep working, and also, that having the same method prototype, we could augment API models and perform a call disregarding if it's an API or Twill model.
