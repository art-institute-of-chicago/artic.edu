@php
    use Symfony\Component\DomCrawler\Crawler;

    // Avoid $block->present() here due to ---
    $markdown = $block->input('table_markdown');
    $parser = new Parsedown();
    $html = $parser->text($markdown);

    $crawler = new Crawler($html);

    // Only get first table, ignore any other content
    $table = $crawler->filter('table:first-child')->first();
    $tableHtml = '<table>' . $table->html() . '</table>';
@endphp

@component('components.molecules._m-table')
    @slot('size', $block->input('size'))
    @slot('title', $block->input('table_title'))
    @slot('tableHtml', $tableHtml)
    @slot('tableCaption', $block->input('table_caption'))
    @slot('hasSideHeader', $block->input('has_side_header'))
    @slot('allowWordWrap', $block->input('allow_word_wrap'))
@endcomponent
