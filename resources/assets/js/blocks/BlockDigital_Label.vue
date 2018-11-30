<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-inputframe label="Digital Label" name="browsers.digitalLabels"> <a17-browserfield :name="fieldName('digitalLabels')" item-label="digital label" :max="1" endpoint="/collection/digitalLabels/browser" modal-title="Attach digital label" :draggable="true" >Add one digital label</a17-browserfield></a17-inputframe>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
