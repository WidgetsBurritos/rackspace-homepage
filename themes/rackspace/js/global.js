/**
 * @file
 * Global functionality used throughout the entire website.
 */
(function ($) {
  "use strict";

  // DOM is ready
  $(document).ready(function () {
    $('a').on('click', clickAllLinks);
    $('form').on('submit', submitAllForms);
  })

  // Initialize our global variable space.
  Drupal.behaviors.rackspaceGlobal = {
    'options': {
      'animationDuration': 300, // How long animations last
      'longTimeoutLength': 1000, // How long to wait to collapse depth-1 submenu
      'shortTimeoutLength': 500, // How long to wait to collapse depth-2 submenu
      'zIndexFront': 10,         // zIndex of Front Element
      'zIndexBack': 1            // zIndex of Back Element
    }
  };

  // Determines whether or not a url starts with http:// or https://
  var isExternalLink = function (url) {
    return url.match(/^http[s]?\:\/\//);
  }

  // Any http:// or https:// links should do nothing.
  var clickAllLinks = function (event) {
    var href = $(this).attr('href');
    if (isExternalLink(href)) {
      event.preventDefault();
      window.open(href, '_blank');
    }
  };

  // Any forms should be submitted in new window to avoid losing track of
  // the docker app.
  var submitAllForms = function (event) {
    var action = $(this).attr('action');
    if (isExternalLink(href)) {
        $(this).attr('target', '_blank');
    }
  };
})(jQuery);