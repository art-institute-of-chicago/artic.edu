<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-inputframe label="Event" name="browsers.events"> <a17-browserfield :name="fieldName('events')" item-label="event" :max="1" :wide="false" endpoint="/exhibitions_events/events/browser" :endpoints="[]" modal-title="Attach event" :draggable="true" >Add one event</a17-browserfield></a17-inputframe>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
