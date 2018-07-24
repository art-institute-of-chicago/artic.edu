<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <div class="col"> <a17-inputframe label="Image" name="medias.family_cover" > <a17-mediafield :name="fieldName('family_cover')" crop-context="family_cover" ></a17-mediafield> </a17-inputframe> <a17-locale type="a17-textfield" :attributes="{ label: 'Title', name: fieldName('title'), type: 'text', required: true, inStore: 'value' }" ></a17-locale> <a17-textfield label="Associated generic page link" :name="fieldName('associated_generic_page_link')" type="text" in-store="value" ></a17-textfield> <a17-locale type="a17-wysiwyg" :attributes="{ label: 'Text', name: fieldName('text'), inStore: 'value' }" ></a17-locale> <a17-locale type="a17-textfield" :attributes="{ label: 'Audience link Label', name: fieldName('link_label'), type: 'text', required: true, inStore: 'value' }" ></a17-locale> <a17-textfield label="Audience link" :name="fieldName('external_link')" type="text" :required="true" in-store="value" ></a17-textfield> </div>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
