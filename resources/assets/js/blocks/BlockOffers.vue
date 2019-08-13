<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-inputframe label="Image" name="medias.hero" > <a17-mediafield :name="fieldName('hero')" crop-context="hero" ></a17-mediafield> </a17-inputframe><a17-textfield label="Title" :name="fieldName('title')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Description" :name="fieldName('description')" type="textarea" :rows="4" in-store="value" ></a17-textfield><a17-textfield label="Label" :name="fieldName('label')" type="text" note="Displayed at bottom-right of image" in-store="value" ></a17-textfield><a17-textfield label="URL" :name="fieldName('url')" type="text" in-store="value" ></a17-textfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
