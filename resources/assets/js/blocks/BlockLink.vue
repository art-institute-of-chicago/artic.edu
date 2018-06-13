<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-textfield label="Title" :name="fieldName('title')" type="text" :maxlength="60" in-store="value" ></a17-textfield><a17-textfield label="Link" :name="fieldName('link')" type="text" in-store="value" ></a17-textfield><a17-locale type="a17-filefield" :attributes="{ label: 'Attachment', itemLabel: 'attachment', name: fieldName('attachment'), note: 'Add one file', max: 1 }"
></a17-locale>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
