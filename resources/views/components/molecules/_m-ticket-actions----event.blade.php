<h3 class="sr-only" id="h-ticket-actions">Admission actions</h3>
<ul class="m-ticket-actions" aria-labelledby="h-ticket-actions">
        <li class="m-ticket-actions__action m-ticket-actions__action--single-action">
            @component('components.atoms._btn')
                @slot('variation', 'btn--full')
                @slot('tag', 'a')
                @slot('href', $ticketLink ?? 'https://sales.artic.edu/')
                @slot('gtmAttributes', 'data-gtm-event="' . getUtf8Slug( $buttonText ?? 'Buy tickets') .'" data-gtm-action="' . ($eventName ?? '') . '" data-gtm-event-category="nav-cta-button"')
                {{ $buttonText ?? 'Buy tickets' }}
            @endcomponent
        </li>

    @if (isset($buttonCaption) and $buttonCaption)
        <li class="m-ticket-actions__inline-list">
            <div class="m-ticket-actions__inline-list-items f-caption">
                {!! $buttonCaption !!}
            </div>
        </li>
    @endif
</ul>
