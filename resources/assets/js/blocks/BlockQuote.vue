<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-textfield label="Quote text" :name="fieldName('quote')" type="textarea" :maxlength="250" :rows="4" in-store="value" ></a17-textfield><a17-textfield label="Attribution" :name="fieldName('attribution')" type="text" :maxlength="50" in-store="value" ></a17-textfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
