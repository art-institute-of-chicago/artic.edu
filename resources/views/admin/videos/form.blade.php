@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'video_url',
        'label' => 'Video URL'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Hero Image',
        'name' => 'hero',
        'note' => 'Minimum image width 3000px'
    ])

    @formField('date_picker', [
        'name' => 'date',
        'label' => 'Display date',
    ])

    @formField('input', [
        'name' => 'heading',
        'label' => 'Copy',
        'rows' => 3,
        'type' => 'textarea'
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

@endsection
