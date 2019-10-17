<?php

/* ================================================================================== */
/*      Products Shortcode
/* ================================================================================== */

if (!function_exists('na_shortcode_tabs_category')) {
    function na_shortcode_tabs_category($atts, $content) {
        $outputs='';
        $atts = shortcode_atts(array(
            'box_title'                 => '',
            'post_type' 			=> 'product',
            'pagination' 			=> 'simple',
            'column' 				=> 'col-md-3 col-sm-6',
            'posts_per_page'		=> 4,
            'meta_query'            => '',
            'list_type'            => 'latest,featured,toprate',
            'products_types'		=> 'products_carousel',
            'carousel_style'		=> 'false',
            'title_align'			=> 'center',
            'paged' 				=> -1,
            'ignore_sticky_posts'	=> 1,
            'show'					=> '',
            'style'                 =>'default',
            'bg_box_css'            =>'',
            'element_custom_class'	=> '',
            'category'              =>'',
            'order_by'              =>'id',
            'padding_bottom_module' => '0px'
        ), $atts);

        //IF category empty
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
        $IDcats = explode(',',$atts['category']);
        ob_start();
        ?>
        <div class="category-tabs widget">
            <?php if ( $atts['box_title'] ) {?>
                <h3 class="widgettitle <?php echo  $atts['title_align'];?>">
                    <span class="<?php echo $atts['title_align']; ?>"><?php echo htmlspecialchars_decode( $atts['box_title'] ); ?></span>
                </h3>
            <?php }?>
            <div data-example-id="togglable-tabs" role="tabpanel" class="cat-tabs">
                <div class="cat-title <?php echo  $atts['title_align'];?>">
                    <ul role="tablist" class="nav nav-tabs">
                        <?php
                        $count=0;
                        foreach ($IDcats as $IDcat) {
                            $name_cat = get_term_by( 'slug', $IDcat, 'product_cat' );
                            ?>
                            <li class="<?php echo ($count==0)?'active':''; ?>" role="presentation">
                                <a class="tabs-title-cat" aria-expanded="true" data-toggle="tab" role="tab" href="#cat-<?php echo  $IDcat; ?>">
                                    <span><?php echo $name_cat->name; ?></span>
                                </a>
                            </li>
                            <?php
                            $count++;
                        }
                        ?>
                    </ul>
                </div>
                <div class="tab-content widget-content clearfix" id="tabs_product">
                    <?php $count=0; ?>
                    <?php foreach ($IDcats as $IDcat) {
                            $args['tax_query'] = array(
                                'taxonomy'  => 'product_cat',
                                'field'     => 'slug',
                                'order_by'  =>'id',
                                'terms'     => $IDcat
                            );
                            $atts['tax_query']  = $args;
                        ?>
                        <div  id="cat-<?php echo  $IDcat; ?>" class="tab-pane <?php echo ($count==0)?' active':''; ?>" role="tabpanel">
                                        <?php
                                            switch ($atts['products_types']) {
                                                case 'products_carousel':
                                                    $output = na_get_part('product-layout/shortcode', 'product-carousel', array('atts' => $atts));
                                                    break;
                                                case 'products_grid':
                                                    $output = na_get_part('product-layout/shortcode', 'product-grid', array('atts' => $atts));
                                                    break;
                                                default:
                                                    $output = na_get_part('product-layout/shortcode', 'product-grid', array('atts' => $atts));
                                                    break;
                                            }
                                        ?>
                        </div>
                        <?php $count++;
                        ?>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}

add_shortcode('na_tabs_category', 'na_shortcode_tabs_category');

add_action('vc_before_init', 'na_tabs_category_integrate_vc');

if (!function_exists('na_tabs_category_integrate_vc')) {
    function na_tabs_category_integrate_vc()
    {
        vc_map(
            array(
                'name' => __('NA Tabs Category Product', 'na-nano'),
                'base' => 'na_tabs_category',
                'icon' => 'icon-nano',
                'category' => __('NA', 'na-nano'),
                'description' => __('Show multiple tabs Category Product.', 'na-nano'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Title', 'na-nano'),
                        'value' => '',
                        'param_name' => 'box_title',
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Title align', 'na-nano'),
                        'value' => array(
                            __('Center', 'na-nano') => 'center',
                            __('Left', 'na-nano') => 'left',
                            __('Right', 'na-nano') => 'right',
                            __('Hidden', 'na-nano') => 'hidden'
                        ),
                        'param_name' => 'title_align',
                    ),

                    array(
                        'type' => 'na_product_categories',
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
                        'type' => 'dropdown',
                        'heading' => __('Style :', 'na-nano'),
                        'value' => array(
                            __('Default', 'na-nano')          => 'default',
                            __('Box - Style', 'na-nano')      => 'box',
                            __('Border - Style', 'na-nano')   => 'border',
                        ),
                        'std' => 'default',
                        'param_name' => 'style',
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