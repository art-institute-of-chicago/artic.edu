<template>
    <div class="block__body">
        <a17-inputframe label="Artworks" name="browsers.artworks"> <a17-browserfield :name="fieldName('artworks')" item-label="artworks" :max="100" endpoint="/whatson/artworks/browser" modal-title="Attach artworks" >Add up to 100 artworks</a17-browserfield></a17-inputframe>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
