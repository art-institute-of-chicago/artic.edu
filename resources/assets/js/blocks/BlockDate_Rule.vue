<template>
    <div class="block__body">
        <a17-vselect label="Type of rule" :name="fieldName('type')" :options='[{"value":0,"label":"Recurring event"},{"value":1,"label":"Include specific date (ignores everything except Start Date)"},{"value":2,"label":"Exclude specific date (ignores everything except Start Date)"}]' :has-default-store="true" size="large" in-store="inputValue" ></a17-vselect><a17-datepicker label="Start Date" :name="fieldName('start_date')" place-holder="Start Date" enable-time allow-input clear in-store="date"
></a17-datepicker><a17-datepicker label="Ends" :name="fieldName('end_date')" place-holder="Ends" enable-time allow-input clear in-store="date"
></a17-datepicker><a17-textfield label="Or ends after these amount of ocurrencies:" :name="fieldName('ocurrencies')" type="number" note="Overwrites ending date" placeholder="1, 2, 3.... etc" in-store="value" ></a17-textfield><a17-textfield label="Repeat every" :name="fieldName('every')" type="number" placeholder="1, 2, 3.... etc" in-store="value" ></a17-textfield><a17-vselect label="Days/Week/Month" :name="fieldName('recurring_type')" :options='[{"value":0,"label":"Days"},{"value":1,"label":"Week\/s"},{"value":2,"label":"Month\/s"}]' :has-default-store="true" size="large" in-store="inputValue" ></a17-vselect><div>&nbsp;</div><div>&nbsp;</div><div>Weekly options:</div><a17-checkboxgroup :name="fieldName('monday')" :options="[ { value: '1', label: 'Monday' } ]" :inline='false' in-store="currentValue"
></a17-checkboxgroup><a17-checkboxgroup :name="fieldName('tuesday')" :options="[ { value: '1', label: 'tuesday' } ]" :inline='false' in-store="currentValue"
></a17-checkboxgroup><a17-checkboxgroup :name="fieldName('wednesday')" :options="[ { value: '1', label: 'Wednesday' } ]" :inline='false' in-store="currentValue"
></a17-checkboxgroup><a17-checkboxgroup :name="fieldName('thursday')" :options="[ { value: '1', label: 'Thursday' } ]" :inline='false' in-store="currentValue"
></a17-checkboxgroup><a17-checkboxgroup :name="fieldName('friday')" :options="[ { value: '1', label: 'Friday' } ]" :inline='false' in-store="currentValue"
></a17-checkboxgroup><a17-checkboxgroup :name="fieldName('saturday')" :options="[ { value: '1', label: 'Saturday' } ]" :inline='false' in-store="currentValue"
></a17-checkboxgroup><a17-checkboxgroup :name="fieldName('sunday')" :options="[ { value: '1', label: 'Sunday' } ]" :inline='false' in-store="currentValue"
></a17-checkboxgroup><div>&nbsp;</div><div>&nbsp;</div><div>Monthly options:</div><a17-vselect label="Monthly repeat pattern" :name="fieldName('monthly_repeat_pattern')" :options='[{"value":0,"label":"Monthly on the numeric day selected as start date (every 1st, 2nd... etc)"},{"value":1,"label":"Monthly the first day of the week selected as start date (first Monday, first Tuesday... etc)"}]' :has-default-store="true" size="large" in-store="inputValue" ></a17-vselect>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
