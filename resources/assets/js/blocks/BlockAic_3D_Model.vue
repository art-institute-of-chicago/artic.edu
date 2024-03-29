<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-vselect v-if="sizes" label="Size" :name="fieldName('model_size')" :options='[{&quot;value&quot;:&quot;s&quot;,&quot;label&quot;:&quot;Small&quot;},{&quot;value&quot;:&quot;m&quot;,&quot;label&quot;:&quot;Medium&quot;},{&quot;value&quot;:&quot;l&quot;,&quot;label&quot;:&quot;Large&quot;}]' placeholder="Size" :has-default-store="true" size="large" in-store="inputValue"></a17-vselect>
        <a17-textfield label="Model URL" :name="fieldName('model_url')" type="text" in-store="value"></a17-textfield>
        <a17-vselect v-if="cc0" label="Override CC0" :name="fieldName('cc0_override')" :options='[{&quot;value&quot;:0,&quot;label&quot;:&quot;Not override&quot;},{&quot;value&quot;:1,&quot;label&quot;:&quot;Display CC0&quot;},{&quot;value&quot;:2,&quot;label&quot;:&quot;Not Display CC0&quot;}]' placeholder="Override CC0 rule?" :has-default-store="true" size="large" in-store="inputValue"></a17-vselect>
        <a17-textfield v-if="caption" label="Model Caption Title" :name="fieldName('model_caption_title')" type="text" in-store="value"></a17-textfield>
        <a17-textfield v-if="caption" label="Model Caption" :name="fieldName('model_caption')" type="text" in-store="value"></a17-textfield>
        <a17-inputframe v-if="thumbnail" label="Cover image" name="medias.cover" >
          <a17-mediafield :name="fieldName('image')" crop-context="family_cover" ></a17-mediafield>
        </a17-inputframe>
        <a17-inputframe v-if="browser" label="Collection Objects" name="browsers.artworks">
          <a17-browserfield
            :name="fieldName('artworks')"
            item-label="collection objects"
            :max="1"
            :wide="false"
            v-if="browser"
            endpoint=""
            :endpoints='[
              {
                "label":"Artworks",
                "value":"\/collection\/artworks\/browser"
              },
              {
                "label":"Artists",
                "value":"\/collection\/artists\/browser"
              },
              {
                "label":"Interactive Features",
                "value":"\/collection\/interactiveFeatures\/experiences\/browser"
              }
            ]'
            modal-title="Attach collection objects"
            :draggable="true"
          >
            Link a collection object
          </a17-browserfield>
        </a17-inputframe>
        <a17-textfield label="Model ID" :name="fieldName('model_id')" type="text" disabled in-store="value"></a17-textfield>
        <a17-textfield label="Camera Position" :name="fieldName('camera_position')" type="text" disabled in-store="value"></a17-textfield>
        <a17-textfield label="Camera Target" :name="fieldName('camera_target')" type="text" disabled in-store="value" ></a17-textfield>
        <a17-textfield label="Annotation List" :name="fieldName('annotation_list')" type="text" disabled in-store="value"></a17-textfield>
        <a17-singlecheckbox v-if="optionalAnnotation" :name="fieldName('hide_annotation')" label="Hide Annotation" :initial-value="false" :has-default-store="true" in-store="currentValue"></a17-singlecheckbox>
        <a17-singlecheckbox v-if="optionalAnnotationTitle" :name="fieldName('hide_annotation_title')" label="Hide Annotation Title" :initial-value="false" :has-default-store="true" in-store="currentValue"></a17-singlecheckbox>
        <iframe src="" id="sketchfab-frame" allow="autoplay; fullscreen; vr" allowvr allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" hidden></iframe>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'
  import { mapState } from 'vuex'
  import store from '@/store'
  const Sketchfab = require('./sketchfab-viewer.js')

  export default {
    mixins: [BlockMixin],
    props: {
      thumbnail: {
        type: Boolean,
        default: true
      },
      browser: {
        type: Boolean,
        default: true
      },
      caption: {
        type: Boolean,
        default: true
      },
      cc0: {
        type: Boolean,
        default: true
      },
      sizes: {
        type: Boolean,
        default: false
      },
      optionalAnnotation: {
        type: Boolean,
        default: false
      },
      optionalAnnotationTitle: {
        type: Boolean,
        default: false
      }
    },
    computed: {
      ...mapState({
        fields: state => state.form.fields
      })
    },
    mounted: function () {
        const moduleTypeField = this.fields.find((e) => e.name === 'module_type')
        let oldModelId = ''
        if (!moduleTypeField || ['3dtour', 'split', 'fullwidthmedia'].includes(moduleTypeField.value)) {
          this.$store.subscribe((mutation, state) => {
            const { payload, type } = mutation;
            if (type === 'updateFormField' && payload.name === this.fieldName('model_url')) {
                const matches = payload.value.match(/[a-z0-9]{10,}$/g);
                const id = matches ? matches[0] : '';
                if (oldModelId !== id) {
                  // Reset model data fields
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
          success: function onSuccess(api) {
            this.api = api;
            api.start();
            api.addEventListener('viewerready', this.onViewerReady.bind(this));
          }.bind(this),
          error: function onError() {
            console.error('Viewer error');
          }
        })
      },
      onViewerReady: function() {
        this.isReady = true;
        this.api.getCameraLookAt(
          function(err, camera) {
            this.camera = camera;
            console.info('Viewer ready');
            this.updateFormField(this.fieldName('camera_position'), camera.position);
            this.updateFormField(this.fieldName('camera_target'), camera.target);
          }.bind(this)
        );
        this.api.getAnnotationList(
          function(err, annotations) {
            this.updateFormField(this.fieldName('annotation_list'), JSON.stringify(annotations));
          }.bind(this)
        );
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
