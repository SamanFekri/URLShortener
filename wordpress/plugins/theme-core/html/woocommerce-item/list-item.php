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
$class='';
switch($atts['column']){
    case 'columns1':
        $class='col-xs-12';
        break;
    case 'columns2':
        $class='col-xs-12 col-sm-6';
        break;
    case 'columns3':
        $class='col-xs-12 col-sm-4';
        break;
    case 'columns4':
        $class='col-xs-12 col-sm-3';
        break;
    case 'columns5':
        $class='col-xs-12 col-sm-1-5';
        break;
    case 'columns6':
        $class='col-xs-12 col-sm-2';
        break;
    default:
        $class='col-xs-12 col-sm-4';
        break;
}
global $post, $product;
?>
<li class="<?php echo esc_attr(implode(' ', get_post_class())).' '. esc_attr($class)?>">
<?php do_action('woocommerce_before_shop_loop_item'); ?>
<div class="row">
    <div class="col-xs-5 col-sm-4 woo-wrapper-thumb">
        <a href="<?php the_permalink(); ?>">
            <?php if ( $product->is_on_sale() ) : ?>

                <?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product ); ?>

            <?php endif; ?>
            <?php
            echo wp_get_attachment_image( get_post_thumbnail_id($post->ID),  $atts['products_img_size']);
            ?>
        </a>
        <div class="wrapper-product-option">
            <?php

            /**
             * woocommerce_after_shop_loop_item hook
             *
             * @hooked woocommerce_template_loop_add_to_cart - 10
             */
            do_action('woocommerce_after_shop_loop_item');

            ?>
        </div>
    </div>
    <div class="woo-wrapper-info col-xs-7 col-sm-8">
        <h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>

        <div class="item-title">
            <?php
            /**
             * woocommerce_after_shop_loop_item_title hook
             *
             * @hooked woocommerce_template_loop_rating - 5
             * @hooked woocommerce_template_loop_price - 10
             */
            do_action('woocommerce_after_shop_loop_item_title');
            do_action('woocommerce_template_single_rating');
            ?>
        </div>
    </div>
</div>
</li>
