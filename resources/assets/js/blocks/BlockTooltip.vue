<template>
  <div class="content">
    <br />
    <h1>Tooltip Previewer</h1>
    <br />
    <div class="previewer-container">
        <div class="previewer">
            <div class="previewer-image-container" v-show="imageUrl" :style="{ backgroundImage: 'url(' + imageUrl + this.rectParam + ')' }">
                <div class="hidden-box" v-on:click.self="addHotspot" @mousemove.prevent="dragging"></div>
                <div class="hotspot" 
                    v-bind:class="{ hotspot_active: currentHotspot == hotspot }" 
                    v-for="(hotspot, index) in hotspots" 
                    :key="index" 
                    v-bind:style="{ left: hotspot.x + '%', top: hotspot.y + '%' }" 
                    v-on:click="showHotspotInfo(index)"
                    @mousedown.stop.self="dragStart($event, index)"
                    ></div>
            </div>
        </div>
        <div class="hotspot-info-container" v-if="currentHotspot">
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
  </div>
</template>

<script>
  import { mapState } from 'vuex'
  import BlockMixin from '@/mixins/block'
  import FormStoreMixin from '@/mixins/formStore'
  import { FORM } from '@/store/mutations'

  export default {
    mixins: [BlockMixin],
    props: ['hotspotsdata'],
    mounted: function () {
        if (this.hotspotsdata) {
            this.hotspots = this.hotspotsdata;
        };
        this.updateImage();
        window.addEventListener('mouseup', this.dragStop);
    },
    data: function() {
        return {
            hotspots: [],
            currentHotspotPos: [undefined, undefined],
            media: undefined,
            mediaPos: {
                x: 0,
                y: 0
            },
            hotspotIndexDragging: undefined,
            currentDescription: '',
            mousePos: {
                x: 0,
                y: 0
            }
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
        imageUrl: function() {
            return this.media ? this.media['medium'] : '';
        },
        crop: function() {
            return this.media ? (this.media['crops'] ? this.media['crops']['default'] : undefined) : undefined;
        },
        rectParam: function() {
            return this.crop ? '&rect=' + this.crop.x + ',' + this.crop.y + ',' + this.crop.width + ',' + this.crop.height : '';
        },
        ...mapState({
            selectedMedias: state => state.mediaLibrary.selected,
      })
    },
    watch: {
        selectedMedias: {
            handler: function() {
                this.updateImage();
            },
            deep: true
        }
    },
    methods: {
        addHotspot: function (e) {
            if (this.hotspotIndexDragging === undefined) {
                const rect = e.currentTarget.getBoundingClientRect()
                const x = (e.clientX - rect.left) / rect.width * 100
                const y = (e.clientY - rect.top) / rect.height * 100
                this.hotspots = this.hotspots.concat({
                    "x": x,
                    "y": y,
                    "description": ''
                });
                this.showHotspotInfo(this.hotspots.length - 1);
                this.currentDescription = '';
                this.saveHotspots();
            }
        },
        showHotspotInfo: function (index) {
            this.currentHotspotPos = [this.hotspots[index].x, this.hotspots[index].y];
            this.currentDescription = this.currentHotspot.description;
        },
        deleteCurrentHotspot: function () {
            this.hotspots = this.hotspots.filter(function (hotspot) {
                return hotspot !== this.currentHotspot;
            }, this)
            this.saveHotspots();
        },
        changeCurrentDescription: function (newValue) {
            this.currentHotspot = {
                description: newValue
            };
            this.currentDescription = newValue;
            this.saveHotspots();
        },
        saveHotspots: function () {
            const field = {
                name: 'tooltip_hotspots',
                value: this.hotspots
            }
            this.$store.commit(FORM.UPDATE_FORM_FIELD, field)
        },
        updateImage: function() {
            for (const selectedMediaName in this.selectedMedias) {
                const matched = selectedMediaName.match(/^blocks\[tooltipExperienceImage\-\d+\]\[experience_image\]$/) || selectedMediaName.match(/^blocks\[\d+\]\[experience_image\]$/);
                if (matched) {
                    this.media = this.selectedMedias[matched[0]][0];
                    if (this.media) {
                        this.resizeImage();
                        break;
                    }
                }
            }
        },
        resizeImage: function() {
            const imgContainer = document.getElementsByClassName('previewer-image-container')[0];
            if (imgContainer) {
                if (this.crop) {
                    const ratio = this.crop.width / this.crop.height;
                    this.mediaPos.x = this.crop.x / this.media.width * 100;
                    this.mediaPos.y = this.crop.y / this.media.height * 100;
                    imgContainer.style.width = ratio > 1 ? '500px' : 500 * ratio + 'px';
                    imgContainer.style.height = ratio > 1 ? 500 / ratio + 'px' : '500px';
                }
            }
        },
        dragStart(event, hotspotIndex) {
            this.hotspotIndexDragging = hotspotIndex;
            this.mousePos.x = event.clientX;
            this.mousePos.y = event.clientY;
        },
        dragging(event) {
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
            this.hotspotIndexDragging = undefined;
            this.saveHotspots();
        }
    }
  }
</script>

<style lang="scss" scoped>

    .previewer-container {
        position: relative;
        width: 100%;
    }

    .hidden-box {
        position: absolute;
        height: 100%;
        width: 100%;
        top: 0;
        left: 0;
    }

    .previewer {
        display: inline-block;
        width: 500px;
        height: 500px;
        position: relative;
        background-color: black;
    }

    // .previewer:before {
    //     content: "";
    //     display: block;
    //     margin-top: 100%;
    // }

    .previewer-image-container {
        position: relative;
        overflow: hidden;
        background-repeat: no-repeat;
        background-size: cover;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-width: 100%;
        max-height: 100%;
        overflow: hidden;
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
    }

    .hotspot_active {
        transform: translateX(-25%) translateY(-25%) scale(2);
        background-color: yellow;
        transform-origin: center center;
    }

    .hotspot:hover {
        cursor: pointer;
    }

    .hotspot-detail {
        width: 300px;
        height: 100px;
        transform: translate(10px, 10px);
        background-color: white;
        border: 1px solid black;
    }

    .hotspot-info-container {
        width: calc(100% - 500px);
        height: 100%;
        display: block;
        position: relative;
        float: right;
        padding: 0 20px;
    }
</style>
