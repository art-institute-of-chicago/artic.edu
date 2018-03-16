<div id="modal-promo" class="g-modal g-modal--promo{{ $modal['image'] ? ' g-modal--image' : '' }}">
    <div class="g-modal__content">
        @if ( $modal['image'] )
            <figure class="g-modal__image">
                @component('components.atoms._img')
                    @slot('image', $modal['image'])
                    @slot('settings', array(
                        'lazyload' => false,
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
            <h3 class="g-modal__title">{{ $modal['title'] }}</h3>
            <p class="g-modal__intro">{{ $modal['intro'] }}</p>

            <form action="" class="g-modal__form">
                <div class="g-modal__form-row g-modal__form-row--split">
                    <p>
                        @component('components.atoms._input')
                            @slot('id', 'modal_first_name')
                            @slot('name', 'modal_first_name')
                            First name
                        @endcomponent
                    </p>

                    <p>
                        @component('components.atoms._input')
                            @slot('id', 'modal_last_name')
                            @slot('name', 'modal_last_name')
                            Last name
                        @endcomponent
                    </p>
                </div>

                <div class="g-modal__form-row">
                    <p>
                        @component('components.atoms._input')
                            @slot('id', 'modal_email')
                            @slot('name', 'modal_email')
                            Email address
                        @endcomponent
                    </p>
                </div>

                <div class="g-modal__form-row g-modal__form-row--submit">
                    @component('components.atoms._btn')
                        Join Now
                    @endcomponent
                </div>

                <p class="g-modal__form-note">By joining you agree to the <a href="#">Terms and Conditions</a></p>
            </form>

            <button class="g-modal__close" data-behavior="closeRoadblock">
                <svg aria-hidden="true" class="icon--close"><use xlink:href="#icon--close" /></svg>
            </button>
        </div>
    </div>
</div>
