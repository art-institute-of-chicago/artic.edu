@extends('twill::layouts.form', [
    // We define the fieldsets here for sticky subnav as the user scrolls down the form
    'additionalFieldsets' => [
        ['fieldset' => 'content', 'label' => 'Content'],
        ['fieldset' => 'sponsors', 'label' => 'Sponsors'],
        ['fieldset' => 'related', 'label' => 'Further Reading'],
        ['fieldset' => 'side_related', 'label' => 'Sidebar Related'],
        ['fieldset' => 'metadata', 'label' => 'Metadata'],
    ]
])

@section('contentFields')
    <x-twill::input
        name='title_display'
        label='Title formatting (optional)'
        note='Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    />

    <x-twill::date-picker
        name='date'
        label='Display date'
        note='Required'
        :required='true'
    />

    <x-twill::select
        name='layout_type'
        label='Article layout'
        :options="$articleLayoutsList"
        :default='0'
    />

    <x-twill::medias
        name='hero'
        label='Hero image'
        note='Minimum image width 3000px'
    />

    <x-twill::medias
        name='mobile_hero'
        label='Mobile hero image'
        note='Minimum image width 3000px'
    />

    <x-twill::wysiwyg
        name='hero_caption'
        label='Hero image caption'
        note='Usually used for copyright'
        :maxlength='255'
        :toolbar-options="[ 'italic', 'link' ]"
    />

    <x-twill::multi-select
        name='categories'
        label='Categories'
        placeholder='Select some categories'
        :options='$categoriesList'
        :unpack="true"
    />

    <x-twill::input
        name='subtype'
        label='Article Label'
    />

    <x-twill::wysiwyg
        name='heading'
        label='Header'
        note='Max 255 characters. Will be used on the article detail page.'
        :maxlength='255'
        :toolbar-options="[ 'italic' ]"
    />

    <x-twill::wysiwyg
        name='list_description'
        label='List Description'
        note='Max 255 characters. Will be used on the article landing and listing pages, and social media.'
        :maxlength='255'
        :toolbar-options="[ 'italic' ]"
    />

    @include('twill.partials.authors')

    <x-twill::medias
        label='Author thumbnail'
        name='author'
        note='Minimum image width 600px'
    />

    <x-twill::checkbox
        name='is_unlisted'
        label="Don't show this article in listings"
    />

    <x-twill::checkbox
        name='is_in_magazine'
        label='Assume this article is featured in a magazine issue'
    />

    <x-twill::wysiwyg
        name='citations'
        label='Citation'
        note='Max 255 characters'
        :maxlength='255'
        :toolbar-options="[ 'italic', 'link' ]"
    />

    @php
        $blocks = BlockHelpers::getBlocksForEditor([
            'paragraph', 'image', 'hr', 'artwork', 'split_block', 'gallery_new', 'link', 'video', 'quote', 'tour_stop', 'accordion', 'media_embed', 'list', 'grid', 'image_slider', 'button', 'audio_player', '360_embed', 'vtour_embed', 'mirador_embed', '3d_embed', 'feature_2x', 'membership_banner', 'layered_image_viewer', '3d_tour', 'feature_4x', 'citation', 'citation', 'mirador_modal'
        ]);
    @endphp

    <x-twill::block-editor
        :blocks="$blocks"
    />
@stop

@section('fieldsets')
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

    <x-twill::formFieldset id="related" title="Further Reading">
        <p>Use "Custom related items" to relate up to 4 articles to show on the article page. See special note on articles below.</p>

        <x-twill::browser
            name='further_reading_items'
            label='Custom related items'
            :max='4'
            :modules="[
                [
                    'label' => 'Article',
                    'name' => 'collection.articlesPublications.articles'
                ],
                [
                    'label' => 'Highlight',
                    'name' => 'collection.highlights'
                ],
                [
                    'label' => 'Interactive feature',
                    'name' => 'collection.interactiveFeatures.experiences'
                ]
            ]"
        />

        <p>We use Category data to determine which articles to relate. We automatically append any article related in this way to the "Related Content" section in reverse chronological order. The following articles would be shown on this article's page automatically:</p>

        @php
            $category_ids = $item->categories->pluck('id')->all();
            $relatedArticles = \App\Models\Article::byCategories($category_ids)->published()->notUnlisted()->orderBy('date', 'desc')->take(5)->get();
        @endphp
        <ol style="margin: 1em 0; padding-left: 40px">
            @foreach($relatedArticles as $article)
                @if($article->id != $item->id)
                    <li style="list-style-type: decimal; margin-bottom: 0.5em">
                        <a href="{!! route('articles.show', $article) !!}">{{ $article->title }}</a>
                    </li>
                @endif
            @endforeach
        </ol>

        <p style="margin-top: 1em">If this logic is satisfactory, there's no need to add exhibitions to the "Custom related items" field. However, if you'd like to control the order of exhibitions relative to other related content, feel free to add them using the field above.</p>
    </x-twill::formFieldset>

    <x-aic::featuredRelated
        :auto-related="$autoRelated" />

    @include('twill.partials.related')

    @include('twill.partials.meta')

@endsection
