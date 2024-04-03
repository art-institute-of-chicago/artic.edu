export default function(container) {
    const expandEventTypes = ['mouseenter', 'focus']
    const collapseEventTypes = {'scroll': document, 'mouseleave': container}
    const menuBarQuery = 'ul[role="menubar"]'
    const menuQuery = 'ul[role="menu"]'
    const listItemQuery = 'li[role="none"]'
    const menuItemQuery = 'a[role="menuitem"]'
    const canExpandAttribute = 'aria-haspopup'
    const isExpandedAttribute = 'aria-expanded'
    const isCollapsingClass = 'collapsing'
    const exhibitionApiPath = '/api/v1/exhibitions/search'
    const featuredExhibitionApiQuery = new URLSearchParams({
        'fields': 'title,image_url,web_url',
        'query[bool][must][][range][aic_start_at][lte]': 'now',
        'query[bool][must][][term][is_published]': true,
        'query[bool][must][][term][position]': 0,
        'size': 1,
    })

    const menuBar = container.querySelector(menuBarQuery)
    const menuItems = menuBar.querySelectorAll(menuItemQuery)
    const exhibitionsDetails = container.querySelector('.exhibitions .details')

    function _init() {
        const featuredExhibitionData = new URL(
            `${exhibitionApiPath}?${featuredExhibitionApiQuery.toString()}`,
            container.dataset.apiUrl
        )
        fetch(featuredExhibitionData, { cache: 'force-cache' })
            .then(response => response.json())
            .then(exhibitionHandler)
        menuItems.forEach(function(menuItem) {
            expandEventTypes.forEach(function(eventType) {
                menuItem.addEventListener(eventType, expandHandler)
            })
        })
    }

    function expandHandler(event) {
        collapseMenu()
        expandAncestors(event.target)
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
            menuItem.classList.remove(isCollapsingClass)
            if (menuItem.getAttribute(canExpandAttribute) === 'true') {
                if (menuItem.getAttribute(isExpandedAttribute) === 'true') {
                    menuItem.classList.add(isCollapsingClass)
                }
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
