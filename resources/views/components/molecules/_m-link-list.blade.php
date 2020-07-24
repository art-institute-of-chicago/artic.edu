@if (isset($screenreaderTitle))
<h3 class="sr-only" id="{{ 'h-' .Str::slug($screenreaderTitle) }}">{{ $screenreaderTitle }}</h3>
@endif
  <ul class="m-link-list{{ (isset($variation)) ? ' '.$variation : '' }}"{!! isset($screenreaderTitle) ? ' aria-labelledby="h-' .Str::slug($screenreaderTitle) .'"' : '' !!}>
    @foreach ($links as $link)
        @component('components.molecules._m-link-list----item')
            @slot('link', $link)
            @slot('variation', $variation)
            @slot('font', $font)
            @slot('sublinkFont', $sublinkFont)
        @endcomponent
    @endforeach
</ul>
