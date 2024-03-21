export default function(container) {
    const expandEventTypes = ['mouseenter', 'focus']
    const collapseEventTypes = {'scroll': document, 'mouseleave': container}
    const menuBarQuery = 'ul[role="menubar"]'
    const menuQuery = 'ul[role="menu"]'
    const listItemQuery = 'li[role="none"]'
    const menuItemQuery = 'a[role="menuitem"]'
    const canExpandAttribute = 'aria-haspopup'
    const isExpandedAttribute = 'aria-expanded'
    const featuredExhibitionData =
        'https://api.artic.edu/api/v1/exhibitions/search?query[bool][must][][term][is_published]=true&query[bool][must][][range][aic_start_at][lte]=now&query[bool][must][][range][aic_end_at][gte]=now&query[bool][must_not][term][status]=Closed&fields=title,image_url,web_url&sort=position&size=1'

    const menuBar = container.querySelector(menuBarQuery)
    const menuItems = menuBar.querySelectorAll(menuItemQuery)
    const exhibitionsDetails = container.querySelector('.exhibitions .details')

    function _init() {
        fetch(featuredExhibitionData, { cache: 'force-cache' })
            .then(response => response.json())
            .then(exhibitionHandler)
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

    function exhibitionHandler(json) {
        let data = json['data'][0]

        const template = container.querySelector('#menu-featured-exhibition').content.cloneNode(true)
        template.querySelector('a').setAttribute('href', data.web_url)
        template.querySelector('img').setAttribute('src', data.image_url)
        template.querySelector('.title').textContent = data.title

        exhibitionsDetails.querySelector('a').remove()
        exhibitionsDetails.prepend(template)
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
