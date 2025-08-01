<template>
  <div class="content" ref="wrapper">
    <br />
    <h1>Seamless Previewer</h1>
    <div v-if="hotspotsEnabled">
        <br />
        <input type="checkbox" v-model="hotspotsMode"> Hotspots Mode
    </div>
    <br />
    <div class="previewer">
        <h1 v-if="fileId && processing"> Processing... </h1>
        <h1 v-if="images.length === 0 && !processing"> Error: Something went wrong. Please try re-uploading the zip file</h1>
        <div class="previewer__inner" :style="{transform: 'scale('+ previewerScale +')'}">
            <div class="images-container"  v-on:click="addHotspot" @mousedown.prevent="dragStart" @mousemove.prevent="dragging" :style="{cursor: isDragging ? 'grabbing' : 'grab', top: imagePos.y + 'px', left: imagePos.x + 'px', transform: 'translate(' + translate.x + '%, ' + translate.y + '%) scale(' + scale / 100 + ')'}">
                <img v-for="image in images" v-bind:key="image.frame" :src="image.url" class="sequence-image" v-show="currentFrame === image.frame"/>
                <div class="hotspot"
                    v-bind:class="{ hotspot_active: currentHotspot == hotspot }"
                    v-for="(hotspot, index) in hotspots" :key="hotspot.x"
                    v-bind:style="{ left: hotspot.x + '%', top: hotspot.y + '%', transform: currentHotspot === hotspot ? 'translateX(-25%) translateY(-25%) scale(' + 200 / scale + ')' : 'translate(-50%, -50%) scale(' + 100 / scale + ')'}"
                    v-on:click.stop="showHotspotInfo(index)"
                    v-show="hotspotsEnabled"
                    @mousedown.stop="hotspotDragStart($event, index)"
                    ></div>
            </div>
        </div>
        <div class="previewer-panel">
            <p v-if="!isSeamlessImage">Frame {{ currentFrame }}</p>
            <input type="range" :min="minFrame" :max="maxFrame" class="frame-slider" step="1" v-model.number="currentFrame" v-if="!isSeamlessImage">
            <p>Scale {{ scale }}%</p>
            <input type="range" min=10 max=200 class="scale-slider" step="1" v-model.number="scale">
            <p> X </p>
            <input type="text" v-model.number="translate.x">
            <p> Y </p>
            <input type="text" v-model.number="translate.y">
        </div>
    </div>
    <div class="hotspot-info-container" v-if="currentHotspot && hotspotsEnabled && hotspotsMode">
        <a17-textfield
            label="Description"
            in-store="value"
            type="textarea"
            name="description"
            :initial-value="currentDescription"
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
        isSeamlessImage: {
            type: Boolean,
            default: false
        }
    },
    mounted () {
        if (this.seamlessAssetData && Object.keys(this.seamlessAssetData).length === 5) {
            this.seamlessAsset = this.seamlessAssetData;
        };
        if (!this.isSeamlessImage && this.hotspotsdata) {
            this.hotspots = this.hotspotsdata;
        };
        this.updateSequence();
        window.addEventListener('mouseup', this.dragStop);
        window.addEventListener('resize', this.onResize);
    },
    updated () {
        this.setPreviewerSize();
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
            processing: true,
            hotspotIndexDragging: undefined,
            imagePos: {
                x: 0,
                y: 0
            },
            translate: {
                x: 0,
                y: 0,
            },
            mousePos: {
                x: 0,
                y: 0
            },
            fileId: null,
            previewerScale: 1,
            currentDescription: '',
        }
    },
    computed: {
        currentHotspot: {
            get: function() {
                return this.hotspots.find(function(el) {
                    return el.x === this.currentHotspotPos[0] && el.y === this.currentHotspotPos[1];
                }, this);
            },
            set: function(data) {
                const foundIndex = this.hotspots.findIndex(function(el) {
                    return el.x === this.currentHotspotPos[0] && el.y === this.currentHotspotPos[1];
                }, this);
                this.hotspots[foundIndex] = {
                    ...this.hotspots[foundIndex],
                    ...data
                };
            }
        },
        minFrame: function() {
            return 0;
        },
        maxFrame: function() {
            return this.images.length - 1;
        },
        seamlessAsset: {
            get: function() {
                return {
                    assetId: this.fileId,
                    frame: this.currentFrame,
                    x: this.translate.x,
                    y: this.translate.y,
                    scale: this.scale
                }
            },
            set: function(data) {
                this.currentFrame = data.frame;
                this.translate.x = data.x,
                this.translate.y = data.y,
                this.scale = data.scale
            }
        },
        ...mapState({
            selectedMedias: state => state.mediaLibrary.selected,
            fields: state => state.form.fields
        })
    },
    watch: {
        selectedMedias: function() {
            this.updateSequence();
        },
        fileId: function() {
            this.processing = true;
            axios.get('/api/v1/seamless-images/' + this.fileId).then(rsp => {
                this.images = rsp.data;
                this.processing = false;
            });
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
            this.mousePos.x = event.clientX;
            this.mousePos.y = event.clientY;
        },
        hotspotDragStart(event, hotspotIndex) {
            this.hotspotIndexDragging = hotspotIndex;
            this.mousePos.x = event.clientX;
            this.mousePos.y = event.clientY;
        },
        dragging(event) {
            if (this.isDragging) {
                this.imagePos.x = this.imagePos.x + (event.clientX - this.mousePos.x);
                this.imagePos.y = this.imagePos.y + (event.clientY - this.mousePos.y);
                this.mousePos.x = event.clientX;
                this.mousePos.y = event.clientY;
            }
            if (this.hotspotIndexDragging !== undefined) {
                const rect = event.currentTarget.getBoundingClientRect();
                this.hotspots = this.hotspots.map(function(hotspot, idx) {
                    if (idx === this.hotspotIndexDragging) {
                        return {
                            ...hotspot,
                            x: hotspot.x + (event.clientX - this.mousePos.x) / rect.width * 100,
                            y: hotspot.y + (event.clientY - this.mousePos.y) / rect.height * 100
                        };
                    } else {
                        return hotspot;
                    }
                }, this)
                this.mousePos.x = event.clientX;
                this.mousePos.y = event.clientY;
            }
        },
        dragStop(event) {
            if (this.isDragging === true) {
                this.isDragging = false;
                this.calculateTranslate();
            }

            if (this.hotspotIndexDragging !== undefined) {
                this.hotspotIndexDragging = undefined;
                this.saveHotspots();
            }
        },
        calculateTranslate() {
            const currentImage = this.images.find(function(image) {
                return image.frame === this.currentFrame;
            }, this);
            if (currentImage) {
                this.translate.x = this.translate.x + this.imagePos.x / currentImage.width * 100;
                this.translate.y = this.translate.y + this.imagePos.y / currentImage.height * 100;
            }
            this.imagePos.x = 0;
            this.imagePos.y = 0;
        },
        updateSequence() {
            if (!this.isSeamlessImage && this.selectedMedias.hasOwnProperty('sequence_file[en]')) {
                const sequenceFile = this.selectedMedias['sequence_file[en]'][0];
                const fileName = sequenceFile['name'];
                if (/(?:\.([^.]+))?$/.exec(fileName)[1] === 'zip') {
                    this.fileId = sequenceFile['id'];
                }

            } else if (this.isSeamlessImage) {
                for (const selectedMediaName in this.selectedMedias) {
                    const matched = selectedMediaName.match(/^blocks\[seamlessExperienceImage\-\d+\]\[experience_image\]$/) || selectedMediaName.match(/^blocks\[\d+\]\[experience_image\]$/);
                    if (matched) {
                        const media = this.selectedMedias[matched[0]][0];
                        if (media) {
                            this.images = [{
                                url: media['original'],
                                frame: this.currentFrame,
                                width: media['width'],
                                height: media['height']
                            }];
                            break;
                        }
                    }
                }
            } else {
                this.images = [];
            }
        },
        saveSeamlessAsset() {
            const field = {
                name: this.isSeamlessImage ? 'seamless_image_asset' : 'seamless_asset',
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
                    "description": ''
                });
                this.showHotspotInfo(this.hotspots.length - 1);
                this.currentHotspot = '';
                this.saveHotspots();
            }
        },
        showHotspotInfo: function (index) {
            if (this.hotspotsEnabled && this.hotspotsMode) {
                this.currentHotspotPos = [this.hotspots[index].x, this.hotspots[index].y];
                this.currentDescription = this.currentHotspot.description;
            }
        },
        deleteCurrentHotspot: function () {
            console.log('deleting');
            this.hotspots = this.hotspots.filter(function (hotspot) {
                return hotspot !== this.currentHotspot;
            }, this)
            this.saveHotspots();
        },
        changeCurrentDescription: function (newValue) {
             this.currentHotspot = {
                description: newValue,
            };
            this.currentDescription = newValue;
            this.saveHotspots();
        },
        saveHotspots: function () {
            let field = {}
            field.name = 'tooltip_hotspots'
            field.value = this.hotspots
            this.$store.commit(FORM.UPDATE_FORM_FIELD, field)
        },
        setPreviewerSize(){
            let colWidth = this.$refs.wrapper.clientWidth;
            let winWidth = 1366;
            let scale = colWidth / winWidth;

            this.previewerScale = scale;
        },
        onResize(event) {
            this.setPreviewerSize();
        }
    }
  }
</script>

<style lang="scss" scoped>
    .previewer {
        position: relative;
        display: inline-block;
        width: 100%;
        padding-top: 75%;
        background-color: gainsboro;
        overflow: hidden;
        border: 1px solid gainsboro;
        transform-origin: top left;
    }
    .previewer__inner {
        position: absolute;
        top: 0;
        left: 0;
        width: 1366px;
        height: 1024px;
        transform-origin: top left;
        overflow: hidden;
    }
    .images-container {
        position: absolute;
        top: 0;
        left: 0;
        transform-origin: top left;
    }
    .sequence-image {
        position: relative;
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
        width: 30px;
        height: 30px;
        background-color: orange;
        border: 6px solid gray;
        border-radius: 50% 50%;
        box-sizing: border-box;
        z-index: 1;
    }
    .hotspot_active {
        background-color: yellow;
        transform-origin: center center;
    }
    .hotspot:hover {
        cursor: pointer;
    }
    .hotspot-info-container {
        width: 100%;
        height: auto;
        display: block;
        position: relative;
        padding: 0 20px;
    }
    .hotspots-container {
        position: absolute;
        width: 100%;
        height: 100%;
        z-index: -10;
    }
</style>
