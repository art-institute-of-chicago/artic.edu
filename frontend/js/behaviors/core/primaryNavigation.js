export default function(container) {
    const expandEventTypes = ['mouseenter', 'focus', 'click']
    const collapseEventTypes = {'scroll': document, 'mouseleave': container}
    const menuBarQuery = 'ul[role="menubar"]'
    const menuQuery = 'ul[role="menu"]'
    const listItemQuery = 'li[role="none"]'
    const menuItemQuery = 'a[role="menuitem"]'
    const levelOneQuery = '.level-1'
    const canExpandAttribute = 'aria-haspopup'
    const isExpandedAttribute = 'aria-expanded'
    const isCollapsingClass = 'collapsing'
    const exhibitionsDetailsContainerQuery = '.exhibitions .details__container'
    const featuredExhibitionTemplateQuery = '#menu-featured-exhibition'
    const exhibitionApiPath = '/api/v1/exhibitions/search'
    const featuredExhibitionApiQuery = new URLSearchParams({
        'fields': 'title,image_url,web_url',
        'query[bool][must][][range][aic_start_at][lte]': 'now',
        'query[bool][must][][term][is_published]': true,
        'query[bool][must][][term][position]': 0,
        'size': 1,
    })
    const featuredExhibitionImageDimensions = new URLSearchParams({
        'h': 'auto',
        'w': 240,
    })

    const menuBar = container.querySelector(menuBarQuery)
    const menuItems = menuBar.querySelectorAll(menuItemQuery)
    const levelOneMenuItems = menuBar.querySelectorAll(`${levelOneQuery}>${menuItemQuery}`)
    const exhibitionsDetailsContainer = container.querySelector(exhibitionsDetailsContainerQuery)
    const featuredExhibitionTemplate = container.querySelector(featuredExhibitionTemplateQuery)

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
        let menuItem = event.target.closest(menuItemQuery)
        if (isLevelOneMenuItem(menuItem)) {
            event.preventDefault()
            event.stopPropagation()
        }
        collapseMenu()
        expandAncestors(menuItem)
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
        let image = `${data.image_url}&${featuredExhibitionImageDimensions.toString()}`

        const template = featuredExhibitionTemplate.content.cloneNode(true)
        template.querySelector('a').setAttribute('href', data.web_url)
        template.querySelector('img').setAttribute('src', image)
        template.querySelector('.title').textContent = data.title

        exhibitionsDetailsContainer.querySelector('a').remove()
        exhibitionsDetailsContainer.prepend(template)
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

    function isLevelOneMenuItem(menuItem) {
        for (let index in levelOneMenuItems) {
            if (menuItem === levelOneMenuItems[index]) {
                return true;
            }
        }
        return false;
    }

    this.init = function() {
        _init();
    };
}
