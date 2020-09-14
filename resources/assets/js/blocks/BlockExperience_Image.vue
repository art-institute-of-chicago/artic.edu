<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-inputframe label="Image" name="medias.experience_image" > <a17-mediafield :name="fieldName('experience_image')" crop-context="experience_image" ></a17-mediafield> </a17-inputframe><a17-singleselect label="Inline Credits" :name="fieldName('inline_credits')" :options="[{&quot;value&quot;:&quot;on&quot;,&quot;label&quot;:&quot;On&quot;},{&quot;value&quot;:&quot;off&quot;,&quot;label&quot;:&quot;Off&quot;}]" selected="off" :grid="false" :inline="true" :has-default-store="true" in-store="value"
> </a17-singleselect><a17-connectorfield :is-value-equal="true" :keep-alive="true" :field-name="fieldName('inline_credits')" :required-field-values="'on'" > <a17-singleselect label="Credits Input" :name="fieldName('credits_input')" :options="[{&quot;value&quot;:&quot;datahub&quot;,&quot;label&quot;:&quot;Datahub&quot;},{&quot;value&quot;:&quot;manual&quot;,&quot;label&quot;:&quot;Manual&quot;}]" selected="datahub" :grid="false" :inline="true" :has-default-store="true" in-store="value"
> </a17-singleselect> <a17-connectorfield :is-value-equal="true" :keep-alive="true" :field-name="fieldName('credits_input')" :required-field-values="'datahub'" > <a17-textfield label="Object ID" :name="fieldName('object_id')" type="text" :maxlength="150" in-store="value" ></a17-textfield></a17-connectorfield> <a17-textfield label="Artist" :name="fieldName('artist')" type="text" :maxlength="150" in-store="value" ></a17-textfield> <a17-textfield label="Title" :name="fieldName('credit_title')" type="text" :maxlength="150" in-store="value" ></a17-textfield> <a17-textfield label="Date" :name="fieldName('credit_date')" type="text" :maxlength="150" in-store="value" ></a17-textfield> <a17-textfield label="Medium" :name="fieldName('medium')" type="text" :maxlength="150" in-store="value" ></a17-textfield> <a17-textfield label="Dimensions" :name="fieldName('dimensions')" type="text" :maxlength="150" in-store="value" ></a17-textfield> <a17-textfield label="Credit Line" :name="fieldName('credit_line')" type="text" :maxlength="150" in-store="value" ></a17-textfield> <a17-textfield label="Main Reference Number" :name="fieldName('main_reference_number')" type="text" :maxlength="150" in-store="value" ></a17-textfield> <a17-textfield label="Copyright Notice" :name="fieldName('copyright_notice')" type="text" :maxlength="150" in-store="value" ></a17-textfield></a17-connectorfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
