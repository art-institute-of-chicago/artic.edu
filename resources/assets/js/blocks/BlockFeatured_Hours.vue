<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <div class="col"> <a17-locale type="a17-textfield" :attributes="{ label: 'Title', name: fieldName('title'), type: 'text', required: true, inStore: 'value' }" ></a17-locale> <a17-textfield label="Link" :name="fieldName('external_link')" type="text" :required="true" in-store="value" ></a17-textfield> <a17-locale type="a17-wysiwyg" :attributes="{ label: 'Text', name: fieldName('copy'), inStore: 'value' }" ></a17-locale> </div>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
