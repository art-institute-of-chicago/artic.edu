<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <div class="col"> <a17-vselect label="Icon" :name="fieldName('icon_type')" :options='[{&quot;value&quot;:0,&quot;label&quot;:&quot;Face Coverings&quot;},{&quot;value&quot;:1,&quot;label&quot;:&quot;Physical Distancing&quot;},{&quot;value&quot;:2,&quot;label&quot;:&quot;Mobile Ticket&quot;},{&quot;value&quot;:3,&quot;label&quot;:&quot;Showing Symptoms&quot;},{&quot;value&quot;:4,&quot;label&quot;:&quot;No Checkroom&quot;},{&quot;value&quot;:5,&quot;label&quot;:&quot;No Dining&quot;},{&quot;value&quot;:6,&quot;label&quot;:&quot;Caution&quot;},{&quot;value&quot;:7,&quot;label&quot;:&quot;Floor Icon&quot;},{&quot;value&quot;:8,&quot;label&quot;:&quot;Virtual Queue&quot;}]' :has-default-store="true" size="large" in-store="inputValue" > </a17-vselect> <a17-locale type="a17-textfield" :attributes="{ label: 'Text', name: fieldName('text'), type: 'text', required: true, inStore: 'value' }" ></a17-locale> </div>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
