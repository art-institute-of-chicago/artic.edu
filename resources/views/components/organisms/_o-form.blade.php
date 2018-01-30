<form class="o-form o-blocks{{ (isset($variation)) ? ' '.$variation : '' }}"{!! (isset($action)) ? ' action="'.$action.'"' : '' !!}{!! (isset($method)) ? ' method="'.$method.'"' : '' !!}>
    @component('components.blocks._blocks')
        @slot('blocks', $blocks)
    @endcomponent
    @if (isset($actions))
    <ul class="o-form__actions">
        @foreach ($actions as $action)
            <li class="o-form__action">
                @component('components.atoms._btn')
                    @slot('variation', $action['variation'] ?? null)
                    @slot('type', $action['type'] ?? 'submit')
                    {{ $action['label'] ?? 'Submit' }}
                @endcomponent
            </li>
        @endforeach
    </ul>
    @endif
</form>
