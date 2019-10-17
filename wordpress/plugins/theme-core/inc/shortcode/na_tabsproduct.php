<?php

/* ================================================================================== */
/*      Products Shortcode
/* ================================================================================== */
function get_TabTitle($type){
    switch ($type) {
        case 'latest':
            return array('title'=>__('New','na-nano'));
        case 'featured':
            return array('title'=>__('Featured','na-nano'));
        case 'toprate':
            return array('title'=> __('Top Rated','na-nano'));
        case 'best-selling':
            return array('title'=>__('BestSeller','na-nano'));
        case 'onsale':
            return array('title'=>__('Onsale','na-nano'));
            break;
    }
}
if (!function_exists('na_shortcode_tabsproduct')) {
    function na_shortcode_tabsproduct($atts, $content) {
        $outputs='';
        $atts = shortcode_atts(array(
            'box_title'             => '',
            'post_type' 			=> 'product',
            'pagination' 			=> 'simple',
            'column' 				=> 'col-md-3 col-sm-6',
            'posts_per_page'		=> 4,
            'meta_query'            => '',
            'list_type'            => 'latest,featured,toprate',
            'products_types'		=> 'products_carousel',
            'carousel_style'		=> 'false',
            'paged' 				=> -1,
            'ignore_sticky_posts'	=> 1,
            'show'					=> '',
            'style'                 =>'default',
            'bg_box_css'            =>'',
            'element_custom_class'	=> '',
            'category'              =>'',
            'padding_bottom_module' => '0px'
        ), $atts);

        //category
        if(isset($atts['category']) && empty($atts['category'])){
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
            $terms=explode(',', $atts['category']);
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

        //list tabs
        $types = explode(',',$atts['list_type']);
        foreach ($types as $type) {
            $list_types[$type] = get_TabTitle($type);
        }
        $idran= random_int(0,99);
        ob_start();
        ?>

        <div data-example-id="togglable-tabs" role="tabpanel" class="product-tabs widget">
            <div class="widgettitle  clearfix">
                <?php if ( $atts['box_title'] ) {?>
                    <h3 class="tabs-title">
                        <?php echo htmlspecialchars_decode( $atts['box_title'] ); ?>
                    </h3>
                <?php }?>
                <ul role="tablist" class="nav nav-tabs nav-product-tabs">
                    <?php
                    $count=0;
                    foreach ($list_types as $key =>$list) {
                        ?>
                        <li class="<?php echo ($count==0)?'active':''; ?>" role="presentation">
                            <a class="tabs-title-product" aria-expanded="true" data-toggle="tab" role="tab" href="#<?php echo  $key; ?><?php echo $idran; ?>">
                                <?php echo $list['title']; ?>
                            </a>
                        </li>
                        <?php
                        $count++;
                    }
                    ?>
                </ul>
            </div>
            <div class="tab-content widgetcontent clearfix" id="tabs_product<?php echo $idran; ?>">
                <?php $count=0; ?>
                <?php foreach ($list_types as $key => $list) {
                    switch ($key) {
                        case 'best-selling':
                            $atts['meta_key'] = 'total_sales';
                            $meta_query = WC()->query->get_meta_query();
                            $atts['meta_query'] = $meta_query;
                            break;

                        case 'toprate':
                            add_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
                            $meta_query = WC()->query->get_meta_query();
                            $atts['meta_query'] = $meta_query;
                            break;

                        case 'latest':
                            $meta_query = WC()->query->visibility_meta_query();
                            $meta_query = WC()->query->stock_status_meta_query();
                            $atts['meta_query'] = $meta_query;
                            break;

                        case 'featured':
                            $meta_query = WC()->query->get_meta_query();
                            $meta_query[] = array(
                                'key' => '_featured',
                                'value' => 'yes'
                            );
                            $atts['meta_query'] = $meta_query;
                            break;

                        case 'onsale':
                            $product_ids_on_sale = wc_get_product_ids_on_sale();
                            $atts['post__in'] = $product_ids_on_sale;
                            $meta_query = WC()->query->get_meta_query();
                            $atts['meta_query'] = $meta_query;
                            break;
                    }
                    ?>
                    <div  id="<?php echo  $key; ?><?php echo $idran; ?>" class="tab-pane <?php echo ($count==0)?' active':''; ?>" role="tabpanel">
                                    <?php
                                        switch ($atts['products_types']) {
                                            case 'products_carousel':
                                                $output = na_get_part('product-layout/shortcode', 'product-carousel', array('atts' => $atts));
                                                break;
                                            case 'products_grid':
                                                $output = na_get_part('product-layout/shortcode', 'product-grid', array('atts' => $atts));
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
                    <?php $count++;
                    ?>
                <?php } ?>
            </div>
        </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}

add_shortcode('na_tabsproduct', 'na_shortcode_tabsproduct');

add_action('vc_before_init', 'na_tabsproduct_integrate_vc');

if (!function_exists('na_tabsproduct_integrate_vc')) {
    function na_tabsproduct_integrate_vc()
    {
        $show_tab = array(
            array('latest', __('Latest Products', 'na-nano')),
            array('featured', __('Featured Products', 'na-nano' )),
            array('best-selling', __('Best Selling Products', 'na-nano' )),
            array('toprate', __('TopRated Products', 'na-nano' )),
            array('onsale', __('Special Products', 'na-nano' ))
        );
        vc_map(
            array(
                'name' => __('NA Tabs Products', 'na-nano'),
                'base' => 'na_tabsproduct',
                'icon' => 'icon-nano',
                'category' => __('NA', 'na-nano'),
                'description' => __('Show multiple tabs products .', 'na-nano'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Title', 'na-nano'),
                        'value' => '',
                        'param_name' => 'box_title',
                    ),
                    array(
                        'type' => 'sorted_list',
                        'heading' => __('Show Tab', 'na-nano'),
                        'param_name' => 'list_type',
                        'description' => __('Control teasers look. Enable blocks and place them in desired order.', 'na-nano'),
                        'value' => 'latest,featured,toprate',
                        'options' => $show_tab
                    ),
                    array(
                        'type' => 'nano_product_categories',
                        'heading' => __( 'Category','na-nano' ),
                        'param_name' => 'category',
                        'description' => __( 'Product category list','na-nano'),
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Select type', 'na-nano'),
                        'value' => array(
                            __('Carousel', 'na-nano')    => 'products_carousel',
                            __('Grid', 'na-nano')        => 'products_grid',
                            __('List', 'na-nano')        => 'products_list'
                        ),
                        'param_name' => 'products_types',
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __("Pagination Carousel:", 'na-nano'),
                        'param_name' => 'carousel_style',
                        'value' => array(
                            __('Yes', 'na-nano') => 'true')
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Column count', 'na-nano'),
                        'value' => array(
                            __('1 Columns', 'na-nano') => 'col-md-12 col-sm-12',
                            __('2 Columns', 'na-nano') => 'col-md-6 col-sm-6',
                            __('3 Columns', 'na-nano') => 'col-md-4 col-sm-6',
                            __('4 Columns', 'na-nano') => 'col-md-3 col-sm-6',
                            __('6 Columns', 'na-nano') => 'col-md-2 col-sm-4'
                        ),
                        'std' => 'col-md-3 col-sm-6',
                        'param_name' => 'column',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Number of Post', 'na-nano'),
                        'value' => 6,
                        'param_name' => 'posts_per_page',
                    ),

                    array(
                        'type' => 'textfield',
                        'heading' => __('Custom Class', 'na-nano'),
                        'value' => '',
                        'param_name' => 'element_custom_class',
                        'description' => __('You can use the custom CSS class for this module', 'na-nano'),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Bottom padding for the module', 'na-nano'),
                        'value' => '35px',
                        'param_name' => 'padding_bottom_module',
                    )
                )
            )
        );
    }
}