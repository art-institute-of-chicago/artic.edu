@extends('twill::layouts.form')

@section('contentFields')
    <x-twill::input
        name='datahub_id'
        label='Datahub ID'
        disabled='true'
    />

    <x-twill::medias
        name='hero'
        label='Hero Image'
        note='Minimum image width 2000px'
    />

    <x-twill::wysiwyg
        name='caption'
        label='Caption'
        :toolbar-options="[ 'italic', 'link' ]"
    />

    <x-twill::input
        name='birth_date'
        label='Birth Date'
        disabled='true'
    />

    <x-twill::input
        name='death_date'
        label='Death Date'
        disabled='true'
    />

    <x-twill::wysiwyg
        name='intro'
        label='Intro'
        :toolbar-options="[ 'italic', 'link', 'strike' ]"
    />
@stop

@section('fieldsets')
    <a17-fieldset id="related" title="Related">
        <p>These fields will be used for the homepage carousel.</p>

        <x-twill::medias
            name='carousel'
            label='Carousel Image'
            note='If left blank, hero image will be used instead'
        />

        <x-twill::input
            name='short_name_caption'
            label='Short name qualifier'
            note='Override default of "{{ $item->getApiModelFilledCached()->short_name_qualifer }}"'
        />

        <x-twill::input
            name='short_name_display'
            label='Short name'
            note='Override default of "{{ $item->getApiModelFilledCached()->short_name }}"'
        />
    </a17-fieldset>

    <a17-fieldset id="related" title="Related">

        <p>Use "Custom related items" to relate as many items as possible. No more than 12 will be shown on the artist's detail page, but all of them will be used to augment search. See special note on exhibitions below.</p>

        <x-twill::browser
            name='related_items'
            label='Custom related items'
            :max='1000'
            :modules="[
                [
                    'label' => 'Articles',
                    'value' => '/collection/articlesPublications/articles/browser'
                ],
                [
                    'label' => 'Digital Publications',
                    'value' => '/collection/articlesPublications/digitalPublications/browser'
                ],
                [
                    'label' => 'Print Publications',
                    'value' => '/collection/articlesPublications/printedPublications/browser'
                ],
                [
                    'label' => 'Educational Resources',
                    'value' => '/collection/researchResources/educatorResources/browser'
                ],
                [
                    'label' => 'Interactive Features',
                    'value' => '/collection/interactiveFeatures/experiences/browser'
                ],
                [
                    'label' => 'Videos',
                    'value' => '/collection/articlesPublications/videos/browser'
                ],
                [
                    'label' => 'Exhibitions',
                    'value' => '/exhibitionsEvents/exhibitions/browser'
                ],
            ]"
        />

        <p>We use CITI data to determine which exhibitions are related to each artist by checking which artworks were featured in each exhibition. We automatically append any exhibition related in this way to the "Related Content" section in reverse chronological order. The following exhibitions would be shown on this artist's page automatically:</p>

        @php
            $apiItem = $item->getApiModelFilled();
            $relatedExhibitions = (new \App\Repositories\Api\ArtistRepository($apiItem))->getApiRelatedItems($apiItem)
        @endphp
        <ol style="margin: 1em 0; padding-left: 40px">
            @foreach($relatedExhibitions as $exhibition)
                <li style="list-style-type: decimal; margin-bottom: 0.5em">
                    <a href="{!! route('exhibitions.show', $exhibition) !!}">{{ $exhibition->title }}</a>
                </li>
            @endforeach
        </ol>

        <p style="margin-top: 1em">If this logic is satisfactory, there's no need to add exhibitions to the "Custom related items" field. However, if you'd like to control the order of exhibitions relative to other related content, feel free to add them using the field above. If you'd like to ensure that certain exhibitions never show up on this artist's detail page, use the following field:</p>

        <x-twill::browser
            name='hidden_related_items'
            label='Suppressed related items'
            :max='1000'
            :modules="[
                [
                    'label' => 'Exhibition',
                    'value' => '/exhibitionsEvents/exhibitions/browser'
                ],
                [
                    'label' => 'Videos',
                    'value' => '/collection/articlesPublications/videos/browser'
                ],
            ]"
        />

    </a17-fieldset>

    @include('twill.partials.meta')

@endsection
