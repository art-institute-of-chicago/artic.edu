<div class="m-search-restricted-field">
    <div class="m-search-restricted-field__dropdown">
        @component('components.molecules._m-search-restricted-field-dropdown')
            @slot('prompt', $prompt)
            @slot('options', $options)
        @endcomponent
    </div>
    <div class="m-search-restricted-field__search-bar">
        @component('components.molecules._m-search-bar')
            @slot('placeholder', $placeholder)
            @slot('name', $name)
            @slot('value', $value)
            @isset($hiddenFields)
                @slot('hiddenFields', $hiddenFields)
            @endisset
            @slot('behaviors', $behaviors)
            @slot('dataAttributes', $dataAttributes)
            @slot('gtmAttributes', $gtmAttributes)
            @slot('action', $action)
        @endcomponent
    </div>
</div>
