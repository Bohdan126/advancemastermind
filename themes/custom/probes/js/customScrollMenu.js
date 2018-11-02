(function($) {
    "use strict";

    Drupal.behaviors.customHideMenuOnScroll = {
        attach: function (context, settings) {
            $(window).on('scroll', function() {
                // var top_scroll = $(this).scrollTop();
                var $menu = $('.navbar .navbar-collapse.in');
                if ($menu.height() > 0) {
                    console.log($menu.offset().top);
                    console.log($menu.height());
                    var $sum = $menu.offset().top + $menu.height();
                    var $height = $(window).scrollTop();
                }
                if ($height > $sum){
                    $('.navbar-collapse.in').removeClass('in');
                }
            });
        }
    };


})(jQuery);
