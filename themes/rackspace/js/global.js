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
        $('li.expanded span.nolink').on('click', clickParentMenuItem);
    })

    // Initialize our global variable space.
    Drupal.behaviors.rackspaceGlobal = {
        'animationDuration': 250,
        'lastSearchEvent': '',
        'lastMenuEvent': []
    };


    // Animates the search collapse/expand.
    $.fn.toggleSearch = function (startCallback, doneCallback) {
        $(this).stop(false, false).animate(
            {
                'width': 'toggle',
                'opacity': 'toggle'
            },
            {
                'duration': Drupal.behaviors.rackspaceGlobal.animationDuration,
                'start': startCallback,
                'done': doneCallback
            }
        );
        return this;
    }

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

    // When someone clicks the search button, toggle the current state of the
    // search form.
    var clickSearchButton = function (event) {
        // In the event the last event was a blur
        if (Drupal.behaviors.rackspaceGlobal.lastSearchEvent == 'blur') {
            Drupal.behaviors.rackspaceGlobal.lastSearchEvent = '';
            return;
        }
        event.preventDefault();
        var $searchButton = $(this);
        var $formGroup = $(this).prev('.form-group');
        var $formControl = $formGroup.find('input.form-control');
        $formGroup.toggleSearch(function (animation) {
            var actionOpening = animation.tweens[1].start < animation.tweens[1].end;
            if (actionOpening) {
                $searchButton.addClass('focus');
                $formControl.focus().one('blur', function (event) {
                    Drupal.behaviors.rackspaceGlobal.lastSearchEvent = 'blur';
                    $formGroup.toggleSearch(null, function () {
                        $searchButton.removeClass('focus');
                        Drupal.behaviors.rackspaceGlobal.lastSearchEvent = '';
                    });
                });
            }
            else {
                $searchButton.removeClass('focus');
            }
        });

    };

    // When someone clicks a parent menu item on the navigation bar we should
    // expand sub navigation
    var clickParentMenuItem = function (event) {
        // Hide all menus from neighboring <li>'s.
        var $parentLI = $(this).closest('li.expanded');
        var parentId = $parentLI.uniqueId();
        $parentLI.siblings('li.expanded').find('ul.nav').hide();

        // Show
        var $nav = $(this).next('ul.nav');
        $nav.stop(true, true).slideDown(Drupal.behaviors.rackspaceGlobal.animationDuration);
        $parentLI.mouseenter(function (e) {
            Drupal.behaviors.rackspaceGlobal.lastMenuEvent[parentId] = 'enter';
        });
        $parentLI.mouseleave(function (e) {
            Drupal.behaviors.rackspaceGlobal.lastMenuEvent[parentId] = 'leave';
            var interval = setInterval(function () {
                if (Drupal.behaviors.rackspaceGlobal.lastMenuEvent[parentId] = 'leave') {
                    clearInterval(interval);
                    $nav.stop(true, true).slideUp(Drupal.behaviors.rackspaceGlobal.animationDuration);
                }
            }, 1000);
        });
    }

})(jQuery);