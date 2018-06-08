<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-inputframe label="Artworks" name="browsers.artworks"> <a17-browserfield :name="fieldName('artworks')" item-label="artworks" :max="100" endpoint="/collection/artworks/browser" modal-title="Attach artworks" :draggable="true" >Add up to 100 artworks</a17-browserfield></a17-inputframe><a17-vselect label="Layout" :name="fieldName('layout')" :options='[{&quot;value&quot;:1,&quot;label&quot;:&quot;Layout 1 (Mosaic)&quot;},{&quot;value&quot;:2,&quot;label&quot;:&quot;Layout 2 (Carousel)&quot;}]' placeholder="Select layout" :has-default-store="true" size="large" in-store="inputValue" > </a17-vselect><a17-textfield label="Gallery Title" :name="fieldName('title')" type="text" :maxlength="150" in-store="value" ></a17-textfield><a17-textfield label="Image Subhead" :name="fieldName('subhead')" type="text" in-store="value" ></a17-textfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
