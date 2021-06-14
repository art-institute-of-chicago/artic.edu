@if (isset($notes) && sizeof($notes))
    <hr class="hr">
    @component('components.molecules._m-title-bar', [
        'variation' => 'm-title-bar--no-hr',
        'titleFont' => 'f-list-3',
    ])
        Notes
    @endcomponent
    <div class="o-blocks o-blocks--bibliographic">
        @component('components.blocks._blocks')
            @slot('blocks', [
                [
                    'type' => 'references',
                    'items' => $notes,
                ],
            ])
        @endcomponent
    </div>
@endif

@if (!empty($references))
    <hr class="hr">
    @component('components.molecules._m-title-bar', [
        'variation' => 'm-title-bar--no-hr',
        'titleFont' => 'f-list-3',
    ])
        References
    @endcomponent
    <div class="o-blocks o-blocks--bibliographic">
        {!! $references !!}
    </div>
@endif

@if (!empty($citeAs))
    <hr class="hr">
    @component('components.molecules._m-title-bar', [
        'variation' => 'm-title-bar--no-hr',
        'titleFont' => 'f-list-3',
    ])
        How to Cite
    @endcomponent
    <div class="o-blocks o-blocks--bibliographic">
        {!! $citeAs !!}
    </div>
@endif
