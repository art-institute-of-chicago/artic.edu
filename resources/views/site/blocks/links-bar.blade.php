@php
    $blocks = $block->blockable->blocks()
    ->where(
        function($query) {
            return $query
                ->where('type', 'paragraph')
                ->orWhere('type', 'gallery')
                ->orWhere('type', 'gallery_new');
        }
    )
    ->get();

    $links = [];
    foreach ($blocks as $b) {
        if ($b->type == 'paragraph') {
            if (preg_match_all('/<h([23])[^>]*>(.*)<\/h\\1>/', $b->content['paragraph'], $matches)) {
                if ($title = html_entity_decode(strip_tags($matches[2][0]) ?? null)) {
                    $links[] = ['label' => $title, 'href' => '#' . Str::slug($title)];
                }
            }
        }
        // `gallery` or `gallery-new`
        else {
            if ($title = html_entity_decode($b->content['title'] ?? null)) {
                $links[] = ['label' => $title, 'href' => '#' . Str::slug($title)];
            }
        }
    }
@endphp

@component('components.molecules._m-links-bar')
    @slot('overflow', true)
    @slot('variation', 'm-links-bar--nav-bar')
    @slot('isPrimaryPageNav', true)
    @slot('linksPrimary', $links)
@endcomponent
