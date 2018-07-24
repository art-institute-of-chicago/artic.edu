<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <div class="col"> <a17-locale type="a17-textfield" :attributes="{ label: 'Title', name: fieldName('title'), type: 'text', required: true, inStore: 'value' }" ></a17-locale> <a17-textfield label="Link" :name="fieldName('link')" type="text" :required="true" in-store="value" ></a17-textfield> </div>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
