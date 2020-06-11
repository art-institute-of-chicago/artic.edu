<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-textfield label="Title" :name="fieldName('title')" type="text" in-store="value" ></a17-textfield><a17-inputframe label="Exhibitions" name="browsers.exhibitions"> <a17-browserfield :name="fieldName('exhibitions')" item-label="exhibitions" :max="4" :wide="false" endpoint="/exhibitions_events/exhibitions/browser" :endpoints="[]" modal-title="Attach exhibitions" :draggable="true" >Add up to 4 exhibitions</a17-browserfield></a17-inputframe>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
