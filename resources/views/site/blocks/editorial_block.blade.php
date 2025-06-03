@php
    $theme = $block->present()->input('theme');
    $variation = $block->input('variation');

    $heading = $block->present()->input('heading');
    $body = $block->present()->input('body');

    $browse_link = $block->present()->input('browse_link') ?? null;
    $browse_label = $block->present()->input('browse_label') ?? null;

    $categories = collect($block->present()->input('categories'))->take(12);
    $tags = \App\Models\Category::whereIn('id', $categories)->get();

    $videos = $block->getRelated('videos');

    if ($block->children->isNotEmpty()) {
        $stories = collect();
        foreach ($block->children as $child) {
            if ($child->getRelated('publication_item')->isNotEmpty()) {
                $childStories = $child->getRelated('publication_item')->map(function ($item) use ($child) {
                    $item->type = 'augmented';
                    $item->image = $child->hasImage('listing_image')
                        ? $child->imageAsArray('listing_image', 'default')
                        : ($item->hasImage('publications_listing')
                            ? $item->imageAsArray('publications_listing', 'default')
                            : $item->imageAsArray('listing', 'listing'));
                    $item->title = $child->input('title') ?? $item->title;
                    $item->label = $child->input('label') ?? $item->type;
                    $item->url_without_slug = $child->input('linkUrl') ?? $item->url_without_slug;
                    $item->list_description = $child->input('description') ?? $item->list_description;

                    return $item;
                });

            } else {
                $childStories = collect([
                    (object) [
                        'type' => 'custom',
                        'image' => $child->hasImage('listing_image') ? $child->imageAsArray('listing_image') : null,
                        'title' => $child->input('title') ?? null,
                        'label' => $child->input('label') ?? null,
                        'url_without_slug' => $child->input('linkUrl') ?? null,
                        'list_description' => $child->input('description') ?? null,
                    ]
                ]);

            }
            $stories = $stories->merge($childStories);
        }
    } else {
        $stories = $block->getRelated('stories');
    }

@endphp

<div
    id="{{ StringHelpers::getUtf8Slug($heading) }}"
    class="m-editorial-block {{ $theme ? 'editorial-block--'.$theme : '' }} {{ $variation ? 'editorial-block--variation-'.$variation : '' }}"
>
    @switch($variation)
        @case('video')
            <div class="editorial-block__video-wrapper">
            @break
        @default
    @endswitch

    <div class="editorial-block__header">
        <div class="editorial-block__heading">
            <h2>{{ $heading }}</h2>
            @switch(true)
                @case(($variation == 'video' || $variation == '4-across' || $variation == '1-and-2') && ($browse_link || $browse_label))
                    @component('components.atoms._link')
                        @slot('font', 'f-secondary')
                        @slot('href', $browse_link)
                        @slot('variation', 'editorial-block__link')
                        {!! SmartyPants::defaultTransform($browse_label) !!} <svg class="icon--arrow"><use xlink:href="#icon--arrow"></use></svg>
                    @endcomponent
                    @break
                @default
            @endswitch
        </div>
        <div class="editorial-block__body">
            {!! $body !!}
        </div>
        @switch(true)
            @case(($theme == 'editorial'))
                @component('components.atoms._link')
                    @slot('font', 'f-secondary')
                    @slot('href', "https://www.youtube.com/user/ArtInstituteChicago")
                    @slot('variation', 'editorial-block__link')
                    Browse our YouTube channel <svg class="icon--new-window"><use xlink:href="#icon--new-window"></use></svg>
                @endcomponent
                @break

            @case(($theme == 'educator-resources'))


                @break

            @default
                <div class="editorial-block__tags">
                    @foreach ($tags as $tag)
                        <a class="tag f-tag" href="{{ route('articles', ['category' => $tag->id]) }}">{{ $tag->name }}</a>
                    @endforeach
                </div>
        @endswitch
    </div>

    <div class="editorial-block__content">
        <div class="editorial-block__content-wrapper">
        @switch(true)
            @case($variation !== 'video' && $variation !== 'quick-look' && $block->children->isEmpty())
                @foreach ($stories as $item)
                    @php
                        $hasFeatured = ($variation !== '3-across' && $variation !== '4-across');
                        $isFeatured = $loop->first && $hasFeatured;
                    @endphp
                    {!! (($loop->iteration == 2 && $hasFeatured) || ($loop->first && !$hasFeatured)) ? '<div class="editorial-block__list">' : '' !!}
                    {!! (($isFeatured) ? '<div class="editorial-block__featured">' : '') !!}
                    @component('components.molecules._m-listing----stories-listing')
                        @slot('variation', $variation)
                        @slot('showDescription', $isFeatured || $variation == '1-and-2')
                        @slot('isFeatured', $isFeatured)
                        @slot('item', $item)
                        @slot('fullscreen', false)
                        @slot('titleFont', ($isFeatured) ? 'f-list-3' : 'f-list-1')
                        @slot('imageSettings', array(
                            'srcset' => array(300,600,800,1200,1600),
                            'sizes' => ImageHelpers::aic_imageSizes(array(
                                  'xsmall' => '58',
                                  'small' => '58',
                                  'medium' => '38',
                                  'large' => '28',
                                  'xlarge' => '28',
                            )),
                        ))
                    @endcomponent
                    {!! ($loop->first && $hasFeatured) || $loop->last ? '</div>' : '' !!}
                @endforeach
                @break

            @case($variation == 'video')
                @if ($theme == 'educator-resources')
                    @foreach ($videos as $item)
                        @if ($item->has_media_content)
                            @component('components.molecules._m-listing----media')
                                @slot('item', $item)
                                @slot('fullscreen', true)
                                @slot('variation', 'editorial-block__video')
                                @slot('playIconSize', '64')
                                @slot('titleFont', 'f-list-1')
                                @slot('hideImage', false)
                                @slot('hideDescription', false)
                                @slot('hideDuration', false)
                                @slot('imageSettings', array(
                                    'srcset' => array(300,600,800,1200,1600),
                                    'sizes' => ImageHelpers::aic_imageSizes(array(
                                        'xsmall' => '58',
                                        'small' => '58',
                                        'medium' => '38',
                                        'large' => '28',
                                        'xlarge' => '28',
                                    )),
                                ))
                            @endcomponent
                        @else
                            @component('components.molecules._m-listing----stories-listing')
                                @slot('variation', 'm-listing editorial-block__video')
                                @slot('showDescription', false)
                                @slot('isFeatured', false)
                                @slot('item', $item)
                                @slot('fullscreen', false)
                                @slot('titleFont', 'f-list-1')
                                @slot('imageSettings', array(
                                    'srcset' => array(300,600,800,1200,1600),
                                    'sizes' => ImageHelpers::aic_imageSizes(array(
                                        'xsmall' => '58',
                                        'small' => '58',
                                        'medium' => '38',
                                        'large' => '28',
                                        'xlarge' => '28',
                                    )),
                                ))
                            @endcomponent
                        @endif
                    @endforeach
                @else
                    @foreach ($videos as $item)
                        @component('components.molecules._m-listing----media')
                            @slot('item', $item)
                            @slot('fullscreen', true)
                            @slot('variation', 'editorial-block__video')
                            @slot('playIconSize', '64')
                            @slot('titleFont', 'f-list-1')
                            @slot('hideImage', false)
                            @slot('hideDescription', false)
                            @slot('hideDuration', false)
                            @slot('imageSettings', array(
                                'srcset' => array(300,600,800,1200,1600),
                                'sizes' => ImageHelpers::aic_imageSizes(array(
                                    'xsmall' => '58',
                                    'small' => '58',
                                    'medium' => '38',
                                    'large' => '28',
                                    'xlarge' => '28',
                                )),
                            ))
                        @endcomponent
                    @endforeach
                @endif
                @break

            @case($variation == 'quick-look')
                @component('components.molecules._m-editorial-block----quick-look')
                    @slot('items', $block->getRelated('featured_items'))
                    @slot('listItems', $block->getRelated('list_items'))
                    @slot('listTitle', $block->present()->input('list_title'))
                    @slot('hideListCount', ($landingPageType == 'educator-resources') ? true : false)
                    @slot('hideListTag', ($landingPageType == 'educator-resources') ? true : false)
                @endcomponent
                @break

            @default
                @foreach ($stories as $item)
                    @php
                        $hasFeatured = ($variation !== '3-across' && $variation !== '4-across');
                    @endphp
                    {!! (($loop->iteration == 2 && $hasFeatured) || ($loop->first && !$hasFeatured)) ? '<div class="editorial-block__list">' : '' !!}
                    {!! (($loop->first && $hasFeatured) ? '<div class="editorial-block__featured">' : '') !!}
                    @component('components.molecules._m-listing----stories-custom-listing')
                        @slot('isFeatured', $loop->first && $hasFeatured)
                        @slot('item', $item)
                        @slot('fullscreen', false)
                        @slot('titleFont', ($loop->first && $hasFeatured) ? 'f-list-3' : 'f-list-1')
                        @slot('imageSettings', array(
                            'srcset' => array(300,600,800,1200,1600),
                            'sizes' => ImageHelpers::aic_imageSizes(array(
                                'xsmall' => '58',
                                'small' => '58',
                                'medium' => '38',
                                'large' => '28',
                                'xlarge' => '28',
                            )),
                        ))
                    @endcomponent
                    {!! ($loop->first && $hasFeatured) || $loop->last ? '</div>' : '' !!}
                @endforeach
        @endswitch
        </div>
    </div>

    @switch($variation)
        @case('video')
            </div>
            @break
        @default
    @endswitch
</div>
