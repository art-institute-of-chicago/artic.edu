<div id="modal-promo" class="g-modal g-modal--promo{{ $modal['image'] ? ' g-modal--image' : '' }}" data-expires="{{ $modal['expiry_period'] ?? 86400 }}">
    <div class="g-modal__content">
        @if ( $modal['image'] )
            <figure class="g-modal__image">
                @component('components.atoms._img')
                    @slot('image', $modal['image'])
                    @slot('settings', array(
                        'lazyload' => false,
                        'fit' => 'crop',
                        'ratio' => '3:4',
                        'srcset' => array(300,600,1000,1500),
                        'sizes' => aic_imageSizes(array(
                              'xsmall' => '0',
                              'small' => '0',
                              'medium' => '25',
                              'large' => '20',
                              'xlarge' => '20',
                        )),
                    ))
                @endcomponent
            </figure>
        @endif

        <div class="g-modal__main">
            <h3 class="g-modal__title f-display-1">{{ $modal['title'] }}</h3>
            <div class="g-modal__intro f-secondary">{!! $modal['intro'] !!}</div>

            <form class="g-modal__form" action="{{ $modal['action_url'] }}" method="post" enctype="multipart/form-data" accept-charset="UTF-8">
                <div class="g-modal__form-row g-modal__form-row--split">
                    <p>
                        @component('components.atoms._input')
                            @slot('id', 'edit-submitted-first-name')
                            @slot('name', 'submitted[first_name]')
                            First name
                        @endcomponent
                    </p>

                    <p>
                        @component('components.atoms._input')
                            @slot('id', 'edit-submitted-last-name')
                            @slot('name', 'submitted[last_name]')
                            Last name
                        @endcomponent
                    </p>
                </div>

                <div class="g-modal__form-row">
                    <p>
                        @component('components.atoms._email')
                            @slot('id', 'edit-submitted-mail')
                            @slot('name', 'submitted[mail]')
                            Email address
                        @endcomponent
                    </p>
                </div>

                <input type="hidden" name="submitted[tlcsource]" value="{{ $modal['form_tlc_source'] }}">
                <input type="hidden" name="form_token" value="{{ $modal['form_token'] }}">
                <input type="hidden" name="form_id" value="{{ $modal['form_id'] }}">

                <div class="g-modal__form-row g-modal__form-row--submit">
                    @component('components.atoms._btn')
                        {{ $modal['lightbox_button_text'] ?? 'Join Now' }}
                    @endcomponent
                </div>

                @if ($modal['terms_text'])
                    <div class="g-modal__form-note f-caption">
                        {!! $modal['terms_text'] !!}
                    </div>
                @endif
            </form>

            <button class="g-modal__close" data-behavior="closeRoadblock">
                <svg aria-hidden="true" class="icon--close"><use xlink:href="#icon--close" /></svg>
            </button>
        </div>
    </div>
</div>
