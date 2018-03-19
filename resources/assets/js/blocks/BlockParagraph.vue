<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-wysiwyg label="Paragraph" :name="fieldName('paragraph')" in-store="value" ></a17-wysiwyg>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
