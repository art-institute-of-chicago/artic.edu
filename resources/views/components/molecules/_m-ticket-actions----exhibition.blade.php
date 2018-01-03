<ul class="m-ticket-actions">
    <li class="m-ticket-actions__action">
        @component('components.atoms._btn')
            @slot('variation', 'btn--full')
            @slot('tag', 'a')
            @slot('href', '#')
            Buy tickets
        @endcomponent
    </li>
    <li class="m-ticket-actions__action">
        @component('components.atoms._btn')
            @slot('variation', 'btn--secondary btn--full')
            @slot('tag', 'a')
            @slot('href', '#')
            Become a member
        @endcomponent
    </li>
    <li class="m-ticket-actions__note f-secondary">Exhibitions are free with museum admission.</li>
</ul>
