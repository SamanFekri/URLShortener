(function($){
    "use strict";
    jQuery(document).ready(function($) {
        //vertical
        jQuery('.na-gallery-image').each(function(){
            var number = jQuery(this).data('number');

            jQuery('.gallery-main').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: false,
                fade: true,
                dots: true,
                asNavFor: '.gallery-nav'
            });
            jQuery('.gallery-nav').slick({
                slidesToShow: number,
                slidesToScroll: 1,
                asNavFor: '.gallery-main',
                focusOnSelect: true,
                arrows: false,
                infinite: false,
                vertical: true,
                verticalSwiping: true
            });

            jQuery('.gallery-main').magnificPopup({
                delegate: 'a',
                type: 'image',
                gallery:{enabled:true}
                // other options
            });
            jQuery('.popup-zoom').click(function(e){
                jQuery('.gallery-main').find('.is-selected a').click(), e.preventDefault();
            });

        });

        //variations
        var orginal_image = $('.product-thumbnails .first img').attr('src');
        jQuery( "form.variations_form" ).live( "show_variation", function (event, variation) {
            if(variation.image_src){
                jQuery('.product-gallery-slider .slide.first img, .product-thumbnails .first img').attr('srcset',variation.image_src);
                jQuery('.product-thumbnails .first img').attr('srcset', variation.image_src);
            } else {
                jQuery('.product-thumbnails .first img').attr('src', orginal_image);
            }
        });
    });

})(jQuery);