import { purgeProperties } from '@area17/a17-helpers'
import youtubeEmbed, {
  controlYouTubePlayer
} from '../../functions/core/youtubeEmbed'

const triggerMediaInline = function (container) {
  let iframe
  let src
  let embedSrcType
  let isYoutube = false
  let pendingPlay = false
  let ytPlayerReady = false

  const _handleNativePlaying = () => {
    activateMedia()
  }

  function _youtubePlayAndActivate() {
    controlYouTubePlayer(iframe, { playVideo: true })
    activateMedia()
  }

  function _onYoutubeReady(event) {
    iframe.removeEventListener('youtube:ready', _onYoutubeReady)
    ytPlayerReady = true

    if (pendingPlay) {
      _youtubePlayAndActivate()
    }
  }

  function _handleClicks(event) {
    event.preventDefault()
    event.stopPropagation()

    activateMedia()

    if (isYoutube) {
      if (embedSrcType !== 'src' && !iframe.src) {
        iframe.src = src
      }

      if (ytPlayerReady) {
        _youtubePlayAndActivate()
      } else {
        pendingPlay = true
      }
    }

    container.removeEventListener('click', _handleClicks)
    container.removeEventListener('keyup', _handleKeyUp)
  }

  function _handleKeyUp(event) {
    if (event.keyCode === 13 || event.key === 'Enter') {
      _handleClicks(event)
    }
  }

  function activateMedia() {
    container.classList.add('s-inline-media-activated')
  }

  function _init() {
    iframe = container.querySelector('iframe')

    if (!iframe) {
      return
    }

    src =
      iframe.getAttribute('data-embed-src') ||
      iframe.getAttribute('data-src') ||
      iframe.getAttribute('src')

    if (!src) {
      return
    }

    if (iframe.hasAttribute('data-embed-src')) embedSrcType = 'data-embed-src'
    else if (iframe.hasAttribute('data-src')) embedSrcType = 'data-src'
    else embedSrcType = 'src'

    if (src.includes('youtube.com') || src.includes('youtu.be')) {
      isYoutube = true
      iframe.addEventListener('youtube:ready', _onYoutubeReady)

      if (embedSrcType === 'src') {
        youtubeEmbed(iframe)
      } else {
        iframe.addEventListener(
          'load',
          () => {
            if (iframe.src) {
              youtubeEmbed(iframe)
            }
          },
          false
        )
      }
    }

    container.addEventListener('click', _handleClicks, false)
    container.addEventListener('keyup', _handleKeyUp, false)
    iframe.addEventListener('youtube:playing', _handleNativePlaying)
  }

  this.destroy = function () {
    if (container) {
      container.removeEventListener('click', _handleClicks)
      container.removeEventListener('keyup', _handleKeyUp)
    }
    if (iframe) {
      iframe.removeEventListener('youtube:ready', _onYoutubeReady)
      iframe.removeEventListener('youtube:playing', _handleNativePlaying)
    }
    purgeProperties(this)
  }

  this.init = function () {
    _init()
  }
}

export default triggerMediaInline
