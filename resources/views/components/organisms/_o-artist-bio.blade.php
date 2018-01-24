@if ( !empty( $bio ) )
    <section class="o-artist-bio">
        <div class="o-artist-bio__inner">
            @if ( !empty( $bio->image ) )
                <figure class="o-artist-bio__image">
                    @component('components.atoms._img')
                        @slot('src', $bio->image['src'])
                        @slot('srcset', $bio->image['srcset'])
                        @slot('width', $bio->image['width'])
                        @slot('height', $bio->image['height'])
                    @endcomponent

                    <figcaption>
                        {!! $bio->caption !!}
                    </figcaption>
                </figure>
            @endif

            <div class="o-artist-bio__main">
                @if ( !empty( $bio->data ) )
                    <dl>
                        @if ( !empty( $bio->data->aka ) )
                            <dt>Also known as</dt>
                            <dd>{{ $bio->data->aka }}</dd>
                        @endif

                        @if ( !empty( $bio->data->dob ) )
                            <dt>Date of birth</dt>
                            <dd>{{ date( 'F j, Y', $bio->data->dob ) }}</dd>
                        @endif

                        @if ( !empty( $bio->data->dod ) )
                            <dt>Date of death</dt>
                            <dd>{{ date( 'F j, Y', $bio->data->dod )  }}</dd>
                        @endif
                    </dl>
                @endif

                @if ( !empty( $bio->body ) )
                    <div class="o-artist-bio__body">
                        {!! $bio->body !!}
                    </div>
                @endif

                @if ( !empty( $bio->tags ) )
                    <div class="o-artist-bio__tags">
                        @foreach ($bio->tags as $tag)
                            @component('components.atoms._tag')
                                {{ $tag }}
                            @endcomponent
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </section>
@endif
