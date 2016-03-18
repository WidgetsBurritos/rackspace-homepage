/**
 * @file Customized jQuery plugins for the Rackspace Homepage App.
 * @author David Stinemetze
 */

(function ($) {
  // Toggles width and Opacity while allowing for custom start and done
  // callback functions.
  $.fn.toggleWidthAndOpacity = function (duration, startCallback, doneCallback) {
    $(this).stop(true, true).animate(
      {
        'width': 'toggle',
        'opacity': 'toggle'
      },
      {
        'duration': duration,
        'start': startCallback,
        'done': doneCallback
      }
    );
    return this;
  }

  $.fn.collapseByDepth = function (duration) {
    var $li = $(this).closest('li.expanded');

    if ($li.hasClass('depth-1')) {
      $(this).stop(true, true).slideUp(duration);
    }
    else if ($li.hasClass('depth-2')) {
      $(this).stop(true, true).animate({
          'width' : '0%',
          'opacity': 0
        },
        duration
      );
    }
  }

  $.fn.expandByDepth = function (duration) {
    var $li = $(this).closest('li.expanded');

    if ($li.hasClass('depth-1')) {
      $(this).stop(true, true).slideDown(duration);
    }
    else if ($li.hasClass('depth-2')) {
      var parentWidth = $(this).parent().width();
      $(this).stop(true, true).show().animate({
          'width' : '100%',
          'opacity': 1
      },
        duration
      );
    }

    return this;
  }

})(jQuery);