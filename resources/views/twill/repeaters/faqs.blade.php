@php
    $currentUrl = explode('/', request()->url());
    $isLandingPage = in_array('landingPages', $currentUrl);
@endphp

@twillRepeaterTitle('FAQ')
@twillRepeaterTrigger('Add FAQ')
@twillRepeaterComponent('a17-block-faqs')
@twillRepeaterMax('10')

@if ($isLandingPage)
    <x-twill::wysiwyg
        name='question'
        label='Question'
    />
    <x-twill::wysiwyg
        name='answer'
        label='Answer'
    />
@else
    <div class="col">
        <x-twill::input
            name='title'
            label='Title'
        />
        <x-twill::input
            name='link'
            label='Link'
        />
    </div>
@endif
