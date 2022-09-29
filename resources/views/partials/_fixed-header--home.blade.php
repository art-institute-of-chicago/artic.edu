@if ($mainFeatures->count() > 0)
    <div class="o-features">
        @component('components.organisms._o-feature')
            @slot('tag', 'div')
            @slot('item', $mainFeatures->first())
            @slot('isHero', true)
            @slot('gtmCount', 1)
        @endcomponent
    </div>
@endif

@if (!empty($hour))
    @component('components.organisms._o-hours')
        @slot('hour', $hour)
    @endcomponent
@endif

@if ($mainFeatures->count() > 1)
    <div class="o-features">
        @foreach ($mainFeatures->slice(1) as $key => $feature)
            @component('components.organisms._o-feature')
                @slot('tag', 'div')
                @slot('item', $feature)
                @slot('isHero', false)
                @slot('gtmCount', $key + 1)
            @endcomponent
        @endforeach
    </div>
@endif

@component('components.molecules._m-intro-block')
    @slot('links', array(
        array('label' => $visit_button_text, 'href' => $visit_button_url, 'variation' => 'btn', 'font' => 'f-buttons', 'gtmAttributes' => 'data-gtm-event="Visit" data-gtm-event-category="nav-cta-button"'),
        array('label' => SmartyPants::defaultTransform($plan_your_visit_link_1_text) .'<span aria-hidden="true">&nbsp;&nbsp;&rsaquo;</span>', 'href' => $plan_your_visit_link_1_url, 'gtmAttributes' => 'data-gtm-event="' . UrlHelpers::lastUrlSegment($plan_your_visit_link_1_url). '" data-gtm-event-category="nav-link"'),
        array('label' => SmartyPants::defaultTransform($plan_your_visit_link_2_text) .'<span aria-hidden="true">&nbsp;&nbsp;&rsaquo;</span>', 'href' => $plan_your_visit_link_2_url, 'gtmAttributes' => 'data-gtm-event="' . UrlHelpers::lastUrlSegment($plan_your_visit_link_2_url). '" data-gtm-event-category="nav-link"'),
        array('label' => SmartyPants::defaultTransform($plan_your_visit_link_3_text) .'<span aria-hidden="true">&nbsp;&nbsp;&rsaquo;</span>', 'href' => $plan_your_visit_link_3_url, 'gtmAttributes' => 'data-gtm-event="' . UrlHelpers::lastUrlSegment($plan_your_visit_link_3_url). '" data-gtm-event-category="nav-link"'),
    ))
    {!! SmartyPants::defaultTransform($intro) !!}
@endcomponent
