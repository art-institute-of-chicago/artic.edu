<template>
    <div class="block__body">
        <a17-vselect label="Size" :name="fieldName('size')" :options='[{"value":"s","label":"Small"},{"value":"m","label":"Medium"},{"value":"l","label":"Large"}]' placeholder="Select size" :selected="{&quot;value&quot;:&quot;m&quot;,&quot;label&quot;:&quot;Medium&quot;}" :has-default-store="true" size="large" in-store="inputValue" ></a17-vselect><a17-inputframe label="Image" name="medias.image" > <a17-mediafield :name="fieldName('image')" crop-context="image" ></a17-mediafield> </a17-inputframe><a17-textfield label="Caption Title" :name="fieldName('caption_title')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Caption" :name="fieldName('caption')" type="textarea" in-store="value" ></a17-textfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
