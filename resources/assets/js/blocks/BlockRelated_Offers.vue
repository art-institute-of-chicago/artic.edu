<template>
    <div class="block__body">
        <a17-repeater type="offer" :name="repeaterName('offer')" ></a17-repeater>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
