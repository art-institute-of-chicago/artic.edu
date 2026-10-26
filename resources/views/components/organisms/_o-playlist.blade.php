<div class="o-playlist">
    <ul class="o-playlist__videos">
        @foreach ($videos as $video)
            @component('components.molecules._m-listing----playlist-video')
                @slot('isCurrent', $video->is($currentVideo))
                @slot('url', route('playlists.videos.show', [
                    'playlist' => $playlist,
                    'video' => $video,
                    'slug' => $video->getSlug(),
                ]))
                @slot('title', $video->title ?? '')
                @slot('image', $video->imageFront('hero') ?? ImageHelpers::youtubeItemAsArray($video))
                @slot('imageSettings', array(
                    'fit' => 'crop',
                    'ratio' => '16:9',
                    'srcset' => ImageHelpers::SRCSET_WIDTHS_SMALL,
                    'sizes' => ImageHelpers::aic_imageSizes(array(
                        'xsmall' => '216px',
                        'small' => '216px',
                        'medium' => '18',
                        'large' => '13',
                        'xlarge' => '13',
                    )),
                ))
            @endcomponent
        @endforeach
    </ul>
</div>
