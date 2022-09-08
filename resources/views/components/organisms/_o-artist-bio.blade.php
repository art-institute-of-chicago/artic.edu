<section class="o-artist-bio{{isset($variation) ? ' o-'.$variation.'-bio' : ''}}">
    <div class="o-artist-bio__inner">
        @if ($item->imageFront('hero'))
            {{-- WEB-2241: This causes two `figure` blocks to be nested in each other --}}
            <figure class="o-artist-bio__image">
                {{-- Mimicking an image block here. --}}
                @component('components.molecules._m-media')
                    @slot('variation', 'o-blocks__block')
                    @slot('imageSettings', $imageSettings ?? '')
                    @slot('item', [
                        'type' => 'image',
                        'media' => $item->imageFront('hero'),
                    ])
                @endcomponent
                @if ($item->caption)
                <figcaption>
                    {!! $item->present()->caption !!}
                </figcaption>
                @endif
            </figure>
        @endif

        <div class="o-artist-bio__main">
            @if ($item->also_known_as or $item->birth_date or $item->death_date or $item->gender_title)
                <dl>
                    @if ($item->also_known_as)
                        <dt>Also known as</dt>
                        <dd itemprop="additionalName">{!! $item->present()->also_known_as !!}</dd>
                    @endif

                    @if ($item->gender_title && config('aic.show_artist_gender'))
                        <dt>Gender</dt>
                        <dd itemprop="gender">{!! $item->gender_title !!}</dd>
                    @endif

                    @if ($item->birth_date)
                        <dt>Date of birth</dt>
                        <dd><time datetime="{{ $item->birth_date }}" itemprop="birthDate">{{ $item->birth_date }}</time></dd>
                    @endif

                    @if ($item->death_date)
                        <dt>Date of death</dt>
                        <dd><time datetime="{{ $item->death_date }}" itemprop="deathDate">{{ $item->death_date }}</time></dd>
                    @endif
                </dl>
            @endif

            @if (gettype($item->present()->intro) === 'string' and $item->present()->intro !== "")
                <div class="o-artist-bio__body o-blocks" itemprop="description">
                    {!! $item->present()->intro !!}
                </div>
            @endif

            @if ($item->tags)
                <ul class="o-artist-bio__tags">
                    @foreach ($item->tags as $link)
                        <li>
                            @component('components.atoms._tag')
                                @slot('href', $link['href'])
                                {!! SmartyPants::defaultTransform($link['label']) !!}
                            @endcomponent
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</section>
