<p class="m-download-file">
    @if (isset($file['thumb']))
        @component('components.atoms._img')
            @slot('image',  $file['thumb'])
            @slot('class', 'm-download-file__img')
            @slot('settings', $imageSettings ?? '')
        @endcomponent
    @endif
    <span class="m-download-file__meta f-secondary">
        @if (isset($file['title']))
            {{ $file['title'] }}
        @endif
        <br>
        @if (isset($file['extension']))
            {{ strtoupper($file['extension']) }}@if (isset($file['size'])){{ ', '}}@endif
        @endif
        @if (isset($file['size']))
            {{ $file['size'] }}
        @endif
    </span>
    @component('components.atoms._btn')
        @slot('variation', 'btn--secondary btn--icon-sq m-download-file__button')
        @slot('font', '')
        @slot('icon', 'icon--download--24')
        @slot('tag', 'a')
        @slot('href', $file['content'] ?? null)
        @slot('download', $file['title'] ?? true)
        @slot('ariaLabel','Download file')
    @endcomponent
</p>
