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

global $post;
$atts = shortcode_atts(
    array(
        'box_title'             =>'',
        'posts_per_page'    => '',
        'number'            => 1,
        'target'            => '_blank',
        'auto'              => 'true',
        'el_class'          => '',

    ), $atts);

$args = array(
    'posts_per_page' => $atts['posts_per_page'],
    'post_type' => 'testimonial'
);
$the_query = new WP_Query($args);?>

<div class="widget widget-testimonial">
            <?php if ( $atts['box_title'] ) {?>
                <h3 class="widgettitle">
                    <?php echo htmlspecialchars_decode( $atts['box_title'] ); ?>
                </h3>
            <?php }?>
            <div class="widget-content na-testimonial <?php echo  $atts['el_class'];?>" data-number="<?php echo $atts['number'];?>" data-auto="<?php echo $atts['auto'];?>">
                <?php
                if ($the_query->have_posts()) :?>
                    <div class="carousel-main">
                        <?php
                            while ($the_query->have_posts()) : $the_query->the_post();
                                ?>
                                <div class="testimonial_item">

                                    <div class="des-testimonial"><blockquote><?php the_content();?></blockquote></div>

                                </div>
                                <?php
                            endwhile;
                        ?>
                    </div>
                    <div class="carousel-nav">
                        <?php while ($the_query->have_posts()) : $the_query->the_post();
                            $poster_image = get_post_meta($post->ID, 'na_testimonial_image', true);
                            $image=wp_get_attachment_image_src($poster_image,'nano-testimonial-image');
                            $testimonial_position = get_post_meta($post->ID, 'na_testimonial_position', true);
                            ?>
                            <div class="testimonial_author">
                                <div class="group-author-position">
                                    <div class="img-author">
                                        <?php
                                        if(isset($poster_image) && !empty($poster_image)){
                                            echo '<img  class="img-circle" src="'. $image[0] .'" alt="image author" />';
                                        }
                                        ?>
                                    </div>
                                    <div class="author"><?php  the_title();?></div>
                                    <div class="testimonial_position">
                                        <p><?php echo $testimonial_position ;?></p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        ?>
                    </div>
                <?php
                endif;
                wp_reset_postdata();
                ?>
        </div>
</div>