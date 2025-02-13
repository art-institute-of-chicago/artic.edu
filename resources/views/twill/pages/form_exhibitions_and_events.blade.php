@section('contentFields')
    <x-twill::input
        name='exhibition_intro'
        label='Intro text'
    />
@stop


@section('fieldsets')

    <x-twill::formFieldset id="current" title="Current exhibitions">
        <x-twill::browser
            name='exhibitionsCurrent'
            label='Current exhibitions'
            note='Top 2 exhibitions will be featured'
            route-prefix='exhibitionsEvents'
            module-name='exhibitions'
            :max='24'
        />
    </x-twill::formFieldset>

    <x-twill::formFieldset id="upcoming" title="Upcoming exhibitions">
        <x-twill::browser
            name='exhibitionsUpcomingListing'
            label='Upcoming exhibitions'
            note='Top 2 exhibitions will be featured'
            route-prefix='exhibitionsEvents'
            module-name='exhibitions'
            :max='24'
        />
    </x-twill::formFieldset>

@endsection
