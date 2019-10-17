<?php
/**
 * @package     wide
 * @version     1.0
 * @author      NanoAgency
 * @link        http://www.nanoagency.co
 * @copyright   Copyright (c) 2016 NanoAgency
 * @license     GPL v2
 */

/* WooCommerce - Disable the default stylesheet WooCommerce ========================================================= */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/* WooCommerce - Remove actions ===================================================================================== */

remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
add_action( 'woo_cart_collaterals', 'woocommerce_cross_sell_display' );

remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

//result
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
add_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 41);

remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

/* WooCommerce - Ajax add to cart =================================================================================== */
add_action('woocommerce_ajax_added_to_cart', 'wide_ajax_added_to_cart');
function wide_ajax_added_to_cart() {
    add_filter( 'add_to_cart_fragments', 'wide_header_add_to_cart_fragment' );
    function wide_header_add_to_cart_fragment( $fragments ) {
        ob_start();
        wide_cartbox();
        $fragments['.na-cart'] = ob_get_clean();
        return $fragments;
    }
}

if(!function_exists('wide_cartbox')){
    function wide_cartbox(){
        global $woocommerce;
        ?>
        <div class="na-cart">
            <div  class="mini-cart btn-header clearfix" role="contentinfo">
                <span class="icon-cart text-items">
                    <i class="ti-shopping-cart"></i>
                    <?php echo sprintf(_n(' <span class="mini-cart-items">%d</span> ', '<span class="mini-cart-items">%d</span>', $woocommerce->cart->cart_contents_count, 'wide'), $woocommerce->cart->cart_contents_count); ?>
                </span>
                <div class="group-mini-cart">
                    <div class="text-cart"><?php esc_html_e('My Cart','wide'); ?></div>
                    <div class="text-items">
                        <?php echo sprintf(_n(' <span class="mini-cart-items"></span> ', '', $woocommerce->cart->cart_contents_count, 'wide'), $woocommerce->cart->cart_contents_count);?> <?php echo esc_attr($woocommerce->cart->get_cart_total()); ?>
                    </div>
                </div>
            </div>
            <div class="cart-box">
                <?php woocommerce_mini_cart(); ?>
            </div>
        </div>
    <?php }
}

/* WooCommerce - Show grid/list toggle buttons ====================================================================== */
add_action('woocommerce_before_shop_loop', 'wide_grid_list_toggle', 20);
function wide_grid_list_toggle() {
        $woo_sidebar=get_theme_mod( 'wide_sidebar_woo', 'left' );
        $add_class="";
        if(isset($_GET['layout'])){
            $woo_sidebar=$_GET['layout'];
        }
        if ( $woo_sidebar && $woo_sidebar == 'full') {
            $add_class="filter-hidden";
        }
    ?>
    <div class="shop-btn-filter pull-left">
        <span class="btn-filter <?php echo esc_attr($add_class);?>">
            <i class="fa fa-align-left" aria-hidden="true"></i>
            <?php echo esc_html__('Filter','wide');?>
        </span>
    </div>
    <ul class="switch-layout pull-left   list-unstyled list-inline">
        <li>
            <a title="Grid View" class="products-grid active">
                <i class="fa fa-th-large"></i>
            </a>
        </li>
        <li>
            <a title="List View" class="products-list">
                <i class="fa fa-th-list"></i>
            </a>
        </li>
    </ul>
    <?php
}

/* WooCommerce - Availability ======================================================================================= */
add_action('woocommerce_single_product_summary', 'wide_woocommerce_stock', 11);
function wide_woocommerce_stock() {
    global $product;
    // Availability
    $availability      = $product->get_availability();
    $availability_html = empty( $availability['availability'] ) ? '' : '<span class="availability">'.esc_attr('Available:','wide').'</span><span class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</span>';

    echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product );

}

/* WooCommerce - Image description category========================================================================== */
//add_action('woocommerce_archive_description', 'wide_woocommerce_category_image', 2);
function wide_woocommerce_category_image() {
    if ( is_product_category() ){

        $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
        if ($term) {
            $thumbnail_id = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
            $image = wp_get_attachment_url( $thumbnail_id );
            if ( $image ) {
                echo '<div class="wrapper-thumb-cat">';
                echo '<img src="' . $image . '" class="category-image" alt="' . esc_attr($term->name) . '" />';
                echo '</div>';
            }
        }

    }
}

/* WooCommerce - Products per page ================================================================================== */
function wide_get_products_per_page(){
    global $woocommerce;
    $wide_woo_product_per_page  = get_theme_mod('wide_woo_product_per_page','16');
    $default = $wide_woo_product_per_page;
    $count = $default;
    return $count;
}
add_filter('loop_shop_per_page','wide_get_products_per_page');

/* WooCommerce - Hover Image Product ================================================================================ */
remove_action('woocommerce_before_shop_loop_item_title','woocommerce_show_product_loop_sale_flash',10);
add_action('woocommerce_before_shop_loop_item_title', 'wide_loop_product_thumbnail', 10);

function wide_loop_product_thumbnail() {
    global $product;
    $hover_image='';

    $image_swap  = get_theme_mod('wide_woo_product_hover');

    $placeholder_image = get_template_directory_uri(). '/assets/images/placeholder.gif';
    //Hover image
    if ( $image_swap ) {
        $gallery_image_ids = $product->get_gallery_attachment_ids();

        if ( $gallery_image_ids ) {
            $hover_image_id = reset( $gallery_image_ids ); // Get first gallery image id
            $hover_image_src = wp_get_attachment_image_src( $hover_image_id, 'shop_catalog' );

            // Make sure the first image is found (deleted image id's can can still be assigned to the gallery)
            if ( $hover_image_src ) {
                $hover_image = '<img data-src="' . esc_url( $hover_image_src[0] ) . '" src="' . esc_url( $placeholder_image ) . '" width="' . esc_attr( $hover_image_src[1] ) . '" height="' . esc_attr( $hover_image_src[2] ) . '" class="wp-post-image hover-image"  alt="product-image" />';
            }

            $classes[] = 'hover-image';
        }
    }


    //group image and hover
    echo '<span class="inner'.(($hover_image)?' img-effect':'').'">';
        if ( has_post_thumbnail() ) {
            $product_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(), 'shop_catalog' );
            echo '<img src="' . esc_url( $placeholder_image ) . '" data-src="' . esc_url( $product_thumbnail[0] ) . '" width="' . esc_attr( $product_thumbnail[1] ) . '" height="' . esc_attr( $product_thumbnail[2] ) . '" class="wp-post-image unveil-image"  alt="product-image" />';

        }
        else if ( woocommerce_placeholder_img_src() ) {
            echo '<img src="' . esc_url( $placeholder_image ) . '" class="wp-post-image"  alt="product-image" />';
        }
//      Hover image
        echo esc_attr($hover_image);
    echo '</span>';
}

// change product thumbnail in products widget
function wide_widget_product_thumbnail() {
    $id = get_the_ID();
    $size = 'shop_thumbnail';

    $image_product_hover  = get_theme_mod('wide_woo_product_hover');
    $gallery = get_post_meta($id, '_product_image_gallery', true);
    $attachment_image = '';
    if (!empty($gallery) && ($image_product_hover)) {
        $gallery = explode(',', $gallery);
        $first_image_id = $gallery[0];
        $attachment_image = wp_get_attachment_image($first_image_id , $size, false, array('class' => 'hover-image '));
    }
    $thumb_image = get_the_post_thumbnail($id , $size, array('class' => ''));
    if (!$thumb_image) {
        if ( wc_placeholder_img_src() ) {
            $thumb_image = wc_placeholder_img( $size );
        }
    }
    echo '<div class="inner'.(($attachment_image)?' img-effect':'').'">';
    // show images
    echo $thumb_image;
    echo $attachment_image;
    echo '</div>';
}
/* WooCommerce - Quick view Product ================================================================================= */
// add button
remove_action( 'yith_wcqv_product_summary', 'woocommerce_template_single_add_to_cart', 25 );
add_action( 'yith_wcqv_product_summary', 'woocommerce_template_single_add_to_cart', 18 );

/* WooCommerce - Output the WooCommerce Breadcrumb ================================================================== */

function woocommerce_breadcrumb( $args = array() ) {
    $args = wp_parse_args( $args, apply_filters( 'woocommerce_breadcrumb_defaults', array(
        'delimiter'   => '&nbsp; &nbsp;',
        'wrap_before' => '<nav class="woocommerce-breadcrumb" ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '>',
        'wrap_after'  => '</nav>',
        'before'      => '',
        'after'       => '',
        'home'        => _x( 'Home', 'breadcrumb', 'wide' )
    ) ) );

    $breadcrumbs = new WC_Breadcrumb();

    if ( $args['home'] ) {
        $breadcrumbs->add_crumb( $args['home'], apply_filters( 'woocommerce_breadcrumb_home_url', home_url() ) );
    }

    $args['breadcrumb'] = $breadcrumbs->generate();

    wc_get_template( 'global/breadcrumb.php', $args );
}


/* Breadcrumb Cover ==================================================================================================*/
function woo_breadcrumb( $args = array() ) {
    if(class_exists('WooCommerce')) {
        wide_breadcrumb_cover();
    }
    else{
        return;
    }
}
function wide_breadcrumb_cover()
{
    // product detail
    if (function_exists('is_product') && is_product()) :
        $breadcrumb_image = get_theme_mod('wide_woo_single_breadcrumb_image', '');
        $wide_woo_text = get_theme_mod('wide_woo_single_breadcrumb_text', '');
    endif;
    // page
    if (is_page()):
        $breadcrumb_image = get_theme_mod('wide_page_breadcrumb_image', '');
        $wide_woo_text = get_theme_mod('wide_page_breadcrumb_text', '');
    endif;

    //
    if (!isset($wide_woo_text) || empty($wide_woo_text)) {
        $wide_woo_text = get_the_title();
    }
    if (!isset($breadcrumb_image) || empty($breadcrumb_image)) {
        $breadcrumb_image = get_template_directory_uri() . '/assets/images/breadcrumb.jpg';
    }
    ?>

    <nav class="breadcrumb clearfix">
        <div class="wrap-breadcrumb clearfix">
            <div class="group-cover">
                <div class="cover-inner">
                    <div class="title-page"><?php echo esc_attr($wide_woo_text); ?></div>
                    <nav class="breadcrumb">
                        <?php woocommerce_breadcrumb(); ?>
                    </nav>
                </div>
            </div>
            <img class="breadcrumb-cover" src="<?php echo esc_url($breadcrumb_image); ?>" alt="breadcrumb-image">
        </div>
    </nav>
<?php }


/* WooCommerce - YITH WCWL Wishlist ================================================================================== */
if (!function_exists('wide_wishlist_button')) {
    function wide_wishlist_button()
    {

        global $product, $yith_wcwl;
        if (class_exists('YITH_WCWL_UI')) {

            $product_type = $product->product_type;

            //Check Wishlist version
            if (version_compare(get_option('yith_wcwl_version'), "2.0") >= 0) {
                $url = YITH_WCWL()->get_wishlist_url();
                $default_wishlists = is_user_logged_in() ? YITH_WCWL()->get_wishlists(array('is_default' => true)) : false;

                if (!empty($default_wishlists)) {
                    $default_wishlist = $default_wishlists[0]['ID'];
                } else {
                    $default_wishlist = false;
                }

                $exists = YITH_WCWL()->is_product_in_wishlist($product->id, $default_wishlist);
            } else {
                $url = $yith_wcwl->get_wishlist_url();
                $exists = $yith_wcwl->is_product_in_wishlist($product->id);
            }
            $label_option = get_option( 'yith_wcwl_add_to_wishlist_text' );
            $classes = get_option('yith_wcwl_use_button') == 'yes' ? 'add_to_wishlist single_add_to_wishlist button alt' : 'add_to_wishlist';

            $html = '<div class="yith-wcwl-add-to-wishlist">';
            $html .= '<div class="yith-wcwl-add-button';  // the class attribute is closed in the next row
            $html .= $exists ? ' hide" style="display:none;"' : ' show"';
            $html .= '><a href="' . htmlspecialchars($yith_wcwl->get_addtowishlist_url()) . '" data-product-id="' . esc_attr($product->id) . '" data-product-type="' . esc_attr($product_type) . '" title="'.esc_attr($label_option,'wide').'" data-placement="top" data-toggle="tooltip" data-original-title="'.esc_attr($label_option,'wide').'" class="product-action-item ' . esc_attr($classes) . '">'. $label_option.'</a>';
            $html .= '<img src="' . esc_url( admin_url( 'images/wpspin_light.gif' ) ) . '" class="ajax-loading" alt="loading" width="16" height="16" style="visibility:hidden" />';
            $html .= '</div>';

            $html .= '<div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;"><span class="feedback">' . esc_html(__('Product added to wishlist.', 'wide')) . '</span> <a class="product-action-item" href="' . esc_url($url) . '"><i class="icon_check"></i></a></div>';
            $html .= '<div class="yith-wcwl-wishlistexistsbrowse ' . ($exists ? 'show' : 'hide') . '" style="display:' . ($exists ? 'block' : 'none') . '"><a class="product-action-item" href="' . esc_url($url) . '" title="'.esc_attr('View Wishlist','wide').'" data-placement="top" data-toggle="tooltip" data-original-title="'.esc_attr('View Wishlist','wide').'">'.esc_attr('View Wishlist','wide').'</a></div>';
            $html .= '<div style="clear:both"></div><div class="yith-wcwl-wishlistaddresponse"></div>';

            $html .= '</div>';
            return $html;

        }

    }
}

/* WooCommerce - YITH WCWL COMPARE ================================================================================== */
add_action( 'wide_add_yith', 'wide_add_links');
if ( ! function_exists( 'wide_add_links' ) ) {
    function wide_add_links() {
        global $product;
        $output='';
        $output='<div class="add-links">';

        $output.=wide_wishlist_button();

        if( class_exists( 'YITH_Woocompare' ) ) {
            $action_add = 'yith-woocompare-add-product';
            $url_args = array(
                'action' => $action_add,
                'id' => $product->id
            );
            $output.='<div class="yith-compare">';
            $output.='<a title="'.esc_attr("Add Compare",'wide').'" data-placement="top" data-toggle="tooltip" data-original-title="'.esc_attr("Add Compare",'wide').'" href="'.wp_nonce_url( add_query_arg( $url_args ), $action_add ).'" class="compare add_to_compare" data-product_id="'.esc_attr($product->id).'">';
            $output.= esc_attr("Add Compare",'wide');
            $output.='</a>';
            $output.='</div>';

        }
        $output.='</div>';
        echo  $output;
    }
}

/* WooCommerce - post_class ========================================================================================= */
add_filter( 'post_class', 'wc_get_wide_class', 20, 3);
function wc_get_wide_class($classes) {
    if( is_post_type_archive('product') || is_tax( 'product_cat' ) || is_tax('product_tag') ){
        $classes = (array) $classes;
        $classes[]='isotope-item product-col';
    }
    return array_unique( $classes );
}

/* WooCommerce - Next / Prev nav on Product Pages =================================================================== */
function next_post_link_product()
{
    global $post;
    $next_post = get_next_post(true, '', 'product_cat');
    if (is_a($next_post, 'WP_Post')) { ?>
        <div class="nav-product">
            <a href="<?php echo get_the_permalink($next_post->ID); ?>" class="fa fa-angle-left"></a>
        </div>
    <?php }
}
function previous_post_link_product()
{
    global $post;
    $prev_post = get_previous_post(true, '', 'product_cat');
    if (is_a($prev_post, 'WP_Post')) { ?>
        <div class="nav-product">
            <a href="<?php echo get_the_permalink($prev_post->ID); ?>" class="fa fa-angle-right"></a>
        </div>
    <?php }
}

/* WooCommerce - Layout on Product Detail =========================================================================== */

if( function_exists('is_product')){
    $layout_product_detail  = get_theme_mod('wide_layout_product_detail','vertical');
    if(isset($_GET['style'])){
            $layout_product_detail=$_GET['style'];
    }
    if(isset($layout_product_detail) && ($layout_product_detail=='vertical')){

        remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
        add_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images_vertical', 20 );

        remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
        add_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails_vertical', 20 );

        //share
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);
        add_action('woocommerce_before_single_product_summary', 'woocommerce_template_single_sharing_vertical', 50);

    }

    function woocommerce_show_product_images_vertical()
    {
        wc_get_template( 'single-product/product-image-vertical.php' );
    }
    function woocommerce_show_product_thumbnails_vertical()
    {
        wc_get_template( 'single-product/product-thumbnails-vertical.php' );
    }
    function woocommerce_template_single_sharing_vertical()
    {
        wc_get_template( 'single-product/share-vertical.php' );
    }


}

/* WooCommerce - Ajax remover cart ================================================================================== */
add_action( 'wp_ajax_cart_remove_product', 'wide_woo_remove_product' );
add_action( 'wp_ajax_nopriv_cart_remove_product', 'wide_woo_remove_product' );
function wide_woo_remove_product() {
    $product_key = $_POST['product_key'];

    $cart = WC()->instance()->cart;
    $removed = $cart->remove_cart_item( $product_key );

    if ( $removed )	{
        $output['status'] = '1';
        $output['cart_count'] = $cart->get_cart_contents_count();
        $output['cart_subtotal'] = $cart->get_cart_subtotal();
    } else {
        $output['status'] = '0';
    }
    echo json_encode( $output );
    exit;
}

/* WooCommerce -Breadcrumb ================================================================================== */
add_action( 'woo-cat-breadcrumb', 'wide_woo_breadcrumb' );
function wide_woo_breadcrumb() {
    $breadcrumb_image = get_theme_mod('wide_woo_cat_breadcrumb_image', '');
    ?>
    <div class="wrap-breadcrumb no-margin">
        <div class="wrap-breadcrumb-cover clearfix">
            <div class="group-cover">
                <div class="cover-inner">
                    <div class="title-page">
                        <?php  woocommerce_page_title(); ?>
                    </div>
                    <nav class="breadcrumb">
                        <?php woocommerce_breadcrumb(); ?>
                    </nav>
                    <div class="archive_product_description">
                        <?php do_action( 'woocommerce_archive_description' ); ?>
                    </div>
                </div>
            </div>
             <?php if($breadcrumb_image){?>
                <img class="breadcrumb-cover" src="<?php echo esc_url($breadcrumb_image); ?>" alt="breadcrumb-image">
             <?php }   ?>
        </div>
    </div>
    <?php
}
/* WooCommerce -Sidebar ================================================================================== */
add_action( 'woo-sidebar-left', 'wide_woo_sidebar_left' );
function wide_woo_sidebar_left() {
    $woo_sidebar=get_theme_mod( 'wide_sidebar_woo', 'left' );
        if(isset($_GET['layout'])){
                $woo_sidebar=$_GET['layout'];
        }
    if ( $woo_sidebar && $woo_sidebar == 'left') {?>
        <div id="shop-sidebar" class="sidebar col-xs-3 col-sm-3 col-md-3 col-lg-3 shop-sidebar sidebar-show" role="complementary">
            <div class="content-inner">
                <?php dynamic_sidebar( 'shop' ); ?>
            </div>
        </div>
    <?php }
}
//add_action( 'woo-sidebar-right', 'wide_woo_sidebar_right' );
//function wide_woo_sidebar_right() {
//    $woo_sidebar=get_theme_mod( 'wide_sidebar_woo', 'left' );
//    if ( $woo_sidebar && $woo_sidebar == 'right') {
//        get_sidebar('shop');
//    }
//}
//content
add_action( 'woo-content-before', 'wide_woo_content_before' );
function wide_woo_content_before() {
    $woo_sidebar=get_theme_mod( 'wide_sidebar_woo', 'left' );
        if(isset($_GET['layout'])){
            $woo_sidebar=$_GET['layout'];
        }
    if ( $woo_sidebar && $woo_sidebar == 'full') {?>
        <div id="shop-sidebar" class="sidebar col-xs-3 col-sm-3 col-md-3 col-lg-3 shop-sidebar widget-area sidebar-hidden" role="complementary">
            <div class="content-inner">
                <?php dynamic_sidebar( 'shop' ); ?>
            </div>
        </div>
        <div class="wrapper-content-product sidebar-hidden">
    <?php }
    else{?>
        <div class="wrapper-content-product">
    <?php }
}
add_action( 'woo-content-after', 'wide_woo_content_after' );
function wide_woo_content_after() {
    $woo_sidebar=get_theme_mod( 'wide_sidebar_woo', 'left' );
    if ( $woo_sidebar){?>
        </div>
    <?php }
}




add_action( 'widgets_init', 'override_woocommerce_widgets', 15 );

function override_woocommerce_widgets() {
    // Ensure our parent class exists to avoid fatal error (thanks Wilgert!)

    if ( class_exists( 'WC_Widget_Layered_Nav' ) ) {
        unregister_widget( 'WC_Widget_Layered_Nav' );

        include_once(get_template_directory().'/inc/widgets/widget-layered.php' );

        register_widget( 'wide_Widget_Layered_Nav' );
    }

}

/* Ajax Quick Viewl ==================================================================================================*/
add_action('wp_ajax_wide_quickview', 'wide_quickview');
add_action('wp_ajax_nopriv_wide_quickview', 'wide_quickview');

/* The Quickview Ajax Output */
function wide_quickview() {

    global $post, $product, $woocommerce;
    wp_enqueue_script( 'wc-add-to-cart-variation' );
    $product_id = $_POST['product_id'];

    $product = wc_get_product( $product_id);

    $post = $product->post;

    setup_postdata( $post );

    ob_start();

        wc_get_template_part( 'quick', 'view' );

        $output = ob_get_contents();

    ob_end_clean();

    wp_reset_postdata();

    echo $output;

    exit;
}


//Add Alphabetical sorting option to shop page / WC Product Settings
function sale_woocommerce_shop_ordering( $sort_args ) {
  $orderby_value = isset( $_GET['orderby'] ) ? woocommerce_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
    if ( 'on_sale' == $orderby_value ) {
        $sort_args['orderby'] = 'meta_value_num';
        $sort_args['order'] = 'DESC';
        $sort_args['meta_key'] = '_sale_price';
    }
    return $sort_args;
}
add_filter( 'woocommerce_get_catalog_ordering_args', 'sale_woocommerce_shop_ordering' );

function sale_catalog_orderby( $sortby ) {
    $sortby['on_sale'] =esc_html__('On Sale','wide');
    return $sortby;
}
add_filter( 'woocommerce_default_catalog_orderby_options', 'sale_catalog_orderby' );
add_filter( 'woocommerce_catalog_orderby', 'sale_catalog_orderby' );