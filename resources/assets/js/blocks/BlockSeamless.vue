<template>
  <div class="content">
    <br />
    <h1>Seamless Previewer</h1>
    <br />
    <div class="previewer">
        <h1 v-if="images.length === 0"> No images found in the zip, please try re-uploading the zip file</h1>
        <div class="images-container" @mousedown.prevent="dragStart" @mousemove.prevent="dragging" :style="{ left: imagePos.x + 'px', top: imagePos.y + 'px', cursor: isDragging ? 'grabbing' : 'grab', transform: 'scale(' + scale / 100 + ')' }"> 
            <img v-for="image in images" v-bind:key="image.frame" :src="image.url" class="sequence-image" v-show="currentFrame === image.frame"/>
        </div>
        <div class="previewer-panel">
            <p>Frame {{ currentFrame }}</p>
            <input type="range" :min="minFrame" :max="maxFrame" class="frame-slider" step="1" v-model.number="currentFrame">
            <p>Scale {{ scale }}%</p>
            <input type="range" min=10 max=200 class="scale-slider" step="1" v-model.number="scale">
        </div>
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex'
  import axios from 'axios'
  import BlockMixin from '@/mixins/block'
  import FormStoreMixin from '@/mixins/formStore'
  import { FORM } from '@/store/mutations'

  export default {
    mixins: [BlockMixin],
    props: ['seamlessAssetData'],
    mounted () {
        if (this.seamlessAssetData && Object.keys(this.seamlessAssetData).length === 5) {
            this.seamlessAsset = this.seamlessAssetData;
        };
        this.updateSequence();
        window.addEventListener('mouseup', this.dragStop);
    },
    data () {
        return {
            tooltipEnabled: false,
            images: [],
            currentFrame: 1,
            isDragging: false,
            scale: 100,
            imagePos: {
                x: 0,
                y: 0
            },
            mousePos: {
                x: 0,
                y: 0
            },
            fileId: null,
        }
    },
    computed: {
        minFrame: function() {
            return 1;
        },
        maxFrame: function() {
            return this.images.length;
        },
        seamlessAsset: {
            get: function() {
                return {
                    assetId: this.fileId,
                    frame: this.currentFrame,
                    x: this.imagePos.x,
                    y: this.imagePos.y,
                    scale: this.scale
                }
            },
            set: function(data) {
                this.currentFrame = data.frame;
                this.imagePos.x = data.x,
                this.imagePos.y = data.y,
                this.scale = data.scale 
            }
        },
        ...mapState({
            selectedMeidas: state => state.mediaLibrary.selected,
        })
    },
    watch: {
        selectedMeidas: function() {
            this.updateSequence();
        },
        fileId: function() {
            axios.get('/api/v1/seamless-images/' + this.fileId).then(rsp => {
                this.images = rsp.data;
            });
        },
        seamlessAsset: function() {
            this.saveSeamlessAsset();
        }
    },
    methods: {
        dragStart(event) {
            this.isDragging = true;
            this.mousePos.x = event.clientX
            this.mousePos.y = event.clientY
        },
        dragging(event) {
            if (this.isDragging) {
                this.imagePos.x = this.imagePos.x + (event.clientX - this.mousePos.x);
                this.imagePos.y = this.imagePos.y + (event.clientY - this.mousePos.y);
                this.mousePos.x = event.clientX;
                this.mousePos.y = event.clientY;
            }
        },
        dragStop() {
            this.isDragging = false;
        },
        updateSequence() {
            if (this.selectedMeidas.hasOwnProperty('sequence_file[en]')) {
                const sequenceFile = this.selectedMeidas['sequence_file[en]'][0];
                const fileName = sequenceFile['name'];
                if (/(?:\.([^.]+))?$/.exec(fileName)[1] === 'zip') {
                    this.fileId = sequenceFile['id'];
                }

            } else {
                this.images = [];
            }
        },
        saveSeamlessAsset() {
            const field = {
                name: 'seamless_asset',
                value: this.seamlessAsset
            };
            this.$store.commit(FORM.UPDATE_FORM_FIELD, field);
        }
    }
  }
</script>

<style lang="scss" scoped>
    .previewer {
        position: relative;
        width: 100%;
        height: 500px;
        background-color: white;
        overflow: hidden;
        border: 1px solid gainsboro;
    }
    .images-container {
        position: absolute;
        width: 100%;
        height: 100%;
    }
    .sequence-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
    }
    .previewer-panel {
        position: absolute;
        padding: 10px;
        bottom: 0;
        left: 0;
        background-color: hsla(0,0%,100%,.8);
    }
</style>
