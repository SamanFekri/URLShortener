(function($){
    "use strict";
    jQuery(document).ready(function($) {
        jQuery('.na-gallery-image').each(function(){
            jQuery('.gallery-main').flickity({
                // options
                cellAlign: 'center',
                wrapAround: true,
                prevNextButtons:true,
                percentPosition: true,
                imagesLoaded: true,
                lazyLoad: 1,
                pageDots: false,
                selectedAttraction : 0.1,
                friction: 0.6,
                rightToLeft: false,
                autoPlay: false,
                pauseAutoPlayOnHover: true
            });

            jQuery('.gallery-nav').flickity({
                asNavFor: '.gallery-main',
                cellAlign: "left",
                wrapAround: false,
                autoPlay: false,
                prevNextButtons:false,
                percentPosition: true,
                imagesLoaded: true,
                pageDots: false,
                selectedAttraction : 0.1,
                friction: 0.6,
                rightToLeft: false,
                contain: true
            });
            //popup
            jQuery('.gallery-main').magnificPopup({
                delegate: 'a',
                type: 'image',
                gallery:{enabled:true}
                // other options
            });
            //zoom
            jQuery('.popup-zoom').click(function(e){
                jQuery('.gallery-main').find('.is-selected a').click(), e.preventDefault();
            });

        });

        //variations
        var orginal_image = $('.product-thumbnails .first img').attr('src');
        jQuery( "form.variations_form" ).on( "show_variation", function (event, variation) {
            if(variation.image_src){
                jQuery('.product-gallery-slider .slide.first img, .product-thumbnails .first img').attr('src',variation.image_src);
                jQuery('.product-gallery-slider').flickity( 'select', 0);
                jQuery('.product-thumbnails .first img').attr('srcset', variation.image_src);
            } else {
                jQuery('.product-thumbnails .first img').attr('src', orginal_image);
            }
        });
    });
})(jQuery);
