<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-inputframe label="Featured items" name="browsers.selections"> <a17-browserfield :name="fieldName('selections')" item-label="featured items" :max="4" :wide="false" endpoint="" :endpoints="[{&quot;label&quot;:&quot;Highlights&quot;,&quot;value&quot;:&quot;\/collection\/selections\/browser&quot;}]" modal-title="Attach featured items" :draggable="true" >Add up to 4 featured items</a17-browserfield></a17-inputframe>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
