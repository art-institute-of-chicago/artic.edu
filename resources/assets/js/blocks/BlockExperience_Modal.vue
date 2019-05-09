<template>
    <!-- eslint-disable -->
    <div class="block__body">
        <a17-vselect label="Modal Type" :name="fieldName('modal_type')" :options='[{&quot;value&quot;:&quot;image&quot;,&quot;label&quot;:&quot;Image&quot;},{&quot;value&quot;:&quot;video&quot;,&quot;label&quot;:&quot;Video&quot;},{&quot;value&quot;:&quot;image_sequence&quot;,&quot;label&quot;:&quot;Image Sequence&quot;}]' placeholder="Choose Modal Type" :selected="{&quot;value&quot;:&quot;image&quot;,&quot;label&quot;:&quot;Image&quot;}" :has-default-store="true" size="large" in-store="inputValue" > </a17-vselect><a17-connectorfield :is-value-equal="true" :keep-alive="true" :field-name="fieldName('modal_type')" :required-field-values="'image'" > <a17-singlecheckbox :name="fieldName('zoomable')" label="Zoomable" :initial-value="false" :has-default-store="true" in-store="currentValue"
></a17-singlecheckbox> <a17-repeater type="modal_experience_image" name="modal_experience_image" ></a17-repeater></a17-connectorfield><a17-connectorfield :is-value-equal="true" :field-name="fieldName('modal_type')" :required-field-values="'video'" > <a17-textfield label="Youtube URL" :name="fieldName('youtube_url')" type="text" in-store="value" ></a17-textfield><a17-multiselect label="Video Player Setting" :name="fieldName('video_play_settings')" :options="[{&quot;value&quot;:&quot;autoplay&quot;,&quot;label&quot;:&quot;Autoplay&quot;},{&quot;value&quot;:&quot;controls_dark&quot;,&quot;label&quot;:&quot;Controls Dark&quot;},{&quot;value&quot;:&quot;controls_light&quot;,&quot;label&quot;:&quot;Controls Light&quot;},{&quot;value&quot;:&quot;inset&quot;,&quot;label&quot;:&quot;Inset&quot;},{&quot;value&quot;:&quot;caption&quot;,&quot;label&quot;:&quot;Caption&quot;},{&quot;value&quot;:&quot;loop&quot;,&quot;label&quot;:&quot;Loop&quot;}]" :grid="true" :inline="false" in-store="currentValue" > </a17-multiselect></a17-connectorfield><a17-connectorfield :is-value-equal="true" :field-name="fieldName('modal_type')" :required-field-values="'image_sequence'" > <a17-locale type="a17-filefield" :attributes="{ label: 'Image Sequence Zip', itemLabel: 'image sequence zip', name: fieldName('image_sequence_file'), note: 'Upload a .zip file', max: 1 }"
></a17-locale> <a17-multiselect label="playback" :name="fieldName('image_sequence_playback')" :options="[{&quot;value&quot;:&quot;reverse&quot;,&quot;label&quot;:&quot;Reverse&quot;},{&quot;value&quot;:&quot;infinite&quot;,&quot;label&quot;:&quot;Infinite&quot;}]" :grid="true" :inline="false" in-store="currentValue" > </a17-multiselect></a17-connectorfield><a17-wysiwyg label="Caption" :name="fieldName('image_sequence_caption')" :maxlength='500' in-store="value" ></a17-wysiwyg>
    </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    mixins: [BlockMixin]
  }
</script>
