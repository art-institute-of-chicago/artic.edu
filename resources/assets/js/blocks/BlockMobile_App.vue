<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-wysiwyg label="Callout text" :name="fieldName('callout')" :options='{"modules":{"toolbar":["bold","italic","link"],"syntax":false}}' in-store="value" ></a17-wysiwyg>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
