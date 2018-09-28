(function() {


  // this script stores 'campaign' query string variables in cookies, and then
  // modifies links with class "citypass-link" to include the original 'campaign'
  // query string variable so that citypass can match purchases to ad keywords.

  // default campaign params may be set simply by including a campaign query var
  // in the link href on the page. any existing campaign query vars will be
  // replaced by those stored in cookies or the page url, if either is present.


  // important variables


  var campaign_cookie_name = 'citypass_campaign';
  var campaign_query_var = 'campaign';
  var campaign_link_class = 'citypass-link';


  // helper functions


  function get_parameter_by_name(name) {
    var regexp = RegExp('[?&]' + name + '=([^&]*)')
    var result = regexp.exec(window.location.search);
    return result && decodeURIComponent(result[1].replace(/\+/g, ' '));
  }
 

  function get_cookie_by_name(name) {
    var regexp = new RegExp(name + '=([^;$]*)', 'g');
    var result = regexp.exec(document.cookie);
    // make sure the cookie actually exists
    return (result !== null && typeof result[1] !== 'undefined') ? result[1] : null;
  }


  function add_campaign_to_links() {
    var this_campaign = get_cookie_by_name(campaign_cookie_name);
    
    if(this_campaign !== null) {
      var citypass_links = document.querySelectorAll('a.' + campaign_link_class);
      for(i = 0; i < citypass_links.length; i++) {
        var link = citypass_links[i];
        link.href = add_campaign_to_single_link(this_campaign, link.href);
      }
    }
  }


  function add_campaign_to_single_link(this_campaign, initial_href) {
    // remove existing campaign param from href if present
    var regexp = new RegExp('[&?]' + campaign_query_var + '=[^&]*');
    var cleaned_href = initial_href.replace(regexp, '', 'g');

    // determine if there's an existing query string, as connector depends on it
    if(initial_href.indexOf('?') === -1) {
      var connector = '?';
    } else {
      var connector = '&';
    }

    // assemble the new href
    var assembled_query_var = campaign_query_var + '=' + this_campaign;
    var new_href = [cleaned_href, assembled_query_var].join(connector);

    // return the new href
    return new_href;
  }


  // get query var, set cookie


  var this_campaign = get_parameter_by_name(campaign_query_var);

  if(this_campaign !== null) {
    document.cookie = campaign_cookie_name + '=' + this_campaign + ';domain=.artic.edu;';
  }


  // get cookie, add campaign query var to links


  if(typeof jQuery !== 'undefined') {
    jQuery(document).ready(add_campaign_to_links);
  } else {
    window.onload = add_campaign_to_links;
  }


}());
