@php
    global $_collectedReferences;
    if (!isset($_collectedReferences)) {
        $_collectedReferences = [];
    }

    // Processing the paragraph content and references
    list($content, $_collectedReferences) = StringHelpers::convertReferenceLinks($block->present()->input('text'), $_collectedReferences);

    global $_paragraphCount;
    if (isset($_paragraphCount)) {
        $oldInternalErrors = libxml_use_internal_errors(true);

        $dom = new DomDocument();
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $xpath = new DOMXpath($dom);
        $nodes = $xpath->query('//p');

        foreach ($nodes as $node) {
            $_paragraphCount++;

            $newNode = $dom->createElement('p');
            $newNode->setAttribute('id', 'p-' . $_paragraphCount);
            $newNode->setAttribute('class', 'p--linked');

            $refSpan = $dom->createElement('span');
            $refSpan->setAttribute('class', 'p--linked__ref');

            $textSpan = $dom->createElement('span');
            $textSpan->setAttribute('class', 'p--linked__text');

            $refAnchor = $dom->createElement('a');
            $refAnchor->setAttribute('href', '#p-' . $_paragraphCount);
            $refAnchor->setAttribute('class', 'reset');

            $refText = $dom->createTextNode($_paragraphCount);
            $refAnchor->appendChild($refText);
            $refSpan->appendChild($refAnchor);

            foreach ($node->childNodes as $childNode) {
                $textSpan->appendChild(clone $childNode);
            }

            $newNode->appendChild($textSpan);
            $newNode->appendChild($refSpan);

            $node->parentNode->replaceChild($newNode, $node);
        }

        $content = $dom->saveHTML($dom);

        libxml_clear_errors();
        libxml_use_internal_errors($oldInternalErrors);
    }
@endphp

<div class="m-tombstone-block">
    @component('components.atoms._title')
        @slot('font', 'f-secondary')
        @slot('tag', 'div')
            {{ $block->input('heading') }}
    @endcomponent

    @component('components.atoms._short-description')
        @slot('font', 'f-body-editorial')
        @slot('tag', 'div')
            {!! $content !!}
    @endcomponent
</div>
