/**
 * @file
 */
(function ($) {

    "use strict";

    Drupal.behaviors.rackspaceClickLink = function(event) {
        var href = $(this).attr('href');
        if (href.match(/^http[s]*\:\/\//)) {
            event.preventDefault();
            window.open(href, '_blank');
        }
    };

    // DOM is ready
    $(document).ready(function () {
        // Any http:// or https:// links should open in a new window to avoid losing track of the docker app.
        $('a').on('click', Drupal.behaviors.rackspaceClickLink);
    })

})(jQuery);