<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <div class="col"> <a17-textfield label="Title" :name="fieldName('title')" type="text" :required="true" in-store="value" ></a17-textfield> <a17-wysiwyg label="Text" :name="fieldName('text')" in-store="value" ></a17-wysiwyg> <a17-textfield label="Link Label" :name="fieldName('link_label')" type="text" :required="true" in-store="value" ></a17-textfield> <a17-textfield label="Link" :name="fieldName('external_link')" type="text" :required="true" in-store="value" ></a17-textfield> <a17-inputframe label="Image" name="medias.family_cover" > <a17-mediafield :name="fieldName('family_cover')" crop-context="family_cover" ></a17-mediafield> </a17-inputframe> </div>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
