<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-inputframe label="Artists" name="browsers.artists"> <a17-browserfield :name="fieldName('artists')" item-label="artists" :max="1" :wide="false" endpoint="/collection/artists/browser" :endpoints="[]" modal-title="Attach artists" :draggable="true" >Add one artist</a17-browserfield></a17-inputframe><p class="f-note">If no image is selected, we will fall back to the hero image, otherwise we will not show this artist.</p><a17-inputframe label="Image" name="medias.artist_image" > <a17-mediafield :name="fieldName('artist_image')" crop-context="artist_image" ></a17-mediafield> </a17-inputframe>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
