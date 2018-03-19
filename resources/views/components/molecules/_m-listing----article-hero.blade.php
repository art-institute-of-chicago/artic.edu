<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}" data-behavior="blurMyBackground">
    <a href="{{ route('articles.show', $item) }}" class="m-listing__link">
        <span class="m-listing__img{{ (isset($imgVariation)) ? ' '.$imgVariation : '' }}" data-blur-img>
            @if ($item->videoFront)
                @component('components.atoms._video')
                    @slot('video', $item->videoFront)
                    @slot('autoplay', true)
                    @slot('loop', true)
                    @slot('muted', true)
                @endcomponent
            @elseif ($item->imageFront('hero'))
                @component('components.atoms._img')
                    @slot('image', $item->imageFront('hero'))
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
            @endif
            @if ($item->isVideo)
                <svg class="icon--play--48"><use xlink:href="#icon--play--48" /></svg>
            @endif
        </span>
        <span class="m-listing__meta" data-blur-clip-to>
            @component('components.atoms._title')
                @slot('font', $titleFont ?? 'f-list-3')
                {{ $item->title }}
            @endcomponent
            <br>
            <span class="intro {{ $captionFont ?? 'f-caption' }}">{{ $item->heading }}</span>
            <br>
            <span class="m-listing__meta-bottom">
                @component('components.atoms._type')
                    {{ $item->type }}
                @endcomponent
                <br>
                @if ($item->date)
                    @component('components.atoms._date')
                        {{ $item->date->format('F j, Y') }}
                    @endcomponent
                @endif
            </span>
        </span>
    </a>
</{{ $tag or 'li' }}>
