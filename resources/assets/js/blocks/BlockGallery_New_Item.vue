<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-singleselect label="Gallery item type" :name="fieldName('gallery_item_type')" :options="[{&quot;value&quot;:&quot;custom&quot;,&quot;label&quot;:&quot;Custom&quot;},{&quot;value&quot;:&quot;artwork&quot;,&quot;label&quot;:&quot;Artwork&quot;}]" selected="custom" :grid="false" :inline="true" :has-default-store="true" in-store="value"
> </a17-singleselect><a17-connectorfield :is-value-equal="true" :field-name="fieldName('gallery_item_type')" :required-field-values="'custom'" > <a17-inputframe label="Image" name="medias.image" > <a17-mediafield :name="fieldName('image')" crop-context="image" ></a17-mediafield> </a17-inputframe> <a17-wysiwyg label="Caption title" :name="fieldName('captionTitle')" :options='{"modules":{"toolbar":["italic"],"syntax":false}}' in-store="value" ></a17-wysiwyg> <a17-wysiwyg label="Caption text" :name="fieldName('captionText')" :options='{"modules":{"toolbar":["italic","link"],"syntax":false}}' in-store="value" ></a17-wysiwyg> <a17-textfield label="YouTube URL" :name="fieldName('videoUrl')" type="text" note="Provide to show video in modal instead of image" in-store="value" ></a17-textfield> <a17-singlecheckbox :name="fieldName('is_zoomable')" label="Zoomable" :initial-value="false" :has-default-store="true" in-store="currentValue"
></a17-singlecheckbox></a17-connectorfield><a17-connectorfield :is-value-equal="true" :field-name="fieldName('gallery_item_type')" :required-field-values="'artwork'" > <a17-inputframe label="Artwork" name="browsers.artworks"> <a17-browserfield :name="fieldName('artworks')" item-label="artwork" :max="1" :wide="false" endpoint="/collection/artworks/browser" :endpoints="[]" modal-title="Attach artwork" :draggable="true" >Add one artwork</a17-browserfield></a17-inputframe> <a17-wysiwyg label="Caption addendum" :name="fieldName('captionAddendum')" note="Appended to generated tombstone" :options='{"modules":{"toolbar":["italic","link"],"syntax":false}}' in-store="value" ></a17-wysiwyg></a17-connectorfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
