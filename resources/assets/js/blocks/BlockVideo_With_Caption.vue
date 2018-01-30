<template>
    <div class="block__body">
        <a17-vselect label="Layout" :name="fieldName('layout')" :options='[{"value":1,"label":"Caption at the bottom"},{"value":2,"label":"Caption at the left"}]' placeholder="Select layout" :selected="{&quot;value&quot;:1,&quot;label&quot;:&quot;Caption at the bottom&quot;}" :has-default-store="true" size="large" in-store="inputValue" ></a17-vselect><a17-inputframe label="Thumbnail image" name="medias.image"> <a17-mediafield :name="fieldName('image')" crop-context="image" ></a17-mediafield> </a17-inputframe><a17-textfield label="Video URL" :name="fieldName('url')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Caption" :name="fieldName('caption')" type="text" in-store="value" ></a17-textfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
