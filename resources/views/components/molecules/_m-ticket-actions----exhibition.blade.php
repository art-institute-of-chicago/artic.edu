<h3 class="sr-only" id="h-ticket-actions">Admission actions</h3>
<ul class="m-ticket-actions" aria-labelledby="h-ticket-actions">
    <li class="m-ticket-actions__action">
        @component('components.atoms._btn')
            @slot('variation', 'btn--full')
            @slot('tag', 'a')
            @slot('href', 'https://sales.artic.edu/admissions')
            @slot('gtmAttributes', 'data-gtm-event="buy-tickets" data-gtm-event-category="nav-cta-button"')
            Buy tickets
        @endcomponent
    </li>
    <li class="m-ticket-actions__action">
        @component('components.atoms._btn')
            @slot('variation', 'btn--secondary btn--full')
            @slot('tag', 'a')
            @slot('href', 'https://sales.artic.edu/memberships')
            @slot('gtmAttributes', 'data-gtm-event="become-a-member" data-gtm-event-category="nav-cta-button"')
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
