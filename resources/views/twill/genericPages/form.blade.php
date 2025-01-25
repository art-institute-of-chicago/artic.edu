@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'hours', 'label' => 'Hours'],
        ['fieldset' => 'side_related', 'label' => 'Sidebar Related'],
        ['fieldset' => 'sponsors', 'label' => 'Sponsors'],
        ['fieldset' => 'metadata', 'label' => 'Metadata'],
    ]
])

@section('contentFields')
    <x-twill::input
        name='title_display'
        label='Title formatting (optional)'
        note='Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    />

    <x-twill::medias
        name='banner'
        label='Banner image'
        note='Minimum image width 2000px'
    />

    <x-twill::medias
        name='listing'
        label='Listing image'
        note='Minimum image width 3000px'
    />

    <x-twill::wysiwyg
        name='listing_description'
        label='Listing description'
        note='Max 255 characters'
        :maxlength="255"
        :toolbar-options="[ 'italic' ]"
    />

    <x-twill::wysiwyg
        name='short_description'
        label='Short description'
        note='Max 255 characters'
        :maxlength='255'
        :toolbar-options="[ 'italic' ]"
    />

    <x-twill::multi-select
        name='categories'
        label='Categories'
        placeholder='Select some categories'
        unpack='true'
        :options="$categoriesList"
    />

    <x-twill::input
        name='redirect_url'
        label='Redirect URL'
    />

    <x-twill::checkbox
        name='is_redirect_url_external'
        label='Is Redirect URL external?'
    />

    <x-twill::checkbox
        name='http_protected'
        label='Authentication required?'
    />

    @php
        $blocks = BlockHelpers::getBlocksForEditor([
            'paragraph', 'image', 'hr', 'artwork', 'split_block', 'gallery_new', 'link', 'video', 'tour_stop', 'accordion', 'ranged_accordion', 'media_embed', 'list', 'timeline', 'child_pages', 'grid', 'button', 'newsletter_signup_inline', 'table', 'audio_player', 'vtour_embed', 'mirador_embed', 'custom_banner', 'search_bar', 'membership_banner', '3d_model', 'mobile_app', 'mirador_modal'
        ]);
    @endphp

    <x-twill::block-editor
        :blocks='$blocks'
    />
@stop

@section('fieldsets')
    <x-twill::formFieldset id="hours" title="Hours">
        <x-twill::checkbox
            name='show_hours'
            label='Select to display museum hours on the page'
        />

        <p>The page must have a banner image in order to display museum hours.</p>
    </x-twill::formFieldset>

    @component('twill.partials.featured-related', ['form_fields' => $form_fields, 'autoRelated' => $autoRelated])
        @slot('routePrefix', 'generic')
        @slot('moduleName', 'genericPages')
    @endcomponent

    <x-twill::formFieldset id="sponsors" title="Sponsors">
        <x-twill::browser
            name='sponsors'
            label='Sponsors'
            note='Display content blocks from this sponsor'
            route-prefix='exhibitionsEvents'
            module-name='sponsors'
            :max='1'
        />
    </x-twill::formFieldset>

    {{-- WEB-2236: Use 'twill.partials.meta' as a component --}}
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

@stop
