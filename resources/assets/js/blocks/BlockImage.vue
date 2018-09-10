<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-vselect label="Size" :name="fieldName('size')" :options='[{&quot;value&quot;:&quot;s&quot;,&quot;label&quot;:&quot;Small&quot;},{&quot;value&quot;:&quot;m&quot;,&quot;label&quot;:&quot;Medium&quot;},{&quot;value&quot;:&quot;l&quot;,&quot;label&quot;:&quot;Large&quot;}]' placeholder="Select size" :selected="{&quot;value&quot;:&quot;m&quot;,&quot;label&quot;:&quot;Medium&quot;}" :has-default-store="true" size="large" in-store="inputValue" > </a17-vselect><a17-inputframe label="Image" name="medias.image" > <a17-mediafield :name="fieldName('image')" crop-context="image" ></a17-mediafield> </a17-inputframe><a17-wysiwyg label="Caption title" :name="fieldName('caption_title')" :options='{"modules":{"toolbar":["italic"],"syntax":false}}' in-store="value" ></a17-wysiwyg><a17-wysiwyg label="Caption" :name="fieldName('caption')" note="Max 200 characters" :options='{"modules":{"toolbar":["italic"],"syntax":false}}' :maxlength='200' in-store="value" ></a17-wysiwyg>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
