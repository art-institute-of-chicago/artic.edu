@php
    $relatedTos = $item->relatedTos;
@endphp
@if ($relatedTos->isNotEmpty())
    <a17-fieldset id="related_from" title="Related (inverse)">

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
