<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-inputframe label="Shop Items" name="browsers.shopItems"> <a17-browserfield :name="fieldName('shopItems')" item-label="shop items" :max="100" endpoint="/general/shopItems/browser" :endpoints="[]" modal-title="Attach shop items" :draggable="true" >Add up to 100 shop items</a17-browserfield></a17-inputframe>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
