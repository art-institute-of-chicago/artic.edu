export default (url, callback) => {
    const xhr = new XMLHttpRequest();
    xhr.onload = function() {
      callback(xhr.response);
    };
    xhr.open("GET", url);
    xhr.responseType = "blob";
    xhr.send();
    return xhr;
  };
  