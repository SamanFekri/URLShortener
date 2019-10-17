<?php
/**
 * The Shortcode Services
 */
function na_list_categories_shortcode( $atts) {

    global $wp_query, $post;

    $atts = shortcode_atts(
        array(
            'title-box'         => 'Categories',
            'show_count'        => 0,
            'taxonomy'          => 'product_cat',
            'hide_empty'        => false
        ), $atts );


    $current_cat   = false;
    $cat_ancestors = array();

    $current_cat   = $wp_query->queried_object;
    $cat_ancestors = get_ancestors( $current_cat->term_id, 'product_cat' );


    $product_categories = get_categories(
        array(
            'taxonomy' => 'product_cat',
        )
    );

    if (count($product_categories) > 0) {

        foreach ($product_categories as $value) {
            $product_cats[] =$value->name;
        }
        $product_cats_all = implode(',', $product_cats);
    }

    include_once( WC()->plugin_path() . '/includes/walkers/class-product-cat-list-walker.php' );

    $atts['walker']                     = new WC_Product_Cat_List_Walker;
    $atts['walker']                     = new WC_Product_Cat_List_Walker;
    $atts['title_li']                   = '';
    $atts['pad_counts']                 = 1;
    $atts['show_option_none']           = __('No product categories exist.', 'woocommerce' );
    $atts['current_category']           = ( $current_cat ) ? $current_cat->term_id : '';;
    $atts['current_category_ancestors'] =$cat_ancestors;?>

    <div class="widget widget_product_categories widget-boxed">
        <h2 class="widgettitle"><?php echo esc_attr($atts['title-box']); ?></h2>
        <ul class="product-categories">

        <?php wp_list_categories( apply_filters( 'woocommerce_product_categories_widget_args', $atts ) );?>

        </ul>
    </div>
<?php
}

add_shortcode( 'na_list_categories', 'na_list_categories_shortcode' );

/**
 * The VC Functions
 */
function na_list_categories_shortcode_vc() {

    vc_map(
        array(
            'icon'     => 'na-list-categories',
            'name'     => __( 'NA - List Categories', 'na-nano' ),
            'base'     => 'na_list_categories',
            'category' => __( 'NA', 'na-nano' ),
            'params'   => array(
                array(
                    'type'       => 'textfield',
                    'heading'    => __( 'Title', 'na-nano' ),
                    'param_name' => 'title-box',
                    'value'      => 'Categories',
                ),
                array(
                    'type'       => 'checkbox',
                    'heading'    => __( 'Show product counts', 'na-nano' ),
                    'param_name' => 'show_count',
                    'value'      => 0,
                ),
            )
        )
    );
}

add_action( 'vc_before_init', 'na_list_categories_shortcode_vc' );