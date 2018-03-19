<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-textfield label="Email" :name="fieldName('email')" type="text" in-store="value" ></a17-textfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
