<template>
    <div class="block__body">
        <a17-vselect label="Layout" :name="fieldName('layout')" :options='[{"value":1,"label":"Small"},{"value":2,"label":"Medium"},{"value":3,"label":"Large"}]' placeholder="Select layout" :selected="{&quot;value&quot;:1,&quot;label&quot;:&quot;Small&quot;}" :has-default-store="true" size="large" in-store="inputValue" ></a17-vselect><a17-inputframe label="Image" name="medias.image" > <a17-mediafield :name="fieldName('image')" crop-context="image" ></a17-mediafield> </a17-inputframe><a17-textfield label="Caption Title" :name="fieldName('caption')" type="text" in-store="value" ></a17-textfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
