<fieldset class="m-fieldset{{ (isset($variation)) ? ' '.$variation : '' }}">
    @if (isset($legend))
    <legend class="m-fieldset__legend"><span class="f-subheading-1">{!! $legend !!}</span></legend>
    @endif
    @if (isset($fields))
    <ol class="m-fieldset__fields">
        @foreach ($fields as $field)
            <li class="m-fieldset__field o-blocks{{ (isset($field['variation'])) ? ' '.$field['variation'] : '' }}">
                @component('components.blocks._blocks')
                    @slot('blocks', $field['blocks'])
                @endcomponent
            </li>
        @endforeach
    </ol>
    @endif
</fieldset>
