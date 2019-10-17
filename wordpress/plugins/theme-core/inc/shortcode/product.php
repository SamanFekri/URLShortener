<?php
/**
 * NA Core Plugin
 * @package     NA Core
 * @version     2.0
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */
if (!function_exists('na_shortcode_products')) {
    function na_shortcode_products($atts, $content)
    {

        if ( class_exists( 'WooCommerce' ) ) {
            $product_categories = get_categories( 
                array(
                    'taxonomy' => 'product_cat',
                )
            );
            $product_cats = array();
            $product_cats_all = '';
            if (count($product_categories) > 0) {
                
                foreach ($product_categories as $value) {
                    $product_cats[$value->name] = $value->slug;
                }
                $product_cats_all = implode(',', $product_cats);
            }


            $product_tags = get_terms( 'product_tag');
            $product_tags_arr = array();
            $product_tags_all = '';
            if (count($product_tags) > 0) {
                
                foreach ($product_tags as $value) {
                    $product_tags_arr[$value->name] = $value->slug;
                }
                $product_tags_all = implode(',', $product_tags_arr);
            }


            $attributes_arr = array();
            $attributes_arr_all = '';
            if(function_exists('wc_get_attribute_taxonomies')){
                $product_attribute_taxonomies = wc_get_attribute_taxonomies();
                if (count($product_attribute_taxonomies) > 0) {
                    
                    foreach ($product_attribute_taxonomies as $value) {
                        $attributes_arr[$value->attribute_label] = $value->attribute_name;
                    }
                    $attributes_arr_all = implode(',', $attributes_arr);
                }
            }

            $atts = shortcode_atts(array(
                'title' => '',
                'post_type' => 'product',
                'pagination' => 'simple',
                'column' => 'columns6',
                'posts_per_page' => 4,
                'products_type' => 'products_carousel',
                'products_img_size' => 'shop_thumbnail',
                'paged' => 1,
                'ignore_sticky_posts' => 1,
                'show' => '',
                'orderby' => 'date',
                'element_custom_class' => '',
                'padding_bottom_module' => '50px',
                'filter_categories' => $product_cats_all,
                'filter_tags' => $product_tags_all,
                'filter_attributes' => $attributes_arr_all,
                'show_filter' => 1,
                'show_featured_filter'=> 1,
                'show_price_filter'=> 1,
                'price_filter_level'=> 5,
                'price_filter_range' => 100,
                'show_loadmore' => 1
            ), $atts);


            $meta_query = WC()->query->get_meta_query();


            $wc_attr = array(
                'post_type' => 'product',
                'posts_per_page' => $atts['posts_per_page'],
                'paged' => $atts['paged'],
                'orderby' => $atts['orderby'],
                'ignore_sticky_posts' => $atts['ignore_sticky_posts'],
            );

            if ($atts['show'] == 'featured') {

                
                $meta_query[] = array(
                    'key' => '_featured',
                    'value' => 'yes'
                );

                $wc_attr['meta_key'] = $meta_query;

            } elseif ($atts['show'] == 'onsale') {

                $product_ids_on_sale = wc_get_product_ids_on_sale();

                $wc_attr['post__in'] = $product_ids_on_sale;

                $wc_attr['meta_query'] = $meta_query;

            } elseif ($atts['show'] == 'best-selling') {

                $wc_attr['meta_key'] = 'total_sales';

                $wc_attr['meta_query'] = $meta_query;

            } elseif ($atts['show'] == 'latest'){

                $wc_attr['orderby'] = 'date';

                $wc_attr['order'] = 'DESC';

            } elseif ($atts['show'] == 'toprate'){

                add_filter('posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses'));

            } elseif ($atts['show'] == 'price'){

                $wc_attr['orderby']  = "meta_value_num {$wpdb->posts}.ID";
                $wc_attr['order']    = 'ASC';
                $wc_attr['meta_key'] = '_price';

            } elseif ($atts['show'] == 'price-desc'){

                $wc_attr['orderby']  = "meta_value_num {$wpdb->posts}.ID";
                $wc_attr['order']    = 'DESC';
                $wc_attr['meta_key'] = '_price';

            }
            if($atts['filter_categories'] != $product_cats_all && $atts['filter_categories'] !=  ''){
                $wc_attr['product_cat'] = $atts['filter_categories'];
            }
            

            $atts['wc_attr'] = $wc_attr;


            return na_get_template_part('shortcode', 'product', array('atts' => $atts));
        }
        return null;

    }
}

add_shortcode('na_products', 'na_shortcode_products');

add_action('vc_before_init', 'na_product_integrate_vc');

if (!function_exists('na_product_integrate_vc')) {
    function na_product_integrate_vc()
    {
        if ( class_exists( 'WooCommerce' ) ) {
            $product_categories = get_categories( 
                array(
                    'taxonomy' => 'product_cat',
                )
            );
            $product_cats = array();
            $product_cats_all = '';
            if (count($product_categories) > 0) {
                
                foreach ($product_categories as $value) {
                    $product_cats[$value->name] = $value->slug;
                }
                $product_cats_all = implode(',', $product_cats);
            }


            $product_tags = get_terms( 'product_tag');
            $product_tags_arr = array();
            $product_tags_all = '';
            if (count($product_tags) > 0) {
                
                foreach ($product_tags as $value) {
                    $product_tags_arr[$value->name] = $value->slug;
                }
                $product_tags_all = implode(',', $product_tags_arr);
            }


            $attributes_arr = array();
            $attributes_arr_all = '';
            if(function_exists('wc_get_attribute_taxonomies')){
                $product_attribute_taxonomies = wc_get_attribute_taxonomies();
                if (count($product_attribute_taxonomies) > 0) {
                    
                    foreach ($product_attribute_taxonomies as $value) {
                        $attributes_arr[$value->attribute_label] = $value->attribute_name;
                    }
                    $attributes_arr_all = implode(',', $attributes_arr);
                }
            }


            vc_map(
                array(
                    'name' => esc_html__('NA Products', 'na-nano'),
                    'base' => 'na_products',
                    'icon' => 'icon-nano',
                    'category' => esc_html__('NA', 'na-nano'),
                    'description' => esc_html__('Show multiple products by ID or SKU.', 'na-nano'),
                    'params' => array(
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Title', 'na-nano'),
                            'value' => '',
                            'param_name' => 'title',
                            'description' => esc_html__('Enter text used as shortcode title (Note: located above content element)', 'na-nano'),
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Layout type', 'na-nano'),
                            'value' => array(
                                esc_html__('Carousel', 'na-nano') => 'products_carousel',
                                esc_html__('Grid', 'na-nano') => 'products_grid',
                                esc_html__('List', 'na-nano') => 'products_list'
                            ),
                            'param_name' => 'products_type',
                            'description' => esc_html__('Select layout type for display product', 'na-nano'),
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Image size', 'na-nano'),
                            'value' => array(
                                esc_html__('Thumbnail', 'na-nano') => 'shop_thumbnail',
                                esc_html__('Catalog Images', 'na-nano') => 'shop_catalog',
                                esc_html__('Single Product Image', 'na-nano') => 'shop_single'
                            ),
                            'param_name' => 'products_img_size',
                            'description' => esc_html__('Select image size follow size in woocommerce product image size', 'na-nano'),
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Column number', 'na-nano'),
                            'value' => array(
                                esc_html__('1 Columns', 'na-nano') => 'columns1',
                                esc_html__('2 Columns', 'na-nano') => 'columns2',
                                esc_html__('3 Columns', 'na-nano') => 'columns3',
                                esc_html__('4 Columns', 'na-nano') => 'columns4',
                                esc_html__('5 Columns', 'na-nano') => 'columns5',
                                esc_html__('6 Columns', 'na-nano') => 'columns6'
                            ),
                            'std' => 'columns3',
                            'param_name' => 'column',
                            'description' => esc_html__('Display product with the number of column', 'na-nano'),
                        ),
                        array(
                            "type" => "na_multi_select",
                            "heading" => esc_html__("Select Product Categories", 'na-nano'),
                            "param_name" => "categories_in",
                            "std" => $product_cats_all,
                            "value" => $product_cats,
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('"Asset type', 'na-nano'),
                            'value' => array(
                                esc_html__('All', 'na-nano') => '',
                                esc_html__('Featured product', 'na-nano') => 'featured',
                                esc_html__('Onsale product', 'na-nano') => 'onsale',
                                esc_html__('Best Selling', 'na-nano') => 'best-selling',
                                esc_html__('Latest product', 'na-nano') => 'latest',
                                esc_html__('Top rate product', 'na-nano') => 'toprate ',
                                esc_html__('Sort by price: low to high', 'na-nano') => 'price',
                                esc_html__('Sort by price: high to low', 'na-nano') => 'price-desc',
                            ),
                            'std' => '',
                            'param_name' => 'show',
                            'description' => esc_html__('Select asset type of products', 'na-nano'),
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => esc_html__('Order by', 'na-nano'),
                            'value' => array(
                                esc_html__('Date', 'na-nano') => 'date',
                                esc_html__('Menu order', 'na-nano') => 'menu_order',
                                esc_html__('Title', 'na-nano') => 'title',
                            ),
                            'std' => 'date',
                            'param_name' => 'orderby',
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Number of product', 'na-nano'),
                            'value' => 6,
                            'param_name' => 'posts_per_page',
                            'description' => esc_html__('Number of product showing', 'na-nano'),
                        ),
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Ignore sticky posts", 'na-nano'),
                            "param_name" => "ignore_sticky_posts",
                            'std' => 1,
                            "value" => array(
                                esc_html__('No', 'na-nano' ) => 0,
                                esc_html__('Yes', 'na-nano' ) => 1,
                            ),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Custom Class', 'na-nano'),
                            'value' => '',
                            'param_name' => 'element_custom_class',
                            'description' => esc_html__('Style particular content element differently - add a class name and refer to it in custom CSS.', 'na-nano'),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Bottom padding for the module', 'na-nano'),
                            'value' => '50px',
                            'param_name' => 'padding_bottom_module',
                            'description' => esc_html__('The space in bottom. Default is 50px', 'na-nano'),
                        ),
                        
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Show Load More button", 'na-nano'),
                            "param_name" => "show_loadmore",
                            'std' => 1,
                            "value" => array(
                                esc_html__('No', 'na-nano' ) => 0,
                                esc_html__('Yes', 'na-nano' ) => 1,
                            ),
                        ),
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Show Filter", 'na-nano'),
                            "param_name" => "show_filter",
                            'std' => 1,
                            "value" => array(
                                esc_html__('No', 'na-nano' ) => 0,
                                esc_html__('Yes', 'na-nano' ) => 1,
                            ),
                        ),
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Show Featured, Onsale, Best Selling, Latest product filter", 'na-nano'),
                            "param_name" => "show_featured_filter",
                            'std' => '1',
                            "dependency" => Array('element' => 'show_filter', 'value' => array('1')),
                            "value" => array(
                                esc_html__('No', 'na-nano' ) => 0,
                                esc_html__('Yes', 'na-nano' ) => 1,
                            ),
                        ),
                        array(
                            "type" => "na_multi_select",
                            "heading" => esc_html__("Categories showing in the filter", 'na-nano'),
                            "param_name" => "filter_categories",
                            "dependency" => Array('element' => 'show_filter', 'value' => array('1')),
                            "std" => $product_cats_all,
                            "value" => $product_cats,
                        ),
                        array(
                            "type" => "na_multi_select",
                            "heading" => esc_html__("Tags showing in the filter", 'na-nano'),
                            "param_name" => "filter_tags",
                            "dependency" => Array('element' => 'show_filter', 'value' => array('1')),
                            "std" => $product_tags_all,
                            "value" => $product_tags_arr,
                        ),
                        array(
                            "type" => "na_multi_select",
                            "heading" => esc_html__("Product attributes showing in the filter", 'na-nano'),
                            "param_name" => "filter_attributes",
                            "dependency" => Array('element' => 'show_filter', 'value' => array('1')),
                            "std" => $attributes_arr_all,
                            "value" => $attributes_arr,
                        ),
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Show Price Filter", 'na-nano'),
                            "param_name" => "show_price_filter",
                            "std" => 1,
                            "dependency" => Array('element' => 'show_filter', 'value' => array('1')),
                            "value" => array(
                                esc_html__('No', 'na-nano' ) => 0,
                                esc_html__('Yes', 'na-nano' ) => 1,
                            ),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Number of price levels', 'na-nano'),
                            'value' => '5',
                            'std' => '5',
                            'param_name' => 'price_filter_level',
                            "dependency" => Array('element' => 'show_price_filter', 'value' => array('1')),
                            'description' => esc_html__('Number of price levels showing in the filter', 'na-nano'),
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => esc_html__('Filter range', 'na-nano'),
                            'std' => '100',
                            'value' => '100',
                            'param_name' => 'price_filter_range',
                            "dependency" => Array('element' => 'show_price_filter', 'value' => array('1')),
                            'description' => esc_html__('Range of price filter. Example range equal 100 => price filter are "0$ to 100$", "100$ to 200$"', 'na-nano'),
                        ),
                    )
                )
            );
        }
    }
}