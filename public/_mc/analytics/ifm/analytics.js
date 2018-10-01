// Google Analytics tracking used by http://impressionsandfashion.tumblr.com/

// define aicAnalytics
var aicAnalytics = {

  initialize: function() {
    // if _gaq doesn't already exist, create placeholder array
    window._gaq = window._gaq || [];
    aicAnalytics.basicSettings();
    aicAnalytics.trackPageview();
    aicAnalytics.loadGoogleAnalytics();
  },

  loadGoogleAnalytics: function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(ga, s);
  },

  basicSettings: function() {
    _gaq.push(['_setAccount', 'UA-4351925-1']);
    _gaq.push(['_setDomainName', 'tumblr.com']);
    _gaq.push(['_setAllowLinker', true]);
    _gaq.push(['_setAllowAnchor', true]);
    _gaq.push(['_setSiteSpeedSampleRate', 20]);
  },

  trackPageview: function() {
    _gaq.push(['_trackPageview']);
  },

  addItem: function(item) {
    // TODO check for conflicts with the default value types
    var transactionId = item.transactionId || ''; // set defaults here
    var sku = item.sku || '';
    var name = item.name || '';
    var category = item.category || '';
    var price = item.price || '';
    var quantity = item.quantity || '';
    _gaq.push(["_addItem", transactionId, sku, name, category, price, quantity]);
  },

  addTransaction: function(trans) {
    var orderId = trans.orderId || ''; // set defaults here
    var affiliation = trans.affiliation || '';
    var total = trans.total || '';
    var tax = trans.tax || '';
    var shipping = trans.shipping || '';
    var city = trans.city || '';
    var state = trans.state || '';
    var country = trans.country || '';
    _gaq.push(["_addTrans", orderId, affiliation, total, tax, shipping, city, state, country]);
  },

  trackTransaction: function() {
    _gaq.push(['_trackTrans']);
  }

};

// load jquery and then call the initialize method of input
// to execute...
aicAnalytics.initialize();
