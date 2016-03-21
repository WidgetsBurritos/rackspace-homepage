/**
 * @file
 *
 * Global Functionality for the mobile footer used throughout the site.
 */
(function ($) {
  "use strict";

  // DOM is ready
  $(document).ready(function () {
    $('.outer-region-footer .content > ul > li').click(toggleSubMenu);
  })

  var toggleSubMenu = function (event) {
    // Only do this in XS view mode.
    var env = Drupal.behaviors.rackspaceGlobal.findBootstrapEnvironment();
    if (env != 'xs') {
      return;
    }
    var $other_menus = $(this).siblings().find('> ul');
    $other_menus.removeClass('expanded')
      .slideUpAndFadeOut(Drupal.behaviors.rackspaceGlobal.options.animationDuration);
    var $submenu = $(this).find("> ul");
    if ($submenu.hasClass('expanded')) {
      $submenu.removeClass('expanded')
        .slideUpAndFadeOut(Drupal.behaviors.rackspaceGlobal.options.animationDuration);
    }
    else {
      $submenu.addClass('expanded')
        .slideDownAndFadeIn(Drupal.behaviors.rackspaceGlobal.options.animationDuration);
    }
  }

})(jQuery);