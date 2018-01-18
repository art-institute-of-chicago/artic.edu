<template>
    <div class="block__body">
        <div class="col"> <a17-textfield label="Name" :name="fieldName('name')" type="text" required in-store="value" ></a17-textfield> <a17-textfield label="Street" :name="fieldName('street')" type="text" in-store="value" ></a17-textfield> <a17-textfield label="Address" :name="fieldName('address')" type="text" in-store="value" ></a17-textfield> </div> <div class="col"> <a17-textfield label="City" :name="fieldName('city')" type="text" in-store="value" ></a17-textfield> <a17-textfield label="State" :name="fieldName('state')" type="text" in-store="value" ></a17-textfield> <a17-textfield label="ZIP code" :name="fieldName('zip')" type="text" in-store="value" ></a17-textfield> </div>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
