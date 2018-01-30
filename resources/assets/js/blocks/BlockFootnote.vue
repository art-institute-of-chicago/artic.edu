<template>
    <div class="block__body">
        <a17-textfield label="Text" :name="fieldName('text')" type="textarea" :rows="4" in-store="value" ></a17-textfield><a17-textfield label="Anchor Link" :name="fieldName('anchor_link')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Footnote Number" :name="fieldName('number')" type="text" in-store="value" ></a17-textfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
