<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-singlecheckbox :name="fieldName('is_slider_zoomable')" label="Enable zoom" :initial-value="false" :has-default-store="true" in-store="currentValue"
></a17-singlecheckbox><a17-vselect label="Size" :name="fieldName('size')" :options='[{&quot;value&quot;:&quot;s&quot;,&quot;label&quot;:&quot;Small&quot;},{&quot;value&quot;:&quot;m&quot;,&quot;label&quot;:&quot;Medium&quot;},{&quot;value&quot;:&quot;l&quot;,&quot;label&quot;:&quot;Large&quot;}]' placeholder="Select size" :selected="{&quot;value&quot;:&quot;m&quot;,&quot;label&quot;:&quot;Medium&quot;}" :has-default-store="true" size="large" in-store="inputValue" > </a17-vselect><a17-wysiwyg label="Caption title" :name="fieldName('caption_title')" :options='{"modules":{"toolbar":["italic"],"syntax":false}}' in-store="value" ></a17-wysiwyg><a17-wysiwyg label="Caption text" :name="fieldName('caption_text')" note="Max 300 characters" :options='{"modules":{"toolbar":["italic","link"],"syntax":false}}' :maxlength='300' in-store="value" ></a17-wysiwyg><hr><a17-inputframe label="Left image" name="medias.left_image" > <a17-mediafield :name="fieldName('left_image')" crop-context="left_image" ></a17-mediafield> </a17-inputframe> <a17-inputframe label="Right image" name="medias.right_image" > <a17-mediafield :name="fieldName('right_image')" crop-context="right_image" ></a17-mediafield> </a17-inputframe> 
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
