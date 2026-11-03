import { triggerCustomEvent } from '@area17/a17-helpers';

const tabbedTombstone = function(container) {

  const CLASS_ACTIVE = 'is-active';
  const CLASS_OVERFLOWING = 'is-overflowing';
  const CLASS_SCROLL_END = 'is-scroll-end';
  const TAB_SELECTOR = '[role="tab"]';
  const PANEL_SELECTOR = '[role="tabpanel"]';
  const SCROLL_SELECTOR = '.o-tabbed-tombstone__panel-scroll';
  const RAIL_SELECTOR = '.o-tabbed-tombstone__rail';
  const COPY_SELECTOR = '.o-tabbed-tombstone__copy, .o-tabbed-tombstone__row-copy';
  const PANEL_ANIMATION_MS = 250;

  let announcer = null;
  let copiedTimers = [];
  let overflowFrame = null;
  const scrollEls = [];

  function _getTabs() {
    return Array.prototype.slice.call(container.querySelectorAll(TAB_SELECTOR));
  }

  function _getPanels() {
    return Array.prototype.slice.call(container.querySelectorAll(PANEL_SELECTOR));
  }

  function _getActivePanel() {
    const panels = _getPanels();
    for (let i = 0; i < panels.length; i++) {
      if (panels[i].classList.contains(CLASS_ACTIVE)) {
        return panels[i];
      }
    }
    return panels[0] || null;
  }

  // Toggle `.is-overflowing` (fade only shows when the active panel's scroll
  // container actually overflows) and `is-scroll-end` (fade hides once the user
  // has scrolled to the bottom) on the wrapper, from one measurement pass so the
  // two classes can never disagree. Re-measured after a frame to allow any
  // just-shown panel to lay out.
  function _measureOverflow() {
    const panel = _getActivePanel();
    const scroll = panel ? panel.querySelector(SCROLL_SELECTOR) : null;
    if (!scroll) {
      container.classList.remove(CLASS_OVERFLOWING);
      container.classList.remove(CLASS_SCROLL_END);
      return;
    }
    container.classList.toggle(CLASS_OVERFLOWING, scroll.scrollHeight > scroll.clientHeight + 1);
    container.classList.toggle(
      CLASS_SCROLL_END,
      scroll.scrollTop + scroll.clientHeight >= scroll.scrollHeight - 2
    );
  }

  function _checkOverflow() {
    if (overflowFrame && window.cancelAnimationFrame) {
      window.cancelAnimationFrame(overflowFrame);
      overflowFrame = null;
    }
    _measureOverflow();
    if (window.requestAnimationFrame) {
      overflowFrame = window.requestAnimationFrame(function() {
        overflowFrame = null;
        _measureOverflow();
      });
    }
  }

  // Wires a tab: aria-selected, roving tabindex and the active classes on the
  // trigger, its panel and the wrapper (see organisms/_o-tabbed-tombstone).
  function _isAccordion() {
    const rail = container.querySelector(RAIL_SELECTOR);
    return !!rail && window.getComputedStyle(rail).display === 'contents';
  }

  function _isReducedMotion() {
    return !!(window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches);
  }

  function _openPanel(panel, instant) {
    const animate = !instant && _isAccordion() && !_isReducedMotion();

    window.clearTimeout(panel.tabbedTombstoneTimer);
    panel.removeAttribute('hidden');

    if (!animate) {
      panel.style.height = '';
      return;
    }

    panel.style.height = '0px';
    panel.offsetHeight;
    panel.style.height = panel.scrollHeight + 'px';
    panel.tabbedTombstoneTimer = window.setTimeout(function() {
      panel.style.height = '';
    }, PANEL_ANIMATION_MS);
  }

  function _closePanel(panel) {
    const animate = _isAccordion() && !_isReducedMotion();

    window.clearTimeout(panel.tabbedTombstoneTimer);

    if (!animate) {
      panel.style.height = '';
      panel.setAttribute('hidden', '');
      return;
    }

    panel.style.height = panel.scrollHeight + 'px';
    panel.offsetHeight;
    panel.style.height = '0px';
    panel.tabbedTombstoneTimer = window.setTimeout(function() {
      panel.style.height = '';
      panel.setAttribute('hidden', '');
    }, PANEL_ANIMATION_MS);
  }

  function _setActiveTab(tab, focusTab, instant) {
    const tabs = _getTabs();
    const panels = _getPanels();
    const panelId = tab.getAttribute('aria-controls');

    tabs.forEach(function(thisTab) {
      const isActive = thisTab === tab;
      thisTab.setAttribute('aria-selected', isActive ? 'true' : 'false');
      thisTab.setAttribute('tabindex', isActive ? '0' : '-1');
      thisTab.classList.toggle(CLASS_ACTIVE, isActive);
    });

    panels.forEach(function(panel) {
      const isActive = panel.id === panelId;
      panel.classList.toggle(CLASS_ACTIVE, isActive);
      if (isActive) {
        _openPanel(panel, instant);
      } else {
        _closePanel(panel);
      }
    });

    container.classList.add(CLASS_ACTIVE);

    if (focusTab) {
      tab.focus();
    }

    _checkOverflow();
    triggerCustomEvent(container, 'tabbedTombstone:changed', { tab: tab });
  }

  function _legacyCopy(text) {
    const textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.setAttribute('readonly', '');
    textarea.style.position = 'fixed';
    textarea.style.top = '-9999px';
    textarea.style.opacity = '0';
    document.body.appendChild(textarea);

    const selection = document.getSelection();
    const previousRange = (selection && selection.rangeCount > 0) ? selection.getRangeAt(0) : null;

    textarea.select();
    textarea.setSelectionRange(0, textarea.value.length);

    let succeeded = false;
    try {
      succeeded = document.execCommand('copy');
    } catch (err) {
      succeeded = false;
    }

    document.body.removeChild(textarea);

    if (selection && previousRange) {
      selection.removeAllRanges();
      selection.addRange(previousRange);
    }

    return succeeded;
  }

  function _writeToClipboard(text) {
    if (navigator.clipboard && navigator.clipboard.writeText) {
      return navigator.clipboard.writeText(text).then(function() {
        return true;
      }).catch(function() {
        return _legacyCopy(text);
      });
    }
    return Promise.resolve(_legacyCopy(text));
  }

  function _announce(message) {
    if (announcer) {
      announcer.textContent = message;
    }
  }

  function _showCopied(button) {
    button.classList.add('is-copied');

    const timer = setTimeout(function() {
      button.classList.remove('is-copied');
      const index = copiedTimers.indexOf(timer);
      if (index > -1) {
        copiedTimers.splice(index, 1);
      }
    }, 1500);
    copiedTimers.push(timer);

    _announce('Copied');
  }

  function _copyFromButton(button) {
    let value = button.getAttribute('data-copy-value');
    if (value === null) {
      const panel = button.closest(PANEL_SELECTOR);
      if (panel) {
        value = panel.getAttribute('data-copy');
      }
    }
    _writeToClipboard(value || '').then(function(succeeded) {
      if (succeeded) {
        _showCopied(button);
      }
    });
  }

  function _handleClick(event) {
    const copyButton = event.target.closest(COPY_SELECTOR);
    if (copyButton && container.contains(copyButton)) {
      event.preventDefault();
      _copyFromButton(copyButton);
      return;
    }

    const tab = event.target.closest(TAB_SELECTOR);
    if (!tab || !container.contains(tab)) {
      return;
    }

    if (tab.getAttribute('aria-selected') === 'true') {
      return;
    }

    event.preventDefault();
    _setActiveTab(tab, false);
  }

  function _handleKeydown(event) {
    const tab = event.target.closest(TAB_SELECTOR);
    if (!tab || !container.contains(tab)) {
      return;
    }

    const tabs = _getTabs();
    const index = tabs.indexOf(tab);
    if (index === -1) {
      return;
    }

    const keyCodes = { 35: 'End', 36: 'Home', 37: 'ArrowLeft', 38: 'ArrowUp', 39: 'ArrowRight', 40: 'ArrowDown' };
    const key = event.key || keyCodes[event.keyCode] || '';

    let nextIndex = null;
    switch (key) {
      case 'ArrowLeft':
      case 'ArrowUp':
        nextIndex = index === 0 ? tabs.length - 1 : index - 1;
        break;
      case 'ArrowRight':
      case 'ArrowDown':
        nextIndex = index === tabs.length - 1 ? 0 : index + 1;
        break;
      case 'Home':
        nextIndex = 0;
        break;
      case 'End':
        nextIndex = tabs.length - 1;
        break;
      default:
        return;
    }

    event.preventDefault();
    _setActiveTab(tabs[nextIndex], true);
  }

  function _handleResized() {
    const activeTab = container.querySelector(TAB_SELECTOR + '[aria-selected="true"]');

    if (activeTab) {
      _setActiveTab(activeTab, false, true);
    } else if (!_isAccordion()) {
      const firstTab = _getTabs()[0];

      if (firstTab) {
        _setActiveTab(firstTab, false, true);
      }
    }

    _checkOverflow();
  }

  function _handleScroll() {
    _checkOverflow();
  }

  function _handleFontsLoaded() {
    _checkOverflow();
  }

  function _handleWindowLoad() {
    _checkOverflow();
  }

  function _init() {
    const activeTab = container.querySelector(TAB_SELECTOR + '[aria-selected="true"]') || _getTabs()[0];

    container.classList.add(CLASS_ACTIVE);

    // Live region for copy feedback read out by assistive tech.
    announcer = document.createElement('span');
    announcer.className = 'o-tabbed-tombstone__announcer sr-only';
    announcer.setAttribute('role', 'status');
    announcer.setAttribute('aria-live', 'polite');
    container.appendChild(announcer);

    container.addEventListener('click', _handleClick, false);
    container.addEventListener('keydown', _handleKeydown, false);

    // Passive scroll listeners on every panel's scroll container keep
    // `is-scroll-end` in sync as the user scrolls the active panel.
    _getPanels().forEach(function(panel) {
      const scroll = panel.querySelector(SCROLL_SELECTOR);
      if (scroll) {
        scroll.addEventListener('scroll', _handleScroll, { passive: true });
        scrollEls.push(scroll);
      }
    });

    // The a17 `resized` helper (see app.js) broadcasts this on the document.
    document.addEventListener('resized', _handleResized, false);
    document.addEventListener('fonts:loaded', _handleFontsLoaded, false);
    window.addEventListener('load', _handleWindowLoad, false);

    // Re-measure once webfonts have settled so the fade matches wrapped copy.
    if (document.fonts && document.fonts.ready && typeof document.fonts.ready.then === 'function') {
      document.fonts.ready.then(_checkOverflow).catch(function() {});
    }

    if (activeTab) {
      _setActiveTab(activeTab, false, true);
    } else {
      _checkOverflow();
    }
  }

  this.destroy = function() {
    container.removeEventListener('click', _handleClick);
    container.removeEventListener('keydown', _handleKeydown);
    scrollEls.forEach(function(scroll) {
      scroll.removeEventListener('scroll', _handleScroll);
    });
    scrollEls.length = 0;
    document.removeEventListener('resized', _handleResized);
    document.removeEventListener('fonts:loaded', _handleFontsLoaded);
    window.removeEventListener('load', _handleWindowLoad);

    if (overflowFrame && window.cancelAnimationFrame) {
      window.cancelAnimationFrame(overflowFrame);
      overflowFrame = null;
    }

    copiedTimers.forEach(function(timer) {
      clearTimeout(timer);
    });
    copiedTimers = [];

    if (announcer && announcer.parentNode === container) {
      container.removeChild(announcer);
    }
    announcer = null;

    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default tabbedTombstone;
