<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-block-aic_3d_model :name="name" :thumbnail="false" :caption="false" :browser="false" :optional-annotation="true" :cc0="false" />
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
