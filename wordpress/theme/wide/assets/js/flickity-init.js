!function(a){"use strict";jQuery(document).ready(function(a){jQuery(".na-gallery-image").each(function(){jQuery(".gallery-main").flickity({cellAlign:"center",wrapAround:!0,prevNextButtons:!0,percentPosition:!0,imagesLoaded:!0,lazyLoad:1,pageDots:!1,selectedAttraction:.1,friction:.6,rightToLeft:!1,autoPlay:!1,pauseAutoPlayOnHover:!0}),jQuery(".gallery-nav").flickity({asNavFor:".gallery-main",cellAlign:"left",wrapAround:!1,autoPlay:!1,prevNextButtons:!1,percentPosition:!0,imagesLoaded:!0,pageDots:!1,selectedAttraction:.1,friction:.6,rightToLeft:!1,contain:!0}),jQuery(".gallery-main").magnificPopup({delegate:"a",type:"image",gallery:{enabled:!0}}),jQuery(".popup-zoom").click(function(a){jQuery(".gallery-main").find(".is-selected a").click(),a.preventDefault()})});var b=a(".product-thumbnails .first img").attr("src");jQuery("form.variations_form").on("show_variation",function(a,c){c.image_src?(jQuery(".product-gallery-slider .slide.first img, .product-thumbnails .first img").attr("src",c.image_src),jQuery(".product-gallery-slider").flickity("select",0),jQuery(".product-thumbnails .first img").attr("srcset",c.image_src)):jQuery(".product-thumbnails .first img").attr("src",b)})})}(jQuery);