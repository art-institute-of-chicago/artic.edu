<ul class="m-ticket-actions">
    @if (isset($ticketLink) and $ticketLink)
        <li class="m-ticket-actions__action m-ticket-actions__action--single-action">
            @component('components.atoms._btn')
                @slot('variation', 'btn--full')
                @slot('tag', 'a')
                @slot('href', $ticketLink)
                @slot('gtmAttributes', 'data-gtm-event="event-buy-tickets" data-gtm-event-category="nav-cta-button"')
                {{ $buttonText ?? 'Buy tickets' }}
            @endcomponent
        </li>
    @endif
    @if (isset($buttonCaption) and $buttonCaption)
        <li class="m-ticket-actions__inline-list">
            <div class="m-ticket-actions__inline-list-items f-caption">
                {!! $buttonCaption !!}
            </div>
        </li>
    @endif
</ul>
