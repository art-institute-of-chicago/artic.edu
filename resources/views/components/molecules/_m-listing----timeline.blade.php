<{{ $tag ?? 'li' }} class="m-listing m-listing--keyline-top{{ (isset($variation)) ? ' '.$variation : '' }}">
<div class="m-listing__meta">
    @component('components.atoms._date')
        @slot('tag','p')
        {{ $date->time }}
    @endcomponent
    @component('components.atoms._title')
        @slot('tag','h4')
        @slot('font','f-list-3')
        {{ $date->title }}
    @endcomponent
    <p class="f-body">{{ $date->blurb }}</p>
</div>
@if ($date->image)
<div class="m-listing__img">
    @component('components.atoms._img')
        @slot('src', $date->image['src'])
    @endcomponent
</div>
@endif
</{{ $tag ?? 'li' }}>
