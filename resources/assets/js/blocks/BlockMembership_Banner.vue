<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-inputframe label="Image" name="medias.membership_banner_image" > <a17-mediafield :name="fieldName('membership_banner_image')" crop-context="membership_banner_image" ></a17-mediafield> </a17-inputframe><a17-textfield label="Headline" :name="fieldName('headline')" type="text" :maxlength="50" in-store="value" ></a17-textfield><a17-textfield label="Short copy" :name="fieldName('short_copy')" type="text" :maxlength="80" in-store="value" ></a17-textfield><a17-textfield label="Link" :name="fieldName('url_address')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Button text" :name="fieldName('link_text')" type="text" in-store="value" ></a17-textfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
