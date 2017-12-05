<section class="box">
    <header class="header_small">
        <h3><b>Visit</b></h3>
    </header>

    @formField('input', [
        'field' => 'visit_intro',
        'field_name' => 'Intro text',
    ])

    {{-- @formField('medias', [
        'media_role' => 'hero',
        'media_role_name' => 'Hero Image',
        'with_multiple' => false,
        'no_crop' => false
    ]) --}}

</section>

@formField('repeater', [
    'moduleName' => 'admissions',
    'title' => 'Free Admissions',
    'routePrefix' => 'landing.visit',
    'title_singular' => 'Free Admission'
])
