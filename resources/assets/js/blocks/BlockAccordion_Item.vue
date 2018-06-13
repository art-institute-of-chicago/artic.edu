<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-textfield label="Header" :name="fieldName('header')" type="text" :maxlength="60" in-store="value" ></a17-textfield><a17-wysiwyg label="Description" :name="fieldName('description')" :options='{"modules":{"toolbar":["bold","italic","underline","link",{"list":"bullet"}],"syntax":false}}' in-store="value" ></a17-wysiwyg>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
