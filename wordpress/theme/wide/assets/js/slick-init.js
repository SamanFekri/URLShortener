!function(a){"use strict";jQuery(document).ready(function(a){jQuery(".na-gallery-image").each(function(){var a=jQuery(this).data("number");jQuery(".gallery-main").slick({slidesToShow:1,slidesToScroll:1,arrows:!1,fade:!0,dots:!0,asNavFor:".gallery-nav"}),jQuery(".gallery-nav").slick({slidesToShow:a,slidesToScroll:1,asNavFor:".gallery-main",focusOnSelect:!0,arrows:!1,infinite:!1,vertical:!0,verticalSwiping:!0}),jQuery(".gallery-main").magnificPopup({delegate:"a",type:"image",gallery:{enabled:!0}}),jQuery(".popup-zoom").click(function(a){jQuery(".gallery-main").find(".is-selected a").click(),a.preventDefault()})});var b=a(".product-thumbnails .first img").attr("src");jQuery("form.variations_form").live("show_variation",function(a,c){c.image_src?(jQuery(".product-gallery-slider .slide.first img, .product-thumbnails .first img").attr("srcset",c.image_src),jQuery(".product-thumbnails .first img").attr("srcset",c.image_src)):jQuery(".product-thumbnails .first img").attr("src",b)})})}(jQuery);