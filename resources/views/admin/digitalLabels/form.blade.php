@extends('twill::layouts.form')

@section('contentFields')
    <br/><h1><strong>iPad URL:</strong> {{ 'https' . $baseUrl . $item->slug . '/ipad'}}</h1>

    @formField('medias', [
        'with_multiple' => false,
        'label' => 'Image',
        'name' => 'hero',
        'note' => 'Minimum image width 3000px'
    ])
    @formField('input', [
        'label' => 'Subtitle',
        'name' => 'sub_title',
    ])

    @formField('radios', [
        'name' => 'grouping_background_color',
        'label' => 'Grouping Background Color',
        'default' => 'grey',
        'inline' => true,
        'options' => [
            [
                'value' => 'grey',
                'label' => 'Grey'
            ],
            [
                'value' => 'white',
                'label' => 'White'
            ],
        ]
    ])

    @php
        $colors = [
            [
                'value' => '#B50938',
                'label' => 'Grape #B50938'
            ],
            [
                'value' => '#083F6E',
                'label' => 'Blue #083F6E'
            ],
            [
                'value' => '#008085',
                'label' => 'Teal #008085'
            ],
            [
                'value' => '#C95100',
                'label' => 'Orange #C95100'
            ],
            [
                'value' => '#5B051C',
                'label' => 'Black Rose #5B051C'
            ],
            [
                'value' => '#86072A',
                'label' => 'Monarch #86072A'
            ],
            [
                'value' => '#B7384D',
                'label' => 'Brick Red #B7384D'
            ],
            [
                'value' => '#E2B2C0',
                'label' => 'Cavern Pink #E2B2C0'
            ],
            [
                'value' => '#3C345F',
                'label' => 'Martinique #3C345F'
            ],
            [
                'value' => '#80104E',
                'label' => 'Disco #80104E'
            ],
            [
                'value' => '#A3A0B1',
                'label' => 'Santas Gray #A3A0B1'
            ],
            [
                'value' => '#5D72B3',
                'label' => 'Blue Violet #5D72B3'
            ],
            [
                'value' => '#4D4D50',
                'label' => 'Cool Gray #4D4D50'
            ],
            [
                'value' => '#1B5656',
                'label' => 'Eden #1B5656'
            ],
            [
                'value' => '#459B47',
                'label' => 'Fruit Salad #459B47'
            ],
            [
                'value' => '#ADC1A8',
                'label' => 'Norway #ADC1A8'
            ],
            [
                'value' => '#EAA700',
                'label' => 'Corn #EAA700'
            ],
            [
                'value' => '#A08F70',
                'label' => 'Mongoose #A08F70'
            ],
            [
                'value' => '#7E746D',
                'label' => 'Warm Gray #7E746D'
            ],
        ];
    @endphp
    @formField('select', [
        'name' => 'color',
        'label' => 'Color',
        'placeholder' => 'Select a color',
        'options' => $colors
    ])

    @foreach($colors as $color)
        @component('twill::partials.form.utils._connected_fields', [
            'fieldName' => 'color',
            'fieldValues' => $color['value'],
        ])
            <div style="background-color: {{ $color['value'] }}; width: 30px; height: 30px; margin-top: 10px"></div>
        @endcomponent
    @endforeach
@stop