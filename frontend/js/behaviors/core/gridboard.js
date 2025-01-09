import { forEach, triggerCustomEvent, queryStringHandler, getUrlParameterByName } from '@area17/a17-helpers';

const gridboard = function(container) {
    let colCounts = {};
    let colCount = 0;
    let cols;
    let active = false;
    let btnRandoms = Array.from(container.querySelectorAll('.o-gridboard__btn-random'));
    let btnPages = Array.from(container.querySelectorAll('.o-gridboard__btn-page'));
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
            forEach(container.getElementsByClassName('o-gridboard')[0].children, function(index, block) {
                block.style.left = '';
                block.style.top = '';
                block.style.height = '';
                block.classList.remove('s-positioned');
            });
            container.getElementsByClassName('o-gridboard')[0].style.height = '';
        }
    }

    function _positionBlocks(resetPreviousPositions) {
        let allBlocks = container.getElementsByClassName('o-gridboard')[0].children;

        let blocks = Array.from(allBlocks).filter(child => {
          return window.getComputedStyle(child).display !== 'none';
        });

        if (blocks.length === 0) {
            return;
        }

        // Get the top margin of the first block
        let firstChild = blocks[0];
        firstChild.classList.add('s-repositioning');
        let marginTop = _getMarginTop(firstChild);
        marginTop = typeof marginTop === 'number' ? marginTop : 60; // Default margin top to 60px if calculation fails
        firstChild.classList.remove('s-repositioning');

        let colWidth = firstChild.offsetWidth;
        let marginLeft = (container.getElementsByClassName('o-gridboard')[0].offsetWidth - colWidth * colCount) / (colCount - 1);

        let rows = [];
        let currentRow = [];
        let currentRowHeight = 0;

        // Loop through each block and position them based on the column layout
        forEach(blocks, function(index, block) {
            if (
                !block.classList.contains('s-positioned') ||
                resetPreviousPositions
            ) {
              let colIndex = index % colCount;
                let rowIndex = Math.floor(index / colCount);

                if (rowIndex !== rows.length) {
                  rows.push(currentRow);
                  currentRow = [];
                  currentRowHeight = 0;
                }

                currentRow.push(block);

                // Calculate the top position based on the tallest element in the previous row
                let prevTop = 0;
                let prevHeight = 0

                if (rowIndex !== 0) {
                  prevTop = rows[rowIndex - 1][0].offsetTop;
                  prevHeight = rows[rowIndex - 1].reduce((maxHeight, el) => {
                    return Math.max(maxHeight, el.offsetHeight);
                  }, 0);
                }
                let topPosition = prevHeight + prevTop + marginTop;


                // Set the `top` and `left` positions for the block
                let leftPosition = colIndex * (colWidth + marginLeft);
                block.style.position = "absolute";
                block.style.left = `${Math.round(leftPosition)}px`;
                block.style.top = `${Math.round(topPosition)}px`;

                currentRowHeight = Math.max(currentRowHeight, block.offsetHeight);

                container.getElementsByClassName('o-gridboard')[0].style.height = (topPosition + currentRowHeight) + 'px';

                // Add the 's-positioned' class after a delay to mark it as positioned
                setTimeout(function() {
                    block.classList.add('s-positioned');
                }, 250);

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
            _getColCounts(container.getElementsByClassName('o-gridboard')[0].className);
            _setupBlocks();
        }, 32);
    }

    function _executeRandom(tag, hash) {
      let blocks = container.getElementsByClassName('o-gridboard')[0].children;
      if (blocks.length === 0) {
          return;
      }

      let hashes = hash.split('');

      // Loop through each block and position them based on the column layout
      forEach(blocks, function(index, block) {
        if (hashes[index] == '1') {
          block.style.display = 'flex';
        }
        else {
          block.style.display = 'none';
        }
      });
      setTimeout(function() {
        _setupBlocks();
        triggerCustomEvent(document, 'page:updated');
        // Update history
        triggerCustomEvent(document, 'history:pushstate', {
          url: '?tag=' + kebabCase(tag),
        });
      }, 32);
    }

    function _executePage(page) {
      let blocks = container.getElementsByClassName('o-gridboard')[0].children;
      if (blocks.length === 0) {
          return;
      }

      // Loop through each block and position them based on the column layout
      forEach(blocks, function(index, block) {
        if ((Math.floor(index / 50) + 1) == page) {
          block.style.display = 'flex';
        }
        else {
          block.style.display = 'none';
        }
      });
      setTimeout(function() {
        _setupBlocks();
        triggerCustomEvent(document, 'page:updated', {'page': page});

        triggerCustomEvent(document, 'history:pushstate', {
          url: '?page=' + page,
        });
      }, 32);
    }

    function kebabCase(string) {
      return string.replace(/\W+/g, " ")
        .split(/ |\B(?=[A-Z])/)
        .map(word => word.toLowerCase())
        .join('-');
    }

    function _init() {
        _getColCounts(container.getElementsByClassName('o-gridboard')[0].className);

        let page = getUrlParameterByName('page', window.location.search);

        if (page) {
          _executePage(page);
        }
        else {
            setTimeout(function() {
              _setupBlocks();
          }, 32); // Add a slight delay for the initial setup similar to how resize behaves
        }
        container.getElementsByClassName('o-gridboard')[0].addEventListener(
            'gridboard:contentAdded',
            _contentAdded,
            false,
        );
        document.addEventListener('resized', _resized, false);
        document.addEventListener('ajaxPageLoad:complete', _resized, false);
        forEach(btnRandoms, function(index, btn) {
          btn.addEventListener('click', _executeRandom.bind(this, btn.innerText, btn.getAttribute('data-hash')), false);
        });
        forEach(btnPages, function(index, btn) {
          btn.addEventListener('click', _executePage.bind(this, btn.innerText), false);
        });
    }

    this.destroy = function() {
        container.removeEventListener('gridboard:contentAdded', _contentAdded);
        document.removeEventListener('resized', _resized);
        document.removeEventListener('ajaxPageLoad:complete', _resized);
        forEach(btnPages, function(index, btn) {
          btn.removeEventListener('click', _executePage.bind(this, btn.innerText), false);
        });
        forEach(btnRandoms, function(index, btn) {
          btn.removeEventListener('click', _executeRandom.bind(this, btn.innerText, btn.getAttribute('data-hash')), false);
        });
        A17.Helpers.purgeProperties(this);
    };

    this.init = function() {
        _init();
    };
};

export default gridboard;
