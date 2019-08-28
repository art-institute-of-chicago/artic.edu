<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-textfield label="Model ID" :name="fieldName('model_id')" type="text" in-store="value" ></a17-textfield><div> <a17-textfield label="Camera Position" :name="fieldName('camera_position')" type="text" disabled in-store="value" ></a17-textfield> <a17-textfield label="Camera Target" :name="fieldName('camera_target')" type="text" disabled in-store="value" ></a17-textfield> <a17-textfield label="Annotation List" :name="fieldName('annotation_list')" type="text" disabled in-store="value" ></a17-textfield> <iframe src="" id="api-frame" allow="autoplay; fullscreen; vr" allowvr allowfullscreen mozallowfullscreen="true" webkitallowfullscreen="true" hidden></iframe></div>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
