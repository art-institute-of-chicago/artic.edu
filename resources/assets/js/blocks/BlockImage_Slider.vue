<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-singlecheckbox :name="fieldName('is_slider_zoomable')" label="Enable zoom" :initial-value="false" :has-default-store="true" in-store="currentValue"
></a17-singlecheckbox><a17-inputframe label="Left image" name="medias.left_image" > <a17-mediafield :name="fieldName('left_image')" crop-context="left_image" ></a17-mediafield> </a17-inputframe> <a17-inputframe label="Right image" name="medias.right_image" > <a17-mediafield :name="fieldName('right_image')" crop-context="right_image" ></a17-mediafield> </a17-inputframe> 
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
