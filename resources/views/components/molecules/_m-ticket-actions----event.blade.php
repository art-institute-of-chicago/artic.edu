<ul class="m-ticket-actions">
    @if (isset($ticketLink) and $ticketLink)
    <li class="m-ticket-actions__action">
        @component('components.atoms._btn')
            @slot('variation', 'btn--full')
            @slot('tag', 'a')
            @slot('href', $ticketLink)
            Buy tickets
        @endcomponent
    </li>
    @endif
    @if (isset($ticketPrices) and $ticketPrices)
    <li class="m-ticket-actions__inline-list">
        <ul class="m-ticket-actions__inline-list-items f-secondary">
            @foreach ($ticketPrices as $ticketPrice)
            <li class="m-ticket-actions__inline-list-item">{{ $ticketPrice['price'] }} {{ $ticketPrice['label'] }}</li>
            @endforeach
        </ul>
    </li>
    @endif
</ul>
