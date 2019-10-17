(function($){
    "use strict";
    function wide_isotope(){
        jQuery('.content-category .archive-blog').isotope({
            masonry: {
                columnWidth:'.col-item',
            },
            transitionDuration: '0.4s',
            fitWidth: true
        });
        jQuery('.blog-grid-layout .archive-blog').isotope({
            masonry: {
                columnWidth:'.col-item',
            },
            transitionDuration: '0.4s',
            fitWidth: true
    });
    }
    jQuery(document).ready(function($) {
        jQuery("img.lazy").lazyload();
    });

    jQuery(window).load(function(){
        wide_isotope();
    })
})(jQuery);
