<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-block-aic_3d_model :name="name" :thumbnail="false" :caption="true" :browser="false" :cc0="false" :optional-annotation="false" />
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
