<template>
    <div class="block__body">
        <a17-textfield label="Title" :name="fieldName('title')" type="text" :required="true" in-store="value" ></a17-textfield><a17-inputframe v-show="!opened"> <a href='#' @click.prevent='open' class="f--small f--note f--underlined">Edit admission</a></a17-inputframe><div v-show="opened"> <a17-datepicker label="Date" :name="fieldName('date')" place-holder="Date" enable-time allow-input clear :required="true" in-store="date"
></a17-datepicker> <a17-textfield label="Opening time" :name="fieldName('time_start')" type="text" :required="true" in-store="value" ></a17-textfield> <a17-textfield label="Closing time" :name="fieldName('time_end')" type="text" :required="true" in-store="value" ></a17-textfield> <a17-textfield label="Copy" :name="fieldName('copy')" type="textarea" :required="true" in-store="value" ></a17-textfield></div>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
