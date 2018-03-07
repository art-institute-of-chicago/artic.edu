<template>
    <div class="block__body">
        <a17-textfield label="Media Embed Code" :name="fieldName('embed_code')" type="textarea" in-store="value" ></a17-textfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
