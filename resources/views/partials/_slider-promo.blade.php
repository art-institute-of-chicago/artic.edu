{{--
    Meant to be used inside <script type="text/template" class="g-slider--promo--template" data-geotarget="{{ $roadblock['geotarget'] }}"  data-expires="{{ $roadblock['expiry_period'] ?? 86400 }}"/>
    Adjust $roadblock['geotarget'] from $roadblock to whatever you need.
    Copy all attributes from the top-level div here into the actual promo modal container.
--}}
<div class="{{ ($modal['hide_fields'] ?? false) ? 'g-slider--promo--hide_fields' : '' }}">
    <div class="g-slider__content">
        <div class="g-slider__main">
            <h3 class="g-slider__title f-module-title-2">{{ $modal['title'] }}</h3>
            <div class="g-slider__intro f-list-2">{!! $modal['intro'] !!}</div>
        </div>

        <form class="g-slider__form" action="{{ $modal['action_url'] }}" method="post" enctype="multipart/form-data" accept-charset="UTF-8" target="_blank" data-gtm-event-category="lightbox" data-gtm-event-action="{{$seo->title}}" data-gtm-event="{{ $modal['lightbox_button_text'] ?? 'Join Now' }}">
            @if (!$modal['hide_fields'])
                <div class="g-slider__form-row">
                    <p>
                        @component('components.atoms._email')
                            @slot('id', 'edit-submitted-mail')
                            @slot('name', 'submitted[mail]')
                            @slot('required', 'required')
                            Email address
                        @endcomponent
                    </p>
                </div>
            @endif

            <input type="hidden" name="submitted[tlcsource]" id="edit-submitted-tlcsource" value="{{ $modal['form_tlc_source'] }}" >
            <input type="hidden" name="form_token" value="{{ $modal['form_token'] }}">
            <input type="hidden" name="form_id" value="{{ $modal['form_id'] }}">

            <div class="g-slider__form-row g-slider__form-row--submit">
                @component('components.atoms._btn')
                    {{ $modal['lightbox_button_text'] ?? 'Join Now' }}
                @endcomponent
            </div>

        </form>

        <button class="g-slider__close" data-behavior="closeRoadblock">
            <svg aria-hidden="true" class="icon--close" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"><path fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="1.5" d="M3 3l10 10M13 3L3 13"></path></svg>
        </button>
    </div>
</div>
