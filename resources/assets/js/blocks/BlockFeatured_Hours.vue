<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <div class="col"> <a17-inputframe label="Image" name="medias.image" > <a17-mediafield :name="fieldName('image')" crop-context="image" ></a17-mediafield> </a17-inputframe> <a17-textfield label="Intro" :name="fieldName('intro')" type="text" :required="true" in-store="value" ></a17-textfield> <a17-textfield label="Hours" :name="fieldName('hours')" type="text" :required="true" in-store="value" ></a17-textfield> </div>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
