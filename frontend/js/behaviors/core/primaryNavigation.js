export default function(container) {
    const expandEventTypes = ['mouseenter', 'focus']
    const collapseEventTypes = {'scroll': document, 'mouseleave': container}
    const menuBarQuery = 'ul[role="menubar"]'
    const menuQuery = 'ul[role="menu"]'
    const listItemQuery = 'li[role="none"]'
    const menuItemQuery = 'a[role="menuitem"]'
    const canExpandAttribute = 'aria-haspopup'
    const isExpandedAttribute = 'aria-expanded'

    const menuBar = container.querySelector(menuBarQuery)
    const menuItems = menuBar.querySelectorAll(menuItemQuery)

    function _init() {
        menuItems.forEach(function(menuItem) {
            expandEventTypes.forEach(function(eventType) {
                menuItem.addEventListener(eventType, expandHandler)
            })
        })
    }

    function expandHandler() {
        collapseMenu()
        expandAncestors(this)
        Object.keys(collapseEventTypes).forEach(function(eventType) {
            collapseEventTypes[eventType].addEventListener(eventType, collapseHandler)

        })
    }

    function collapseHandler(event) {
        collapseMenu()
        document.removeEventListener(event.type, collapseHandler)
    }

    function collapseMenu() {
        menuItems.forEach(function (menuItem) {
            if (menuItem.getAttribute(canExpandAttribute) === 'true') {
                menuItem.setAttribute(isExpandedAttribute, 'false')
            }
        })
    }

    function expandAncestors(menuItem) {
        if (menuItem.getAttribute(canExpandAttribute) === 'true') {
            menuItem.setAttribute(isExpandedAttribute, 'true')
        }
        let ancestor = menuItem.closest(`${menuBarQuery}, ${menuQuery}`).closest(listItemQuery)
        if (ancestor) {
            expandAncestors(ancestor.querySelector(menuItemQuery))
        }
    }

    this.init = function() {
        _init();
    };
}
