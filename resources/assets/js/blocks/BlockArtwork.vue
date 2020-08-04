<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-inputframe label="Artworks" name="browsers.artworks"> <a17-browserfield :name="fieldName('artworks')" item-label="artworks" :max="1" :wide="false" endpoint="/collection/artworks/browser" :endpoints="[]" modal-title="Attach artworks" :draggable="true" >Add one artwork</a17-browserfield></a17-inputframe><a17-wysiwyg label="Caption addendum" :name="fieldName('captionAddendum')" note="Appended to generated tombstone" :options='{"modules":{"toolbar":["italic","link"],"syntax":false}}' in-store="value" ></a17-wysiwyg>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
