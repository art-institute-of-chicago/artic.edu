<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-singleselect label="Feature type" :name="fieldName('feature_type')" :options="[{&quot;value&quot;:&quot;articles&quot;,&quot;label&quot;:&quot;Article&quot;},{&quot;value&quot;:&quot;selections&quot;,&quot;label&quot;:&quot;Highlights&quot;},{&quot;value&quot;:&quot;experiences&quot;,&quot;label&quot;:&quot;Interactive Features&quot;},{&quot;value&quot;:&quot;custom&quot;,&quot;label&quot;:&quot;Custom&quot;}]" selected="articles" :grid="false" :inline="true" :has-default-store="true" in-store="value"
> </a17-singleselect><a17-connectorfield :is-value-equal="true" :field-name="fieldName('feature_type')" :required-field-values="'articles'" > <a17-inputframe label="Article" name="browsers.articles"> <a17-browserfield :name="fieldName('articles')" item-label="article" :max="1" :wide="false" endpoint="/collection/articles_publications/articles/browser" :endpoints="[]" modal-title="Attach article" :draggable="true" >Add one article</a17-browserfield></a17-inputframe></a17-connectorfield><a17-connectorfield :is-value-equal="true" :field-name="fieldName('feature_type')" :required-field-values="'selections'" > <a17-inputframe label="Highlight" name="browsers.selections"> <a17-browserfield :name="fieldName('selections')" item-label="highlight" :max="1" :wide="false" endpoint="/collection/selections/browser" :endpoints="[]" modal-title="Attach highlight" :draggable="true" >Add one highlight</a17-browserfield></a17-inputframe></a17-connectorfield><a17-connectorfield :is-value-equal="true" :field-name="fieldName('feature_type')" :required-field-values="'experiences'" > <a17-inputframe label="Interactive Feature" name="browsers.experiences"> <a17-browserfield :name="fieldName('experiences')" item-label="interactive feature" :max="1" :wide="false" endpoint="/collection/interactive_features/experiences/browser" :endpoints="[]" modal-title="Attach interactive feature" :draggable="true" >Add one interactive feature</a17-browserfield></a17-inputframe></a17-connectorfield><a17-connectorfield :is-value-equal="true" :field-name="fieldName('feature_type')" :required-field-values="'custom'" > <a17-textfield label="Tag" :name="fieldName('tag')" type="text" note="Small text, e.g. &quot;Exhibition&quot;" in-store="value" ></a17-textfield> <a17-textfield label="Title" :name="fieldName('title')" type="text" note="Use &lt;i&gt; tag to add italics, e.g. &lt;i&gt;Nighthawks&lt;/i&gt;" in-store="value" ></a17-textfield> <a17-textfield label="URL for link" :name="fieldName('url')" type="text" in-store="value" ></a17-textfield></a17-connectorfield><a17-wysiwyg label="List description" :name="fieldName('list_description')" note="Max 255 characters" :options='{"modules":{"toolbar":["italic"],"syntax":false}}' :maxlength='255' in-store="value" ></a17-wysiwyg>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
