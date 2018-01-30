<template>
    <div class="block__body">
        <a17-wysiwyg label="Text" :name="fieldName('text')" in-store="value" ></a17-wysiwyg>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
