<template>
    <div class="block__body">
        <a17-inputframe label="Shop Item" name="browsers.shopItems"> <a17-browserfield :name="fieldName('shopItems')" item-label="shop item" :max="1" endpoint="/visit/shopItems/browser" modal-title="Attach shop item" >Add one shop item</a17-browserfield></a17-inputframe>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
