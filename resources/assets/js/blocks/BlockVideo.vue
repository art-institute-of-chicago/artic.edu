<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-vselect label="Size" :name="fieldName('size')" :options='[{&quot;value&quot;:&quot;s&quot;,&quot;label&quot;:&quot;Small&quot;},{&quot;value&quot;:&quot;m&quot;,&quot;label&quot;:&quot;Medium&quot;},{&quot;value&quot;:&quot;l&quot;,&quot;label&quot;:&quot;Large&quot;}]' placeholder="Select size" :selected="{&quot;value&quot;:&quot;m&quot;,&quot;label&quot;:&quot;Medium&quot;}" :has-default-store="true" size="large" in-store="inputValue" > </a17-vselect><a17-inputframe label="Thumbnail image" name="medias.image" > <a17-mediafield :name="fieldName('image')" crop-context="image" ></a17-mediafield> </a17-inputframe><a17-textfield label="Video URL" :name="fieldName('url')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Caption title" :name="fieldName('caption_title')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Caption" :name="fieldName('caption')" type="textarea" in-store="value" ></a17-textfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
