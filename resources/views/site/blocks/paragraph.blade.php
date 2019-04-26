@php
    global $_collectedReferences;
    if (!isset($_collectedReferences)) {
        $_collectedReferences = [];
    }
    list($content, $_collectedReferences)  = convertReferenceLinks($block->present()->input('paragraph'), $_collectedReferences);
@endphp
{!! $content !!}
