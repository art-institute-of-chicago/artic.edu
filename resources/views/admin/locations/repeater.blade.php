<section class="box @unless(isset($form_fields['id'])) hidden @endunless" data-repeater-item>
    <header class="header_small">
        <a href="#" class="icon-handle">
            <input type="hidden" name="{{ $moduleName }}[{{ $repeaterIndex }}][position]" value="{{ $repeaterIndex }}" />
        </a>
        <ul>
            <li><a href="#" data-remove>Remove</a></li>
        </ul>
    </header>

    @if(isset($form_fields['locations']) && isset($form_fields['locations'][$repeaterIndex]) && isset($form_fields['locations'][$repeaterIndex]['id']))
        <input type="hidden" name="{{ $moduleName }}[{{ $repeaterIndex }}][id]" value="{{ $form_fields['locations'][$repeaterIndex]['id'] }}" />
    @endif

    @formField('publish_status', ['repeater' => true])

    <div class="columns">
        <div class="col">
            @formField('input', [
                'repeater' => true,
                'field' => 'name',
                'field_name' => 'Name',
                'required' => true
            ])
            @formField('input', [
                'repeater' => true,
                'field' => 'street',
                'field_name' => 'Street',
            ])
            @formField('input', [
                'repeater' => true,
                'field' => 'address',
                'field_name' => 'Address',
            ])
        </div>

        <div class="col">
            @formField('input', [
                'repeater' => true,
                'field' => 'city',
                'field_name' => 'City',
            ])
            @formField('input', [
                'repeater' => true,
                'field' => 'state',
                'field_name' => 'State',
            ])
            @formField('input', [
                'repeater' => true,
                'field' => 'zip',
                'field_name' => 'ZIP code',
            ])
        </div>
    </div>

</section>

