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
        @if ($header_my_museum_tour_icons)
        <div class="my-museum-tour-header__icons">
            @if (in_array('mmt_icon_choose', $header_my_museum_tour_icons))
                <div>
                    <svg aria-hidden="true" class="icon--choose">
                        <use xlink:href="#icon--choose"></use>
                    </svg>
                    <div>
                        <h3>Choose your artworks</h3>
                        <p>Build a tour by adding up to six artworks</p>
                    </div>
                </div>
            @endif
            @if (in_array('mmt_icon_personalize', $header_my_museum_tour_icons))
                <div>
                    <svg aria-hidden="true" class="icon--personalize">
                        <use xlink:href="#icon--personalize"></use>
                    </svg>
                    <div>
                        <h3>Personalize</h3>
                        <p>Add a title to your tour and notes to the artworks you picked</p>
                    </div>
                </div>
            @endif
            @if (in_array('mmt_icon_finish', $header_my_museum_tour_icons))
                <div>
                    <svg aria-hidden="true" class="icon--finish">
                        <use xlink:href="#icon--finish"></use>
                    </svg>
                    <div>
                        <h3>Finish and Share</h3>
                        <p>View your one-of-a-kind tour on your phone or in print–and get ready to plan a museum visit!</p>
                    </div>
                </div>
            @endif
        </div>
        @endif
    </div>
</div>