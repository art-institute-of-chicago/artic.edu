<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-textfield label="Custom copy" :name="fieldName('copy')" type="text" note="Override default copy" :maxlength="60" in-store="value" ></a17-textfield><a17-vselect label="Newsletter target list" :name="fieldName('list')" :options='[{&quot;value&quot;:&quot;OptEnews&quot;,&quot;label&quot;:&quot;News and Exhibitions&quot;},{&quot;value&quot;:&quot;OptHumanResources&quot;,&quot;label&quot;:&quot;Career Opportunities&quot;},{&quot;value&quot;:&quot;OptEveningAssociates&quot;,&quot;label&quot;:&quot;Young Professionals&quot;},{&quot;value&quot;:&quot;OptFamilyPrograms&quot;,&quot;label&quot;:&quot;Families&quot;},{&quot;value&quot;:&quot;OptEvents&quot;,&quot;label&quot;:&quot;Public Programs&quot;},{&quot;value&quot;:&quot;OptStudentTeacherPrograms&quot;,&quot;label&quot;:&quot;Students and Teachers&quot;},{&quot;value&quot;:&quot;OptTeenPrograms&quot;,&quot;label&quot;:&quot;Teens&quot;},{&quot;value&quot;:&quot;OptAcademicEngagement&quot;,&quot;label&quot;:&quot;Research, Publishing, and Conservation&quot;}]' :has-default-store="true" size="large" in-store="inputValue" > </a17-vselect>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
