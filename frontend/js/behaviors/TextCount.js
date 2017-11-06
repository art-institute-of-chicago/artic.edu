import { purgeProperties } from 'a17-helpers';

var textCount = function(container) {

  const input = container.querySelector('input');
  const output = container.querySelector('output');

  function _updateOutput() {
    let str = input.value;
    let length = str.length;

    // browsers count the line breaks as 2 characters, so the count is wrong
    let newLines = str.match(/(\r\n|\n|\r)/g);
    if (newLines !== null) {
      length += newLines.length;
    }

    output.value = length;
  }

  function _init() {
    input.addEventListener('input', _updateOutput, false);
    _updateOutput();
  }

  this.destroy = function() {
    // remove specific event handlers
    input.removeEventListener('input', _updateOutput);

    // remove properties of this behavior
    purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default textCount;
