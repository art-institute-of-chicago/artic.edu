<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-textfield label="Title" :name="fieldName('title')" type="text" in-store="value" ></a17-textfield><a17-multiselect label="Audience" :name="fieldName('audience')" :options="[{&quot;value&quot;:1,&quot;label&quot;:&quot;Families&quot;},{&quot;value&quot;:2,&quot;label&quot;:&quot;Members&quot;},{&quot;value&quot;:3,&quot;label&quot;:&quot;Adults&quot;},{&quot;value&quot;:4,&quot;label&quot;:&quot;Teens&quot;},{&quot;value&quot;:5,&quot;label&quot;:&quot;Researchers\/Scholars&quot;},{&quot;value&quot;:6,&quot;label&quot;:&quot;Teachers&quot;},{&quot;value&quot;:7,&quot;label&quot;:&quot;Evening Associates&quot;},{&quot;value&quot;:8,&quot;label&quot;:&quot;Sustaining Fellows&quot;}]" :grid="true" :inline="false" in-store="currentValue" > </a17-multiselect><a17-multiselect label="Type" :name="fieldName('type')" :options="[{&quot;value&quot;:1,&quot;label&quot;:&quot;Classes and Workshops&quot;},{&quot;value&quot;:2,&quot;label&quot;:&quot;Live Arts&quot;},{&quot;value&quot;:3,&quot;label&quot;:&quot;Screenings&quot;},{&quot;value&quot;:4,&quot;label&quot;:&quot;Special Event&quot;},{&quot;value&quot;:5,&quot;label&quot;:&quot;Talks&quot;},{&quot;value&quot;:6,&quot;label&quot;:&quot;Tour&quot;},{&quot;value&quot;:7,&quot;label&quot;:&quot;Programs in Communities&quot;}]" :grid="true" :inline="false" in-store="currentValue" > </a17-multiselect><div class="wrapper"> <div class="col--double col--double-wrap"> <a17-datepicker label="Start date" :name="fieldName('date_start')" place-holder="Start date" in-store="date"
></a17-datepicker> </div> <div class="col--double col--double-wrap"> <a17-datepicker label="End date" :name="fieldName('date_end')" place-holder="End date" in-store="date"
></a17-datepicker> </div></div>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
