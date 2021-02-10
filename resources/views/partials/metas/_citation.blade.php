@php
    $citationTitle = strip_tags($seo->citationTitle ?? '');
    $citationJournalTitle = strip_tags($seo->citationJournalTitle ?? '');
    $citationJournalAbbrev = strip_tags($seo->citationJournalAbbrev ?? '');
    $citationPublisher = strip_tags($seo->citationPublisher ?? '');
    $citationPublicationDate = strip_tags($seo->citationPublicationDate ?? '');
    $citationOnlineDate = strip_tags($seo->citationOnlineDate ?? '');
    $citationIssue = strip_tags($seo->citationIssue ?? '');
    $citationAuthor = [];
    foreach ($seo->citationAuthor ?? [] as $author) {
        $citationAuthor[] = strip_tags($author);
    }
@endphp

@if ($citationTitle)
    <meta name="citation_title"      content="{{ $citationTitle }}" />
@endif
@if ($citationJournalTitle)
    <meta name="citation_journal_title"      content="{{ $citationJournalTitle }}" />
@endif
@if ($citationJournalAbbrev)
    <meta name="citation_journal_abbrev"      content="{{ $citationJournalAbbrev }}" />
@endif
@if ($citationPublisher)
    <meta name="citation_publisher"      content="{{ $citationPublisher }}" />
@endif
@if ($citationPublicationDate)
    <meta name="citation_publication_date"      content="{{ $citationPublicationDate }}" />
@endif
@if ($citationOnlineDate)
    <meta name="citation_online_date"      content="{{ $citationOnlineDate }}" />
@endif
@if ($citationIssue)
    <meta name="citation_issue"      content="{{ $citationIssue }}" />
@endif
@foreach ($citationAuthor as $author)
    <meta name="citation_author"      content="{{ $author }}" />
@endforeach
