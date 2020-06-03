<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-locale type="a17-filefield" :attributes="{ label: 'Image Sequence Zip', itemLabel: 'image sequence zip', name: fieldName('image_sequence_file'), note: 'Upload a .zip file', max: 1 }"
></a17-locale>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
