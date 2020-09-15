<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-textfield label="Time" :name="fieldName('time')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Title" :name="fieldName('title')" type="text" in-store="value" ></a17-textfield><a17-wysiwyg label="Description" :name="fieldName('description')" :options='{"modules":{"toolbar":["italic","link"],"syntax":false}}' in-store="value" ></a17-wysiwyg><a17-inputframe label="Image" name="medias.image" > <a17-mediafield :name="fieldName('image')" crop-context="image" ></a17-mediafield> </a17-inputframe>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
