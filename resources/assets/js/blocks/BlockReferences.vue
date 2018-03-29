<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-wysiwyg label="Numbered List" :name="fieldName('references')" :options='{"modules":{"toolbar":[{"list":"ordered"},{"list":"bullet"}],"syntax":false}}' in-store="value" ></a17-wysiwyg>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
