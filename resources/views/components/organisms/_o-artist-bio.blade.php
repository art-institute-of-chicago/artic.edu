<section class="o-artist-bio">
    <div class="o-artist-bio__inner">
        @if ($item->imageFront('hero'))
            <figure class="o-artist-bio__image">
                @component('components.atoms._img')
                    @slot('image', $item->imageFront('hero'))
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
                @if ($item->caption)
                <figcaption>
                    {!! $item->caption !!}
                </figcaption>
                @endif
            </figure>
        @endif

        <div class="o-artist-bio__main">
            @if ($item->also_known_as or $item->birth_date or $item->death_date)
                <dl>
                    @if ($item->also_known_as)
                        <dt>Also known as</dt>
                        <dd itemprop="additionalName">{{ $item->also_known_as }}</dd>
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

            @if (gettype($item->intro) === 'string' and $item->intro !== "")
                <div class="o-artist-bio__body o-blocks" itemprop="description">
                    {!! $item->intro !!}
                </div>
            @endif

            @if ($item->tags)
                <ul class="o-artist-bio__tags">
                    @foreach ($item->tags as $link)
                        <li>
                            @component('components.atoms._tag')
                                @slot('href', $link['href'])
                                {{ $link['label'] }}
                            @endcomponent
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</section>
