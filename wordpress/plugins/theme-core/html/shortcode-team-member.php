<?php
global $post;
$na_member_image = $na_member_position = $na_member_fb = $na_member_tw = $na_member_isg = $na_member_gl = '';
$_order = $atts['order'];
$_eb_position = $atts['eb_position'];
$_eb_social = $atts['eb_social'];
$_class = 'col-sm-' . (12 / $atts['num_slider']) . ' ' . 'col-md-' . (12 / $atts['num_slider']);
?>
<div class="na-member-wrap <?php echo esc_attr($atts['el_class']) ?>">
    <h3 class="widgettitle">
        <span><?php echo htmlspecialchars_decode( $atts['box_title'] ); ?></span>
    </h3>
    <ul class="na-member-list row">
        <?php
        $args = array(
            'order' => $_order,
            'post_type' => 'member');

        $the_query = new WP_Query($args);

        if ($the_query->have_posts()) :
            while ($the_query->have_posts()) : $the_query->the_post();
                if(!is_404()){
                    $na_member_image = get_post_meta(get_the_ID(), 'na_member_image', true);
                    $na_member_position = get_post_meta(get_the_ID(), 'na_member_position', true);
                    $na_member_fb = get_post_meta(get_the_ID(), 'na_member_fb', true);
                    $na_member_tw = get_post_meta(get_the_ID(), 'na_member_tw', true);
                    $na_member_isg = get_post_meta(get_the_ID(), 'na_member_isg', true);
                    $na_member_gl = get_post_meta(get_the_ID(), 'na_member_gl', true);
                }
                ?>
                <li class="na-member-item <?php echo esc_attr($_class); ?>">
                    <div class="na-member-item-inner">
                        <?php if($na_member_image != '') { ?>
                            <img src="<?php echo esc_url(wp_get_attachment_url($na_member_image)); ?>" alt="<?php echo esc_html(__('Image Team', 'na-nano')); ?>" />
                        <?php } ?>
                        <div class="member-info">
                            <h5 class="member"><?php echo get_the_title(); ?></h5>
                            <?php if($_eb_position != 'no' && $na_member_position != '') { ?>
                                <span class="member-position"><?php echo esc_html($na_member_position); ?></span>
                            <?php } ?>
                        </div>
                        <?php if($_eb_social != 'no') { ?>
                            <div class="na-social">
                                <ul>
                                    <?php if($na_member_fb) { ?>
                                        <li class="facebook"><a href="<?php echo esc_url($na_member_fb); ?>"><i class="fa fa-facebook"></i></a></li>
                                    <?php } ?>
                                    <?php if($na_member_tw) { ?>
                                        <li class="twitter"><a href="<?php echo esc_url($na_member_tw); ?>"><i class="fa fa-twitter"></i></a></li>
                                    <?php } ?>
                                    <?php if($na_member_isg) { ?>
                                        <li class="instagram"><a href="<?php echo esc_url($na_member_isg); ?>"><i class="fa fa-instagram"></i></a></li>
                                    <?php } ?>
                                    <?php if($na_member_gl) { ?>
                                        <li class="googleplus"><a href="<?php echo esc_url($na_member_gl); ?>"><i class="fa fa-google-plus"></i></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>
                    </div>
                </li>
            <?php
            endwhile;
        endif;

        wp_reset_postdata();

        ?>
    </ul>
</div>