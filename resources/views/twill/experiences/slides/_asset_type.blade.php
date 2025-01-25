@unless(in_array($item->module_type, ['attract', 'end']))
    <x-twill::radios
        name='asset_type'
        label='Asset Type'
        default='standard'
        :inline='true'
        :options="[
            [
                'value' => 'standard',
                'label' => 'Standard'
            ],
            [
                'value' => 'seamless',
                'label' => 'Seamless'
            ],
            [
                'value' => '3dModel',
                'label' => '3D model'
            ]
        ]"
    />

    @push('extra_js')
    <script>
        const find3dOption = () => {
            return [].slice.call(document.querySelectorAll("input[value='3dModel']")).find(
                el => el.className === 'singleselector__radio'
            )
        }

        const currentModuleType = window['{{ config('twill.js_namespace') }}'].STORE.form.fields.find(
            field => field.name == 'module_type'
        ).value;

        if (currentModuleType !== 'fullwidthmedia' && find3dOption()) {
            find3dOption().parentNode.style.display = "none";
        }

        window.vm.$store.watch(
            function (state) {
                return state.form.fields;
            },
            function (newVal, oldVal) {
                const moduleType = newVal.find(field => field.name == 'module_type');
                if(moduleType && find3dOption()) {
                    if (moduleType.value !== 'fullwidthmedia') {
                        find3dOption().parentNode.style.display = "none";
                    } else {
                        find3dOption().parentNode.style.display = "block";
                    }
                }
            })
    </script>
    @endpush

@endunless

<x-twill::formConnectedFields
    field-name='asset_type'
    field-values="standard"
    :render-for-blocks='false'
    :keep-alive='true'
>
    @foreach(['split', 'fullwidthmedia'] as $moduleType)
        <x-twill::formConnectedFields
            field-name='module_type'
            field-values="$moduleType"
            :render-for-blocks='false'
            :keep-alive='true'
        >
            @php
                $name = $moduleType . '_standard_media_type';
            @endphp
            <x-twill::radios
                :name="$name"
                label='Media Type'
                default='type_image'
                :inline='true'
                :options="[
                    [
                        'value' => 'type_image',
                        'label' => 'Image'
                    ],
                    [
                        'value' => 'type_video',
                        'label' => 'Video'
                    ]
                ]"
            />
        </x-twill::formConnectedFields>
    @endforeach
</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='asset_type'
    field-values="seamless"
    :render-for-blocks='false'
    :keep-alive='true'
>
    <x-twill::radios
        name='media_type'
        label='Media Type'
        default='type_image'
        :inline='true'
        :options="[
            [
                'value' => 'type_image',
                'label' => 'Image'
            ],
            [
                'value' => 'type_sequence',
                'label' => 'Sequence'
            ]
        ]"
    />

    <x-twill::formConnectedFields
        field-name='media_type'
        field-values="type_image"
        :render-for-blocks='false'
        :keep-alive='true'
    >
        <x-twill::repeater
            type="seamless_experience_image"
        />
        <component
            v-bind:is="`a17-block-seamless`"
            :is-seamless-image="{{ 'true' }}"
            :seamless-asset-data="{{ isset($form_fields['seamless_image_asset']) ? json_encode($form_fields['seamless_image_asset']) : "null" }}"
            :hotspotsdata="{{ isset($form_fields['tooltip_hotspots']) ? json_encode($form_fields['tooltip_hotspots']) : '[]' }}"
            :name="`seamless_image`">
        </component>
    </x-twill::formConnectedFields>

    <br />
    <x-twill::formConnectedFields
        field-name='media_type'
        field-values="type_sequence"
        :render-for-blocks='false'
        :keep-alive='true'
    >
        <x-twill::formFieldset title="Seamless Sequence" id="seamless-asset">
            <x-twill::files
                name='sequence_file'
                label='Sequence zip file'
                :max='1'
            />

            <component
                v-bind:is="`a17-block-seamless`"
                :name="`seamless`"
                :seamless-asset-data="{{ isset($form_fields['seamless_asset']) ? json_encode($form_fields['seamless_asset']) : "null" }}"
                :hotspotsdata="{{ isset($form_fields['tooltip_hotspots']) ? json_encode($form_fields['tooltip_hotspots']) : '[]' }}">
            </component>

            <x-twill::input
                name='seamless_alt_text'
                label='Alt Text'
            />
        </x-twill::formFieldset>
    </x-twill::formConnectedFields>

    <x-twill::formConnectedFields
        field-name='module_type'
        field-values="compare"
        :render-for-blocks='false'
    >
        <x-twill::wysiwyg
            name='caption'
            label='Seamless Caption'
            :maxlength='500'
        />
    </x-twill::formConnectedFields>
</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='asset_type'
    field-values="standard"
    :keep-alive='true'
>
    @foreach(['split', 'fullwidthmedia'] as $moduleType)
        @php
            $name = $moduleType . '_standard_media_type';
        @endphp
        <x-twill::formConnectedFields
            :field-name="$name"
            field-values="type_video"
            :keep-alive='true'
        >
            <x-twill::formConnectedFields
                field-name='module_type'
                :field-values="$moduleType"
                :render-for-blocks='false'
                :keep-alive='true'
            >
                <br/>
                <x-twill::formFieldset title="Video" id="video">
                    @include('twill.experiences.slides._video_form', ['moduleType' => $moduleType])
                </x-twill::formFieldset>
            </x-twill::formConnectedFields>
        </x-twill::formConnectedFields>
    @endforeach
</x-twill::formConnectedFields>
