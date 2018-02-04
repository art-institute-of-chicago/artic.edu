<template>
    <div class="block__body">
        <a17-textfield label="Title" :name="fieldName('title')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Text" :name="fieldName('text')" type="textarea" :rows="4" in-store="value" ></a17-textfield><a17-inputframe label="Image" name="medias.image" > <a17-mediafield :name="fieldName('image')" crop-context="image" ></a17-mediafield> </a17-inputframe>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
