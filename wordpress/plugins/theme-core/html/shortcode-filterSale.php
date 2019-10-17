<?php
/**
 * Na Core Plugin
 * @package     Nano Agency
 * @version     1.0
 * @author      Nano Agency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2016 Nano Agency
 * @license     GPL v2
 */

extract(shortcode_atts(
    //option back end
    array(
        'column' 				=> 'col-md-3 col-sm-6',
    ), $atts));

    //array the products on sale
    $args = array(
        'posts_per_page' => -1,
        'no_found_rows'  => 1,
        'post_status'    => 'publish',
        'post_type'      => 'product',
        'meta_query'     => WC()->query->get_meta_query(),
        'post__in'       => array_merge( array( 0 ), wc_get_product_ids_on_sale() ),

    );
    $deals_product = new WP_Query($args);

    //array the category
    $arr = array(
        'posts_per_page' => -1,
        'no_found_rows'  => 1,
        'post_status'    => 'publish',
        'post_type'      => 'product',
    );
    $product_categories = get_terms( 'product_cat', $arr );

    //option filter category
    ?>
    <div id ="na_from_filter" class="na_from_filter">
        <div class="dropdown-arrow">
            <select name="filter_category" id="filter_category" class="filter_category">
                <option value="" selected="selected"><?php echo esc_html_e('ALL Categories','na-nano');?></option>
                <?php foreach ( $product_categories as $car ) {?>
                        <option value="<?php echo esc_attr($car->name);?>"><?php echo esc_attr($car->name);?></option>
                <?php }?>
            </select>
        </div>
        <div class="dropdown-affect filter" id="filter_date">
            <span class="filter_select">
                <?php echo esc_html("Date Time",'na-nano')?>
            </span>
        </div>
        <div class="na-layout dropdown-arrow filter">
            <select>
                <option> 2 columne</option>
                <option> 3 columne</option>
                <option> 4 columne</option>
                <option> 5 columne</option>
            </select>
        </div>
    </div>
<?php

?>

<?php
$class_col ='col-md-3 col-sm-3';
$class_i =0;
$class_col = $column;
$number=4;
    ?>

    <div class="widgetcontent">
        <div class="products row clearfix">
            <?php while ( $deals_product->have_posts() ) : $deals_product->the_post();
                global $product;
                $class_i ++;
                // Extra post classes
                $na_class = array();
                $na_class[]=$class_col;
                if ( (0 == ( $class_i - 1 ) % $number) || (1 == $number) ) {
                    $na_class[] = 'first';
                }
                if ( 0 == $class_i % $number ) {
                    $na_class[] = 'last';
                }?>

                <div <?php post_class( $na_class ); ?>>
                    <?php
                        $output =na_get_part('product-layout/shortcode', 'product-sale');
                    ?>
                </div>
           <?php endwhile;
            wp_reset_postdata();?>
        </div>
    </div>
