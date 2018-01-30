<template>
    <div class="block__body">
        <a17-textfield label="Name" :name="fieldName('name')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Email" :name="fieldName('email')" type="text" in-store="value" ></a17-textfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
