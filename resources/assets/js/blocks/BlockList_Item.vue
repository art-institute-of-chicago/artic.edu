<template>
    <div class="block__body">
        <a17-inputframe label="Image" name="medias.image"> <a17-mediafield :name="fieldName('image')" crop-context="image" ></a17-mediafield> </a17-inputframe><a17-textfield label="Header" :name="fieldName('header')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Description" :name="fieldName('description')" type="textarea" :rows="4" in-store="value" ></a17-textfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
