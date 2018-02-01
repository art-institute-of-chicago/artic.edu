@if ( isset($bio) )
    <section class="o-artist-bio">
        <div class="o-artist-bio__inner">
            @if ( isset( $bio['image'] ) )
                <figure class="o-artist-bio__image">
                    @component('components.atoms._img')
                        @slot('src', $bio['image']['src'])
                        @slot('srcset', $bio['image']['srcset'])
                        @slot('width', $bio['image']['width'])
                        @slot('height', $bio['image']['height'])
                    @endcomponent
                    @if (isset($bio['caption']))
                    <figcaption>
                        {!! $bio['caption'] !!}
                    </figcaption>
                    @endif
                </figure>
            @endif

            <div class="o-artist-bio__main">
                @if ( isset( $bio['data'] ) )
                    <dl>
                        @if ( isset( $bio['data']['aka'] ) )
                            <dt>Also known as</dt>
                            <dd>{{ $bio['data']['aka'] }}</dd>
                        @endif

                        @if ( isset( $bio['data']['dob'] ) )
                            <dt>Date of birth</dt>
                            <dd>{{ date( 'F j, Y', $bio['data']['dob'] ) }}</dd>
                        @endif

                        @if ( isset( $bio['data']['dod'] ) )
                            <dt>Date of death</dt>
                            <dd>{{ date( 'F j, Y', $bio['data']['dod'] )  }}</dd>
                        @endif
                    </dl>
                @endif

                @if ( isset( $bio['body'] ) )
                    <div class="o-artist-bio__body o-blocks">
                        @component('components.blocks._blocks')
                            @slot('blocks', $bio['body'] ?? null)
                        @endcomponent
                    </div>
                @endif

                @if ( isset( $bio['tags'] ) )
                    <ul class="o-artist-bio__tags">
                        @foreach ($bio['tags'] as $link)
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
@endif
