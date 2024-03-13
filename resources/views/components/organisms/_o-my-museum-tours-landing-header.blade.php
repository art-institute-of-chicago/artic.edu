<div class="my-museum-tour-header-section">
    <div class="my-museum-tour-header-section__wrapper">
        <div class="my-museum-tour-header-section__info">
            <h1 class="mmt-title">My Museum Tour</h1>
            @if ($header_my_museum_tour_text)
                <span class="f-lead mmt-desc">{!!$header_my_museum_tour_text!!}</span>
            @endif
            <div class="mmt-btn">
            @if ($header_my_museum_tour_primary_button_link && $header_my_museum_tour_primary_button_label)
                <a href="{{$header_my_museum_tour_primary_button_link}}" class="btn btn--secondary f-buttons">{{$header_my_museum_tour_primary_button_label}}</a>
            @endif
            @if ($header_my_museum_tour_secondary_button_link && $header_my_museum_tour_secondary_button_label)
                <a href="{{$header_my_museum_tour_secondary_button_link}}" class="btn f-buttons primary">{{$header_my_museum_tour_secondary_button_label}}</a>
            @endif
            </div>
        </div>
        @component('components.atoms._img')
            @slot('image', $header_my_museum_tour_header_image)
            @slot('settings', $imageSettings ?? '')
            @slot('class', 'my-museum-tour-header-section__img')
        @endcomponent
        @if ($header_my_museum_tour_icon_choose_title || $header_my_museum_tour_icon_choose_desc || $header_my_museum_tour_icon_personalize_title || $header_my_museum_tour_icon_personalize_desc || $header_my_museum_tour_icon_finish_title || $header_my_museum_tour_icon_finish_desc)
        <div class="my-museum-tour-header__icons">
            @if ($header_my_museum_tour_icon_choose_title || $header_my_museum_tour_icon_choose_desc)
                <div>
                    <svg aria-hidden="true" class="icon--choose">
                        <use xlink:href="#icon--choose"></use>
                    </svg>
                    <div>
                        <h3>{{$header_my_museum_tour_icon_choose_title}}</h3>
                        <p>{{$header_my_museum_tour_icon_choose_desc}}</p>
                    </div>
                </div>
            @endif
            @if ($header_my_museum_tour_icon_personalize_title || $header_my_museum_tour_icon_personalize_desc)
                <div>
                    <svg aria-hidden="true" class="icon--personalize">
                        <use xlink:href="#icon--personalize"></use>
                    </svg>
                    <div>
                        <h3>{{$header_my_museum_tour_icon_personalize_title}}</h3>
                        <p>{{$header_my_museum_tour_icon_personalize_desc}}</p>
                    </div>
                </div>
            @endif
            @if ($header_my_museum_tour_icon_finish_title || $header_my_museum_tour_icon_finish_desc)
                <div>
                    <svg aria-hidden="true" class="icon--finish">
                        <use xlink:href="#icon--finish"></use>
                    </svg>
                    <div>
                        <h3>{{$header_my_museum_tour_icon_finish_title}}</h3>
                        <p>{{$header_my_museum_tour_icon_finish_desc}}</p>
                    </div>
                </div>
            @endif
        </div>
        @endif
    </div>
</div>