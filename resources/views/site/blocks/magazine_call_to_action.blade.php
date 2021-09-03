@php
    $type = $block->input('tag');
    $title_display = $block->input('title');
    $link_text = $block->input('link_text');
    $href = $block->input('link_url');
    $theme = $block->input('theme');
    $gtmEvent = UrlHelpers::lastUrlSegment($href);
    if (!$gtmEvent) {
        $gtmEvent = strip_tags($title_display);
    }
@endphp

@component('components.molecules._m-listing----publication-call-to-action')
    @slot('variation', (isset($theme) && $theme == 'light') ? 'm-listing--publication-call-to-action-light' : null)
    @slot('href', $href ?? null)
    @slot('type', $type ?? null)
    @slot('title_display', $title_display ?? null)
    @slot('link_text', $link_text ?? null)
    @slot('gtmAttributes', 'data-gtm-event="' . $gtmEvent . '" data-gtm-event-category="mag-content-' . $block->position . '"')
@endcomponent
