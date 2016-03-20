/**
 * @file
 *
 * Global Functionality for the live chat slider used throughout the entire
 * website.
 */
(function ($) {
  "use strict";

  // DOM is ready
  $(document).ready(function () {
    $('#live-chat').hover(mouseOverLiveChatSlider, mouseOutLiveChatSlider)
  })


  var mouseOverLiveChatSlider = function(event) {
    $(this).css('right', '30px');
  }
  var mouseOutLiveChatSlider = function(event) {
    $(this).css('right', '-233px');
  }

})(jQuery);