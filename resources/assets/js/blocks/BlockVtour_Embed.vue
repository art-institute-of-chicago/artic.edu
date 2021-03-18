<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-locale type="a17-filefield" :attributes="{ label: 'Virtual tour XML file', itemLabel: 'virtual tour xml file', name: fieldName('vtour_xml_file'), note: 'Upload a .xml file', max: 1 }"
></a17-locale><a17-vselect label="Size" :name="fieldName('size')" :options='[{&quot;value&quot;:&quot;m&quot;,&quot;label&quot;:&quot;Medium&quot;},{&quot;value&quot;:&quot;l&quot;,&quot;label&quot;:&quot;Large&quot;}]' placeholder="Select size" :selected="{&quot;value&quot;:&quot;l&quot;,&quot;label&quot;:&quot;Large&quot;}" :has-default-store="true" size="large" in-store="inputValue" > </a17-vselect><a17-wysiwyg label="Caption title" :name="fieldName('caption_title')" :options='{"modules":{"toolbar":["italic"],"syntax":false}}' in-store="value" ></a17-wysiwyg><a17-wysiwyg label="Caption" :name="fieldName('caption')" note="Max 300 characters" :options='{"modules":{"toolbar":["italic","link"],"syntax":false}}' :maxlength='300' in-store="value" ></a17-wysiwyg>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
