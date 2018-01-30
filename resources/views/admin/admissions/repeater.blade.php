<section class="box @unless(isset($form_fields['id'])) hidden @endunless" data-repeater-item>
    <header class="header_small">
        <a href="#" class="icon-handle">
            <input type="hidden" name="{{ $moduleName }}[{{ $repeaterIndex }}][position]" value="{{ $repeaterIndex }}" />
        </a>
        <ul>
            <li><a href="#" data-remove>Remove</a></li>
        </ul>
    </header>

    @if(isset($form_fields['admissions']) && isset($form_fields['admissions'][$repeaterIndex]) && isset($form_fields['admissions'][$repeaterIndex]['id']))
        <input type="hidden" name="{{ $moduleName }}[{{ $repeaterIndex }}][id]" value="{{ $form_fields['admissions'][$repeaterIndex]['id'] }}" />
    @endif

    @formField('publish_status', ['repeater' => true])

    <div class="columns">
        <div class="col">
            @formField('input', [
                'repeater' => true,
                'name' => 'title',
                'label' => 'Title',
                'required' => true
            ])

            @formField('date_picker', [
                'repeater' => true,
                'name' => 'date',
                'label' => 'Date',
                'date_settings' => 'admissions_date_settings',
                'required' => true
            ])
            @formField('input', [
                'repeater' => true,
                'name' => 'time_start',
                'label' => 'Opening time',
                'required' => true
            ])
            @formField('input', [
                'repeater' => true,
                'name' => 'time_end',
                'label' => 'Closing time',
                'required' => true
            ])
        </div>

        <div class="col">
            @formField('textarea', [
                'repeater' => true,
                'name' => 'copy',
                'label' => 'Copy',
                'required' => true
            ])
        </div>

        <script>
            var admissions_date_settings = {
                lang:'en',
                format: 'm/d/Y',
                datepicker: true,
                timepicker: false,
                dayOfWeekStart:1,
            }
        </script>

    </div>

</section>

