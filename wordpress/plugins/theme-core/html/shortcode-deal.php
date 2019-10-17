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
wp_enqueue_script( 'countdown');
extract(shortcode_atts(
    array(
        'before_title'          => 'SALE OFF',
        'after_title'           => 'FOR ALL ITEMS',
        'description'           => '',
        'link'                  => '',

    ), $atts ));

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'paged' => 1
    );

    $deals_product =  new WP_Query($args);

    $link =vc_build_link($link);
    $target ='_self';
    $title = 'Shop Now';
    if ( $link['target'] ) {
        $target =$link['target'];
    }
    if ( $link['title'] ) {
        $title = $link['title'];
    };
    ?>
<div class="widget_deals widget">


        <?php
        $deals="";
        // Start.loop
        $maxPercentage=0;
        $minTime=0;
        while ( $deals_product->have_posts() ) : $deals_product->the_post();
            //get id product
            $productID = get_the_ID();
            //get link custom product
            $product = new WC_Product($productID);
            // get time deal product
            $date_sale = get_post_meta( $productID, '_sale_price_dates_to', true );
            $regular_price=$product->regular_price;//price
            $sale_price=$product->sale_price;//sale
            //percentage sale
            if((($regular_price - $sale_price)>0) && ($sale_price > 0) && !empty($sale_price)){
                $percentage = round( ( ( $product->regular_price - $product->sale_price ) / $product->regular_price ) * 100 );
            }
            else{
                $percentage=0;
            }
            //max sale
            if(($percentage >0) && ($percentage > $maxPercentage)){
                $maxPercentage =$percentage;
            }
            //min time
            if(($date_sale > time()) && !empty($date_sale)){
                if($minTime==0){$minTime = $date_sale;}
                else{
                    $minTime=  $minTime < $date_sale? $minTime : $date_sale;
                }
            }
            ?>
            <?php
        endwhile;
        //    End.loop
        ?>

        <?php

        if($minTime > time()){
            $deals[] = $product;
            $total = count($deals);?>
            <div class="item-deal">
                        <div class="image-countdown">
                            <div class="ground-title clearfix">
                                <?php if ( $before_title) {?>
                                    <h3 class="box_title">
                                        <?php echo esc_attr($before_title);?>
                                    </h3>
                                <?php }?>

                                <!-- Discount-->
                                <div class="sale-off">
                                    <?php

                                        echo $maxPercentage.'%';


                                    ?>
                                </div>


                                <?php if ( $after_title) {?>
                                    <h3 class="box_title">
                                        <?php echo esc_attr($after_title);?>
                                    </h3>
                                <?php }?>
                            </div>
                            <p class="description">
                                <?php echo esc_attr($description);?>
                            </p>
                            <!-- countdown-->

                            <div class="deal-countdown clearfix " data-countdown="countdown"
                                 data-date="<?php echo date('m',$minTime).'-'.date('d',$minTime).'-'.date('Y',$minTime).'-'. date('H',$minTime) . '-' . date('i',$minTime) . '-' .  date('s',$minTime) ; ?>">
                            </div>

                        </div>
                        <div class="product-block-deal clearfix">
                            <div class="deals-information">
                                <a  class="button btn-discver" href="<?php echo esc_url($link['url']); ?>" target="<?php echo esc_attr($target); ?>">
                                    <?php echo  esc_attr($title);?>
                                </a>
                            </div>
                        </div>
            </div>
        <?php }?>
</div>