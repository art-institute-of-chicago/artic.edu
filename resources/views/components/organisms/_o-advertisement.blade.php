@if($advertisement)
    <div class="o-advertisement" >
        <div class="o-advertisement__image">
            @component('components.atoms._img')
                @slot('image', $advertisement->imageAsArray('hero'))
                @slot('settings', [
                        'srcset' => ImageHelpers::SRCSET_WIDTHS_LARGE,
                        'sizes' => ImageHelpers::aic_imageSizes([
                            'xsmall' => '58',
                            'small'  => '28',
                            'medium' => '28',
                            'large'  => '28',
                            'xlarge' => '21',
                    ]),
                ])
            @endcomponent
        </div>
        <div class="o-advertisement__text">
            @component('components.atoms._title')
                @slot('tag', 'h3')
                @slot('title', $advertisement->header)
            @endcomponent
            <div class="description">
                {!! $advertisement->description !!}
            </div>
            <div class="button">
                @component('components.atoms._btn')
                    @slot('tag', 'a')
                    @slot('href', $advertisement->destination_url)
                    {{ $advertisement->destination_label }}
                @endcomponent
            </div>
        </div>
    </div>
@endif
