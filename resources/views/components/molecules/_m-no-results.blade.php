<div class="m-no-results">
    @component('components.atoms._hr')
    @endcomponent
    @component('components.atoms._title')
        @slot('tag','h2')
        @slot('font', 'f-list-3')
        {{ $text ?? 'Sorry, we couldn\'t find any results matching your criteria.' }}
    @endcomponent
</div>
