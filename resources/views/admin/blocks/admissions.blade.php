{{-- @formField('publish_status', ['repeater' => true])

<div class="columns">
    <div class="col">
        @formField('input', [
            'repeater' => true,
            'name' => 'title',
            'label' => 'Title',
            'field_name' => 'Title',
            'required' => true
        ])

        @formField('date_picker', [
            'repeater' => true,
            'name' => 'date',
            'label' => 'Date',
            'field_name' => 'Date',
            'date_settings' => 'admissions_date_settings',
            'required' => true
        ])
        @formField('input', [
            'repeater' => true,
            'name' => 'time_start',
            'label' => 'Opening time',
            'field_name' => 'Opening time',
            'required' => true
        ])
        @formField('input', [
            'repeater' => true,
            'name' => 'time_end',
            'label' => 'Closing time',
            'field_name' => 'Closing time',
            'required' => true
        ])
    </div>

    <div class="col">
        @formField('textarea', [
            'repeater' => true,
            'label' => 'Copy',
            'name' => 'copy',
            'field_name' => 'Copy',
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
 --}}
