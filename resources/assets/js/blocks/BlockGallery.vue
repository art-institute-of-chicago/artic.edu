<template>
    <div class="block__body">
        <a17-inputframe label="Image" name="medias.image" > <a17-slideshow :name="fieldName('image')" :max="100" crop-context="image" ></a17-slideshow> </a17-inputframe><a17-vselect label="Layout" :name="fieldName('layout')" :options='[{"value":1,"label":"Layout 1 (Mosaic)"},{"value":2,"label":"Layout 2 (Carousel)"}]' placeholder="Select layout" :has-default-store="true" size="large" in-store="inputValue" > </a17-vselect><a17-textfield label="Description" :name="fieldName('description')" type="textarea" :rows="4" in-store="value" ></a17-textfield><a17-textfield label="Image Subhead" :name="fieldName('subhead')" type="text" :maxlength="150" in-store="value" ></a17-textfield><a17-textfield label="Image Label" :name="fieldName('label')" type="text" :maxlength="150" in-store="value" ></a17-textfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
