/**
 * @file Customized jQuery plugins for the Rackspace Homepage App.
 * @author David Stinemetze
 */

(function ($) {
  // Callback to set the opacity to the current progress value.
  var progressOpacity = function(animation, progress, remainingMs) {
    if (typeof animation.tweens[0] !== "undefined") {
      // Determine if we're opening or closing.
      var opening = animation.tweens[0].start < animation.tweens[0].end;

      // Calculate opacity based on progress. Invert value, if closing action is called.
      var opacity = progress * 1.0;
      if (!opening) {
        opacity = 1 - opacity;
      }
      $(this).css('opacity', opacity);
    }
  }

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

  // Collapses a region based on depth classes. If no depth classes exist,
  // this function does nothing, but could easily call a default collapse action.
  $.fn.collapseByDepth = function (duration) {
    var $li = $(this).closest('li.expanded');

    // li.depth-1 should slide up when it's done.
    if ($li.hasClass('depth-1')) {
      $(this).stop(true, true).slideUp({
        'duration' : duration,
        'progress' : progressOpacity
      });
    }
    // li.depth-2 should slide left when it's done.
    else if ($li.hasClass('depth-2')) {
      $(this).stop(true, true).animate({
          'width' : 'toggle',
          'opacity': 0
        },
        duration
      );
    }

    return this;
  }

  // Collapses a region based on depth classes. If no depth classes exist,
  // this function does nothing, but could easily call a default expand action.
  $.fn.expandByDepth = function (duration) {
    var $li = $(this).closest('li.expanded');

    // li.depth-1 should slide down when it opens
    if ($li.hasClass('depth-1')) {
      $(this).stop(true, true).slideDown({
        'duration' : duration,
        'progress' : progressOpacity
      });
    }
    // li.depth-2 should slide right
    else if ($li.hasClass('depth-2')) {
      var parentWidth = $(this).parent().width();
      $(this).stop(true, true).hide().animate({
          'width' : 'toggle',
          'opacity': 1
      },
        duration
      );
    }

    return this;
  }

})(jQuery);