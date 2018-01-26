<template>
    <div class="block__body">
        <a17-textfield label="Reference" :name="fieldName('reference')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Link" :name="fieldName('link')" type="text" in-store="value" ></a17-textfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
