<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <p>Use Markdown to create the table below. See <a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet#tables">tutorial</a>.</p><hr><a17-textfield label="Title" :name="fieldName('table_title')" type="text" note="Optional" :maxlength="60" in-store="value" ></a17-textfield><a17-textfield label="Table (Markdown)" :name="fieldName('table_markdown')" type="textarea" note="Limited to one table per block" :rows="4" in-store="value" ></a17-textfield><a17-singlecheckbox :name="fieldName('has_side_header')" label="Leftmost column is also a header" :initial-value="false" :has-default-store="true" in-store="currentValue"
></a17-singlecheckbox>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
