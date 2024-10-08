import aicPublicationMediaField from '@/components/PublicationMediaField.vue'

const AicConfig = {
  install (Vue, opts) {
    Vue.component('aic-publicationmediafield', aicPublicationMediaField)
  }
}

export default AicConfig
