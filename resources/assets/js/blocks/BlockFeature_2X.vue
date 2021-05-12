<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-inputframe label="Featured items" name="browsers.experiences"> <a17-browserfield :name="fieldName('experiences')" item-label="featured items" :max="2" :wide="false" endpoint="" :endpoints="[{&quot;label&quot;:&quot;Interactive feature&quot;,&quot;value&quot;:&quot;\/collection\/interactive_features\/experiences\/browser&quot;}]" modal-title="Attach featured items" :draggable="true" >Add up to 2 featured items</a17-browserfield></a17-inputframe>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
