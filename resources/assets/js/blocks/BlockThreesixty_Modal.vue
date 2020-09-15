<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-inputframe label="360 Image" name="medias.image" > <a17-mediafield :name="fieldName('image')" crop-context="image" ></a17-mediafield> </a17-inputframe><a17-wysiwyg label="Caption title" :name="fieldName('caption_title')" :options='{"modules":{"toolbar":["italic"],"syntax":false}}' in-store="value" ></a17-wysiwyg><a17-wysiwyg label="Caption" :name="fieldName('caption')" note="Max 300 characters" :options='{"modules":{"toolbar":["italic","link"],"syntax":false}}' :maxlength='300' in-store="value" ></a17-wysiwyg><a17-locale type="a17-filefield" :attributes="{ label: '360 Zip', itemLabel: '360 zip', name: fieldName('image_sequence_file'), note: 'Upload a .zip file', max: 1 }"
></a17-locale>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
