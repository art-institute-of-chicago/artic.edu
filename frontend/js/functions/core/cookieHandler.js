// Doc: https://code.area17.com/a17/a17-helpers/wikis/cookieHandler-create
// Doc: https://code.area17.com/a17/a17-helpers/wikis/cookieHandler-delete
// Doc: https://code.area17.com/a17/a17-helpers/wikis/cookieHandler-read

function cookieCreate(name, value, days) {
  var expires = '';
  if (days) {
    var date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000));
    expires = '; expires='+date.toGMTString();
  }
  document.cookie = name+'='+value+expires+'; path=/; '+(A17.env !== 'local' ? 'Secure; ' : '')+'HttpOnly';
}

function cookieDelete(name) {
  if (name) {
    cookieCreate(name, '', -1);
  }
}

function cookieRead(name) {
  if (name) {
    var nameEQ = name + '=';
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
      var c = ca[i];
      while (c.charAt(0) === ' ') {
        c = c.substring(1, c.length);
      }
      if (c.indexOf(nameEQ) === 0) {
        return c.substring(nameEQ.length, c.length);
      }
    }
    return null;
  }
  return null;
}

const cookieHandler = {
  cookieCreate,
  cookieDelete,
  cookieRead,
  // convenience aliases used in some codepaths
  create: cookieCreate,
  delete: cookieDelete,
  read: cookieRead,
};

export default cookieHandler;
