<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-inputframe label="Image" name="medias.image" > <a17-mediafield :name="fieldName('image')" crop-context="image" ></a17-mediafield> </a17-inputframe><a17-textfield label="Caption title" :name="fieldName('captionTitle')" type="text" :maxlength="80" in-store="value" ></a17-textfield><a17-textfield label="Caption" :name="fieldName('caption')" type="text" :maxlength="200" in-store="value" ></a17-textfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
