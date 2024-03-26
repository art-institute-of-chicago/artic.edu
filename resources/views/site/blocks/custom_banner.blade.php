@php

    $bg_type = $block->input('background_type');
    $btn_type = $block->input('button_type');

    $categories = collect($block->input('categories'))->take(12);
    $tags = \App\Models\Category::whereIn('id', $categories)->get();

    $link_label = $block->input('link_label');
    $link_url = $block->input('link_label');

    $heading = $block->input('title');
    $body = $block->input('body');

    $theme = $block->input('theme');
    $variation = $block->input('variation');

@endphp
<div class="m-custom-banner-block {{ $theme ? 'custom-banner-block--'.$theme : '' }} {{ $variation ? 'custom-banner-block--variation-'.$variation : '' }}">
    <span class="hr"></span>
    <div class="content-wrapper">
        <div class="background-wrapper">
            @if($bg_type == 'background_color')
                <div class="background_color" {{ $block->input('bgcolor') ? 'style="background-color: ' . $block->input('bgcolor') . '"' : '' }}></div>
            @endif

            @if($bg_type == 'background_image')
                @component('components.atoms._img')
                    @slot('image', $block->imageAsArray('image', 'desktop'))
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
            @endif
        </div>

        <div class="text-wrapper">
            <div>
                @component('components.atoms._title')
                    @slot('font', 'f-headline-editorial')
                    @slot('variation', 'custom-banner-title')
                    @slot('title', $heading)
                @endcomponent

                @component('components.atoms._title')
                    @slot('font', 'f-secondary')
                    @slot('variation', 'custom-banner-body')
                    @slot('title', $body)
                @endcomponent
            </div>
            <div class="button-wrapper">
                @if ($variation == 'cloud')
                    <div class="tag-cloud">
                        @foreach ($tags as $tag)
                            <a class="tag f-tag" href="{{ route('articles', ['category' => $tag->id]) }}">{{ $tag->name }}</a>                    
                        @endforeach
                    </div>
                    @if ($link_label && $link_url)
                        <a class="tag-cloud__link f-tag" href="{{ $link_url }}">{{ $link_label }}
                            <svg class='icon--arrow'><use xlink:href='#icon--arrow'></use></svg>
                        </a>
                    @endif
                @else
                    @if($btn_type == 'mobile_app')
                        <div class="banner-apps">
                            <a class="app-store" target=”_blank” href="https://apps.apple.com/us/app/art-institute-of-chicago-app/id1130366814?itsct=apps_box_badge&amp;itscg=30200"><img src="{{FrontendHelpers::revAsset('images/icon_app-store.svg')}}" alt="Download on the App Store"></a>
                            <a class="google-play" target=”_blank” href='https://play.google.com/store/apps/details?id=edu.artic&hl=en_US&gl=US&pcampaignid=pcampaignidMKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1'><img alt='Get it on Google Play' src="{{FrontendHelpers::revAsset('images/icon_google-play.svg')}}"/></a>
                        </div>
                    @endif
                    @if($btn_type == 'custom')
                        @component('components.atoms._btn')
                            @slot('variation', 'primary')
                            @slot('tag', 'a')
                            @slot('href', $block->input('button_url'))
                            {!! SmartyPants::defaultTransform($block->input('button_text')) !!}
                        @endcomponent
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
