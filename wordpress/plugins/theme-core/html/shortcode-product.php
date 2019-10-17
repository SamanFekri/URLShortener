<?php
/**
 * NA Core Plugin
 * @package     NA Core
 * @version     0.1
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */
?>
<?php
    if(!isset($_POST['show'])){
        echo '<input name="na-filter-page-baseurl" type="hidden" value="'.na_current_url().'">';
    }
?>
<div class="na-products-wrap">
<?php if (isset($atts['title'])&& $atts['title']!=''){?>
    <h3 class="widget-title" >
        <span class="<?php echo $atts['title_align']; ?>"><?php echo htmlspecialchars_decode( $atts['title'] ); ?></span>
    </h3>
<?php }?>
<?php

if($atts['show_filter']){?>
    <div class="na-filter-wrap  clearfix">
                <div class="na-filter-nav clearfix">
                    <?php
                    //list category
                    if($atts['filter_categories'] != ''){
                        $product_categories = explode(',', $atts['filter_categories'] );
                        echo '<ul class="na-ajax-load na-list-product-category list-unstyled pull-left clearfix">';
                        foreach ($product_categories as $product_cat_id)
                        {
                            $product_cat = get_term( $product_cat_id, 'product_cat' );
                            $selected = '';
                            if(isset($atts['wc_attr']['product_cat'] ) && $atts['wc_attr']['product_cat'] == $product_cat->slug ){
                                $selected = 'chosen';
                            }
                            echo '<li><a class="'. esc_attr($selected) .'"
                            data-type="product_cat" data-value="'.esc_attr($product_cat->slug).'"
                            href="' . esc_url(get_term_link( $product_cat->slug, 'product_cat' )) . '"
                            title="' . esc_attr($product_cat->name) . '">' . esc_html($product_cat->name) . '</a></li>';

                        }

                        echo '</ul>';
                    }
                    //end of list category
                    ?>

                    <a class="btn btn-primary pull-right" role="button" data-toggle="collapse" href="#na-filter" aria-expanded="false" aria-controls="na-filter">
                        <?php echo esc_html__('Filter','na-nano');?>
                    </a>
                </div>
                <?php
                //filter ?>
                <div class="collapse na-filter-attribute clearfix" id="na-filter">
                   <div class="widget">
                        <h3 class="filter-title"><?php echo esc_html__('Sort By','na-nano');?></h3>
                        <?php
                        //list featured filter
                        $filter_arrs = array(
                            esc_html__('All','na-nano') => 'all',
                            esc_html__('Featured','na-nano') => 'featured',
                            esc_html__('Onsale','na-nano') => 'onsale',
                            esc_html__('Best Selling','na-nano') => 'best-selling',
                            esc_html__('Latest','na-nano') => 'latest',
                            esc_html__('Top rate','na-nano') => 'toprate ',
                            esc_html__('Price: low to high','na-nano') => 'price',
                            esc_html__('Price: high to low','na-nano') => 'price-desc',
                        );

                        echo '<ul class="na-ajax-load na-list-filter list-unstyled">';
                        foreach ($filter_arrs as $key => $value)
                        {
                            $selected = '';
                            if(isset($atts['show']) &&  $atts['show'] == $value){
                                $selected = 'chosen';
                            }
                            echo '<li>
                                            <a  class="'. esc_attr($selected) .'"
                                                data-type="show"
                                                data-value="'.esc_attr($value).'" href="" title="'.esc_attr($key).'">' . esc_html($key) . '
                                            </a>
                                  </li>';

                        }
                        echo '</ul>';?>
                   </div>

                   <?php
                   //list product_attributes
                   if($atts['filter_attributes'] != ''){
                       $product_attribute_taxonomies = explode(',', $atts['filter_attributes'] );


                       if(count($product_attribute_taxonomies) > 0){
                           foreach ($product_attribute_taxonomies as $product_attribute_taxonomie_id) {

                               global $wpdb;

                               $attribute_taxonomies = $wpdb->get_results( "SELECT * FROM " . $wpdb->prefix . "woocommerce_attribute_taxonomies where attribute_id='".$product_attribute_taxonomie_id."'" );

                               if(isset($attribute_taxonomies[0])){
                                   $product_attribute_taxonomie = $attribute_taxonomies[0];
                                   //$product_terms = get_terms( 'pa_'.$product_attribute_taxonomie->attribute_name, 'hide_empty=0' );
                                   $product_terms = get_terms( 'pa_'.$product_attribute_taxonomie->attribute_name);

                                   if(count($product_terms) > 0){
                                       echo '<div class="widget">';
                                       echo '<h3 class="filter-title">'.esc_html($product_attribute_taxonomie->attribute_label).'</h3>';
                                       echo '<ul class="na-ajax-load na-product-attribute-filter list-unstyled">';
                                       foreach ($product_terms as $product_term) {

                                           $selected = '';
                                           if(isset($atts['wc_attr']['tax_query']) && count($atts['wc_attr']['tax_query']) > 0){
                                               foreach ($atts['wc_attr']['tax_query'] as $tax_query) {
                                                   if($tax_query['taxonomy'] == $product_term->taxonomy && $tax_query['terms'] == $product_term->slug ){
                                                       $selected = 'chosen';
                                                   }
                                               }

                                           }
                                           echo '<li><a class="na-product-attribute '. esc_attr($selected) .'"
                                            data-type="product_attribute"
                                            data-attribute_value="'.esc_attr($product_term->slug).'"
                                            data-value="'.esc_attr($product_term->taxonomy).'"
                                            title="'.esc_attr($product_term->name).'">' . esc_html($product_term->name) . '</a></li>';
                                       }
                                       echo '</ul></div>';
                                   }
                               }
                           }
                       }
                   }
                   //end list product_attributes


                   //reset filter
                   echo '<div class="na-ajax-load pull-right"><a class="btn btn-default" data-type="na-reset-filter" href="'.na_current_url().'">'.esc_html__('Reset', 'na-nano').'</a></div>';
                   //end reset filter

                if(!isset($_POST['show'])){
                    //hidden argument shortcode
                    $init_atts = $atts;
                    unset($init_atts['wc_attr']);
                    echo '<script type="text/javascript">var data = jQuery.parseJSON(\''.json_encode($init_atts).'\')</script>';
                }else{
                    echo '<script type="text/javascript">var data = jQuery.parseJSON(\''.json_encode($_POST).'\')</script>';
                }
                ?>
                <script type="text/javascript">
                    jQuery(document).ready(function($){
                        function na_ajax_filter(){
                            if(typeof filter_links == 'undefined'){

                                var filter_links = $('.na-ajax-load a');

                                filter_links.click(function(e) {
                                    e.preventDefault();
                                    $('.na-products-wrap').addClass('loading');

                                    var $this = $(this);
                                    var link  = $this.attr('href');
                                    var title = $this.attr('title');


                                    data['action'] = 'na_ajax_product_filter';


                                    if($this.hasClass('na-product-attribute')){
                                        if(typeof data['product_attribute'] == 'object'){
                                            data['product_attribute'].push($this.data('value'));

                                            data['attribute_value'].push( $this.data('attribute_value'));
                                        }else{
                                            data['product_attribute'] = [];
                                            data['product_attribute'].push($this.data('value'));

                                            data['attribute_value'] = [];
                                            data['attribute_value'].push( $this.data('attribute_value'));
                                        }

                                    }else {

                                        data[$this.data('type')] = $this.data('value');

                                    }


                                    data['paged'] = 1;

                                    if($this.data('type') == 'product_cat'){
                                        data['product_attribute'] = [];
                                        data['attribute_value'] = [];
                                        data['product_tag'] = '';
                                        data['show'] = '';
                                    }
                                    if($this.data('type') == 'na-reset-filter'){
                                        data['product_attribute'] = [];
                                        data['attribute_value'] = [];
                                        data['product_tag'] = '';
                                        data['product_cat'] = '';
                                        data['show'] = '';
                                    }

                                    $.ajax({
                                        url: '<?php echo  admin_url( 'admin-ajax.php')?>',
                                        data: data,
                                        type: 'POST',
                                    }).success(function(response){
                                        if($this.data('type') == 'na-reset-filter'){
                                            link = $('input[name="na-filter-page-baseurl"]').val();

                                            window.history.pushState(null, title, link);
                                        }else{
                                            if(link != ''){
                                                window.history.pushState(null, title, link);
                                            }
                                        }
                                        //console.log(response);
                                        $('.na-products-wrap').html($(response).html());
                                        $('.na-products-wrap').removeClass('loading');
                                        if(max_num_pages == data['paged']){
                                            $('.na_ajax_load_more_button').hide();
                                        }else{
                                            $('.na_ajax_load_more_button').show();
                                        }
                                    })
                                })
                            }
                        }

                        na_ajax_filter();
                    }(jQuery));
                </script>
                </div>
                <?php
                }

                $class = ''; ?>
                <div class="na-wrapper-products-shortcode"  style="padding-bottom:<?php echo esc_attr($atts['padding_bottom_module']) ?>">
                        <?php
                        $class .= 'grid-layout';
                        if(isset($atts['element_custom_class']))
                            $class .= ' ' . $atts['element_custom_class'];

                        $product_query = new WP_Query(apply_filters('woocommerce_shortcode_products_query', $atts['wc_attr']));

                        $product_query->query($atts['wc_attr']);

                        $class_col ='col-md-3 col-sm-3';

                        $class_col = str_replace('column', 'products-',$atts['column']);

                        remove_filter( 'posts_clauses', array( 'WC_Shortcodes', 'order_by_rating_post_clauses' ) );
                        ?>
                        <div class="category-tabs category-tabs-filter widget">
                            <div class="products_shortcode_wrap product-grid woocommerce <?php esc_attr( $atts['element_custom_class']);?> ">
                                <div class="products row clearfix">
                                    <?php while ( $product_query->have_posts() ){
                                        $product_query->the_post();
                                        global $product;
                                        ?>
                                        <div class="<?php echo esc_attr($class_col); ?>">
                                            <?php wc_get_template_part( 'content', 'product-inner'); ?>
                                        </div>
                                    <?php
                                    }
                                    wp_reset_postdata();?>
                                </div>
                            </div>
                        </div>
                        <?php if($atts['show_loadmore']):?>
                            <script type="text/javascript">
                                var max_num_pages = <?php echo esc_js($product_query->max_num_pages);?>;
                            </script>
                        <?php endif; ?>
                    <?php
                    if(!isset($_POST['ajax'])):
                        if($atts['show_loadmore'] && $product_query->max_num_pages > $atts['wc_attr']['paged']):
                            echo '<div class="na_ajax_load_more"><a class="na_ajax_load_more_button ">'.esc_html__('Load more', 'na-nano').'</a></div>';

                            ?>
                            <script type="text/javascript">

                                jQuery(document).ready(function ($) {
                                    if(typeof filter_links == 'undefined'){

                                        var na_ajax_load_more_button = $('.na_ajax_load_more_button');

                                        na_ajax_load_more_button.click(function(e){


                                            e.preventDefault();
                                            na_ajax_load_more_button.addClass('loading');
                                            if(data['paged'] < max_num_pages){

                                                data['paged'] = parseInt(data['paged'])+parseInt(1);

                                                $.ajax({
                                                    url: '<?php echo  admin_url( 'admin-ajax.php')?>',
                                                    data: data,
                                                    type: 'POST',
                                                }).success(function(response){

                                                    $('.products').append($(response).find('.products').html());

                                                    if(max_num_pages == data['paged']){
                                                        $('.na_ajax_load_more_button').hide();
                                                    }else{
                                                        $('.na_ajax_load_more_button').show();
                                                    }
                                                    na_ajax_load_more_button.removeClass('loading');
                                                })
                                            }

                                        });
                                    }
                                });


                            </script>
                        <?php endif;?>
                    <?php endif;?>
                </div>
    </div>
<?php
wp_reset_postdata();
wp_reset_query();
?>
</div>