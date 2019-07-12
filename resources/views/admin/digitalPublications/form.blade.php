@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'title_display',
        'label' => 'Title formatting (optional)',
        'note' => 'Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'label' => 'Banner image',
        'name' => 'banner',
        'note' => 'Minimum image width 2000px'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'label' => 'Listing image',
        'name' => 'listing',
        'note' => 'Minimum image width 3000px'
    ])

    @formField('wysiwyg', [
        'name' => 'listing_description',
        'label' => 'Listing description',
        'maxlength'  => 255,
        'note' => 'Max 255 characters',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @formField('input', [
        'name' => 'short_description',
        'label' => 'Short description',
        'type' => 'textarea',
        'maxlength' => 255
    ])

    @formField('input', [
        'name' => 'publication_year',
        'label' => 'Publication year',
    ])

    @formField('block_editor', [
        'blocks' => getBlocksForEditor([
            'paragraph', 'image', 'video', 'media_embed', 'list',
            'accordion', 'membership_banner', 'timeline', 'link', 'newsletter_signup_inline',
            'hr', 'split_block'
        ])
    ])
@stop

@section('fieldsets')

    @php
        $relatedTos = $item->relatedTos;
    @endphp
    @if ($relatedTos->isNotEmpty())
        <a17-fieldset id="related" title="Related">

            <p>The following content has been related to this one. These will be used to bring this item into global search results.</p>

            <ol style="margin: 1em 0; padding-left: 40px">
                @foreach($relatedTos as $related)
                    <li style="list-style-type: decimal; margin-bottom: 0.5em">
                        {!! Str::title($related->subject_type) !!}: <a href="{!! route($related->subject_type .'.show', $related->subject) !!}">{{ $related->subject->title }}</a>
                    </li>
                @endforeach
            </ol>
        </a17-fieldset>
    @endif

    @include('admin.partials.meta')

@endsection
