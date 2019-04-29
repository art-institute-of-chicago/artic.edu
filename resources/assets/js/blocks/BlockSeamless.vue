<template>
  <div class="content">
    <br />
    <h1>Seamless Previewer</h1>
    <div v-if="hotspotsEnabled">
        <br />
        <input type="checkbox" v-model="hotspotsMode"> Hotspots Mode 
    </div>
    <br />
    <div class="previewer" v-on:click.prevent.stop="addHotspot">
        <h1 v-if="images.length === 0"> No images found in the zip, please try re-uploading the zip file</h1>
        <div class="images-container" @mousedown.prevent="dragStart" @mousemove.prevent="dragging" :style="{cursor: isDragging ? 'grabbing' : 'grab', top: imagePosPercentage.y + '%', left: imagePosPercentage.x + '%', transform: 'scale(' + scale / 100 + ')'}"> 
            <img v-for="image in images" v-bind:key="image.frame" :src="image.url" class="sequence-image" v-show="currentFrame === image.frame"/>
        </div>
        <div class="hotspot" v-bind:class="{ hotspot_active: currentHotspot == hotspot }" v-for="(hotspot, index) in hotspots" :key="index" v-bind:style="{ left: hotspot.x + '%', top: hotspot.y + '%' }" v-on:click.stop="showHotspotInfo(index)"></div>
        <div class="previewer-panel">
            <p>Frame {{ currentFrame }}</p>
            <input type="range" :min="minFrame" :max="maxFrame" class="frame-slider" step="1" v-model.number="currentFrame">
            <p>Scale {{ scale }}%</p>
            <input type="range" min=10 max=200 class="scale-slider" step="1" v-model.number="scale">
            <p> X </p>
            <input type="text" v-model.number="imagePosPercentage.x">
            <p> Y </p>
            <input type="text" v-model.number="imagePosPercentage.y">
        </div>
    </div>
    <div class="hotspot-info-container" v-if="currentHotspot && hotspotsEnabled && hotspotsMode">
        <a17-textfield
            label="Description"
            in-store="value"
            type="textarea"
            name="description"
            :initial-value="currentHotspot ? currentHotspot.description : ''"
            v-on:change="changeCurrentDescription"
        ></a17-textfield>
        <br />
        <a17-button variant="secondary" data-action @click="deleteCurrentHotspot()">Delete <span v-svg symbol="close_icon"></span></a17-button>
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
    props: {
        seamlessAssetData: {
            type: Object
        },
        hotspotsdata: {
            type: Array
        },
    },
    mounted () {
        if (this.seamlessAssetData && Object.keys(this.seamlessAssetData).length === 5) {
            this.seamlessAsset = this.seamlessAssetData;
        };
        if (this.hotspotsdata) {
            this.hotspots = this.hotspotsdata;
        };
        this.updateSequence();
        window.addEventListener('mouseup', this.dragStop);
    },
    data () {
        return {
            images: [],
            hotspots: [],
            hotspotsEnabled: false,
            hotspotsMode: false,
            currentHotspotPos: [undefined, undefined],
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
        imagePosPercentage: function() {
            return {
                x: this.imagePos.x / 6.4,
                y: this.imagePos.y / 5
            }
        },
        currentHotspot: function() {
            return this.hotspots.find(function(el) {
                return el.x === this.currentHotspotPos[0] && el.y === this.currentHotspotPos[1];
            }, this);
        },
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
                    x: this.imagePosPercentage.x,
                    y: this.imagePosPercentage.y,
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
            fields: state => state.form.fields
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
        hotspots: function() {
            this.saveHotspots();
        },
        seamlessAsset: function() {
            this.saveSeamlessAsset();
        },
        fields: function() {
            const moduleTypeField = this.fields.find(function (field) {
                return field.name === 'module_type';
            })
            if (moduleTypeField && moduleTypeField.value === 'tooltip') {
                this.hotspotsEnabled = true;
            } else {
                this.hotspotsEnabled = false;
            }
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
        dragStop(event) {
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
        },
        addHotspot: function (e) {
            if (this.hotspotsEnabled && this.hotspotsMode) {
                const rect = e.currentTarget.getBoundingClientRect()
                const x = (e.clientX - rect.left) / rect.width * 100
                const y = (e.clientY - rect.top) / rect.height * 100
                this.hotspots = this.hotspots.concat({
                    "x": x,
                    "y": y,
                });
                this.showHotspotInfo(this.hotspots.length - 1);
            }
        },
        showHotspotInfo: function (index) {
            if (this.hotspotsEnabled && this.hotspotsMode) {
                this.currentHotspotPos = [this.hotspots[index].x, this.hotspots[index].y];
            }
        },
        deleteCurrentHotspot: function () {
            this.hotspots = this.hotspots.filter(function (hotspot) {
                return hotspot !== this.currentHotspot;
            }, this)
        },
        changeCurrentDescription: function (newValue) {
            this.hotspots = this.hotspots.map(hotspot => {
                if (hotspot === this.currentHotspot) {
                    hotspot.description = newValue;
                }
                return hotspot;
            })
        },
        saveHotspots: function () {
            let field = {}
            field.name = 'tooltip_hotspots'
            field.value = this.hotspots
            this.$store.commit(FORM.UPDATE_FORM_FIELD, field)
        },
    }
  }
</script>

<style lang="scss" scoped>
    .previewer {
        position: relative;
        display: inline-block;
        width: 640px;
        height: 500px;
        background-color: gainsboro;
        overflow: hidden;
        border: 1px solid gainsboro;
    }
    .images-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        transform-origin: top left;
    }
    .sequence-image {
        position: absolute;
        top: 0;
        left: 0;
    }
    .previewer-panel {
        position: absolute;
        padding: 10px;
        bottom: 0;
        left: 0;
        background-color: hsla(0,0%,100%,.8);
    }
    .hotspot {
        position: absolute;
        width: 10px;
        height: 10px;
        background-color: orange;
        border: 2px solid gray;
        border-radius: 50% 50%;
        box-sizing: border-box; 
        transform: translate(-50%, -50%);
        z-index: 1;
    }
    .hotspot_active {
        transform: translateX(-25%) translateY(-25%) scale(2);
        background-color: yellow;
        transform-origin: center center;
    }
    .hotspot:hover {
        cursor: pointer;
    }
    .hotspot-info-container {
        width: calc(100% - 640px);
        height: 100%;
        display: block;
        position: relative;
        float: right;
        padding: 0 20px;
    }
    .hotspot-container {
        position: absolute;
        width: 100%;
        height: 100%;
    }
</style>
