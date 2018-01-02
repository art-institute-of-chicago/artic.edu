<template>
    <div class="block__body">
        <a17-inputframe label="Image"> <a17-mediafield :name="fieldName('image')" crop-context="image" ></a17-mediafield> </a17-inputframe><a17-textfield label="Link" :name="fieldName('url_address')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Link Text" :name="fieldName('link_text')" type="text" in-store="value" ></a17-textfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
