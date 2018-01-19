<template>
    <div class="block__body">
        <a17-textfield label="Header" :name="fieldName('header')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Subheader" :name="fieldName('subheader')" type="text" in-store="value" ></a17-textfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
