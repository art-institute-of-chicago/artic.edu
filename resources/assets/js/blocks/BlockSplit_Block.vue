<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-singleselect label="Variation" :name="fieldName('variation')" :options="[{&quot;value&quot;:&quot;quarter&quot;,&quot;label&quot;:&quot;Quarter block&quot;},{&quot;value&quot;:&quot;half&quot;,&quot;label&quot;:&quot;Half block&quot;}]" selected="quarter" :grid="false" :inline="true" :has-default-store="true" in-store="value"
> </a17-singleselect><a17-inputframe label="Image" name="medias.image" > <a17-mediafield :name="fieldName('image')" crop-context="image" ></a17-mediafield> </a17-inputframe><a17-wysiwyg label="Paragraph" :name="fieldName('paragraph')" :options='{"modules":{"toolbar":[{"header":2},{"header":3},"bold","italic","underline","link",{"list":"ordered"},{"list":"bullet"}],"syntax":false}}' in-store="value" ></a17-wysiwyg>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
