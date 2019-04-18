<template>
  <div class="content">
    <br />
    <h1>Tooltip Previewer</h1>
    <br />
    <div class="previewer-container">
        <div class="previewer">
            <div class="previewer-image-container" v-on:click.prevent.stop="addHotspot" v-show="imageUrl">
                <img :src="imageUrl" class="previewer-image" id="previewer-image"/>
                <div class="hotspot" v-bind:class="{ hotspot_active: currentHotspot == hotspot }" v-for="(hotspot, index) in hotspots" :key="index" v-bind:style="{ left: hotspot.x + '%', top: hotspot.y + '%' }" v-on:click.stop="showHotspotInfo(index)"></div>
            </div>
        </div>
        <div class="hotspot-info-container" v-if="currentHotspot">
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
    },
    data: function() {
        return {
            hotspots: [],
            currentHotspotPos: [undefined, undefined],
            imageUrl: undefined,
        } 
    },
    computed: {
        currentHotspot: function() {
            return this.hotspots.find(function(el) {
                return el.x === this.currentHotspotPos[0] && el.y === this.currentHotspotPos[1];
            }, this);
        },
        ...mapState({
            selectedMedias: state => state.mediaLibrary.selected,
      })
    },
    watch: {
        hotspots: function() {
            this.saveHotspots();
        },
        selectedMedias: function() {
            this.updateImage();
        }
    },
    methods: {
        addHotspot: function (e) {
            const rect = e.currentTarget.getBoundingClientRect()
            const x = (e.clientX - rect.left) / rect.width * 100
            const y = (e.clientY - rect.top) / rect.height * 100
            this.hotspots = this.hotspots.concat({
                "x": x,
                "y": y,
            });
            this.showHotspotInfo(this.hotspots.length - 1);
        },
        showHotspotInfo: function (index) {
            this.currentHotspotPos = [this.hotspots[index].x, this.hotspots[index].y];
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
        updateImage: function() {
            this.hotspots = [];
            this.imageUrl = "";
            for (const selectedMediaName in this.selectedMedias) {
                const matched = selectedMediaName.match(/^blocks\[tooltipExperienceImage\-\d+\]\[experience_image\]$/) || selectedMediaName.match(/^blocks\[\d+\]\[experience_image\]$/);
                if (matched) {
                    this.imageUrl = this.selectedMedias[matched[0]][0]['medium'];
                    this.resizeImage();
                    break;
                }
            }
        },
        resizeImage: function() {
            const img = document.getElementById('previewer-image');
            if (img) {
                img.onload = function(){
                    img.style.width = 'auto';
                    img.style.height = 'auto';
                    const ratio = img.width / img.height;
                    if (ratio > 1) {
                        img.style.width = '500px';
                        img.style.height = 500 / ratio + 'px';
                    } else {
                        img.style.height = '500px';
                        img.style.width = 500 * ratio + 'px';
                    }
                }
            }
        }
    }
  }
</script>

<style lang="scss" scoped>

    .previewer-container {
        position: relative;
        width: 100%;
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
        position: absolute;
        overflow: hidden;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-width: 100%;
        max-height: 100%;
    }

    .previewer-image {
        max-width: 500px;
        max-height: 500px;
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
