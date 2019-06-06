<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-textfield label="Media embed code" :name="fieldName('embed_code')" type="textarea" in-store="value" ></a17-textfield><a17-textfield label="Height override" :name="fieldName('embed_height')" type="text" note="Optional. Use CSS units, e.g. &quot;400px&quot;" in-store="value" ></a17-textfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
