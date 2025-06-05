// Function to get the scroll position of an element
const getOffsetTop = function(element) {
    let offsetTop = 0;
    while (element) {
        offsetTop += element.offsetTop;
        element = element.offsetParent;
    }
    return offsetTop;
}

export default getOffsetTop;
