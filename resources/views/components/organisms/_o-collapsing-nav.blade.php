<div class="o-collapsing-nav" data-behavior="dropdown" data-dropdown-breakpoints="medium-">
    <button class="o-collapsing-nav__trigger f-secondary">{{ $title }}<svg class="icon--arrow"><use xlink:href="#icon--arrow" /></svg></button>
    @component('components.molecules._m-link-list')
        @slot('font', 'f-module-title-1')
        @slot('links', $links);
    @endcomponent
</div>
