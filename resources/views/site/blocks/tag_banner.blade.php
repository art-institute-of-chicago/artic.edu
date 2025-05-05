@php
    $theme = $block->input('theme');
    $variation = $block->input('variation');
    $title = $block->input('title');
    $body = $block->input('body');
    if ($variation == 'categories') {
        $categories = collect($block->input('categories'))->take(12);
        $tags = \App\Models\Category::whereIn('id', $categories)->get()->transform(function ($category) {
            return (object) [
                'url' => route('articles', ['category' => $category->id]),
                'label' => $category->name,
            ];
        });
    } else {
        $tags = $block->repeater('link_tag');
    }
    $linkLabel = $block->input('link_label');
    $linkUrl = $block->input('link_url');
@endphp

<div class="m-tag-banner-block {{ $theme ? 'tag-banner-block--'.$theme : '' }} {{ $variation ? 'tag-banner-block--variation-'.$variation : '' }}">
    <div class="content-wrapper">
        <div class="background-wrapper"></div>
        <div class="body-wrapper">
            <div class="text-wrapper">
                @component('components.atoms._title')
                    @slot('font', 'f-headline-editorial')
                    @slot('variation', 'tag-banner-title')
                    @slot('title', $title)
                @endcomponent

                @component('components.atoms._title')
                    @slot('font', 'f-secondary')
                    @slot('variation', 'tag-banner-body')
                    @slot('title', $body)
                @endcomponent
            </div>
            <div class="tag-wrapper">
                @component('components.molecules._m-tag-banner')
                    @slot('tags', $tags)
                @endcomponent
                @if ($linkLabel && $linkUrl)
                    <a class="tag-banner-link f-tag" href="{{ $linkUrl }}">{{ $linkLabel }}
                        <svg class='icon--arrow'><use xlink:href='#icon--arrow'></use></svg>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
