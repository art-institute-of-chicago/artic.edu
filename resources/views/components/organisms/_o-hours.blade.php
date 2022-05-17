<div class="o-hours f-secondary">
    <div class="o-hours__clock">
        <svg class="icon--clock" aria-hidden="true">
            <use xlink:href="#icon--clock"></use>
        </svg>
    </div>
    <div class="o-hours__text">
        <span>Open</span>
        <span>10–11 members | 11–5 public</span>
        @component('components.atoms._dropdown')
            @slot('variation', 'dropdown--filter')
            @slot('prompt', 'See all hours')
            @slot('ariaTitle', 'See all hours')
            <li>Lorem ipsum</li>
        @endcomponent
    </div>
</div>
