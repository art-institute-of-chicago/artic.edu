<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-textfield label="Object ID" :name="fieldName('objectId')" type="number" note="Enter object ID to obtain manifest dynamically." in-store="value" ></a17-textfield><a17-locale type="a17-filefield" :attributes="{ label: 'Alternative manifest file', itemLabel: 'alternative manifest file', name: fieldName('upload_manifest_file'), note: 'Upload a .json file', max: 1 }"
></a17-locale>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
