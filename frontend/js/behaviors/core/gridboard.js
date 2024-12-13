import { forEach, triggerCustomEvent } from '@area17/a17-helpers';
import { mediaQuery } from '../../functions/core';

const gridboard = function(container) {
    let colCounts = {};
    let colCount = 0;
    let colCurrent = 0;
    let cols;
    let active = false;
    let maintainOrder = false;
    let primeLayout = container.className;
    let optionLayout = container.getAttribute('data-gridboard-option-layout');
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

        // Get the top margin of the first block
        let firstChild = container.firstElementChild;
        firstChild.classList.add('s-repositioning');
        let marginTop = _getMarginTop(firstChild);
        firstChild.classList.remove('s-repositioning');

        let colWidth = firstChild.offsetWidth;
        let marginLeft = (container.offsetWidth - colWidth * colCount) / (colCount - 1);
        marginTop = typeof marginTop === 'number' ? marginTop : 60; // Default margin top to 60px if calculation fails

        let rows = [];
        let currentRow = [];
        let currentRowHeight = 0;

        // Loop through each block and position them based on the column layout
        forEach(blocks, function(index, block) {
            if (
                !block.classList.contains('s-positioned') ||
                resetPreviousPositions
            ) {
                block.style.height = 'auto';
                block.style.top = "auto";
                block.style.left = "auto";

                let colIndex = index % colCount;
                let rowIndex = Math.floor(index / colCount);

                if (rowIndex !== rows.length) {
                  rows.push(currentRow);
                  currentRow = [];
                  currentRowHeight = 0;
                }

                currentRow.push(block);

                // Calculate the top position based on the tallest element in the previous row
                let topPosition = rowIndex === 0 ? 0 : rows[rowIndex - 1].reduce((maxHeight, el) => {
                  return Math.max(maxHeight, el.offsetTop + el.offsetHeight);
                }, 0) + marginTop;

                // Set the `top` and `left` positions for the block
                let leftPosition = colIndex * (colWidth + marginLeft);
                block.style.position = "absolute";
                block.style.left = `${Math.round(leftPosition)}px`;
                block.style.top = `${Math.round(topPosition)}px`;

                currentRowHeight = Math.max(currentRowHeight, block.offsetHeight);

                // Determine and set the height of the block
                let computedStyle = window.getComputedStyle(block);
                let paddingTop = parseFloat(computedStyle.paddingTop) || 0;
                let paddingBottom =
                    parseFloat(computedStyle.paddingBottom) || 0;

                let newHeight =
                    block.offsetHeight + paddingTop + paddingBottom + 12;

                block.style.height = Math.round(newHeight) + 'px';

                // Add the 's-positioned' class after a delay to mark it as positioned
                setTimeout(function() {
                    block.classList.add('s-positioned');
                }, 250);

                // Update the overall container height to the height of the tallest column
                container.style.height = (topPosition + newHeight) + 'px';

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
            container.getAttribute('data-gridboard-maintain-order') === 'true';
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
            'gridboard:contentAdded',
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
        container.removeEventListener('gridboard:contentAdded', _contentAdded);
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

export default gridboard;
