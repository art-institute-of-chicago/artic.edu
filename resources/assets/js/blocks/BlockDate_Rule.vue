<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-vselect label="Type of rule" :name="fieldName('type')" :options='[{"value":0,"label":"Recurring event"},{"value":1,"label":"Include specific date (all fields ignored except Start Date)"},{"value":2,"label":"Exclude specific date (all fields ignored except Start Date)"}]' :has-default-store="true" size="large" in-store="inputValue" > </a17-vselect><div class="wrapper"> <div class="col--double"> <a17-datepicker label="Start Date" :name="fieldName('start_date')" place-holder="Start Date" in-store="date"
></a17-datepicker> </div> <div class="col--double"> <a17-datepicker label="Ends" :name="fieldName('end_date')" place-holder="Ends" in-store="date"
></a17-datepicker> <a17-textfield label="Or stop after the following amount of ocurrencies:" :name="fieldName('ocurrencies')" type="number" placeholder="1, 2, 3.... etc" in-store="value" ></a17-textfield> </div></div><div class="wrapper"> <div class="col--double"> <a17-textfield label="Repeat every" :name="fieldName('every')" type="number" placeholder="1, 2, 3.... etc" in-store="value" ></a17-textfield> </div> <div class="col--double"> <a17-vselect label="Days/Week/Month" :name="fieldName('recurring_type')" :options='[{"value":0,"label":"Days"},{"value":1,"label":"Week\/s"},{"value":2,"label":"Month\/s"}]' :has-default-store="true" size="large" in-store="inputValue" > </a17-vselect> </div></div><a17-inputframe v-show="!opened"> <a href='#' @click.prevent='open' class="f--small f--note f--underlined">Edit weekly/monthly options</a></a17-inputframe><div v-show="opened"> <a17-inputframe label="If repeated weekly, which days?"> <div class="input__inliner"> <a17-singlecheckbox :name="fieldName('monday')" label="Monday" :initial-value="false" :has-default-store="true" in-store="currentValue"
></a17-singlecheckbox> <a17-singlecheckbox :name="fieldName('tuesday')" label="Tuesday" :initial-value="false" :has-default-store="true" in-store="currentValue"
></a17-singlecheckbox> <a17-singlecheckbox :name="fieldName('wednesday')" label="Wednesday" :initial-value="false" :has-default-store="true" in-store="currentValue"
></a17-singlecheckbox> <a17-singlecheckbox :name="fieldName('thursday')" label="Thursday" :initial-value="false" :has-default-store="true" in-store="currentValue"
></a17-singlecheckbox> <a17-singlecheckbox :name="fieldName('friday')" label="Friday" :initial-value="false" :has-default-store="true" in-store="currentValue"
></a17-singlecheckbox> <a17-singlecheckbox :name="fieldName('saturday')" label="Saturday" :initial-value="false" :has-default-store="true" in-store="currentValue"
></a17-singlecheckbox> <a17-singlecheckbox :name="fieldName('sunday')" label="Sunday" :initial-value="false" :has-default-store="true" in-store="currentValue"
></a17-singlecheckbox> </div></a17-inputframe> <a17-vselect label="If repeated monthly, select a pattern" :name="fieldName('monthly_repeat_pattern')" :options='[{"value":0,"label":"Monthly on the numeric day selected as start date (every 1st, 2nd... etc)"},{"value":1,"label":"Monthly the first day of the week selected as start date (first Monday, first Tuesday... etc)"}]' :has-default-store="true" size="large" in-store="inputValue" > </a17-vselect></div>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
