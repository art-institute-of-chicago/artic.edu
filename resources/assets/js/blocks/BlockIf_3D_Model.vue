<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-textfield label="Model URL" :name="fieldName('model_url')" type="text" in-store="value"></a17-textfield>
        <div>
          <a17-textfield label="Model ID" :name="fieldName('model_id')" type="text" disabled in-store="value"></a17-textfield>
          <a17-textfield label="Camera Position" :name="fieldName('camera_position')" type="text" disabled in-store="value"></a17-textfield>
          <a17-textfield label="Camera Target" :name="fieldName('camera_target')" type="text" disabled in-store="value" ></a17-textfield>
          <a17-textfield label="Annotation List" :name="fieldName('annotation_list')" type="text" disabled in-store="value"></a17-textfield>
          <iframe src="" id="sketchfab-frame" allow="autoplay; fullscreen; vr" allowvr allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" hidden></iframe>
        </div>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'
  import { mapState } from 'vuex'
  import store from '@/store'
  const Sketchfab = require('./sketchfab-viewer.js')

  export default {
    mixins: [BlockMixin],
    computed: {
      ...mapState({
        fields: state => state.form.fields
      })
    },
    mounted: function () {
        const moduleTypeField = this.fields.find((e) => e.name === 'module_type')
        let oldModelId = ''
        if (!moduleTypeField || moduleTypeField.value === '3dtour' || moduleTypeField.value === 'split') {
          this.$store.subscribe((mutation, state) => {
            const { payload, type } = mutation;
            if (type === 'updateFormField' && payload.name === this.fieldName('model_url')) {
                const matches = payload.value.match(/[a-z0-9]{10,}$/g);
                const id = matches ? matches[0] : '';
                if (oldModelId !== id) {
                  // reset model data fields
                    this.updateFormField(this.fieldName('model_id'), id);
                    this.updateFormField(this.fieldName('camera_position'), '');
                    this.updateFormField(this.fieldName('camera_target'), '');
                    this.updateFormField(this.fieldName('annotation_list'), '');
                    this.fetchModel(id);
                    oldModelId = id;
                }
            }
          })
        }
    },
    methods: {
      fetchModel: function(id) {
        if (id === '') {
          return;
        }
        const client = new Sketchfab(document.getElementById('sketchfab-frame'));
        client.init(id, {
            success: (api) => {
                api.start();
                api.getCameraLookAt((err, camera) => {
                    this.updateFormField(this.fieldName('camera_position'), camera.position);
                    this.updateFormField(this.fieldName('camera_target'), camera.target);
                })
                api.getAnnotationList((err, annotations) => {
                    this.updateFormField(this.fieldName('annotation_list'), JSON.stringify(annotations));
                })
            }
        })
      },
      updateFormField: function(name, value) {
        this.$store.commit('updateFormField', {
            name: name,
            value: value
        });
      }
    }
  }
</script>
