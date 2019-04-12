<template>
  <div class="content">
    <br />
    <h1>Tooltip Previewer</h1>
    <br />
    <div class="previewer-container">
        <div class="previewer">
            <div class="previewer-image-container" v-on:click.prevent.stop="addHotspot">
                <img :src="imageUrl" class="previewr-image" />
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
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin],
    data: function() {
        return {
            hotspots: [
                {
                    'x': 50,
                    'y': 50,
                    'description': 'Suspendisse platea pulvinar diam senectus aenean at'
                }
            ],
            currentHotspotPos: [undefined, undefined],
            imageUrl: "https://artic-web.imgix.net/23063a3f-d292-4052-bf80-b2a841fdc894/MirrorPiecesInstallation.jpg?auto=compress%2Cformat&fit=min&fm=jpg&h=430&q=80"
        } 
    },
    computed: {
        currentHotspot: function() {
            return this.hotspots.find(function(el) {
                return el.x === this.currentHotspotPos[0] && el.y === this.currentHotspotPos[1];
            }, this);
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
        width: 70%;
        position: relative;
        background-color: black;
    }

    .previewer:before {
        content: "";
        display: block;
        margin-top: 100%;
    }

    .previewer-image-container {
        position: absolute;
        overflow: hidden;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        height: 100%;
        max-width: 100%;
        max-height: 100%;
    }

    .previewr-image {
        height: 100%;
    }

    .hotspot {
        position: absolute;
        width: 10px;
        height: 10px;
        background-color: orange;
        border: 2px solid white;
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
        display: block;
        position: relative;
        float: right;
        padding: 0 20px;
        width: 30%;
        height: 100%;
    }
</style>
