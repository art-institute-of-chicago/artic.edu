<section class="o-artist-bio">
    <div class="o-artist-bio__inner">
        @if ($item->image)
            <figure class="o-artist-bio__image">
                @component('components.atoms._img')
                    @slot('image', $item->image)
                    @slot('settings', $imageSettings ?? '')
                @endcomponent
                @if (isset($item->caption))
                <figcaption>
                    {!! $item->caption !!}
                </figcaption>
                @endif
            </figure>
        @endif

        <div class="o-artist-bio__main">
            @if ($item->aka or $item->dob or $item->dod)
                <dl>
                    @if ($item->aka)
                        <dt>Also known as</dt>
                        <dd>{{ $item->aka }}</dd>
                    @endif

                    @if ($item->dob)
                        <dt>Date of birth</dt>
                        <dd>{{ date( 'F j, Y', $item->dob ) }}</dd>
                    @endif

                    @if ($item->dod)
                        <dt>Date of death</dt>
                        <dd>{{ date( 'F j, Y', $item->dod )  }}</dd>
                    @endif
                </dl>
            @endif

            @if ($item->blocks)
                <div class="o-artist-bio__body o-blocks">
                    @component('components.blocks._blocks')
                        @slot('blocks', $item->blocks ?? null)
                    @endcomponent
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
