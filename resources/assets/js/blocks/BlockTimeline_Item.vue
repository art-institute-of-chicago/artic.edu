<template>
    <div class="block__body">
        <a17-datepicker label="Date" :name="fieldName('date')" place-holder="Date" enable-time allow-input clear in-store="date"
></a17-datepicker><a17-textfield label="Text" :name="fieldName('text')" type="text" in-store="value" ></a17-textfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
