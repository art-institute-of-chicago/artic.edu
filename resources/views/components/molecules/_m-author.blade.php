<div class="m-author{{ (isset($editorial) and $editorial) ? ' m-author--editorial' : '' }}{{ (isset($variation)) ? ' '.$variation : '' }}">
    @if (isset($img))
        <div class="m-author__img">
            @component('components.atoms._img')
                @slot('src', $img['src'] ?? '')
                @slot('srcset', $img['srcset'] ?? '')
                @slot('sizes', $img['sizes'] ?? '')
                @slot('width', $img['width'] ?? '')
                @slot('height', $img['height'] ?? '')
            @endcomponent
        </div>
    @endif
    @component('components.blocks._text')
        @slot('font', 'f-secondary')
        @if (isset($name))
            @if (isset($link))
                <a href="{{ $link ?? '#' }}">{{ $name ?? '' }}</a>
            @else
                {{ $name ?? '' }}
            @endif
        @endif
        @if (isset($name) and isset($date))
        <br>
        @endif
        @if (isset($date))
            {{ $date ?? '' }}
        @endif
    @endcomponent
</div>
