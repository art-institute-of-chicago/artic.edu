<template>
    <div class="block__body">
        <a17-textfield label="Audio/Video Url" :name="fieldName('source_url')" type="text" in-store="value" ></a17-textfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
