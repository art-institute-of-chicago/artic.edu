<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-inputframe label="Mirador Image" name="medias.image" > <a17-mediafield :name="fieldName('image')" crop-context="image" ></a17-mediafield> </a17-inputframe> <a17-textfield label="Object ID" :name="fieldName('objectId')" type="number" note="Enter object ID to obtain manifest dynamically." in-store="value" ></a17-textfield><a17-locale type="a17-filefield" :attributes="{ label: 'Alternative manifest file', itemLabel: 'alternative manifest file', name: fieldName('upload_manifest_file'), note: 'Upload a .json file', max: 1 }"
></a17-locale><a17-singleselect label="Default View" :name="fieldName('default_view')" :options="[{&quot;value&quot;:&quot;single&quot;,&quot;label&quot;:&quot;Single&quot;},{&quot;value&quot;:&quot;book&quot;,&quot;label&quot;:&quot;Book&quot;}]" selected="single" :grid="false" :inline="true" :has-default-store="true" in-store="value"
> </a17-singleselect><a17-wysiwyg label="Caption title" :name="fieldName('caption_title')" :options='{"modules":{"toolbar":["italic"],"syntax":false}}' in-store="value" ></a17-wysiwyg><a17-wysiwyg label="Caption" :name="fieldName('caption')" note="Max 300 characters" :options='{"modules":{"toolbar":["italic","link"],"syntax":false}}' :maxlength='300' in-store="value" ></a17-wysiwyg>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
