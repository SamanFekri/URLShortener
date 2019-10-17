<?php

/* ================================================================================== */
/*      Products Shortcode
/* ================================================================================== */

if (!function_exists('na_shortcode_category_banner')) {
    function na_shortcode_category_banner($atts, $content) {
        $outputs='';
        $atts = shortcode_atts(array(
            'box_title'                 => '',
            'post_type' 			=> 'product',
            'column' 				=> 'col-md-3 col-sm-6',
            'posts_per_page'		=> 4,
            'meta_query'            => '',
            'products_types'		=> 'products_carousel',
            'paged' 				=> -1,
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

            $class_col ='col-md-3 col-sm-3';
            $number=4;
            $class = '';
            $class_col = str_replace('column', 'products-',$atts['column']);

            if($class_col       == "col-md-12 col-sm-12"){
                $number=1;
            }
            elseif($class_col   == 'col-md-6 col-sm-6'){
                $number=2;
            }
            elseif($class_col   == 'col-md-4 col-sm-6'){
                $number=3;
            }
            elseif($class_col   == 'col-md-3 col-sm-6'){
                $number=4;
            }
            elseif($class_col   == 'col-md-2 col-sm-4'){
                $number=6;
            }else{
                $number=4;
            }

            if(isset($atts['element_custom_class']))
            $class .= ' ' . $atts['element_custom_class'];

        ob_start();
        ?>
        <div class="category-banner widget style-border">
            <?php if ( $atts['box_title'] ) {?>
                <h3 class="widgettitle center">
                    <?php echo htmlspecialchars_decode( $atts['box_title'] ); ?>
                </h3>
            <?php }?>
            <div class="widget-content">
                <div class="products_shortcode_wrap  woocommerce <?php echo esc_attr($class);?> ">
                    <div class="row">
                        <div class="products clearfix" data-number="<?php echo esc_attr($number);?>">

                            <?php

                                foreach ($IDcats as $IDcat) {
                                    $term = get_term_by( 'slug', $IDcat, 'product_cat');
                                    $thumbnail_id = get_woocommerce_term_meta($term->term_id, 'thumbnail_id', true);
                                    $image = wp_get_attachment_image( $thumbnail_id, 'nano-categoris-image', false, array('class'=>'category_thumb'));
                                    ?>

                                    <div class="<?php echo esc_attr($class_col); ?>">
                                        <div class="category-banner-inner">
                                            <a class="cat-image" href="<?php echo esc_url(get_term_link( $term ));?>">
                                                <?php if(!isset($image) || empty($image)){
                                                    echo '<img src="' . esc_url((NANO_PLUGIN_URL.'assets/images/cat.jpg')) . '" alt="'. esc_attr__('Place Holder','na-nano') .'" />';
                                                }?>
                                                <?php echo $image; ?>
                                            </a>
                                            <div class="cat-des clearfix">
                                                <a class="cat-name" href="<?php echo esc_url(get_term_link( $term ));?>">
                                                    <?php echo esc_attr($term->name);?>
                                                </a>
                                                <div class="cat-count">
                                                    <?php echo esc_attr($term->count);?>
                                                </div>
                                            </div>
                                         </div>
                                    </div>

                                <?php
                                }
                            wp_reset_postdata();?>
                        </div>
                    </div>
                </div>

            </div>


        </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}

add_shortcode('na_category_banner', 'na_shortcode_category_banner');

add_action('vc_before_init', 'na_category_banner_integrate_vc');

if (!function_exists('na_category_banner_integrate_vc')) {
    function na_category_banner_integrate_vc()
    {
        vc_map(
            array(
                'name' => __('NA  Category Banner', 'na-nano'),
                'base' => 'na_category_banner',
                'icon' => 'icon-nano',
                'category' => __('NA', 'na-nano'),
                'description' => __('Show multiple  Category Banner.', 'na-nano'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Title', 'na-nano'),
                        'value' => '',
                        'param_name' => 'box_title',
                    ),
                    array(
                        'type' => 'nano_product_categories',
                        'heading' => __( 'Category','na-nano' ),
                        'param_name' => 'category',
                        'description' => __( 'Product category list','na-nano'),
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