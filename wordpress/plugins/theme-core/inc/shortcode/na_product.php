<?php

/* ================================================================================== */
/*      Products Shortcode
/* ================================================================================== */
if (!function_exists('na_shortcode_products')) {
    function na_shortcode_products($atts, $content) {
        $outputs='';
        $atts = shortcode_atts(array(
            'box_title'                 => '',
            'heading_color'         =>'#040203',
            'post_type' 			=> 'product',
            'pagination' 			=> 'simple',
            'column' 				=> 'col-md-3 col-sm-6',
            'posts_per_page'		=> 4,
            'products_types'		=> 'products_carousel',
            'carousel_style'		=> 'false',
            'name_align'			=> 'left',
            'paged' 				=> -1,
            'ignore_sticky_posts'	=> 1,
            'show'					=> '',
            'title_style'           =>'center',
            'element_custom_class'	=> '',
            'meta_query'            =>'',
            'show_category'         =>'',
            'padding_bottom_module' => '0px',
            'link'              => ''
        ), $atts);
        //category

        if(isset($atts['show_category']) && empty($atts['show_category'])){
            $args = array(
                'post_type'     => 'product',
                'post_status'   => 'publish',
                'tax_query'     => array(
                    array(
                        'taxonomy'  => 'product_cat'
                    )
                )
            );
            $query_shop = new WP_Query($args);
            $atts['tax_query']  = $query_shop;
        }
        else{
            $terms=explode(',', $atts['show_category']);
            $args = array(
                array(
                    'taxonomy'  => 'product_cat',
                    'field'     => 'slug',
                    'terms'     => $terms,
                    'posts_per_page' => -1,
                    'post_status' => 'publish'
                )

            );
            $atts['tax_query']  = $args;
        }

        if( $atts['show'] == 'featured' ){

            $meta_query = WC()->query->get_meta_query();

            $meta_query[] = array(
                'key' => '_featured',
                'value' => 'yes'
            );

            $atts['meta_query'] = $meta_query;

        }
        elseif( $atts['show'] == 'onsale' ){

            $product_ids_on_sale = wc_get_product_ids_on_sale();

            $atts['post__in'] = $product_ids_on_sale;

            $meta_query = WC()->query->get_meta_query();

            $atts['meta_query'] = $meta_query;

        }
        elseif( $atts['show'] == 'best-selling' ){
            $atts['meta_key']='total_sales';
            $atts['orderby']='meta_value_num';
            $atts['ignore_sticky_posts']   = 1;
            $atts['meta_query']= WC()->query->stock_status_meta_query();
            $atts['meta_query']= WC()->query->visibility_meta_query();
        }

        elseif( $atts['show'] == 'latest' ){
            $meta_query = WC()->query->stock_status_meta_query();
            $atts['meta_query'] = $meta_query;
        }

        elseif( $atts['show'] == 'toprate' ){
            add_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
            $atts['meta_query'] = WC()->query->get_meta_query();
        }

        $heading_color_css = array();
        if($atts['heading_color']){
            $heading_color[]   = vc_get_css_color( 'color', $atts['heading_color'] );
        }

        $heading_color_css      = ' style="' . implode( '', $heading_color ) . '"';
        $addclass='';
        if ( $atts['link']) {
            $addclass="group-title";
        }
        $link =vc_build_link($atts['link']);
        $target ='_self';
        if ( $link['target'] ) {
            $target =$link['target'];
        }
        if ( $link['title'] ) {
            $title = $link['title'];
        };

        ob_start();?>

        <div class="widget widget-product <?php echo $atts['title_style']; ?> <?php echo esc_attr($addclass); ?>">
            <?php if ( $atts['link']) {?>
                <div class=" <?php echo esc_attr($addclass); ?> clearfix">
                    <?php if ( $atts['box_title'] ) {?>
                        <h3 class="widgettitle" <?php echo $heading_color_css;?> >
                            <?php echo htmlspecialchars_decode( $atts['box_title'] ); ?>
                        </h3>
                    <?php }?>
                    <a  class="link-cat" href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr($target); ?>">
                        <?php echo esc_attr($title) ;?>
                    </a>
                </div>
            <?php } else{
                if ( $atts['box_title'] ) {?>
                    <h3 class="widgettitle" <?php echo $heading_color_css;?> >
                        <?php echo htmlspecialchars_decode( $atts['box_title'] ); ?>
                    </h3>
                <?php }
            }?>
            <div class="widgetcontent <?php echo $atts['name_align']; ?>">
                <?php
                switch ($atts['products_types']) {
                    case 'products_carousel':
                        $output = na_get_part('product-layout/shortcode', 'product-carousel', array('atts' => $atts));
                        break;
                    case 'products_grid':
                        $output = na_get_part('product-layout/shortcode', 'product-grid', array('atts' => $atts));
                        break;
                    case 'products_taxonomy':
                        $output = na_get_part('product-layout/shortcode', 'product-taxonomy', array('atts' => $atts));
                        break;
                    case 'products_list':
                        $output = na_get_part('product-layout/shortcode', 'product-list', array('atts' => $atts));
                        break;
                    default:
                        $output = na_get_part('product-layout/shortcode', 'product-list', array('atts' => $atts));
                        break;
                }
            ?>
            </div>
        </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}

add_shortcode('na_products', 'na_shortcode_products');

add_action('vc_before_init', 'na_product_integrate_vc');

if (!function_exists('na_product_integrate_vc')) {
    function na_product_integrate_vc()
    {
        vc_map(
            array(
                'name' => __('NA Products', 'nano'),
                'base' => 'na_products',
                'icon' => 'icon-nano',
                'category' => __('NA', 'nano'),
                'description' => __('Show multiple products by layout.', 'nano'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Title', 'nano'),
                        'value' => '',
                        'param_name' => 'box_title',
                    ),
                    array(
                        'type' => 'colorpicker',
                        'heading' => __( 'Heading Color','nano'),
                        'param_name' => 'heading_color',
                        'std' => '#040203',
                    ),

                    array(
                        'type' => 'dropdown',
                        'heading' => __('Show', 'nano'),
                        'value' => array(
                            __('Featured', 'nano') => 'featured',
                            __('Onsale', 'nano') => 'onsale',
                            __('Best Selling', 'nano') => 'best-selling',
                            __('Latest product', 'nano') => 'latest',
                            __('Top rate product', 'nano') => 'toprate'
                        ),
                        'std' => '',
                        'param_name' => 'show',
                    ),
                    array(
                        'type' => 'nano_product_categories',
                        'heading' => __( 'Category','nano' ),
                        'param_name' => 'show_category',
                        'description' => __( 'Product category list','nano'),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Select type', 'nano'),
                        'value' => array(
                            __('Carousel', 'nano')    => 'products_carousel',
                            __('Grid', 'nano')        => 'products_grid',
                            __('Taxonomy', 'nano')    => 'products_taxonomy',
                            __('List', 'nano')        => 'products_list'
                        ),
                        'param_name' => 'products_types',
                    ),
                    array(
                        'type' => 'vc_link',
                        'heading' => __( 'URL (Link) Category', 'nano' ),
                        'param_name' => 'link',
                        'description' => __( 'Add link to button.', 'nano' ),
                    ),
                    array(
                        'type'          => 'dropdown',
                        'heading'       => __('Product align', 'nano'),
                        'description'   => __('Product name and price align','nano'),
                        'value' => array(
                            __('Center', 'nano') => 'center',
                            __('Left', 'nano') => 'left',
                            __('Right', 'nano') => 'right',
                        ),
                        'param_name' => 'name_align',
                        'std' => 'left',
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __("Pagination Carousel:", 'nano'),
                        'param_name' => 'carousel_style',
                        'value' => array(
                            __('Yes', 'nano') => 'true')
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Column count', 'nano'),
                        'value' => array(
                            __('1 Columns', 'nano') => 'col-md-12 col-sm-12',
                            __('2 Columns', 'nano') => 'col-md-6 col-sm-6',
                            __('3 Columns', 'nano') => 'col-md-4 col-sm-6',
                            __('4 Columns', 'nano') => 'col-md-3 col-sm-6',
                            __('6 Columns', 'nano') => 'col-md-2 col-sm-4'
                        ),
                        'std' => 'col-md-3 col-sm-6',
                        'param_name' => 'column',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Number of Post', 'nano'),
                        'value' => 6,
                        'param_name' => 'posts_per_page',
                    ),

                    array(
                        'type' => 'textfield',
                        'heading' => __('Custom Class', 'nano'),
                        'value' => '',
                        'param_name' => 'element_custom_class',
                        'description' => __('You can use the custom CSS class for this module', 'nano'),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Bottom padding for the module', 'nano'),
                        'value' => '35px',
                        'param_name' => 'padding_bottom_module',
                    )
                )
            )
        );
    }
}