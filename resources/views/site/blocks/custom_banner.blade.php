@php
    $bgType = $block->input('background_type');
    $bgColor = $block->input('bgcolor');
    $btnType = $block->input('button_type');

    $heading = $block->input('heading');
    $title = $block->input('title');
    $body = $block->input('body');

    $theme = $block->input('theme');
    $variation = $block->input('variation');

@endphp
<div class="m-custom-banner-block {{ $theme ? 'custom-banner-block--'.$theme : '' }} {{ $variation ? 'custom-banner-block--variation-'.$variation : '' }}">
    <div class="content-wrapper">
        <div class="background-wrapper">
            @if($bgType == 'background_color')
                <div class="background_color" style="{{ $bgColor ? "background-color: $bgColor" : '' }}"></div>
            @endif

            @if($bgType == 'background_image')
                @component('components.atoms._img')
                    @slot('image', $block->imageAsArray('image', 'desktop'))
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
            @endif
        </div>

        <div class="text-wrapper">
            <div class="custom-banner-text">
                @if ($heading)
                    @component('components.atoms._title')
                        @slot('tag', 'h3')
                        @slot('id', Str::slug($heading))
                        @slot('font', 'f-tag')
                        @slot('variation', 'custom-banner-heading')
                        @slot('title', $heading)
                    @endcomponent
                @endif
                @component('components.atoms._title')
                    @slot('font', 'f-headline-editorial')
                    @slot('variation', 'custom-banner-title')
                    @slot('title', $title)
                @endcomponent

                @component('components.atoms._title')
                    @slot('font', 'f-secondary')
                    @slot('variation', 'custom-banner-body')
                    @slot('title', $body)
                @endcomponent
            </div>
            <div class="button-wrapper">
                @if($btnType == 'mobile_app')
                    <div class="banner-apps">
                        <a class="app-store" target=”_blank” href="https://apps.apple.com/us/app/art-institute-of-chicago-app/id1130366814?itsct=apps_box_badge&amp;itscg=30200"><img src="{{FrontendHelpers::revAsset('images/icon_app-store.svg')}}" alt="Download on the App Store"></a>
                        <a class="google-play" target=”_blank” href='https://play.google.com/store/apps/details?id=edu.artic&hl=en_US&gl=US&pcampaignid=pcampaignidMKT-Other-global-all-co-prtnr-py-PartBadge-Mar2515-1'><img alt='Get it on Google Play' src="{{FrontendHelpers::revAsset('images/icon_google-play.svg')}}"/></a>
                    </div>
                @endif
                @if($btnType == 'custom')
                    @component('components.atoms._btn')
                        @slot('variation', 'primary')
                        @slot('tag', 'a')
                        @slot('href', $block->input('button_url'))
                        {!! SmartyPants::defaultTransform($block->input('button_text')) !!}
                    @endcomponent
                    @if($block->input('second_button_url'))
                        @component('components.atoms._btn')
                            @slot('variation', 'primary')
                            @slot('tag', 'a')
                            @slot('href', $block->input('second_button_url'))
                            {!! SmartyPants::defaultTransform($block->input('second_button_text')) !!}
                        @endcomponent
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
