jQuery(document).ready(function($) {

	$('.image-bg').each(function(index, el) {

		if($(this).find('.image_bg').length) {

			var img_src = $(this).find('.image_bg').data('img-src');

			$(this).css('background-image', 'url(' + img_src + ')');

		}

	});

	// Set background color for elements

	$('.background-color').each(function(index, el) {

		$data_color = $(this).data('bg-color');

		$(this).css('background-color', $data_color);

	});

	$('.footer-bg-image').each(function(index, el) {

		var footer_bg_img = $(this).attr('data-bg-image');

		$(this).css('background-image', 'url(' + footer_bg_img + ')');

		removeDataAttributes($(this));

	});

	$('.footer-bg-color').each(function(index, el) {

		var footer_bg_color = $(this).attr('data-bg-color');

		$(this).css('background-color', footer_bg_color);

		removeDataAttributes($(this));

	});

	

	// Main menu

	$('.navbar-nav .megamenu').each(function(index, el) {

		var new_menu = '';

		$(this).find('.row >ul >li').each(function(index, el) {

			$(this).removeClass('menu-title');

			var col_class = $(this).attr('class') + ' list-unstyled';

			if($(this).find('.dropdown-menu').length) {

				var col_sub = $(this).find('.dropdown-menu').html();

			} else col_sub = '';

			var title = '<li>' + $(this).find('> span').outerHTML() + '</li>';

			new_menu += '<ul class="'+col_class+'">'+ title + col_sub + '</ul>';

		});

		$(this).find('.row').html(new_menu);

	});

	$('.megamenu').each(function(index, el) {

		if($(this).find('.yamm-content .list-unstyled a').hasClass('fa')) {

			$(this).find('.yamm-content .list-unstyled a').prepend(' ');	

		} else{

			$(this).find('.yamm-content .list-unstyled a').prepend('<i class="fa fa-angle-right"></i> ');

		}	

		//$(this).find('.yamm-content .list-unstyled >li a').prepend('<i class="fa fa-angle-right"></i> ');

	});

	if($('header').hasClass('menu-icon')) {

		$('nav .nav.navbar-nav >li').each(function(index, el) {

			if($(this).attr('style')) {

				var menu_icon = '<i class="'+$(this).attr('style')+'"></i>';

				$(this).find('>a i').remove();

				$(this).find('>a').prepend('<i class="'+$(this).attr('style')+'"></i> ');

			}

		});

	}



	//Shop

	if($('.header.headr-style-3').hasClass('shop')) {

		$('nav ul.nav.navbar-nav').append('<li class="dropdown cart"><a href="#" class="dropdown-toggle"><i class="fa fa-shopping-cart"></i> <span class="items">0</span> item(s) : <span class="font-bold">$0.00</span> <i class="fa fa-angle-down"></i></a></li>');

		Updatecart ();

		$('li.dropdown.cart').hover(function() {

			if($('.shopping-cart').hasClass('hide')) {

				$('.shopping-cart').show('fast');

				$('.shopping-cart').removeClass('hide');

			} else {

				$('.shopping-cart').slideUp("slow");

				$('.shopping-cart').addClass('hide');

			}

		}, function() {	

			if($('.shopping-cart').hasClass('hide')) {

			} else {

				$('.shopping-cart').mouseleave(function() {

					$('.shopping-cart').slideUp("slow");

					$('.shopping-cart').addClass('hide');

				});

			}		

		});

		if($('.cart-contents .line-item-total').length) {

			var price = $('.cart-contents .line-item-total').text();

			$('.dropdown.cart span.font-bold').text(price);

		}

	}

	//Style layout

    jQuery('.layout-style .boxed').click(function(event) {

    	var href = jQuery('#site_layout').attr('href');

    	href = href.replace('style.css','style_boxed.css');

    	jQuery('#site_layout').attr('href', href);

    });

    jQuery('.layout-style .wide').click(function(event) {

    	var href = jQuery('#site_layout').attr('href');

    	href = href.replace('style_boxed.css','style.css');

    	jQuery('#site_layout').attr('href', href);

    });

});



function Updatecart () {

	if($('.shopping-cart .num-items').text()) {

		var l = $('.shopping-cart .num-items').text();

		var price = $('.shopping-cart .cart-block-summary-total').text();

		var t = price.substring(14);

		$('.dropdown.cart span.font-bold').text(t);

	} else {

		var l = 0;

	}	

	$('.dropdown.cart span.items').text(l);

}



jQuery.fn.outerHTML = function() {

   return (this[0]) ? this[0].outerHTML : '';  

};



// MasterSlider

(function($) {

  	"use strict";	

	var slider = new MasterSlider();



	    // adds Arrows navigation control to the slider.

	    //slider.control('arrows');

	    //slider.control('timebar' , {insertTo:'#masterslider'});

	    //slider.control('bullets');





	var slider = new MasterSlider();

	slider.setup('masterslider2', {

	    width: 1400, // slider standard width

	    height: 600, // slider standard height

	    space: 1,

	    layout: 'fullwidth',

	    loop: true,

	    preload: 0,

	    autoplay: true

	});



})(jQuery);



//Flip hover image	

(function($) {

  "use strict";	

	$(".flip").hover(function(){

  $(this).find(".card").toggleClass("flipped");

  return false;

});



$(".flip").hover(function(){

  $(this).find(".cardv").toggleClass("flippedv");

  return false;

});



})(jQuery);



(function($) {

    "use strict";

    $(function() {

        window.prettyPrint && prettyPrint()

        $(document).on('click', '.yamm .dropdown-menu', function(e) {

            e.stopPropagation()

        })

    })

})(jQuery);



function removeDataAttributes(target) {



    var i,

        $target = $(target),

        attrName,

        dataAttrsToDelete = [],

        dataAttrs = $target.get(0).attributes,

        dataAttrsLen = dataAttrs.length;



    // loop through attributes and make a list of those

    // that begin with 'data-'

    for (i=0; i<dataAttrsLen; i++) {

        if ( 'data-' === dataAttrs[i].name.substring(0,5) ) {

            // Why don't you just delete the attributes here?

            // Deleting an attribute changes the indices of the

            // others wreaking havoc on the loop we are inside

            // b/c dataAttrs is a NamedNodeMap (not an array or obj)

            dataAttrsToDelete.push(dataAttrs[i].name);

        }

    }

    // delete each of the attributes we found above

    // i.e. those that start with "data-"

    $.each( dataAttrsToDelete, function( index, attrName ) {

        $target.removeAttr( attrName );

    })

};