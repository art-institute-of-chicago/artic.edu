<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-vselect label="Layout" :name="fieldName('layout')" :options='[{&quot;value&quot;:1,&quot;label&quot;:&quot;Layout 1 (Mosaic)&quot;},{&quot;value&quot;:2,&quot;label&quot;:&quot;Layout 2 (Carousel)&quot;}]' placeholder="Select layout" :has-default-store="true" size="large" in-store="inputValue" > </a17-vselect><a17-textfield label="Title" :name="fieldName('title')" type="text" :maxlength="150" in-store="value" ></a17-textfield><a17-textfield label="Description" :name="fieldName('description')" type="textarea" :rows="4" in-store="value" ></a17-textfield><a17-repeater type="gallery_item" :name="repeaterName('gallery_item')" ></a17-repeater>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
