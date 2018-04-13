<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-wysiwyg label="Paragraph" :name="fieldName('paragraph')" :options='{"modules":{"toolbar":[{"header":2},"bold","italic","underline","link",{"list":"bullet"}],"syntax":false}}' in-store="value" ></a17-wysiwyg>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
