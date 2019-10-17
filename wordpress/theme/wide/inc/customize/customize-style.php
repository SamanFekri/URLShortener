<?php
//////////////////////////////////////////////////////////////////
// Customizer - Add CSS
//////////////////////////////////////////////////////////////////
/**
 * Enqueues front-end CSS for the page Font.
 *
 * @since wideagency
 *
 * @see wp_add_inline_style()
 */
add_action( 'wp_enqueue_scripts', 'wide_font_google');
function wide_font_google()
{
    $font_family = get_theme_mod('wide_body_font_google', 'Poppins');
    if ($font_family != 'Poppins') {
        $query_args = array(
            'family' => urlencode($font_family),
            'subset' => urlencode('latin,latin-ext'),
        );
        $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
        $wide_google_font = esc_url_raw($fonts_url);
        wp_enqueue_style('wide-fonts-customize', $wide_google_font, array(), null);
    }
}

function wide_body_font_family() {
    $default_font         = 'Poppins';
    $font_family   = get_theme_mod('wide_body_font_google',$default_font);

    // Don't do anything if the current color is the default.
    if ( $font_family === $default_font ) {
        return;
    }

    $css = '
		/* Custom  Font size */
		body {
            font-family: %1$s;
		}
	';

    wp_add_inline_style( 'wide-css', sprintf( $css, $font_family ) );
}
add_action( 'wp_enqueue_scripts', 'wide_body_font_family', 11 );

function wide_body_font_size() {
    $default_font         = '14';
    $wide_body_font_size   = get_theme_mod('wide_body_font_size',$default_font);
    // Don't do anything if the current color is the default.
    if ( $wide_body_font_size === $default_font ) {
        return;
    }

    $css = '
		/* Custom  Font size */
		body {
            font-size: %1$spx;
		}
	';

    wp_add_inline_style( 'wide-css', sprintf( $css, $wide_body_font_size ) );
}
add_action( 'wp_enqueue_scripts', 'wide_body_font_size', 12 );


function wide_padding_left() {
    $default         = '20';
    $wide_padding_left       = get_theme_mod('wide_padding_left',$default);

    // Don't do anything if the current color is the default.
    if ( $wide_padding_left === $default ) {
        return;
    }

    $css = '
		/* Custom  color title  */
        .na-cart .mini-cart
		{
		    padding-left:%1$spx;
		}

	';

    wp_add_inline_style( 'wide-css', sprintf( $css, $wide_padding_left ) );
}
add_action( 'wp_enqueue_scripts', 'wide_padding_left', 20 );

function wide_cart_position() {
    $default         = '-12';
    $wide_cart_position       = get_theme_mod('wide_cart_position',$default);

    // Don't do anything if the current color is the default.
    if ( $wide_cart_position === $default ) {
        return;
    }

    $css = '
		/* Custom  color title  */
        .na-cart .icon-cart .mini-cart-items
		{
		    right:%1$spx;
		}

	';

    wp_add_inline_style( 'wide-css', sprintf( $css, $wide_cart_position ) );
}
add_action( 'wp_enqueue_scripts', 'wide_cart_position', 21 );

function wide_max_width_cart() {
    $default         = '40';
    $wide_max_width_cart       = get_theme_mod('wide_max_width_cart',$default);

    // Don't do anything if the current color is the default.
    if ( $wide_max_width_cart === $default ) {
        return;
    }

    $css = '
		/* Custom  color title  */
        .na-cart .cart_image
		{
		    max-width:%1$spx;
		}

	';

    wp_add_inline_style( 'wide-css', sprintf( $css, $wide_max_width_cart ) );
}
add_action( 'wp_enqueue_scripts', 'wide_max_width_cart', 22 );


function wide_color_footer() {
    $default         = '';
    $wide_color_footer       = get_theme_mod('wide_color_footer',$default);

    // Don't do anything if the current color is the default.
    if ( $wide_color_footer === $default ) {
        return;
    }

    $css = '
		/* Custom  color title  */
        #na-footer .widgettitle,#na-footer ul li,#na-footer ul li a,#na-footer ul li b,[class*="ion-social-"],#na-footer
		{
		    color:%1$s;
		}
		[class*="ion-social-"]{
		    border-color:%1$s;
		}

	';

    wp_add_inline_style( 'wide-css', sprintf( $css, $wide_color_footer ) );
}
add_action( 'wp_enqueue_scripts', 'wide_color_footer', 23 );

function wide_bg_footer() {
    $default         = '';
    $wide_bg_footer       = get_theme_mod('wide_bg_footer',$default);

    // Don't do anything if the current color is the default.
    if ( $wide_bg_footer === $default ) {
        return;
    }

    $css = '
		/* Custom  color title  */
        #na-footer,#na-footer .footer-bottom,#na-footer .footer-center
		{
		    background:%1$s;
		}

	';

    wp_add_inline_style( 'wide-css', sprintf( $css, $wide_bg_footer ) );
}
add_action( 'wp_enqueue_scripts', 'wide_bg_footer', 24 );

function wide_color_topbar() {
    $default         = '';
    $wide_color_topbar       = get_theme_mod('wide_color_topbar',$default);

    // Don't do anything if the current color is the default.
    if ( $wide_color_topbar === $default ) {
        return;
    }

    $css = '
		/* Custom  color title  */
        .wrap-select-currency::after,
        .wrap-select-country::after,
        #wide-top-navbar,
        #wide-top-navbar .topbar-left a,
        #wide-top-navbar a,
        .currency_switcher .woocommerce-currency-switcher-form .dd-selected-text,
        .currency_switcher .woocommerce-currency-switcher-form .dd-option-text
		{
		    color:%1$s;
		}

	';

    wp_add_inline_style( 'wide-css', sprintf( $css, $wide_color_topbar ) );
}
add_action( 'wp_enqueue_scripts', 'wide_color_topbar', 25 );

function wide_bg_topbar() {
    $default         = '';
    $wide_bg_topbar       = get_theme_mod('wide_bg_topbar',$default);

    // Don't do anything if the current color is the default.
    if ( $wide_bg_topbar === $default ) {
        return;
    }

    $css = '
		/* Custom  color title  */
		#wide-top-navbar{
		    background:%1$s;
		}

	';

    wp_add_inline_style( 'wide-css', sprintf( $css, $wide_bg_topbar ) );
}
add_action( 'wp_enqueue_scripts', 'wide_bg_topbar', 25 );

function wide_bg_header() {
    $default         = '';
    $wide_bg_header       = get_theme_mod('wide_bg_header',$default);

    // Don't do anything if the current color is the default.
    if ( $wide_bg_header === $default ) {
        return;
    }

    $css = '
		/* Custom  color title  */
		#wide-header,.header-drawer #wide-header{
		    background:%1$s;
		}

	';

    wp_add_inline_style( 'wide-css', sprintf( $css, $wide_bg_header ) );
}
add_action( 'wp_enqueue_scripts', 'wide_bg_header', 26 );

function wide_color_menu() {
    $default         = '';
    $wide_color_menu       = get_theme_mod('wide_color_menu',$default);

    // Don't do anything if the current color is the default.
    if ( $wide_color_menu === $default ) {
        return;
    }

    $css = '
		/* Custom  color title  */
		.menu-drawer #na-menu-primary ul.mega-menu > li > a,
		#na-menu-primary ul > li[class*="-has-children"] > a::before,
		.menu-drawer #na-menu-primary ul > li[class*="-has-children"] > a::before,
		.btn-mini-search, .na-cart .icon-cart,
		.wide_icon-bar,
        #na-menu-primary ul.mega-menu > li > a
		{
		    color:%1$s;
		}

	';

    wp_add_inline_style( 'wide-css', sprintf( $css, $wide_color_menu ) );
}
add_action( 'wp_enqueue_scripts', 'wide_color_menu', 27 );


function wide_body_background() {
    $default         = '';
    $wide_bg_body       = get_theme_mod('wide_bg_body',$default);

    // Don't do anything if the current color is the default.
    if ( $wide_bg_body === $default ) {
        return;
    }

    $css = '
		/* Custom  color title  */
		body{
		    background:%1$s;
		}

	';
    wp_add_inline_style( 'wide-css', sprintf( $css, $wide_bg_body ) );
}
add_action( 'wp_enqueue_scripts', 'wide_body_background', 28 );

/**
 * Enqueues front-end CSS for the Primary  Color .
 *
 * @since wide
 *
 * @see wp_add_inline_style()
 */

function wide_primary_body() {
    $default         = '';
    $wide_primary_color       = get_theme_mod('wide_primary_body',$default);

    // Don't do anything if the current color is the default.
    if ( $wide_primary_color === $default ) {
        return;
    }

    $css = '
        .div.affect-border:before, div.affect-border:after,
        div.affect-border-inner:before,
        .btn-primary,
        div.affect-border-inner:after,
        #comments .meta-user a,
        .yith-wcwl-wishlistexistsbrowse a:after,
        .quick-view a,
        .btn-checkout,
        .btn-order,
        html input[type="button"],
        input[type="submit"],
        input[type="reset"],
        .na-cart .icon-cart .mini-cart-items,
        .pagination .current,
        .pagination span.current,
        .page-links span.page-numbers:hover,
        #calendar_wrap #today,
        .wide_icon:hover .wide_icon-bar,
        .tagcloud a:hover,
        .scrollup,
        .about .wide-social-icon a:hover,
        .widget_layered_nav ul li.chosen > a:before,
        .widget_layered_nav_filters ul li.chosen > a:before,
        .widget_layered_nav ul li a:hover:before,
        .widget_layered_nav_filters ul li a:hover:before,
        .newsletters .btn-newsletter:hover,
        [class*="ion-social-"]:hover,
        .navigation a.inactive:hover,
        .navigation a.next.page-numbers:hover,
        .navigation a.prev.page-numbers:hover,
        .post-format,
        .tags a:hover
        {
            background: %1$s;
        }

        .link:hover,
        a:hover,
        a:focus,
        .byline strong:hover,
        .comments-link.pull-right:hover a,
        .tags-list a:hover,
        .tagcloud a:hover,
        .btn-outline,
        .btn-outline:hover,
        .btn-outline:focus,
        .btn-outline:active,
        .btn-outline.active,
        .open .btn-outline.dropdown-toggle,
        .btn-inverse .badge,
        .btn-variant .badge,
        .add_to_cart_button:hover,
        .add_to_cart_button:focus,
        .add_to_cart_button:active,
        .add_to_cart_button.active,
        .button.product_type_simple:hover,
        .button.product_type_simple:focus,
        .button.product_type_simple:active,
        .button.product_type_simple.active,
        .add_to_cart_button,
        .button.product_type_simple,
        .open .add_to_cart_button.dropdown-toggle,
        .open .button.product_type_simple.dropdown-toggle,
        .added_to_cart,
        .added_to_cart:hover,
        .added_to_cart:focus,
        .added_to_cart:active,
        .added_to_cart.active,
        .open .added_to_cart.dropdown-toggle,
        .slick-arrow:hover,
        .slick-arrow:hover:before,
        .na-filter-wrap #na-filter .widget .na-ajax-load a:hover,
        .na-filter-wrap .na-remove-attribute,
        .btn-mini-search:hover ,
        #na-menu-primary ul.mega-menu > li > a:hover,
        #na-menu-primary ul.mega-menu > li > a:focus,
        #na-menu-primary ul > li:hover[class*="-has-children"] > a:before,
        #na-menu-primary ul > li > a:hover, #na-menu-primary ul > li > a:focus,
        #na-menu-primary ul > li > ul li[class*="-has-children"]:hover:after,
        #na-menu-primary .product-details a:hover,
        #na-top-navbar #language-switch ul > li span:hover,
        .currency_switcher .woocommerce-currency-switcher-form .dd-selected-text:hover,
        .currency_switcher .woocommerce-currency-switcher-form .dd-option-text:hover,
        #cart-panel-loader > *:before,
        .cart-header .close:hover,
        .pagination .page-numbers,
        .pagination .page-numbers:hover span,
        .pagination .page-numbers:hover,
        .page-links span.page-numbers:hover,
        .woocommerce-tabs li.resp-tab-item.active,
        .woocommerce-tabs li.resp-tab-item.active a,
        .woocommerce-tabs .resp-tabs-list li a:hover,
        .alert a,
        .share-links .social-item > a ,
        header .wide-social-icon a i:hover,
        .menu-drawer #na-menu-primary ul.mega-menu > li > a:hover,
        .menu-vertical #na-menu-primary ul.mega-menu > li > a:hover,
        .sidebar .author-link,
        .sidebar .NA_social a,
        .sidebar #recentcomments li > a,
        ul li.current-cat > a,
        .about .wide-social-icon a i,
        .na-footer .footer-bottom .coppy-right a,
        .na-footer ul li a:hover,
        .footer-2 .about .wide-social-icon > a:hover i,
        .page-cart .product-name a,
        .contact .fa,
        .woocommerce-thankyou-order-received,
        .woocommerce-thankyou-order-received:before,
        .woocommerce #content table.wishlist_table.cart a.remove:hover,
        #wide-quickview .price,
        .product-image.loading::after,
        .product-image.loading::before,
        .is-active > a,
        #wide-top-navbar a:hover,
        #wide-top-navbar a:focus,
        #wide-top-navbar .topbar-left a:hover,
        .widget_layered_nav ul li.chosen,
        .widget_layered_nav_filters ul li.chosen,
        .widget_layered_nav ul li.chosen > a,
        .widget_layered_nav_filters ul li.chosen > a,
        .widget_layered_nav ul li:hover .count,
        .widget_layered_nav_filters ul li:hover .count,
        [class*="ion-social-"],
        .na-banners .bannertitle,
        .entry-avatar .main-avt-like .view-like .watch-action .status,
        .entry-avatar .author-link,
        .widget_tabs_post .widget-title li a:hover,
        .widget_tabs_post .widget-title li a:focus,
        .widget_tabs_post .widget-title li a:active,
        .slick-dots li.slick-active button:before,
        .style_center .post-tran .post-cat a,
        .style_center .post-tran .btn-readmore:hover,
        .post-tran .article-content.full-width .btn-readmore:hover,
        .post-tran .article-content.full-width .entry-header .post-cat a,
        .post-tran h2.entry-title a:hover,
        .post-tran .btn-readmore:hover,
        .post-tran .post-cat a:hover,
        .navigation a.inactive,
        .navigation a.next.page-numbers,
        .navigation a.prev.page-numbers,
        .archive-blog article.post-list .entry-header .posted-on a:hover,
        .archive-blog article.post-list .author strong:hover,
        .article-content .sticky-post i,
        .article-content .sticky-post,
        .post-cat,
        .post-cat a,
        .entry-title > a:hover,
        .post-comment .fa,
        .text-comment:hover i.fa,
        .post-related .author-link:hover,
        .item-related .post-title > a:hover,
        .entry_pagination .pagination .fa,
        .nav-links a.page-numbers:hover
        {
          color: %1$s;
        }

       .btn-outline,
        .btn-outline:hover,
        .btn-outline:focus,
        .btn-outline:active,
        .btn-outline.active ,
        .open .btn-outline.dropdown-toggle,
        .btn-outline.disabled,
        .btn-outline.disabled:hover,
        .btn-outline.disabled:focus,
        .btn-outline.disabled:active,
        .btn-outline.disabled.active,
        .btn-outline[disabled],
        .btn-outline[disabled]:hover,
        .btn-outline[disabled]:focus,
        .btn-outline[disabled]:active,
        .btn-outline[disabled].active,
        fieldset[disabled] .btn-outline,
        fieldset[disabled] .btn-outline:hover,
        fieldset[disabled] .btn-outline:focus,
        fieldset[disabled] .btn-outline:active,
        fieldset[disabled] .btn-outline.active,
        .btn-inverse,
        .btn-inverse:hover,
        .btn-inverse:focus,
        .btn-inverse:active,
        .btn-inverse.active,
        .open .btn-inverse.dropdown-toggle ,
        .btn-inverse.disabled,
        .btn-inverse.disabled:hover,
        .btn-inverse.disabled:focus,
        .btn-inverse.disabled:active,
        .btn-inverse.disabled.active,
        .btn-inverse[disabled], .btn-inverse[disabled]:hover,
        .btn-inverse[disabled]:focus, .btn-inverse[disabled]:active,
        .btn-inverse[disabled].active,
        fieldset[disabled] .btn-inverse,
        fieldset[disabled] .btn-inverse:hover,
        fieldset[disabled] .btn-inverse:focus,
        fieldset[disabled] .btn-inverse:active,
        fieldset[disabled] .btn-inverse.active,
        .btn-variant,
        .btn-variant.disabled,
        .btn-variant.disabled:hover,
        .btn-variant.disabled:focus,
        .btn-variant.disabled:active,
        .btn-variant.disabled.active,
        .btn-variant[disabled],
        .btn-variant[disabled]:hover,
        .btn-variant[disabled]:focus,
        .btn-variant[disabled]:active,
        .btn-variant[disabled].active,
        fieldset[disabled] .btn-variant,
        fieldset[disabled] .btn-variant:hover,
        fieldset[disabled] .btn-variant:focus,
        fieldset[disabled] .btn-variant:active,
        fieldset[disabled] .btn-variant.active,
        .button:hover,
        .button:focus,
        .button:active,
        .button.active,
        .open .button.dropdown-toggle,
        .form-control:focus,
        .searchform .form-control:focus,
        .woocommerce-product-search .form-control:focus,
        .page-links span.page-numbers:hover,
        .button.single_add_to_cart_button:hover,
        .button.single_add_to_cart_button:focus,
        .button.single_add_to_cart_button:active,
        .button.single_add_to_cart_button.active,
        .page-content .vc_btn3.vc_btn3-style-custom,
        .page-content .vc_btn3.vc_btn3-style-custom:hover,
        .page-content .vc_btn3.vc_btn3-style-custom:focus,
        .page-content .vc_btn3.vc_btn3-style-custom:active,
        .page-content .vc_btn3.vc_btn3-style-custom.active,
        .btn-checkout,
        .btn-order,
        .btn-readmore:hover,
        html input[type="button"],
        input[type="submit"],
        input[type="reset"],
        .share-links .social-item.facebook,
        .share-links .social-item.twitter,
        .share-links .social-item.google,
        .share-links .social-item.linkedin,
        .share-links .social-item.pinterest,
        [class*="ion-social-"],
        .style_center .post-tran .btn-readmore:hover,
        .woocommerce-tabs li.resp-tab-item.active,
        .sidebar .NA_social a:hover
        {
          border-color: %1$s;
        }

	';

    wp_add_inline_style( 'wide-css', sprintf( $css, $wide_primary_color ) );
}
add_action( 'wp_enqueue_scripts', 'wide_primary_body', 29 );
?>