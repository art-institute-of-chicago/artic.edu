<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-inputframe label="Image" name="medias.left_image" > <a17-mediafield :name="fieldName('left_image')" crop-context="left_image" ></a17-mediafield> </a17-inputframe><a17-inputframe label="Image" name="medias.right_image" > <a17-mediafield :name="fieldName('right_image')" crop-context="right_image" ></a17-mediafield> </a17-inputframe>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
