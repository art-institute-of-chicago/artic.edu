# Images

Images on the frontend are provided by Twill's [Media Library](https://twill.io/docs/#media-library-3) as well as the Art Institute of Chicago's collections digital asset management system (DAMS) via the API. Eloquent models as well as our API models can provide images to the frontend.



## API models

Use the [`HasMediasApi`](../app/Models/Behaviors/HasMediasApi) trait in the API models you want to load images. This behavior adds a method with the same prototype as Twill so we can show images from the CMS or API models indistinctly.


```php
use App\Models\Behaviors\HasMediasApi;

class Artwork extends BaseApiModel
{
    use HasMediasApi;
}
```

After that you should define your roles and crops:


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

`field`: API field containing the image ID. Typically this will be `image_id`.
`width`: Width for this image
`height`: Height for this image



## Eloquent/Twill Models

Use the [`HasMediasEloquent`](../app/Models/Behaviors/HasMediaEloquent) trait in the Twill models you want to load images.


```php
use App\Models\Behaviors\HasMediasEloquent;

class Event extends Model
{
    use HasSlug, HasMediasEloquent;
}
```

This will just add an extra function to access the image and apply the `ImageHelpers::aic_convertFromImage` function.



## How to use it

The `imageFront($role, $crop)` function is used in both these traits to retrieve images. You can call the same function on either type of model—API or Eloquent. Having the same method prototype ensures that you can augment API models and perform a call to retrieve images without regard to whether it's an API or Twill model.
