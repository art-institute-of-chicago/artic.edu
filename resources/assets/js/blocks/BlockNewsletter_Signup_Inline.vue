<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-vselect label="Newsletter target list" :name="fieldName('list')" :options='[{&quot;value&quot;:&quot;OptEveningAssociates&quot;,&quot;label&quot;:&quot;Evening Associates&quot;},{&quot;value&quot;:&quot;OptEvents&quot;,&quot;label&quot;:&quot;Public Programs&quot;},{&quot;value&quot;:&quot;OptFamilyPrograms&quot;,&quot;label&quot;:&quot;Family Programs&quot;},{&quot;value&quot;:&quot;OptMemberTravel&quot;,&quot;label&quot;:&quot;Member Travel&quot;},{&quot;value&quot;:&quot;OptStudentTeacherPrograms&quot;,&quot;label&quot;:&quot;Student and Teacher Programs&quot;},{&quot;value&quot;:&quot;OptTeenPrograms&quot;,&quot;label&quot;:&quot;Teen Programs&quot;},{&quot;value&quot;:&quot;OptAcademicEngagement&quot;,&quot;label&quot;:&quot;Academic Engagement&quot;},{&quot;value&quot;:&quot;OptEnews&quot;,&quot;label&quot;:&quot;E-news&quot;},{&quot;value&quot;:&quot;DP Test&quot;,&quot;label&quot;:&quot;DP test list&quot;}]' :has-default-store="true" size="large" in-store="inputValue" > </a17-vselect>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
