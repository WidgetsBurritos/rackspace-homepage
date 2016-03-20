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
    var $other_menus = $(this).siblings().find('> ul');
    $other_menus
      .collapseByDepth(Drupal.behaviors.rackspaceGlobal.options.animationDuration);
    var $submenu = $(this).find("> ul");
    console.log($submenu);
    if ($submenu.hasClass('expanded')) {
      $submenu.removeClass('expanded')
        .collapseByDepth(Drupal.behaviors.rackspaceGlobal.options.animationDuration);
    }
    else {
      $submenu.addClass('expanded')
        .expandByDepth(Drupal.behaviors.rackspaceGlobal.options.animationDuration);
    }
  }

})(jQuery);