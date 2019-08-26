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

@push('extra_js')
    <script type="text/javascript" src="https://static.sketchfab.com/api/sketchfab-viewer-1.5.1.js"></script>
    <script>
        const iframe = document.getElementById( 'api-frame' );
        // Pull 3d model data when model url changed. 
        window.vm.$store.subscribe((mutation, state) => {
            const { payload, type } = mutation;
            if (type === 'updateFormField' && payload.name === 'model_id') {
                const id = payload.value;
                if (id === '') {
                    console.log('id is empty');
                    return;
                }
                const result = fetchModel(id);
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
@endpush