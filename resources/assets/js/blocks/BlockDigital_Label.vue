<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-inputframe label="Interactive Feature" name="browsers.digitalLabels"> <a17-browserfield :name="fieldName('digitalLabels')" item-label="interactive feature" :max="1" :wide="false" endpoint="/collection/digitalLabels/browser" :endpoints="[]" modal-title="Attach interactive feature" :draggable="true" >Add one interactive feature</a17-browserfield></a17-inputframe>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
