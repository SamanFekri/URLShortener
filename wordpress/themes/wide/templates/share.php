<div class="social share-links clearfix" xmlns="http://www.w3.org/1999/html">
    <?php
    $url                = get_permalink();
    $share_facebook     = get_theme_mod('wide_share_facebook',true);
    $share_twitter      = get_theme_mod('wide_share_twitter',true);
    $share_google       = get_theme_mod('wide_share_google',true);
    $share_linkedin     = get_theme_mod('wide_share_linkedin',false);
    $share_pinterest    = get_theme_mod('wide_share_pinterest',false);
    ?>
    <ul class="social-icons list-unstyled list-inline">
        <?php if ($share_facebook):?>
        <li class="social-item facebook">
            <a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" title="<?php echo esc_html__('facebook', 'wide'); ?>" class="post_share_facebook facebook" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=220,width=600');return false;">
                <i class="fa fa-facebook"></i>
            </a>
        </li>
        <?php endif; ?>
        <?php if ($share_twitter):?>
        <li class="social-item twitter">
            <a href="https://twitter.com/share?url=<?php the_permalink(); ?>" title="<?php echo esc_html__('twitter', 'wide'); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=260,width=600');return false;" class="product_share_twitter twitter">
                <i class="fa fa-twitter"></i>
            </a>
        </li>
        <?php endif; ?>
        <?php if ($share_google):?>
        <li class="social-item google">
            <a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" class="googleplus" title="<?php echo esc_html__('google +', 'wide'); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;">
                <i class="fa fa-google-plus"></i>
            </a>
        </li>
        <?php endif; ?>
        <?php if ($share_linkedin):?>
        <li class="social-item linkedin">
            <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink();?>&title=<?php echo esc_html__('pinterest', 'wide'); ?>&summary=<?php echo get_the_title(); ?>&source=<?php echo get_the_title(); ?>">
                <i class="fa fa-linkedin"></i>
            </a>
        </li>
        <?php endif; ?>
        <?php if ($share_pinterest):?>
            <li class="social-item pinterest">
                <a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php if(function_exists('the_post_thumbnail')) echo wp_get_attachment_url(get_post_thumbnail_id()); ?>&description=<?php echo get_the_title(); ?>" title="<?php echo esc_html__('pinterest', 'wide'); ?>" class="pinterest">
                    <i class="fa fa-pinterest"></i>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</div>