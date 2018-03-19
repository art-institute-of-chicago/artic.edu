<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-textfield label="Title" :name="fieldName('title')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Description" :name="fieldName('description')" type="textarea" :rows="4" in-store="value" ></a17-textfield><a17-textfield label="Link" :name="fieldName('link')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Button Link" :name="fieldName('button_link')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Button text" :name="fieldName('button_text')" type="text" in-store="value" ></a17-textfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
