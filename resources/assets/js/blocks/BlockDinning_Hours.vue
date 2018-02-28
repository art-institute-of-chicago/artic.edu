<template>
    <div class="block__body">
        <div class="col"> <a17-textfield label="Name" :name="fieldName('name')" type="text" :required="true" in-store="value" ></a17-textfield> <a17-textfield label="Hours" :name="fieldName('hours')" type="text" :required="true" in-store="value" ></a17-textfield> <a17-inputframe label="Image" name="medias.image" > <a17-mediafield :name="fieldName('image')" crop-context="image" ></a17-mediafield> </a17-inputframe> </div>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
