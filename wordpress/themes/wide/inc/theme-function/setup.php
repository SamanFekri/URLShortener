<?php
/**
 * @package     wide
 * @version     1.0
 * @author      NanoAgency
 * @link        http://www.nanoagency.co
 * @copyright   Copyright (c) 2016 NanoAgency
 * @license     GPL v2
 */

/*  Setup Theme ===================================================================================================== */
add_action( 'after_setup_theme', 'wide_theme_setup' );
if ( ! function_exists( 'wide_theme_setup' ) ) :
    function wide_theme_setup() {
        load_theme_textdomain( 'wide', get_template_directory() . '/languages' );

        //  Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        //  Let WordPress manage the document title.
        add_theme_support( 'title-tag' );

        //  Enable support for Post Thumbnails on posts and pages.
        add_theme_support( 'post-thumbnails' );

        set_post_thumbnail_size( 825, 510, true );

        //Enable support for Post Formats.
        add_theme_support( 'html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
        ) );

        add_theme_support( 'post-formats', array(
            'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
        ) );

        add_theme_support( 'custom-header' );

        add_theme_support( 'custom-background' );

        add_theme_support( "title-tag" );

        add_theme_support( 'woocommerce' );

        add_theme_support( 'customize-selective-refresh-widgets' );
    }
endif;

/* Thumbnail Sizes ================================================================================================== */
set_post_thumbnail_size( 220, 150, true);
add_image_size( 'wide-blog-grid', 1170 , 800, true);
add_image_size( 'wide-blog-list', 500 , 500, true);
add_image_size( 'wide-breadcrumb-image','full',424,true);
add_image_size( 'wide-widget-blog-large',310, 232, true);
add_image_size( 'wide-widget-blog',135, 90, true);
add_image_size( 'wide-blog-vertical',600, 800, true);
add_image_size( 'wide-blog-one',1170, 510, true);



/* Setup Font ======================================================================================================= */
function wide_font_url() {
    $fonts_url = '';
    $poppins    = _x( 'on', 'Poppins font: on or off', 'wide' );

    if ( 'off' !== $poppins) {
        $font_families = array();

        if ( 'off' !== $poppins ) {
            $font_families[] = 'Poppins:300,400,500,600,700';
        }
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,latin-ext' ),
        );

        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }

    return esc_url_raw( $fonts_url );
}


/* Load Front-end scripts  ========================================================================================== */
add_action( 'wp_enqueue_scripts', 'wide_theme_scripts');
function wide_theme_scripts() {

    // Add  fonts, used in the main stylesheet.
    wp_enqueue_style( 'wide_fonts', wide_font_url(), array(), null );

    //style bootstrap
    wp_enqueue_style('bootstrap',get_template_directory_uri().'/assets/css/bootstrap.min.css', array(), '3.0.2 ');

    //style MAIN THEME
    wp_enqueue_style( 'wide-main', get_template_directory_uri(). '/style.css', array(), null );

    //style skin
    wp_enqueue_style('wide-css', get_template_directory_uri().'/assets/css/style-default.min.css' );

    //register all plugins
    wp_enqueue_script( 'plugins', get_template_directory_uri().'/assets/js/plugins.min.js', array(), null );

    //variation form
    wp_enqueue_script( 'wc-add-to-cart-variation' );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    if ( is_singular() && wp_attachment_is_image() ) {
        wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/assets/js/keyboard-image-navigation.min.js', array( 'jquery' ), '20141010' );
    }
    wp_enqueue_script('jquery.sticky-kit.min', get_template_directory_uri() . '/assets/js/plugins/jquery.sticky-kit.js', array('jquery'), '1.1.2', true);
    wp_enqueue_script('isotope.pkgd.min', get_template_directory_uri() . '/assets/js/plugins/isotope.pkgd.min.js', array('jquery'), '2.2.0', true);
    wp_enqueue_script('jquery.lazyload', get_template_directory_uri() . '/assets/js/plugins/jquery.lazyload.js', array('jquery'),'1.9.3', true);
    wp_enqueue_script('isotope-init-js-theme', get_template_directory_uri() . '/assets/js/dev/isotope-init.js', array('jquery'), null, true);
    wp_enqueue_script('na-js-theme', get_template_directory_uri() . '/assets/js/dev/nano.js', array('jquery'), null, true);

}

/* Load Back-end SCRIPTS============================================================================================= */
function wide_js_enqueue()
{
    wp_enqueue_media();
    wp_enqueue_style('thickbox');
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    // moved the js to an external file, you may want to change the path
    wp_enqueue_script('information_js',get_template_directory_uri(). '/assets/js/widget.min.js', 'jquery', '1.0', true);
}
add_action('admin_enqueue_scripts', 'wide_js_enqueue');

/* Register the required plugins    ================================================================================= */
add_action( 'tgmpa_register', 'wide_register_required_plugins' );
function wide_register_required_plugins() {

    $plugins = array(
        // This is an example of how to include a plugin pre-packaged with a theme.
        array(
            'name'      => esc_html__( 'Nano Core Plugin', 'wide' ),
            'slug'      => 'theme-core',
            'source'    => esc_url('http://guide.nanoagency.co/data/wide/theme-core.zip'),
            'required'  => true,
            'version'   => '1.0.0',
            'force_activation' => false,
            'force_deactivation' => false,
            'image_url' => get_template_directory_uri() . '/inc/backend/assets/images/plugins/nano.jpg',

        ),
        //Contact form 7
        array(
            'name'      => esc_html__('Contact Form 7', 'wide' ),
            'slug'      => 'contact-form-7',
            'required'  => false,
            'image_url' => get_template_directory_uri() . '/inc/backend/assets/images/plugins/contact-form7.jpg',
        ),
        //MailChimp for WordPress
        array(
            'name'      =>  esc_html__('MailChimp for WordPress ', 'wide' ),
            'slug'      => 'mailchimp-for-wp',
            'required'  => false,
            'image_url' => get_template_directory_uri() . '/inc/backend/assets/images/plugins/mailchimp.jpg',
        ),
        //Max Mega Menu
        array(
            'name'      =>  esc_html__('Max Mega Menu','wide'),
            'slug'      => 'megamenu',
            'required'  => false,
            'image_url' => get_template_directory_uri() . '/inc/backend/assets/images/plugins/max-megamenu.jpg',
        ),
        //WPBakery Visual Composer
        array(
            'name'      =>  esc_html__('WPBakery Visual Compose', 'wide' ),
            'slug'      => 'js_composer',
            'source'    => esc_url('http://guide.nanoagency.co/data/plugins/js_composer.zip'),
            'required'  => true,
            'version'   => '5.0.1',
            'image_url' => get_template_directory_uri() . '/inc/backend/assets/images/plugins/vc.jpg',
        ),
        //Instagram
        array(
            'name'      =>  esc_html__('Instagram Feed', 'wide' ),
            'slug'      => 'instagram-feed',
            'required'  => false,
            'image_url' => get_template_directory_uri() . '/inc/backend/assets/images/plugins/instagram.jpg',
        )
    );

    $config = array(
        'id'           => 'wide',                   // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                       // Default absolute path to pre-packaged plugins.
        'has_notices'  => true,
        'menu'         => 'tgmpa-install-plugins',  // Menu slug.
        'dismiss_msg'  => '',                       // If 'dismissable' is false, this message will be output at top of nag.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'is_automatic' => true,                     // Automatically activate plugins after installation or not.
        'message'      => '',                       // Message to output right before the plugins table.

    );

    tgmpa( $plugins, $config );

}

/* Register Navigation ============================================================================================== */
register_nav_menus( array(
    'primary_navigation'    => esc_html__( 'Primary Navigation', 'wide' ),
    'top_navigation'        => esc_html__( 'Topbar Navigation', 'wide' ),

) );

/* Register Sidebar ================================================================================================= */
if ( function_exists('register_sidebar') ) {
    register_sidebar( array(
        'name'          => esc_html__('Archive', 'wide' ),
        'id'            => 'archive',
        'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'wide' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ) );
    register_sidebar( array(
        'name'          => esc_html__('Blogs', 'wide' ),
        'id'            => 'blogs',
        'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'wide' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar(array(
        'name' => esc_html__('Footer Top', 'wide' ),
        'id'   => 'footer-top',
        'before_widget' => '<div id="%1$s" class="widget first %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer 1', 'wide' ),
        'id'   => 'footer-1',
        'before_widget' => '<div id="%1$s" class="widget first %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer 2', 'wide' ),
        'id'   => 'footer-2',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer 3', 'wide' ),
        'id'   => 'footer-3',
        'before_widget' => '<div id="%1$s" class="widget last %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer 4', 'wide' ),
        'id'   => 'footer-4',
        'before_widget' => '<div id="%1$s" class="widget last %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer 5 (Footer style 2)', 'wide' ),
        'id'   => 'footer-5',
        'before_widget' => '<div id="%1$s" class="widget last %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => esc_html__('Custom Link Topbar Left', 'wide' ),
        'id'   => 'custom-topbar-left',
        'before_widget' => '<div id="%1$s" class="widget last %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Custom Link Topbar Right', 'wide' ),
        'id'   => 'custom-topbar-right',
        'before_widget' => '<div id="%1$s" class="widget last %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
    register_sidebar( array(
        'name'          => esc_html__('Sidebar Customize', 'wide' ),
        'id'            => 'sidebar-customize',
        'description'   => esc_html__( 'Add widgets here to appear in your sidebar.', 'wide' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widgettitle">',
        'after_title'   => '</h2>',
    ) );
    register_sidebar(array(
        'name' => esc_html__('Custom Header Middle', 'wide' ),
        'id'   => 'custom-header-middle',
        'before_widget' => '<div id="%1$s" class="widget last %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
}






