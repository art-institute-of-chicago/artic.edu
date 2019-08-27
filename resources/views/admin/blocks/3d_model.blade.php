@formField('input', [
    'name' => 'model_id',
    'label' => 'Model ID'
])

<div>
    @formField('input', [
        'name' => 'camera_position',
        'label' => 'Camera Position',
        'disabled' => true
    ])
    
    @formField('input', [
        'name' => 'camera_target',
        'label' => 'Camera Target',
        'disabled' => true
    ])
    
    @formField('input', [
        'name' => 'annotation_list',
        'label' => 'Annotation List',
        'disabled' => true
    ])
    
    <iframe src="" id="api-frame" allow="autoplay; fullscreen; vr" allowvr allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" hidden></iframe>
</div>

{{-- @push('extra_js')
    <script type="text/javascript" src="https://static.sketchfab.com/api/sketchfab-viewer-1.5.1.js"></script>
    <script>
        const iframe = document.getElementById( 'api-frame' );
        // Pull 3d model data when model url changed. 
        window.vm.$store.subscribe((mutation, state) => {
            const { payload, type } = mutation;
            if (type === 'updateFormField' && payload.name === 'model_id') {
                const id = payload.value;
                // reset model data fields
                window.vm.$store.commit('updateFormField', {
                        name: 'camera_position',
                        value: ''
                    });
                window.vm.$store.commit('updateFormField', {
                    name: 'camera_target',
                    value: ''
                });
                window.vm.$store.commit('updateFormField', {
                    name: 'annotation_list',
                    value: ''
                });
                if (id === '') {
                    return;
                }
                fetchModel(id);
            }
        })
        
        const fetchModel = (id) => {
            const client = new Sketchfab(iframe);
            client.init(id, {
                success: onSuccess = (api) => {
                    api.start();
                    api.getCameraLookAt((err, camera) => {
                        window.vm.$store.commit('updateFormField', {
                            name: 'camera_position',
                            value: camera.position
                        });
                        window.vm.$store.commit('updateFormField', {
                            name: 'camera_target',
                            value: camera.target
                        });
                    })
                    api.getAnnotationList((err, annotations) => {
                        window.vm.$store.commit('updateFormField', {
                            name: 'annotation_list',
                            value: JSON.stringify(annotations)
                        });
                    })
                }
            })
        }
    </script>
@endpush --}}

@push('extra_js')
    <script type="text/javascript" src="https://static.sketchfab.com/api/sketchfab-viewer-1.5.1.js"></script>
    <script>
        const iframe = document.getElementById( 'api-frame' );
        const moduleTypeField = window.STORE.form.fields.find((e) => e.name === 'module_type');
        let oldModelId = '';

        if (moduleTypeField.value === '3dtour') {
            window.vm.$store.subscribe((mutation, state) => {
            const { payload, type } = mutation;
            if (type === 'updateFormField' && payload.name === 'model_id') {
                const id = payload.value;
                if (oldModelId !== id) {
                    // reset model data fields
                    updateFormField('camera_position', '');
                    updateFormField('camera_target', '');
                    updateFormField('annotation_list', '');
                    fetchModel(id);
                    oldModelId = id;
                }
            }
        })
        }
        
        const fetchModel = (id) => {
            if (id === '') {
                return;
            }
            const client = new Sketchfab(iframe);
            client.init(id, {
                success: onSuccess = (api) => {
                    api.start();
                    api.getCameraLookAt((err, camera) => {
                        updateFormField('camera_position', camera.position);
                        updateFormField('camera_target', camera.target);
                    })
                    api.getAnnotationList((err, annotations) => {
                        updateFormField('annotation_list', JSON.stringify(annotations));
                    })
                }
            })
        }

        const updateFormField = (name, value) => {
            window.vm.$store.commit('updateFormField', {
                name: name,
                value: value
            });
        }
    </script>
@endpush