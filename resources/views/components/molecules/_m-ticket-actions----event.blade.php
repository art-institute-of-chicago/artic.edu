<ul class="m-ticket-actions">
        <li class="m-ticket-actions__action">
            @component('components.atoms._btn')
                @slot('variation', 'btn--full')
                @if (isset($ticketLink) and $ticketLink)
                    @slot('tag', 'a')
                    @slot('href', $ticketLink)
                @endif
                {{ $buttonText ?? 'Buy tickets' }}
            @endcomponent
        </li>
    @if (isset($buttonCaption) and $buttonCaption)
        <li class="m-ticket-actions__inline-list">
            <div class="m-ticket-actions__inline-list-items f-secondary">
                {!! $buttonCaption !!}
            </div>
        </li>
    @endif
</ul>
