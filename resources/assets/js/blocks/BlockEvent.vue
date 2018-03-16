<template>
    <div class="block__body">
        <a17-inputframe label="Event" name="browsers.events"> <a17-browserfield :name="fieldName('events')" item-label="event" :max="1" endpoint="/exhibitions_events/events/browser" modal-title="Attach event" >Add one event</a17-browserfield></a17-inputframe>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
