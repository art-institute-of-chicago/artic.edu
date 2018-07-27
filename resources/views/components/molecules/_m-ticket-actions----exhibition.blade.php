<ul class="m-ticket-actions">
    <li class="m-ticket-actions__action">
        @component('components.atoms._btn')
            @slot('variation', 'btn--full')
            @slot('tag', 'a')
            @slot('href', 'https://sales.artic.edu/')
            @slot('gtmAttributes', 'data-gtm-event="exhibition-buy-tickets" data-gtm-event-action="Exhibition" data-gtm-event-category="nav-cta-button"')
            Buy tickets
        @endcomponent
    </li>
    <li class="m-ticket-actions__action">
        @component('components.atoms._btn')
            @slot('variation', 'btn--secondary btn--full')
            @slot('tag', 'a')
            @slot('href', 'https://sales.artic.edu/memberships')
            @slot('gtmAttributes', 'data-gtm-event="exhibition-become-member" data-gtm-event-action="Exhibition" data-gtm-event-category="nav-cta-button"')
            Become a member
        @endcomponent
    </li>

    <li class="m-ticket-actions__inline-list">
        <div class="m-ticket-actions__inline-list-items f-caption">
            @if(isset($pricingAttendanceMessage) && !empty($pricingAttendanceMessage))
                {!! $pricingAttendanceMessage !!}
            @else
                Exhibitions are free with museum admission.
            @endif
        </div>
    </li>
</ul>
