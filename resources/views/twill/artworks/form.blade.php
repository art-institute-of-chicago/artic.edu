@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'side_related', 'label' => 'Sidebar Related'],
        ['fieldset' => 'artwork_publications', 'label' => 'Publications'],
        ['fieldset' => 'artwork_exhibitions', 'label' => 'Exhibitions'],
        ['fieldset' => 'artwork_educator_resources', 'label' => 'Educator Resources'],
        ['fieldset' => 'artwork_multimedia', 'label' => 'Multimedia'],
        ['fieldset' => 'artwork_videos', 'label' => 'Videos'],
        ['fieldset' => 'metadata', 'label' => 'Metadata'],
        ['fieldset' => 'api', 'label' => 'Datahub fields'],
        ['fieldset' => '3dModel', 'label' => '3D Model'],
        ['fieldset' => 'high_res', 'label' => 'Hi-Res'],
    ]
])

@section('contentFields')
    {{-- This section will always be shown --}}
    <p>Artwork content is defined in CITI.</p>

    @if (auth()->user()->role->id == \App\Enums\UserRole::Admin->value ||
         auth()->user()->role->id == \App\Enums\UserRole::XDPublisher->value)
      <x-twill::input
          name='semantic_search_description'
          label='Semantic Search Description'
          type='textarea'
      />
    @endif
@stop

@section('fieldsets')

    <x-aic::featuredRelated
        :auto-related="$autoRelated" />

    <x-twill::formFieldset id="artwork_publications" title="Publications">
        <p>These publications are curated by hand. They are shown first, followed by any automatically related publications below.</p>

        <x-twill::browser
            name='artwork_publications'
            label='Publications'
            :max='12'
            :endpoints="[
                [
                    'label' => 'Digital Publication',
                    'value' => '/collection/articlesPublications/digitalPublications/browser'
                ],
                [
                    'label' => 'Digital Publication Article',
                    'value' => '/collection/articlesPublications/digitalPublicationsBrowser/articles/browser'
                ],
                [
                    'label' => 'Print Publication',
                    'value' => '/collection/articlesPublications/printedPublications/browser'
                ],
            ]"
        />

        <x-twill::checkbox
            name='toggle_autopublications'
            label='Suppress auto-related publications'
            default='false'
        />

        <br>

        <x-twill::formConnectedFields
            field-name='toggle_autopublications'
            :field-values="false"
            :render-for-blocks='false'
        >

            @if(collect($autoPublications ?? [])->isNotEmpty())
                <p>These publications are automatically related and will fill the section along with any of the above selected items.</p>

                <ol style="margin: 1em 0; padding-left: 40px">
                    @foreach($autoPublications as $publication)
                        <li style="list-style-type: decimal; margin-bottom: 0.5em">
                            @if(!empty($publication->admin_edit_url))
                                <a href="{{ $publication->admin_edit_url }}">{{ $publication->title }}</a>
                            @else
                                {{ $publication->title }}
                            @endif
                        </li>
                    @endforeach
                </ol>
            @endif

        </x-twill::formConnectedFields>
    </x-twill::formFieldset>

    <x-twill::formFieldset id="artwork_exhibitions" title="Exhibitions">
        <p>These exhibitions are curated by hand. They are shown first, followed by any automatically related exhibitions below.</p>

        <x-twill::browser
            name='artwork_exhibitions'
            label='Exhibitions'
            :max='12'
            :endpoints="[
                [
                    'label' => 'Exhibition',
                    'value' => '/exhibitionsEvents/exhibitions/browser'
                ],
            ]"
        />

        <x-twill::checkbox
            name='toggle_autoexhibitions'
            label='Suppress auto-related exhibitions'
            default='false'
        />

        <br>

        <x-twill::formConnectedFields
            field-name='toggle_autoexhibitions'
            :field-values="false"
            :render-for-blocks='false'
        >

            @if(collect($autoExhibitions ?? [])->isNotEmpty())
                <p>These exhibitions are automatically related and will fill the section along with any of the above selected items.</p>

                <ol style="margin: 1em 0; padding-left: 40px">
                    @foreach($autoExhibitions as $exhibition)
                        <li style="list-style-type: decimal; margin-bottom: 0.5em">
                            @if(!empty($exhibition->admin_edit_url))
                                <a href="{{ $exhibition->admin_edit_url }}">{{ $exhibition->title }}</a>
                            @else
                                {{ $exhibition->title }}
                            @endif
                        </li>
                    @endforeach
                </ol>
            @endif

        </x-twill::formConnectedFields>
    </x-twill::formFieldset>

    <x-twill::formFieldset id="artwork_educator_resources" title="Educator Resources">
        <p>These educator resources are curated by hand. They are shown first, followed by any automatically related educator resources below.</p>

        <x-twill::browser name='artwork_educator_resources' label='Educator Resources' route-prefix='collection' module-name='educatorResources' :max='12' />

        <x-twill::checkbox
            name='toggle_autoeducator_resources'
            label='Suppress auto-related educator resources'
            default='false'
        />

        <br>

        <x-twill::formConnectedFields
            field-name='toggle_autoeducator_resources'
            :field-values="false"
            :render-for-blocks='false'
        >

            @if(collect($autoEducatorResources ?? [])->isNotEmpty())
                <p>These educator resources are automatically related and will fill the section along with any of the above selected items.</p>

                <ol style="margin: 1em 0; padding-left: 40px">
                    @foreach($autoEducatorResources as $educatorResource)
                        <li style="list-style-type: decimal; margin-bottom: 0.5em">
                            @if(!empty($educatorResource->admin_edit_url))
                                <a href="{{ $educatorResource->admin_edit_url }}">{{ $educatorResource->title }}</a>
                            @else
                                {{ $educatorResource->title }}
                            @endif
                        </li>
                    @endforeach
                </ol>
            @endif

        </x-twill::formConnectedFields>
    </x-twill::formFieldset>

    <x-twill::formFieldset id="artwork_multimedia" title="Multimedia">
        <p>These interactive features, digital explorers, and layered image viewers are curated by hand and render as individual full-width sections on the artwork page, in the order selected here.</p>
        <p><strong>Note:</strong> layered image viewer blocks are <em>copied</em> onto this artwork when you save. Later edits to the original block will not propagate, and deleting the original will not affect this artwork.</p>

        <x-twill::browser
            name='artwork_multimedia'
            label='Multimedia'
            :max='12'
            :endpoints="[
                [
                    'label' => 'Interactive Feature',
                    'value' => '/collection/interactiveFeatures/experiences/browser'
                ],
                [
                    'label' => 'Digital Explorer',
                    'value' => '/collection/digitalExplorers/browser'
                ],
                [
                    'label' => 'Layered Image Viewer',
                    'value' => '/collection/artworks/layered-image-viewer-blocks/browser'
                ],
            ]"
        />
    </x-twill::formFieldset>

    {{-- AUDIO (not scaffolded yet): <x-twill::formFieldset id="artwork_audio" title="Audio"> … block editor limited to audio blocks … </x-twill::formFieldset> --}}

    <x-twill::formFieldset id="artwork_videos" title="Videos">
        <p>Videos added here render in a "Videos" section on the artwork page, in the order shown.</p>
        @php $videoBlocks = BlockHelpers::getBlocksForEditor(['video']); @endphp
        <x-twill::block-editor :blocks="$videoBlocks" />
    </x-twill::formFieldset>

    @include('twill.partials.meta')

    <x-twill::formFieldset id="api" title="Datahub fields">
        <x-twill::input
            name='datahub_id'
            label='Datahub ID'
            disabled='true'
        />
    </x-twill::formFieldset>

    <x-twill::formFieldset title="3D Object" id="3dModel">
        <a17-block-aic_3d_model name="aic_3d_model" :thumbnail="false" :caption="false" :browser="false" :cc0="false" />
    </x-twill::formFieldset>

    <x-twill::formFieldset title="Hi-Res" id="high_res">
        <p>This functionality is meant to support super-resolution images. It is a work-around for the 3000-pixel limit on images coming from our DAMS. If you upload an image here, it will replace the primary zoomable image for the artwork on the website.</p>

        <x-twill::medias
            name='iiif'
            label='Custom image'
            note='Minimum image width 3000px'
        />

        <x-twill::checkbox
            name='force_iiif_regenerate'
            label='Force tile regeneration'
            default='false'
        />

        <p>This checkbox is meant as a fail-safe. If for some reason, you see missing tiles when you zoom and pan around the deep-zoom viewer, check this option and re-publish. There's no need to use it under normal circumstances. Please note that it may take up to 10 minutes to generate tiles.</p>
    </x-twill::formFieldset>

    <x-twill::formFieldset id="360file" title="360 File">
        <x-twill::files
            name='image_sequence_file'
            label='Image Sequence Zip'
            note='Upload a .zip file'
        />
    </x-twill::formFieldset>

    <x-twill::formFieldset id="mirador" title="Mirador">
        <p>Add a Mirador modal to the artwork page by either checking the box below to use the default manifest file or uploading your own.</p>

        @php
            $note = 'i.e. ' . config('api.public_uri') . '/api/v1/artworks/' . $item->datahub_id . '/manifest.json';
        @endphp
        <x-twill::checkbox
            name='default_manifest_url'
            label='Use default manifest file.'
            :note="$note"
            default='false'
        />
        <x-twill::files
            name='upload_manifest_file'
            label='Alternative manifest file'
            note='Upload a .json file'
        />
        <x-twill::radios
            name='default_view'
            label='Default View'
            default='single'
            :inline='true'
            :options="[
                [
                    'value' => 'single',
                    'label' => 'Single'
                ],
                [
                    'value' => 'book',
                    'label' => 'Book'
                ]
            ]"
        />
    </x-twill::formFieldset>

    <x-twill::formFieldset id="website" title="Artwork website">
        <p>When the work of art is itself a website, enter its information here.</p>
        <x-twill::input
            name='artwork_website_url'
            label='Artwork website URL'
        />
    </x-twill::formFieldset>
@stop

@push('vuexStore')
    @php($model3d = $item->model3d)
    @foreach (['model_url', 'model_caption', 'model_id', 'camera_position', 'camera_target', 'annotation_list'] as $name)
        window['{{ config('twill.js_namespace') }}'].STORE.form.fields.push({
            name: "{{ 'aic_3d_model[' . $name . ']' }}",
            value: {!! json_encode($model3d ? $model3d->$name : '') !!}
        })
    @endforeach
@endpush
