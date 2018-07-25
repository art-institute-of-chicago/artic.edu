<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <div class="col"> <a17-locale type="a17-textfield" :attributes="{ label: 'Name', name: fieldName('name'), type: 'text', required: true, inStore: 'value' }" ></a17-locale> <a17-locale type="a17-textfield" :attributes="{ label: 'Hours', name: fieldName('hours'), type: 'text', required: true, inStore: 'value' }" ></a17-locale> <a17-inputframe label="Image" name="medias.dining_cover" > <a17-mediafield :name="fieldName('dining_cover')" crop-context="dining_cover" ></a17-mediafield> </a17-inputframe> </div>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
