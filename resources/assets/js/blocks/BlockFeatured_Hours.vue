<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <div class="col"> <a17-textfield label="Title" :name="fieldName('title')" type="text" :required="true" in-store="value" ></a17-textfield> <a17-textfield label="link" :name="fieldName('external_link')" type="text" :required="true" in-store="value" ></a17-textfield> <a17-textfield label="Text" :name="fieldName('text')" type="text" :required="true" in-store="value" ></a17-textfield> </div>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
