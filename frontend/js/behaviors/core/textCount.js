const textCount = function(container) {

  const input = container.querySelector('input');
  const output = container.querySelector('output');

  function _updateOutput() {
    let str = input.value;
    let length = str.length;

    // Browsers count the line breaks as 2 characters, so the count is wrong
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
    // Remove specific event handlers
    input.removeEventListener('input', _updateOutput);

    // Remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };
};

export default textCount;
