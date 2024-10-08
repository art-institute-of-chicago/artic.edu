<?php

namespace App\Models\Behaviors;

use App\Models\PublicationMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use A17\Twill\Services\MediaLibrary\ImageService;

trait HasPublicationMedias
{
    protected $cropParamsKeys = [
        'crop_x',
        'crop_y',
        'crop_w',
        'crop_h',
    ];

    public static function bootHasPublicationMedias(): void
    {
        self::deleted(static function (Model $model) {
            if (!method_exists($model, 'isForceDeleting') || $model->isForceDeleting()) {
                /** @var \App\Models\Behaviors\HasPublicationMedias $model */
                $model->publicationMedias()->detach();
            }
        });
    }

    /**
     * Defines the many-to-many relationship for media objects.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function publicationMedias()
    {
        return $this->morphToMany(
            PublicationMedia::class,
            'publication_mediable',
            config('twill.publication_mediables_table', 'twill_publication_mediables')
        )->withPivot(array_merge([
            'crop',
            'role',
            'crop_w',
            'crop_h',
            'crop_x',
            'crop_y',
            'lqip_data',
            'ratio',
            'metadatas',
        ], config('twill.media_library.translated_form_fields', false) ? ['locale'] : []))
            ->withTimestamps()->orderBy(config('twill.publication_mediables_table', 'twill_publication_mediables') . '.id', 'asc');
    }

    private function findPublicationMedia($role, $crop = 'default')
    {
        $media = $this->publicationMedias->first(function ($media) use ($role, $crop) {
            if (config('twill.media_library.translated_form_fields', false)) {
                $localeScope = $media->pivot->locale === app()->getLocale();
            }

            return $media->pivot->role === $role && $media->pivot->crop === $crop && ($localeScope ?? true);
        });

        if (! $media && config('twill.media_library.translated_form_fields', false)) {
            $media = $this->publicationMedias->first(function ($media) use ($role, $crop) {
                return $media->pivot->role === $role && $media->pivot->crop === $crop;
            });
        }

        return $media;
    }

    /**
     * Checks if an image has been attached for a role and crop.
     *
     * @param string $role Role name.
     * @param string $crop Crop name.
     * @return bool
     */
    public function hasPublicationImage($role, $crop = "default")
    {
        $media = $this->findPublicationMedia($role, $crop);

        return !empty($media);
    }

    /**
     * Returns the URL of the attached image for a role and crop.
     *
     * @param string $role Role name.
     * @param string $crop Crop name.
     * @param array $params Parameters compatible with the current image service, like `w` or `h`.
     * @param bool $has_fallback Indicate that you can provide a fallback. Will return `null` instead of the default image fallback.
     * @param bool $cms Indicate that you are displaying this image in the CMS views.
     * @param Media|null $media Provide a media object if you already retrieved one to prevent more SQL queries.
     * @return string|null
     */
    public function publicationImage($role, $crop = "default", $params = [], $has_fallback = false, $cms = false, $media = null)
    {

        if (!$media) {
            $media = $this->findPublicationMedia($role, $crop);
        }

        if ($media) {

            $crop_params = Arr::only($media->pivot->toArray(), $this->cropParamsKeys);

            if ($cms) {

                return ImageService::getCmsUrl($media->uuid, $crop_params + $params);
            }

            return ImageService::getUrlWithCrop($media->uuid, $crop_params, $params);
        }

        if ($has_fallback) {
            return null;
        }

        return ImageService::getTransparentFallbackUrl();
    }

    /**
     * Returns an array of URLs of all attached images for a role and crop.
     *
     * @param string $role Role name.
     * @param string $crop Crop name.
     * @param array $params Parameters compatible with the current image service, like `w` or `h`.
     * @return array
     */
    public function publicationImages($role, $crop = "default", $params = [])
    {
        $medias = $this->publicationMedias->filter(function ($media) use ($role, $crop) {
            return $media->pivot->role === $role && $media->pivot->crop === $crop;
        });

        $urls = [];

        foreach ($medias as $media) {
            $urls[] = $this->publicationImage($role, $crop, $params, false, false, $media);
        }

        return $urls;
    }

    /**
     * Returns an array of URLs of all attached images for a role, including all crops.
     *
     * @param string $role Role name.
     * @param array $params Parameters compatible with the current image service, like `w` or `h`.
     * @return array
     */
    public function publicationImagesWithCrops($role, $params = [])
    {
        $medias = $this->publicationMedias->filter(function ($media) use ($role) {
            return $media->pivot->role === $role;
        });

        $urls = [];

        foreach ($medias as $media) {
            $paramsForCrop = $params[$media->pivot->crop] ?? [];
            $urls[$media->id][$media->pivot->crop] = $this->publicationImage($role, $media->pivot->crop, $paramsForCrop, false, false, $media);
        }

        return $urls;
    }

    /**
     * Returns an array of meta information for the image attached for a role and crop.
     *
     * @param string $role Role name.
     * @param string $crop Crop name.
     * @param array $params Parameters compatible with the current image service, like `w` or `h`.
     * @param Media|null $media Provide a media object if you already retrieved one to prevent more SQL queries.
     * @return array
     */
    public function publicationImageAsArray($role, $crop = "default", $params = [], $media = null)
    {
        if (!$media) {
            $media = $this->findPublicationMedia($role, $crop);
        }

        if ($media) {
            return [
                'src' => $this->publicaitonImage($role, $crop, $params, false, false, $media),
                'width' => $media->pivot->crop_w ?? $media->width,
                'height' => $media->pivot->crop_h ?? $media->height,
                'alt' => $this->publicationImageAltText($role, $media),
                'caption' => $this->publicationImageCaption($role, $media),
                'video' => $this->publicationImageVideo($role, $media),
            ];
        }

        return [];
    }

    /**
     * Returns an array of meta information for all images attached for a role and crop.
     *
     * @param string $role Role name.
     * @param string $crop Crop name.
     * @param array $params Parameters compatible with the current image service, like `w` or `h`.
     * @return array
     */
    public function publicationImagesAsArrays($role, $crop = "default", $params = [])
    {
        $medias = $this->publicationMedias->filter(function ($media) use ($role, $crop) {
            return $media->pivot->role === $role && $media->pivot->crop === $crop;
        });

        $arrays = [];

        foreach ($medias as $media) {
            $arrays[] = $this->publicationImageAsArray($role, $crop, $params, $media);
        }

        return $arrays;
    }

    /**
     * Returns an array of meta information for all images attached for a role, including all crops.
     *
     * @param string $role Role name.
     * @param array $params Parameters compatible with the current image service, like `w` or `h`.
     * @return array
     */
    public function publicationImagesAsArraysWithCrops($role, $params = [])
    {
        $medias = $this->publicationMedias->filter(function ($media) use ($role) {
            return $media->pivot->role === $role;
        });

        $arrays = [];

        foreach ($medias as $media) {
            $paramsForCrop = $params[$media->pivot->crop] ?? [];
            $arrays[$media->id][$media->pivot->crop] = $this->imageAsArray($role, $media->pivot->crop, $paramsForCrop, $media);
        }

        return $arrays;
    }

    /**
     * Returns the alt text of the image attached for a role.
     *
     * @param string $role Role name.
     * @param Media|null $media Provide a media object if you already retrieved one to prevent more SQL queries.
     * @return string
     */
    public function publicationImageAltText($role, $media = null)
    {
        if (!$media) {
            $media = $this->publicationMedias->first(function ($media) use ($role) {
                if (config('twill.media_library.translated_form_fields', false)) {
                    $localeScope = $media->pivot->locale === app()->getLocale();
                }

                return $media->pivot->role === $role && ($localeScope ?? true);;
            });
        }

        if ($media) {
            return $media->getMetadata('altText', 'alt_text');
        }

        return '';
    }

    /**
     * Returns the caption of the image attached for a role.
     *
     * @param string $role Role name.
     * @param Media|null $media Provide a media object if you already retrieved one to prevent more SQL queries.
     * @return string
     */
    public function publicationImageCaption($role, $media = null)
    {
        if (!$media) {
            $media = $this->publicationMedias->first(function ($media) use ($role) {
                if (config('twill.media_library.translated_form_fields', false)) {
                    $localeScope = $media->pivot->locale === app()->getLocale();
                }

                return $media->pivot->role === $role && ($localeScope ?? true);;
            });
        }

        if ($media) {
            return $media->getMetadata('caption');
        }

        return '';
    }

    /**
     * Returns the video URL of the image attached for a role.
     *
     * @param string $role Role name.
     * @param Media|null $media Provide a media object if you already retrieved one to prevent more SQL queries.
     * @return string
     */
    public function publicationImageVideo($role, $media = null)
    {
        if (!$media) {
            $media = $this->publicationMedias->first(function ($media) use ($role) {
                if (config('twill.media_library.translated_form_fields', false)) {
                    $localeScope = $media->pivot->locale === app()->getLocale();
                }

                return $media->pivot->role === $role && ($localeScope ?? true);;
            });
        }

        if ($media) {
            $metadatas = (object) json_decode($media->pivot->metadatas);
            $language = app()->getLocale();
            return $metadatas->video->$language ?? (is_object($metadatas->video) ? '' : ($metadatas->video ?? ''));
        }

        return '';
    }

    /**
     * Returns the media object attached for a role and crop.
     *
     * @param string $role Role name.
     * @param string $crop Crop name.
     * @return Media|null
     */
    public function publicaitonImageObject($role, $crop = "default")
    {
        return $this->findPublicaitonMedia($role, $crop);
    }

    /**
     * Returns the LQIP base64 encoded string for a role.
     * Use this in conjunction with the `RefreshLQIP` Artisan command.
     *
     * @param string $role Role name.
     * @param string $crop Crop name.
     * @param array $params Parameters compatible with the current image service, like `w` or `h`.
     * @param bool $has_fallback Indicate that you can provide a fallback. Will return `null` instead of the default image fallback.
     * @return string|null
     * @see \A17\Twill\Commands\RefreshLQIP
     */
    public function lowQualityPublicationImagePlaceholder($role, $crop = "default", $params = [], $has_fallback = false)
    {
        $media = $this->findPublicaitonMedia($role, $crop);

        if ($media) {
            return $media->pivot->lqip_data ?? ImageService::getTransparentFallbackUrl();
        }

        if ($has_fallback) {
            return null;
        }

        return ImageService::getTransparentFallbackUrl();

    }

    /**
     * Returns the URL of the social image for a role and crop.
     *
     * @param string $role Role name.
     * @param string $crop Crop name.
     * @param array $params Parameters compatible with the current image service, like `w` or `h`.
     * @param bool $has_fallback Indicate that you can provide a fallback. Will return `null` instead of the default image fallback.
     * @return string|null
     */
    public function socialPublicationImage($role, $crop = "default", $params = [], $has_fallback = false)
    {
        $media = $this->findPublicationMedia($role, $crop);

        if ($media) {
            $crop_params = Arr::only($media->pivot->toArray(), $this->cropParamsKeys);

            return ImageService::getSocialUrl($media->uuid, $crop_params + $params);
        }

        if ($has_fallback) {
            return null;
        }

        return ImageService::getSocialFallbackUrl();
    }

    /**
     * Returns the URL of the CMS image for a role and crop.
     *
     * @param string $role Role name.
     * @param string $crop Crop name.
     * @param array $params Parameters compatible with the current image service, like `w` or `h`.
     * @return string
     */
    public function cmsPublicationImage($role, $crop = "default", $params = [])
    {
        return $this->publicationImage($role, $crop, $params, false, true, false) ?? ImageService::getTransparentFallbackUrl($params);
    }

    /**
     * Returns the URL of the default CMS image for this model.
     *
     * @param array $params Parameters compatible with the current image service, like `w` or `h`.
     * @return string
     */
    public function defaultCmsPublicationImage($params = [])
    {
        $media = $this->publicationMedias->first();

        if ($media) {
            return $this->image(null, null, $params, true, true, $media) ?? ImageService::getTransparentFallbackUrl($params);
        }

        return ImageService::getTransparentFallbackUrl($params);
    }

    /**
     * Returns the media objects associated with a role and crop.
     *
     * @param string $role Role name.
     * @param string $crop Crop name.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function publicationImageObjects($role, $crop = "default")
    {
        return $this->publicationMedias->filter(function ($media) use ($role, $crop) {
            return $media->pivot->role === $role && $media->pivot->crop === $crop;
        });
    }
}
