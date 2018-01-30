<template>
    <div class="block__body">
        <a17-textfield label="Quote text" :name="fieldName('quote')" type="textarea" :maxlength="250" :rows="4" in-store="value" ></a17-textfield><a17-textfield label="Quote author" :name="fieldName('author')" type="text" :maxlength="150" in-store="value" ></a17-textfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
