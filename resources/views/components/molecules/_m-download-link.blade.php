<div class="m-download-link">
    @component('components.atoms._btn')
        @slot('variation', 'btn--icon btn--quaternary')
        @slot('font', '')
        @slot('tag', 'a')
        @slot('href', $pdfDownloadPath)
        @slot('icon', 'icon--download--24')
        @slot('ariaLabel',$ariaLabel)
    @endcomponent

    @component('components.atoms._link')
        @slot('href', $pdfDownloadPath)
        {{ $slot }}
    @endcomponent
</div>
