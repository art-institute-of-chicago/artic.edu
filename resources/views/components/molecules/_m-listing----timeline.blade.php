<{{ $tag ?? 'li' }} class="m-listing m-listing--keyline-top{{ (isset($variation)) ? ' '.$variation : '' }}">
<div class="m-listing__meta">
    @component('components.atoms._date')
        @slot('tag','p')
        {{ $item->time }}
    @endcomponent
    @component('components.atoms._title')
        @slot('tag','h4')
        @slot('font','f-list-3')
        {{ $item->title }}
    @endcomponent
    <p class="f-body">{{ $item->blurb }}</p>
</div>
@if ($item->image)
<div class="m-listing__img">
    @component('components.atoms._img')
        @slot('src', $item->image['src'])
        @slot('width', $item->image['width'])
        @slot('height', $item->image['height'])
    @endcomponent
</div>
@endif
</{{ $tag ?? 'li' }}>
