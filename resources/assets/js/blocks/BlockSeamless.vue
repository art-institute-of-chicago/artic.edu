<template>
  <div class="content" v-if="images.length > 0">
    <br />
    <h1>Seamless Previewer</h1>
    <br />
    <div class="previewer">
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
    props: ['fileId'],
    data () {
        return {
            images: [],
            currentFrame: 0,
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
        }
    },
    computed: {
        minFrame: function() {
            return 0;
        },
        maxFrame: function() {
            return this.images.length - 1;
        }
    },
    mounted () {
        if (this.fileId) {
            axios.get('http://aic.dev.a17.io/api/v1/seamless-images/' + this.fileId).then(rsp => {
                this.images = rsp.data;
            });
        }
        window.addEventListener('mouseup', this.dragStop);
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
