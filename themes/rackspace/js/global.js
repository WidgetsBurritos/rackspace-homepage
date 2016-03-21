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

  // Detects which Bootstrap environment we're in.
  // Function downloaded from here:
  // http://stackoverflow.com/questions/14441456/how-to-detect-which-device-view-youre-on-using-twitter-bootstrap-api#answer-15150381
  Drupal.behaviors.rackspaceGlobal.findBootstrapEnvironment = function () {
    var envs = ['xs', 'sm', 'md', 'lg'];

    var $el = $('<div>');
    $el.appendTo($('body'));

    for (var i = envs.length - 1; i >= 0; i--) {
      var env = envs[i];

      $el.addClass('hidden-' + env);
      if ($el.is(':hidden')) {
        $el.remove();
        return env;
      }
    }
  }


  // Determines whether or not a url starts with http:// or https://
  var isExternalLink = function (url) {
    return url.match(/^http[s]?\:\/\//);
  }

  // Any http:// or https:// links should open in a new window.
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