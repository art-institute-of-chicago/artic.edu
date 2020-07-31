<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-inputframe label="Audio Tour Stop" name="browsers.tour_stop"> <a17-browserfield :name="fieldName('tour_stop')" item-label="audio tour stop" :max="1" :wide="false" endpoint="/general/tourStops/browser" :endpoints="[]" modal-title="Attach audio tour stop" :draggable="true" >Add one audio tour stop</a17-browserfield></a17-inputframe><a17-singlecheckbox :name="fieldName('hidePromoText')" label="Hide promo text" :initial-value="false" :has-default-store="true" in-store="currentValue"
></a17-singlecheckbox>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
