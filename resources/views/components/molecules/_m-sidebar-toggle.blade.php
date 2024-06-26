<div class="m-sidebar-toggle">
    <button data-behavior="showStickySidebar" aria-label="Show publication navigation">
        <svg class="icon--menu--24">
            <use xlink:href="#icon--menu--24" />
        </svg>
        @component('components.blocks._text')
            @slot('tag', 'span')
            @slot('font', 'f-list-1')
            Table of Contents
        @endcomponent
    </button>
</div>
