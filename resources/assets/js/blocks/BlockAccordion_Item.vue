<template>
    <div class="block__body">
        <a17-textfield label="Header" :name="fieldName('header')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Description" :name="fieldName('description')" type="textarea" :rows="4" in-store="value" ></a17-textfield><a17-textfield label="Audio/Video Url" :name="fieldName('source_url')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Link" :name="fieldName('link')" type="text" in-store="value" ></a17-textfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
