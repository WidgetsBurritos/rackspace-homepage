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

  // Slide the live chat slider to the left when moused over.
  var mouseOverLiveChatSlider = function(event) {
    $(this).css('right', '30px');
  }

  // Slide the live chat slider off screen when moused out.
  var mouseOutLiveChatSlider = function(event) {
    $(this).css('right', '-234px');
  }

})(jQuery);