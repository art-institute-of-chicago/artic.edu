@section('contentFields')
    <x-twill::browser
        name='digitalPublications'
        label='Digital Publications'
        route-prefix='collection.articlesPublications'
        module-name='digitalPublications'
        :max='6'
    />

    <x-twill::browser
        name='printedPublications'
        label='Print Publications'
        route-prefix='collection.articlesPublications'
        module-name='printedPublications'
        :max='6'
    />

    <x-twill::input
        name='printed_publications_intro'
        label='Print Publications intro text'
        type='textarea'
    />
@stop
