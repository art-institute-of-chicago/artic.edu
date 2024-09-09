import { forEach, triggerCustomEvent } from '@area17/a17-helpers';
import { mediaQuery } from '../../functions/core';

const pinboard = function(container) {
    let colCounts = {};
    let colCount = 0;
    let colCurrent = 0;
    let cols;
    let active = false;
    let maintainOrder = false;
    let primeLayout = container.className;
    let optionLayout = container.getAttribute('data-pinboard-option-layout');
    const re = /([0-9])-col@(\w*)/gi;

    function _getColCounts(classes) {
        let classListColInfo;
        while ((classListColInfo = re.exec(classes)) !== null) {
            colCounts[classListColInfo[2]] = classListColInfo[1];
        }
    }

    function _minOfArray(array) {
        return Math.min.apply(Math, array);
    }

    function _maxOfArray(array) {
        return Math.max.apply(Math, array);
    }

    function _getMarginTop(node) {
        let style = window.getComputedStyle(node);
        return parseInt(style.getPropertyValue('margin-top'));
    }

    function _unpositionBlocks() {
        if (active) {
            forEach(container.children, function(index, block) {
                block.style.left = '';
                block.style.top = '';
                block.style.height = '';
                block.classList.remove('s-positioned');
            });
            container.style.height = '';
        }
    }

    function _positionBlocks(resetPreviousPositions) {
        let blocks = container.children;
        if (blocks.length === 0) {
            return;
        }

        let firstChild = container.firstElementChild;
        let colWidth = firstChild.offsetWidth; // Get the width of the first block to calculate column width

        // Calculate the margin between columns
        let marginLeft =
            (container.offsetWidth - colWidth * colCount) / (colCount - 1);

        // Get the top margin of the first block
        firstChild.classList.add('s-repositioning'); // Add a class to avoid margin issues when calculating
        let marginTop = _getMarginTop(firstChild); // Calculate the margin top of the first block
        firstChild.classList.remove('s-repositioning'); // Remove the class once calculated

        marginTop = typeof marginTop === 'number' ? marginTop : 60; // Default margin top to 60px if calculation fails

        colCurrent = 0; // Initialize the current column index

        // Loop through each block and position them based on the column layout
        forEach(blocks, function(index, block) {
            if (
                !block.classList.contains('s-positioned') ||
                resetPreviousPositions
            ) {
                // Reset the block's height to auto, so it can adjust its height dynamically
                block.style.height = 'auto';

                let smallestCol;
                let smallestColIndex;
                let leftPos;

                if (maintainOrder) {
                    smallestCol = cols[colCurrent];
                    smallestColIndex = colCurrent;
                    leftPos = smallestColIndex * (colWidth + marginLeft); // Calculate left position based on the column index and margin
                    colCurrent =
                        colCurrent < cols.length - 1 ? colCurrent + 1 : 0; // Move to the next column or reset
                } else {
                    smallestCol = _minOfArray(cols); // Find the column with the smallest height
                    smallestColIndex = cols.indexOf(smallestCol);
                    leftPos = smallestColIndex * (colWidth + marginLeft); // Set left position based on smallest column index
                }

                // Handle image resizing for variable height blocks
                let img = block.querySelector('img');
                if (
                    img &&
                    block.classList.contains('m-listing--variable-height')
                ) {
                    let blockWidth = block.offsetWidth;
                    let maxHeight = Math.round((blockWidth * 4) / 3); // Set max height as a 4:3 ratio

                    let imageNativeHeightAtThisWidth = Math.round(
                        (parseInt(img.getAttribute('height')) /
                            parseInt(img.getAttribute('width'))) *
                            blockWidth,
                    );

                    // Set the image container's height based on the calculated or max height
                    if (imageNativeHeightAtThisWidth > maxHeight) {
                        img.parentNode.style.height = maxHeight + 'px';
                    } else {
                        img.parentNode.style.height =
                            imageNativeHeightAtThisWidth + 'px';
                    }
                }

                // Get the padding-top and padding-bottom values
                let computedStyle = window.getComputedStyle(block);
                let paddingTop = parseFloat(computedStyle.paddingTop) || 0;
                let paddingBottom =
                    parseFloat(computedStyle.paddingBottom) || 0;

                // Calculate the new height, including padding and other content
                let newHeight =
                    block.offsetHeight + paddingTop + paddingBottom + 12;

                // Position the block
                block.style.left = Math.round(leftPos) + 'px';
                block.style.top = Math.round(smallestCol) + 'px';
                block.style.height = Math.round(newHeight) + 'px';

                // Add the 's-positioned' class after a delay to mark it as positioned
                setTimeout(function() {
                    block.classList.add('s-positioned');
                }, 250);

                // Update the column height, adding the new block's height and margin-top
                cols[smallestColIndex] = smallestCol + newHeight + marginTop;

                // Update the overall container height to the height of the tallest column
                container.style.height = _maxOfArray(cols) + 'px';

                // Trigger a custom event to signal that the page has been updated
                triggerCustomEvent(document, 'page:updated');
            }
        });
    }

    function _setupBlocks() {
        colCount = colCounts[A17.currentMediaQuery];
        if (colCount) {
            cols = [];
            for (var i = 0; i < colCount; i++) {
                cols.push(0);
            }
            active = true;
            _positionBlocks(true);
        } else {
            _unpositionBlocks();
            active = false;
        }
    }

    function _contentAdded() {
        _positionBlocks();
    }

    function _resized() {
        setTimeout(function() {
            _getColCounts(
                document.documentElement.classList.contains(
                    's-collection-filters-active',
                ) && optionLayout
                    ? optionLayout
                    : container.className,
            );
            _setupBlocks();
        }, 32);
    }

    function _showFilters() {
        if (mediaQuery('medium+')) {
            setTimeout(function() {
                _getColCounts(optionLayout);
                _setupBlocks();
            }, 432);
        }
    }

    function _hideFilters() {
        if (mediaQuery('medium+')) {
            setTimeout(function() {
                _getColCounts(container.className);
                _setupBlocks();
            }, 432);
        }
    }

    function _init() {
        maintainOrder =
            container.getAttribute('data-pinboard-maintain-order') === 'true';
        _getColCounts(
            document.documentElement.classList.contains(
                's-collection-filters-active',
            ) && optionLayout
                ? optionLayout
                : container.className,
        );
        setTimeout(function() {
            _setupBlocks();
        }, 32); // Add a slight delay for the initial setup similar to how resize behaves
        container.addEventListener(
            'pinboard:contentAdded',
            _contentAdded,
            false,
        );
        document.addEventListener('resized', _resized, false);
        document.addEventListener('ajaxPageLoad:complete', _resized, false);
        document.addEventListener(
            'collectionFilters:open',
            _showFilters,
            false,
        );
        document.addEventListener(
            'collectionFilters:close',
            _hideFilters,
            false,
        );
    }

    this.destroy = function() {
        container.removeEventListener('pinboard:contentAdded', _contentAdded);
        document.removeEventListener('resized', _resized);
        document.removeEventListener('ajaxPageLoad:complete', _resized);
        document.removeEventListener('collectionFilters:open', _showFilters);
        document.removeEventListener('collectionFilters:close', _hideFilters);
        A17.Helpers.purgeProperties(this);
    };

    this.init = function() {
        _init();
    };
};

export default pinboard;
