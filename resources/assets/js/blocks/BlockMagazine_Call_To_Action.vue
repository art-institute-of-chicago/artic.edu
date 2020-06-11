<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-singleselect label="Theme" :name="fieldName('theme')" :options="[{&quot;value&quot;:&quot;dark&quot;,&quot;label&quot;:&quot;Dark&quot;},{&quot;value&quot;:&quot;light&quot;,&quot;label&quot;:&quot;Light&quot;}]" selected="dark" :grid="false" :inline="true" :has-default-store="true" in-store="value"
> </a17-singleselect><a17-textfield label="Tag" :name="fieldName('tag')" type="text" note="Small text, e.g. &quot;Exhibition&quot;" in-store="value" ></a17-textfield><a17-wysiwyg label="Title" :name="fieldName('title')" :options='{"modules":{"toolbar":["italic"],"syntax":false}}' in-store="value" ></a17-wysiwyg><a17-textfield label="Link text" :name="fieldName('link_text')" type="text" in-store="value" ></a17-textfield><a17-textfield label="Link URL" :name="fieldName('link_url')" type="text" in-store="value" ></a17-textfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
