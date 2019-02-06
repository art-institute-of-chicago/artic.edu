<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-inputframe label="Image" name="medias.image" > <a17-mediafield :name="fieldName('image')" crop-context="image" ></a17-mediafield> </a17-inputframe><a17-wysiwyg label="Caption title" :name="fieldName('captionTitle')" note="Max 80 characters" :options='{"modules":{"toolbar":["italic"],"syntax":false}}' :maxlength='80' in-store="value" ></a17-wysiwyg><a17-wysiwyg label="Caption" :name="fieldName('caption')" note="Max 200 characters" :options='{"modules":{"toolbar":["italic","link"],"syntax":false}}' :maxlength='200' in-store="value" ></a17-wysiwyg>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
