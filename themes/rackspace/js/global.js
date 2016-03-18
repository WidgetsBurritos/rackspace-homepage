/**
 * @file Global Settings for the entire Rackspace Homepage App.
 * @author David Stinemetze
 */
(function ($) {
  "use strict";

  // DOM is ready
  $(document).ready(function () {
    $('a').on('click', clickAllLinks);
    $('form').on('submit', submitAllForms);
    $('#search-button').on('click', clickSearchButton);
    $('li.expanded > span.nolink, li.expanded > a').on('click', clickMenuItem);
  })

  // Initialize our global variable space.
  Drupal.behaviors.rackspaceGlobal = {
    'options': {
      'animationDuration': 250, // How long animations last
      'longTimeoutLength': 1000, // How long to wait to collapse depth-1 submenu
      'shortTimeoutLength': 500, // How long to wait to collapse depth-2 submenu
      'zIndexFront': 10,         // zIndex of Front Element
      'zIndexBack': 1            // zIndex of Back Element
    }
  };
  var lastSearchEvent = '';
  var mouseOverElement = [];

  // Determines whether or not a url starts with http:// or https://
  var isExternalLink = function (url) {
    return url.match(/^http[s]?\:\/\//);
  }

  // Any http:// or https:// links should open in a new window to avoid losing
  // track of the docker app.
  var clickAllLinks = function (event) {
    var href = $(this).attr('href');
    if (isExternalLink(href)) {
      event.preventDefault();
      // TODO: REactivate this
//            window.open(href, '_blank');
    }
  };

  // Any forms should be submitted in new window to avoid losing track of
  // the docker app.
  var submitAllForms = function (event) {
    var action = $(this).attr('action');
    if (isExternalLink(href)) {
      // TODO: Reactivate this
      event.preventDefault();
//            $(this).attr('target', '_blank');
    }
  };

  // When someone clicks the search button, toggle the current state of the
  // search form.
  var clickSearchButton = function (event) {
    // In the event the last event was a blur
    if (lastSearchEvent === 'blur') {
      lastSearchEvent = '';
      return;
    }
    event.preventDefault();
    var $searchButton = $(this);
    var $formGroup = $(this).prev('.form-group');
    var $formControl = $formGroup.find('input.form-control');
    $formGroup.toggleWidthAndOpacity(
      Drupal.behaviors.rackspaceGlobal.options.animationDuration,
      function (animation) {
        var actionOpening = animation.tweens[1].start < animation.tweens[1].end;
        if (actionOpening) {
          $searchButton.addClass('focus');
          $formControl.focus().one('blur', function (event) {
            lastSearchEvent = 'blur';
            $formGroup.toggleWidthAndOpacity(
              Drupal.behaviors.rackspaceGlobal.options.animationDuration,
              null,
              function () {
                $searchButton.removeClass('focus');
                lastSearchEvent = '';
              });
          });
        }
        else {
          $searchButton.removeClass('focus');
        }
      });

  };

  // When someone clicks a parent menu item on the navigation bar we should
  // expand sub-navigation.
  var clickMenuItem = function (event) {
    // Find the parent <li class="expanded"> of the clicked item.
    var $li = $(this).closest('li.expanded');
    var uniqueId = $li.uniqueId().prop('id');

    // Hide any neighboring <li>'s submenus.
    $li.siblings('li.expanded').find('ul.nav')
      .css('z-index', Drupal.behaviors.rackspaceGlobal.options.zIndexBack)
      .collapseByDepth(Drupal.behaviors.rackspaceGlobal.options.animationDuration);

    // Show submenu of the clicked menu item.
    var $nav = $(this).next('ul.nav');
    $nav.stop(true, true)
      .css('z-index', Drupal.behaviors.rackspaceGlobal.options.zIndexFront)
      .expandByDepth(Drupal.behaviors.rackspaceGlobal.options.animationDuration);

    // When the mouse enters the parent <li>, mark the mouse over state.
    var parentEnter = function (event) {
//      mouseOverElement[uniqueId] = true;
      $(this).data('mouseover', true);
    };
    $li.mouseenter(parentEnter);

    // When the mouse leaves from the parent <li>, wait a while and then
    // check to see if we're still not hovering over the parent <li>.
    // - If we are hovering over it again, do nothing.
    // - Otherwise close our sub menu.
    var parentLeave = function (event) {
//      mouseOverElement[uniqueId] = false;
      $li = $(this);
      $li.data('mouseover', false);
      var timeoutLength;
      if ($(this).hasClass('depth-1')) {
        timeoutLength = Drupal.behaviors.rackspaceGlobal.options.longTimeoutLength;
      }
      else {
        timeoutLength = Drupal.behaviors.rackspaceGlobal.options.shortTimeoutLength;
      }
      var timeout = setTimeout(function () {
        if (!$li.data('mouseover')) {
          $nav.stop(true, true)
            .collapseByDepth(Drupal.behaviors.rackspaceGlobal.options.animationDuration);
        }
      }, timeoutLength);
    }
    $li.mouseleave(parentLeave);

  }

})(jQuery);