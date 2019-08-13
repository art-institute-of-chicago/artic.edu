<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-textfield label="Title" :name="fieldName('grid_title')" type="text" :maxlength="60" in-store="value" ></a17-textfield><a17-textfield label="Link Label" :name="fieldName('grid_link_label')" type="text" note="Displayed at top-right of title bar" :maxlength="60" in-store="value" ></a17-textfield><a17-textfield label="Link URL" :name="fieldName('grid_link_href')" type="text" :maxlength="60" in-store="value" ></a17-textfield><a17-repeater type="grid_item" :name="repeaterName('grid_item')" ></a17-repeater>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
