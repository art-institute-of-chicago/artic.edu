<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{{ $item->slug }}" class="m-listing__link">
        @if ($item->imageFront())
        <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '  m-listing__img--square' }}">
            @if ($item->videoFront)
                @component('components.atoms._video')
                    @slot('video', $item->videoFront)
                    @slot('autoplay', true)
                    @slot('loop', true)
                    @slot('muted', true)
                @endcomponent
            @elseif ($item->imageFront())
                @component('components.atoms._img')
                    @slot('image', $item->imageFront())
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
            @endif
        </span>
        @endif
        <span class="m-listing__meta">
            @component('components.atoms._title')
                @slot('font', $titleFont ?? 'f-list-3')
                {{ $item->title }}
            @endcomponent
            @if ($item->nationality or $item->dob or $item->dod)
            <br>
            <span class="intro {{ $captionFont ?? 'f-secondary' }}">
                @if ($item->nationality)
                    {{ $item->nationality }},
                @endif
                @if ($item->dob)
                    {{ date( 'Y', $item->dob ) }}
                @endif
                @if ($item->dob and $item->dod)
                    {{ ' - ' }}
                @endif
                @if ($item->dod)
                    {{ date( 'Y', $item->dod ) }}
                @endif
            </span>
            @endif
        </span>
    </a>
</{{ $tag or 'li' }}>
