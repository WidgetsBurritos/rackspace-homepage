/**
 * @file
 * Global Functionality for the header used throughout the entire website.
 */
(function ($) {
  "use strict";

  // DOM is ready
  $(document).ready(function () {
    $('#search-button').on('click', clickSearchButton);
    // Trigger sub menus on click (.depth-1) or hover (.depth-2).
    $('li.expanded.depth-1 > span.nolink, li.expanded.depth-1 > a').on('click', openSubMenu);
    $('li.expanded.depth-2 > span.nolink, li.expanded.depth-2 > a').on('mouseenter', openSubMenu);
    $('li.expanded.depth-2 > span.nolink, li.expanded.depth-2 > a').on('click', openSubMenu);
  })

  var lastSearchEvent = '';

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
  var openSubMenu = function (event) {
    var env = Drupal.behaviors.rackspaceGlobal.findBootstrapEnvironment();

    // Only allow clicks on mobile menu.
    if ((env !== 'lg' && env !== 'md') && event.type === 'mouseenter') {
      return;
    }

    // Find the parent <li class="expanded"> of the clicked item.
    var $li = $(this).closest('li.expanded');

    // Fetch/generate unique id for this element.
    var uniqueId = $(this).data('unique-id');
    if (typeof(uniqueId) === "undefined") {
      uniqueId = 'unique-' + Math.random();
      $(this).data('unique-id', uniqueId);
    }

    // Hide any neighboring <li>'s submenus.
    var $other_menus = $li.siblings('li.expanded').find('ul.nav');
    $other_menus.css('z-index', Drupal.behaviors.rackspaceGlobal.options.zIndexBack);
    if (env == 'lg' || env == 'md') {
      $other_menus.collapseByDepth(Drupal.behaviors.rackspaceGlobal.options.animationDuration);
    }
    else {
      $other_menus.slideUpAndFadeOut(Drupal.behaviors.rackspaceGlobal.options.animationDuration);
    }

    // When the mouse enters the parent <li>, mark the mouse over state.
    var parentEnter = function (event) {
      $(this).data('mouseover', true);
    };

    // When the mouse leaves from the parent <li>, wait a while and then
    // check to see if we're still not hovering over the parent <li>.
    // - If we are hovering over it again, do nothing.
    // - Otherwise close our sub menu.
    var parentLeave = function (event) {
      $li = $(this);
      $li.data('mouseover', false);
      var timeoutLength;
      if ($(this).hasClass('depth-1')) {
        timeoutLength = Drupal.behaviors.rackspaceGlobal.options.longTimeoutLength;
      }
      else {
        timeoutLength = Drupal.behaviors.rackspaceGlobal.options.shortTimeoutLength;
      }

      if (env == 'lg' || env == 'md') {
        var timeout = setTimeout(function () {
          if (!$li.data('mouseover')) {
            $nav.stop(true, true)
              .collapseByDepth(Drupal.behaviors.rackspaceGlobal.options.animationDuration);
          }
        }, timeoutLength);
      }
    }


    // Show submenu of the clicked menu item.
    var $nav = $(this).next('ul.nav');
    $nav.stop(true, true)
      .css('z-index', Drupal.behaviors.rackspaceGlobal.options.zIndexFront);
    if (env == 'lg' || env == 'md') {
      $nav.expandByDepth(Drupal.behaviors.rackspaceGlobal.options.animationDuration);
      $li.mouseenter(parentEnter);
      $li.mouseleave(parentLeave);
    }
    else {
      $nav.slideDownAndFadeIn(Drupal.behaviors.rackspaceGlobal.options.animationDuration);
    }

  }

})(jQuery);