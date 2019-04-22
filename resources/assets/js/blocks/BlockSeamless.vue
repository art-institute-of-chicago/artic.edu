<template>
  <div class="content">
    <br />
    <h1>Seamless Previewer</h1>
    <br />
    <div class="previewer">
        <div class="images-container">
            <img v-for="image in images" v-bind:key="image.frame" :src="image.url" class="sequence-image" v-show="currentFrame === image.frame"/>
        </div>
        <div class="previewer-panel">
            <p>Frame {{ currentFrame }}</p>
            <input type="range" :min="minFrame" :max="maxFrame" class="frame-slider" step="1" v-model.number="currentFrame">
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
    data () {
        return {
            images: [],
            currentFrame: 0
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
        axios.get('http://aic.dev.a17.io/api/v1/seamless-images/745').then(rsp => {
            this.images = rsp.data;
        });
    },
  }
</script>

<style lang="scss" scoped>
    .previewer {
        position: relative;
        width: 100%;
        height: 500px;
        background-color: black;
        overflow: hidden;
        border: 1px solid gainsboro;
    }
    .images-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }
    .sequence-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
    }
    .previewer-panel {
        position: absolute;
        bottom: 0;
        left: 0;
        background-color: hsla(0,0%,100%,.8);
    }
</style>
