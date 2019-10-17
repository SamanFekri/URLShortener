<?php

/* ================================================================================== */
/*      Products Shortcode
/* ================================================================================== */
if (!function_exists('na_shortcode_product_id')) {
    function na_shortcode_product_id($atts, $content) {
        $outputs='';
        $atts = shortcode_atts(array(
            'product_id' 		    => '',
            'box_color' 		    => '',

            'product_image' 		=> '',

            'heading_color'         =>'',
            'heading_font'          =>'',

            'product_des' 		    => 'Product Description',
            'des_product_color' 	=> '',
            'des_product_font' 		=> '',

            'description_image' 	=> '',
            'alignment_product' 	=> 'product_left',

            'post_type' 			=> 'product',
            'paged' 				=> -1,
            'bg_box_css'            =>'',
            'element_custom_class'	=> ''
        ), $atts);
        $box_color_css=$box_color  = '';
        if($atts['box_color']){
            $box_color[]            = vc_get_css_color( 'background', $atts['box_color'] );
            $box_color_css          = ' style=' . implode( '', $box_color ).'';
        }

        $heading_css=$heading_font = $heading_color ='';
        if($atts['heading_color'] || $atts['heading_font']){
            $heading_color[]            = vc_get_css_color( 'color', $atts['heading_color'] );
            $heading_font[]             = vc_get_css_color( 'font-size', $atts['heading_font'] );
            $heading_css                = ' style=' .implode( '', $heading_color ) .implode( '', $heading_font ) .'';
        }
        $des_product_css=$des_product_color = $des_product_font = '';
        if($atts['des_product_color']||$atts['des_product_font']){
            $des_product_color[]           = vc_get_css_color( 'color', $atts['des_product_color'] );
            $des_product_font[]            = vc_get_css_color( 'font-size', $atts['des_product_font'] );
            $des_product_css               = ' style=' . implode( '', $des_product_color ) . implode( '', $des_product_font ) .'';
        }

        $product = new WC_Product($atts['product_id']);
        $the_product_factory = new WC_Product_Factory();
        $product = $the_product_factory->get_product($product);

        $description_image    = wp_get_attachment_image_src( $atts['description_image'],  'full' );
        $url_link=$bg_image='';
        if ( !empty( $description_image ) && isset($description_image)) {
            $url_link = $description_image[0];
            $bg_image='style=background-image:url('.$url_link.')';
        }
        ob_start();?>

        <div class="widget product-id <?php echo $atts['element_custom_class'];?>">

                <?php if($atts['alignment_product'] == 'product_right'){?>
                    <div class="box-equal <?php echo esc_attr($atts['alignment_product']);?>">
                        <div class="productid-content">
                            <div class="productid-content-inner" <?php echo esc_attr($box_color_css);?> >
                                <h3 class="name">
                                    <a href="<?php echo esc_attr($product->get_permalink())?>" <?php echo esc_attr($heading_css);?>>
                                        <?php echo esc_attr($product->get_title());?>
                                    </a>
                                </h3>

                                <div class="description" <?php echo esc_attr($des_product_css);?>>
                                    <p><?php echo esc_attr($atts['product_des']);?></p>
                                </div>
                                <a class="product-image" href="<?php echo esc_attr($product->get_permalink());?>">
                                    <span class="inner">
                                      <?php
                                      $product_image    = wp_get_attachment_image_src( $atts['product_image'], array( 500, 481 ) );
                                      if ( !empty( $product_image ) && isset($product_image)) {
                                          $urlproduct_link = $product_image[0];
                                          echo '<img class="product_image" src="'.$urlproduct_link .'" alt="product_image"> ';
                                      }
                                      else{
                                          echo $product->get_image( 'shop_catalog', $attr = array());
                                      }
                                      ?>
                                    </span>
                                </a>
                                <span class="price">
                                    <?php echo  $product->get_price_html();?>
                                </span>
                                <div class="na-button-add-cart">
                                    <?php
                                        echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                                            sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="button %s product_type_%s">%s</a>',
                                                esc_url( $product->add_to_cart_url() ),
                                                esc_attr( $product->id ),
                                                esc_attr( $product->get_sku() ),
                                                esc_attr( isset( $quantity ) ? $quantity : 1 ),
                                                $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                                                esc_attr( $product->product_type ),
                                                esc_html( $product->add_to_cart_text())
                                            ),
                                            $product );
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="productid-image" <?php echo esc_attr($bg_image);?>>
                            <img class="productid-image hidden-lg hidden-md hidden-sm" src="<?php echo esc_attr($url_link);?>" alt="productid-image">
                        </div>
                    </div>
                <?php }
                else if($atts['alignment_product'] == 'product_left'){?>
                    <div class="box-equal <?php echo esc_attr($atts['alignment_product']);?>">
                        <div class="productid-image" <?php echo esc_attr($bg_image);?>>
                            <img class="productid-image hidden-lg hidden-md hidden-sm" src="<?php echo esc_attr($url_link);?>" alt="productid-image">
                        </div>
                        <div class="productid-content">
                            <div class="productid-content-inner" <?php echo esc_attr($box_color_css);?> >
                                <h3 class="name">
                                    <a href="<?php echo esc_attr($product->get_permalink())?>" <?php echo esc_attr($heading_css);?>>
                                        <?php echo esc_attr($product->get_title());?>
                                    </a>
                                </h3>

                                <div class="description" <?php echo esc_attr($des_product_css);?>>
                                    <p><?php echo esc_attr($atts['product_des']);?></p>
                                </div>
                                <a class="product-image" href="<?php echo esc_attr($product->get_permalink());?>">
                                    <span class="inner">
                                        <?php
                                        $product_image    = wp_get_attachment_image_src( $atts['product_image'], array( 500, 481 ) );
                                        if ( !empty( $product_image ) && isset($product_image)) {
                                            $urlproduct_link = $product_image[0];
                                            echo '<img class="product_image" src="'.$urlproduct_link .'" alt="product_image"> ';
                                        }
                                        else{
                                            echo $product->get_image( 'shop_catalog', $attr = array());
                                        }
                                        ?>
                                    </span>
                                </a>
                                <span class="price">
                                    <?php echo  $product->get_price_html();?>
                                </span>
                                <div class="na-button-add-cart">
                                    <?php
                                        echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                                        sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="button %s product_type_%s">%s</a>',
                                            esc_url( $product->add_to_cart_url() ),
                                            esc_attr( $product->id ),
                                            esc_attr( $product->get_sku() ),
                                            esc_attr( isset( $quantity ) ? $quantity : 1 ),
                                            $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                                            esc_attr( $product->product_type ),
                                            esc_html( $product->add_to_cart_text())
                                        ),
                                        $product );
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
                else {?>
                    <div class="productid-content <?php echo esc_attr($atts['alignment_product']);?>">
                        <div class="productid-content-inner" <?php echo esc_attr($box_color_css);?> >
                            <h3 class="name">
                                <a href="<?php echo esc_attr($product->get_permalink())?>" <?php echo esc_attr($heading_css);?>>
                                    <?php echo esc_attr($product->get_title());?>
                                </a>
                            </h3>

                            <div class="description" <?php echo esc_attr($des_product_css);?>>
                                <p><?php echo esc_attr($atts['product_des']);?></p>
                            </div>
                            <a class="product-image" href="<?php echo esc_attr($product->get_permalink());?>">
                                <span class="inner">
                                   <?php
                                   $product_image    = wp_get_attachment_image_src( $atts['product_image'], array( 500, 481 ) );
                                   if ( !empty( $product_image ) && isset($product_image)) {
                                       $urlproduct_link = $product_image[0];
                                       echo '<img class="product_image" src="'.$urlproduct_link .'" alt="product_image"> ';
                                   }
                                   else{
                                       echo $product->get_image( 'shop_catalog', $attr = array());
                                   }
                                   ?>
                                </span>
                            </a>
                            <span class="price">
                                <?php echo  $product->get_price_html();?>
                            </span>
                            <div class="na-button-add-cart">
                                <?php
                                echo apply_filters( 'woocommerce_loop_add_to_cart_link',
                                    sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="button %s product_type_%s">%s</a>',
                                        esc_url( $product->add_to_cart_url() ),
                                        esc_attr( $product->id ),
                                        esc_attr( $product->get_sku() ),
                                        esc_attr( isset( $quantity ) ? $quantity : 1 ),
                                        $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                                        esc_attr( $product->product_type ),
                                        esc_html( $product->add_to_cart_text())
                                    ),
                                    $product );
                                ?>
                            </div>
                        </div>
                    </div>
                <?php }?>
        </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}

add_shortcode('na_product', 'na_shortcode_product_id');

add_action('vc_before_init', 'na_product_id_integrate_vc');

if (!function_exists('na_product_id_integrate_vc')) {
    function na_product_id_integrate_vc()
    {
        vc_map(
            array(
                'name' => __('NA Products ID', 'na-nano'),
                'base' => 'na_product',
                'icon' => 'icon-nano',
                'category' => __('NA', 'na-nano'),
                'description' => __('Show multiple products by ID eg:23 .', 'na-nano'),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __( 'Product id','na-nano' ),
                        'param_name' => 'product_id',
                        'description' => __( 'Show  product','na-nano'),
                    ),

                    array(
                        'type'        => 'attach_image',
                        'heading'     => __( 'Product Image(size default :500x481 )', 'na-nano' ),
                        'param_name'  => 'product_image',
                        'description' => __( 'Select images from media library.', 'na-nano' ),
                        'value'      => ''
                    ),

                    array(
                        'type' => 'colorpicker',
                        'heading' => __( 'Background Box Product','na-nano'),
                        'description' => __( 'You should choose background box similar background product','na-nano'),
                        'param_name' => 'box_color',
                        'std' => '',
                    ),

                    array(
                        'type' => 'colorpicker',
                        'heading' => __( 'Color Name Product','na-nano'),
                        'param_name' => 'heading_color',
                        'std' => '',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __( 'Font Name Product','na-nano'),
                        'description' => __( 'eg:18px','na-nano'),
                        'param_name' => 'heading_font',
                        'std' => '',
                    ),

                    array(
                        'type' => 'textarea',
                        'holder' => 'div',
                        'heading' => __( 'Product description', 'na-nano' ),
                        'param_name' => 'product_des',
                        'value' =>''
                    ),
                    array(
                        'type' => 'colorpicker',
                        'heading' => __( 'Color Product description','na-nano'),
                        'param_name' => 'des_product_color',
                        'std' => '',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __( 'Font Product description','na-nano'),
                        'description' => __( 'eg:18px','na-nano'),
                        'param_name' => 'des_product_font',
                        'std' => '',
                    ),
                    array(
                        'type'        => 'attach_image',
                        'heading'     => __( 'Description Image', 'na-nano' ),
                        'param_name'  => 'description_image',
                        'description' => __( 'Select images from media library.', 'na-nano' ),
                        'value'      => ''
                    ),
                    array(
                        'type' => 'dropdown',
                        'param_name' => 'alignment_product',
                        'value' => array(
                            __( 'Left', 'na-nano' )   => 'product_left',
                            __( 'Right', 'na-nano' )  => 'product_right',
                            __( 'Center', 'na-nano' ) => 'product_center',
                        ),
                        'std' => 'product_left',
                        'heading' => __( 'Alignment Product','na-nano'),
                        'description' => __( 'Select product alignment.', 'na-nano'),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Custom Class', 'na-nano'),
                        'value' => '',
                        'param_name' => 'element_custom_class',
                        'description' => __('You can use the custom CSS class for this module', 'na-nano'),
                    )
                )
            )
        );
    }
}