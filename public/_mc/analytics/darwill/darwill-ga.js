// Google Analytics tracking code for the Art Institute of Chicago
// by Dave Ciske and Ben Baker-Smith
// updated: Nov 19, 2012
// also must include, after this script, the following //dnwssx4l7gl7s.cloudfront.net/artic/default/page/-/js/aic-analytics.js

// parse existing query string
var qsParams = new Array();
var query = window.location.search.substring(1);
var params = query.split('&');
for (var i=0; i<params.length; i++) {
  var pos = params[i].indexOf('=');
  if (pos > 0) {
    var key = params[i].substring(0,pos);
    var val = params[i].substring(pos+1);
    qsParams[key] = val;
  }
}

// if no utm_medium then set direct-mail defaults
if(typeof(qsParams['utm_medium']) === 'undefined') {
  qsParams['utm_medium'] = 'direct-mail';
  qsParams['utm_source'] = 'renewal';
  qsParams['utm_campaign'] = 'member';
  // not sure what packageid is, but if darwill
  // decides to supply one, they just need to
  // define var packageid in a script prior to
  // loading this script. if not supplied, there
  // will be no utm_content for direct-mail
  if(typeof(packageid) !== "undefined") {
    qsParams['utm_content'] = packageid;
  }
}

// reassemble query string and stick it in the URL
qsString = '#';
params =  new Array('utm_medium', 'utm_source', 'utm_campaign', 'utm_content');
for(var i = 0; i < params.length; i++) {
  if(typeof(qsParams[params[i]]) !== 'undefined' && qsParams[params[i]] !== '') {
    if(qsString.length > 1) {
      qsString = qsString + '&';
    }
    qsString = qsString + params[i] + '=' + qsParams[params[i]];
  }
}
location.hash = qsString;
