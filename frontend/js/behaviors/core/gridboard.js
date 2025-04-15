import { forEach, triggerCustomEvent, queryStringHandler, getUrlParameterByName } from '@area17/a17-helpers';

const gridboard = function(container) {
    let colCounts = {};
    let colCount = 0;
    let cols;
    let active = false;
    const re = /([0-9])-col@(\w*)/gi;

    function _getColCounts(classes) {
        let classListColInfo;
        while ((classListColInfo = re.exec(classes)) !== null) {
            colCounts[classListColInfo[2]] = classListColInfo[1];
        }
    }

    function _getMarginTop(node) {
        let style = window.getComputedStyle(node);
        return parseInt(style.getPropertyValue('margin-top'));
    }

    function _unpositionBlocks() {
        if (active) {
            container.getElementsByClassName('o-gridboard')[0].style.height = '';
        }
    }

    function _positionBlocks(resetPreviousPositions) {
        // When positioning blocks, first clear positioning state but keep coordinates for animation
        if (resetPreviousPositions) {
            _unpositionBlocks();
        }

        let allBlocks = container.getElementsByClassName('o-gridboard')[0].children;

        let blocks = Array.from(allBlocks).filter(child => {
          return window.getComputedStyle(child).display !== 'none';
        });

        if (blocks.length === 0) {
            return;
        }

        // Get the top margin of the first block
        let firstChild = blocks[0];
        let marginTop = _getMarginTop(firstChild);
        marginTop = typeof marginTop === 'number' ? marginTop : 60; // Default margin top to 60px if calculation fails

        let colWidth = firstChild.offsetWidth;
        let marginLeft = (container.getElementsByClassName('o-gridboard')[0].offsetWidth - colWidth * colCount) / (colCount - 1);

        // Initialize rows structure with proper dimensions based on current colCount
        let rows = [];
        let rowHeights = [];

        // Pre-calculate the rows needed based on the number of blocks and colCount
        const totalRows = Math.ceil(blocks.length / colCount);
        for (let i = 0; i < totalRows; i++) {
            rows[i] = [];
            rowHeights[i] = 0;
        }

        // First pass: assign blocks to rows
        forEach(blocks, function(index, block) {
            const rowIndex = Math.floor(index / colCount);
            rows[rowIndex].push(block);
        });

        // Second pass: position blocks and calculate heights
        let totalHeight = 0;

        for (let rowIndex = 0; rowIndex < rows.length; rowIndex++) {
            const row = rows[rowIndex];
            let rowTop = 0;

            // Calculate top position based on previous rows
            if (rowIndex === 0) {
                rowTop = 0;
            } else {
                rowTop = totalHeight + marginTop + 25;
            }

            // Position blocks in the current row
            forEach(row, function(colIndex, block) {
                if (block.style.display === 'none') {
                    block.classList.remove('s-positioned');
                }
                // Set the `top` and `left` positions for the block
                let leftPosition = colIndex * (colWidth + marginLeft);

                block.style.position = "absolute";
                block.style.left = `${Math.round(leftPosition)}px`;
                block.style.top = `${Math.round(rowTop)}px`;

                // Update the maximum height for this row
                rowHeights[rowIndex] = Math.max(rowHeights[rowIndex], block.offsetHeight);

                // Add the 's-positioned' class after a delay to mark it as positioned
                setTimeout(function() {
                    block.classList.add('s-positioned');
                }, 50);
            });

            // Update the total height after this row
            totalHeight = rowTop + rowHeights[rowIndex];
        }

        // Set the container height
        container.getElementsByClassName('o-gridboard')[0].style.height = totalHeight + 'px';

        // Trigger a custom event to signal that the page has been updated
        triggerCustomEvent(document, 'page:updated');
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
        // Keep track of previous column count to detect changes
        const previousColCount = colCount;

        setTimeout(function() {
            _getColCounts(container.getElementsByClassName('o-gridboard')[0].className);

            // Always call setupBlocks which will reposition all items with animation
            _setupBlocks();
        }, 32);
    }

    function _init() {
        _getColCounts(container.getElementsByClassName('o-gridboard')[0].className);

        setTimeout(function() {
            _setupBlocks();
        }, 32); // Add a slight delay for the initial setup similar to how resize behaves

        container.getElementsByClassName('o-gridboard')[0].addEventListener(
            'gridboard:contentAdded',
            _contentAdded,
            false,
        );
        document.addEventListener('resized', _resized, false);
        document.addEventListener('ajaxPageLoad:complete', _resized, false);
        document.addEventListener('filter:updated', _resized);
    }

    this.destroy = function() {
        container.removeEventListener('gridboard:contentAdded', _contentAdded);
        document.removeEventListener('resized', _resized);
        document.removeEventListener('ajaxPageLoad:complete', _resized);
        A17.Helpers.purgeProperties(this);
    };

    this.init = function() {
        _init();
    };
};

export default gridboard;