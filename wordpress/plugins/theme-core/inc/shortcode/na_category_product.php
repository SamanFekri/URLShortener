<?php

/* ================================================================================== */
/*      Products Shortcode
/* ================================================================================== */
if (!function_exists('na_shortcode_category_product')) {
    function na_shortcode_category_product($atts, $content) {
        $outputs='';
        $atts = shortcode_atts(array(
            'box_title'             => '',
            'heading_color'         =>'#353535',
            'title_style' 			=> 'default',
            'post_type' 			=> 'product',
            'cat_image'             =>'',
            'pagination' 			=> 'simple',
            'column' 				=> 'col-md-3 col-sm-6',
            'posts_per_page'		=> 4,
            'products_types'		=> 'products_carousel',
            'carousel_style'		=> 'false',
            'title_align'			=> 'center',
            'paged' 				=> -1,
            'ignore_sticky_posts'	=> 1,
            'show'					=> '',
            'bg_box_css'            =>'',
            'element_custom_class'	=> '',
            'meta_query'            =>'',
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


        $bg_box_css = $heading_color_css = array();
        if($atts['bg_box_css']){
            $bg_box_css[]   = vc_get_css_color( 'background-color', $atts['bg_box_css'] );
        }
        if($atts['heading_color']){
            $heading_color[]   = vc_get_css_color( 'color', $atts['heading_color'] );
        }

        $heading_color_css      = ' style="' . implode( '', $heading_color ) . '"';
        $bg_box_css             = ' style="' . implode( '', $bg_box_css ) . '"';
        ob_start();?>

        <div class="widget category-product">
            <?php if ( $atts['box_title'] ) {?>
                <h3 class="widgettitle <?php echo $atts['title_align']; ?> style-<?php echo $atts['title_style']; ?>">
                    <span <?php echo $heading_color_css;?> ><?php echo htmlspecialchars_decode( $atts['box_title'] ); ?></span>
                </h3>
            <?php }?>
            <div class="cat-image">
                <?php
                    $cat_image    = wp_get_attachment_image_src( $atts['cat_image'],'full',false );
                    if ( !empty( $cat_image ) && isset($cat_image)) {
                        $url_link = $cat_image[0];
                        echo '<img class="cat_images" src="'.$url_link .'" alt="cat_image">';
                    }
                ?>
            </div>
            <div class="widget-content">
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
        </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}

add_shortcode('na_category_product', 'na_shortcode_category_product');

add_action('vc_before_init', 'na_category_product_integrate_vc');

if (!function_exists('na_category_product_integrate_vc')) {
    function na_category_product_integrate_vc()
    {
        vc_map(
            array(
                'name' => __('NA Category Products', 'na-nano'),
                'base' => 'na_category_product',
                'icon' => 'icon-nano',
                'category' => __('NA', 'na-nano'),
                'description' => __('Show multiple products by ID or SKU.', 'na-nano'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Title', 'na-nano'),
                        'value' => '',
                        'param_name' => 'box_title',
                    ),
                    array(
                        'type' => 'colorpicker',
                        'heading' => __( 'Heading Color','na-nano'),
                        'param_name' => 'heading_color',
                        'std' => '#353535',
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Title style', 'na-nano'),
                        'value' => array(
                            __('Defaut', 'na-nano') => 'Defaut',
                            __('Small', 'na-nano') => 'small',
                        ),
                        'param_name' => 'title_style',
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
                        'type'        => 'attach_image',
                        'heading'     => __( 'Image Category', 'na-nano' ),
                        'param_name'  => 'cat_image',
                        'description' => __( 'Image description category(size default :1170x200 )', 'na-nano' ),
                        'value'      => ''
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
                        'type' => 'colorpicker',
                        'heading' => __( 'Background Color','na-nano'),
                        'param_name' => 'bg_box_css',
                        'description' => __( 'Select custom background color.', 'na-nano' )
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