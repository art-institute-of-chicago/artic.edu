@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'content', 'label' => 'Content'],
        ['fieldset' => 'related_to', 'label' => 'Related'],
        ['fieldset' => 'metadata', 'label' => 'Metadata'],
    ]
])

@section('contentFields')
    <x-twill::input
        name='title'
        label='Title'
        disabled='true'
    />
    <x-twill::input
        name='title_display'
        label='Title formatting'
        note='Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    />

    <x-twill::formColumns>
        <x-slot:left>
            <img
                style="margin-top: 35px; width: 100%"
                src='{{ $item->thumbnail_url }}'
            />
        </x-slot:left>
        <x-slot:right>
            <x-twill::medias
                name='hero'
                label='Listing image'
            />
        </x-slot:right>
    </x-twill::formColumns>

    <x-twill::formColumns>
        <x-slot:left>
            <x-twill::input
                name='uploaded_at'
                label='Uploaded At'
                disabled='true'
                note="{{ $item->uploaded_at?->format('M j, Y') }}"
            />
        </x-slot:left>
        <x-slot:right>
            <x-twill::date-picker
                name='date'
                label='Display date'
                note='When was this video published?'
            />
        </x-slot:right>
    </x-twill::formColumns>

    <x-twill::input
        name='description'
        label='Description'
        type='textarea'
        disabled='true'
    />

    <x-twill::wysiwyg
        name='list_description'
        label='Listing description'
        note='Max 255 characters. Will be used in "Related Videos" and social media.'
        :maxlength='255'
        :toolbar-options="[ 'italic' ]"
    />

    <x-twill::wysiwyg
        name='heading'
        label='Heading'
        :toolbar-options="[ 'italic' ]"
    />

    @php
        $blocks = BlockHelpers::getBlocksForEditor([
            'paragraph', 'hr', 'artwork', 'split_block', 'quote', 'tour_stop', 'list', 'button', 'audio_player', 'membership_banner', 'mobile_app', 'artworks'
        ]);
    @endphp

    <x-twill::block-editor
        :blocks='$blocks'
    />
@stop

@section('fieldsets')

    <x-twill::formFieldset id="related_to" title="Related">
        <x-twill::multi-select
            name='videoCategories'
            label='Video Categories'
            placeholder='Select some video categories'
            unpack='true'
            :options="$videoCategoriesList"
        />

        <x-twill::checkbox
            name='is_listed'
            label='Show this video in Article listings'
        />
        <x-twill::formConnectedFields
            field-name='is_listed'
            :field-values='true'
            :keep-alive='true'
        >
            <x-twill::multi-select
                name='categories'
                label='Article Categories'
                placeholder='Select some article categories'
                unpack='true'
                :options="$articleCategoriesList"
            />
        </x-twill::formConnectedFields>

        <x-twill::browser
            name='related_videos'
            label='Related videos'
            route-prefix='collection.articlesPublications'
            module-name='videos'
            field-note="If this is left blank, we will show the four most recently published videos."
            :max='4'
        />

    </x-twill::formFieldset>

    <x-twill::formFieldset id="metadata" title="Overwrite default metadata (optional)">
        <x-twill::input
            name='meta_title'
            label='Metadata Title'
        />

        <x-twill::input
            name='meta_description'
            label='Metadata Description'
            type='textarea'
        />

        <x-twill::input
            name='search_tags'
            label='Internal Search Tags'
            type='textarea'
        />

    <p>Comma-separatated list of words or phrases. Don't worry about grammar or similar word variations. This field is intended to assist our internal search engine in finding your content. These tags will not be shown to website users and will have no effect on external search engines, e.g. Google.</p>

    </x-twill::formFieldset>

    @include('twill.partials.related')

@endsection

@section('sideFieldsets')
    <a17-fieldset title="YouTube" id="youtube">
        <x-twill::input
            name='youtube_id'
            label='YouTube ID'
            disabled='true'
        />
        <a href="{{ $item->video_url }}" target="_blank" rel="noopener noreferrer">🔗 YouTube</a>

        <x-twill::input
            name='uploaded_at'
            label='Uploaded At'
            disabled='true'
        />

        <x-twill::formColumns>
            <x-slot:left>
                <x-twill::input
                    name='duration'
                    label='Duration'
                    disabled='true'
                />
            </x-slot:left>
            <x-slot:right>
                <x-twill::input
                    name='format'
                    label='Format'
                    disabled='true'
                />
            </x-slot:right>
        </x-twill::formColumns>

        <x-twill::browser
            name='captions'
            label='Captions'
            note='Read-only'
            module-name='videos.captions'
            route-prefix='collection.articlesPublications'
            disabled='true'
            itemLabel=''
        />

        <x-twill::browser
            name='playlists'
            label='Playlists'
            note='Read-only'
            module-name='playlists'
            route-prefix='collection.articlesPublications'
            disabled='true'
            itemLabel=''
        />
    </a17-fieldset>
@endsection
