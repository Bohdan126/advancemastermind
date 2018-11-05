(function ($) {
    "use strict";

    Drupal.behaviors.customHideMenuOnScroll = {
        attach: function (context, settings) {
            $(window).on('scroll', function () {
                var $menu = $('.navbar .navbar-collapse.in');
                if ($menu.length) {
                    if ($menu.height() > 0) {
                        var sum = $menu.offset().top + $menu.height();
                        var height = $(window).scrollTop();
                    }
                    if (height > sum) {
                        $menu.removeClass('in');
                    }
                }
            });
        }
    };


})(jQuery);
