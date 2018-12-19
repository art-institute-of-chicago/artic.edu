<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-textfield label="Header" :name="fieldName('header')" type="text" note="Not shown if omitted" in-store="value" ></a17-textfield><a17-textfield label="Placeholder text" :name="fieldName('placeholder')" type="text" note="Shown inside search bar" in-store="value" ></a17-textfield><a17-textfield label="Search URL template" :name="fieldName('url_template')" type="text" note="Use {query} to specify which part should be replaced" in-store="value" ></a17-textfield>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
