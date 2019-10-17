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

$class = '';
if ($atts['portfolio_layout'] == 'medium') {
    $class .= 'col-md-4 col-sm-6 col-xs-12';
}
if (has_post_format('video')):
    if ($atts['portfolio_layout'] == 'medium') echo '<div class="' .  esc_attr($class) . '">'?>
    <div class="wrapper-img">
        <?php $sp_video = get_post_meta(get_the_ID(), '_format_video_embed', true); ?>
        <?php if (wp_oembed_get($sp_video)) : ?>
            <?php echo esc_html(wp_oembed_get($sp_video)); ?>
        <?php else : ?>
            <?php echo esc_html($sp_video); ?>
        <?php endif; ?>
    </div>
    <?php if ($atts['portfolio_layout'] == 'medium'): echo '</div>'; endif;
elseif (has_post_format('audio')) :
    if ($atts['portfolio_layout'] == 'medium') echo '<div class="' . esc_attr($class) . '">'?>
    <div class="wrapper-img">
        <?php $sp_audio = get_post_meta($post->ID, '_format_audio_embed', true); ?>
        <?php if (wp_oembed_get($sp_audio)) : ?>
            <?php echo esc_html(wp_oembed_get($sp_audio)); ?>
        <?php else : ?>
            <?php echo esc_html($sp_audio); ?>
        <?php endif; ?>
    </div>
    <?php
    if ($atts['portfolio_layout'] == 'medium'): echo '</div>'; endif;
elseif (has_post_format('gallery')) : if ($atts['portfolio_layout'] == 'medium') echo '<div class="' .  esc_attr($class) . '">' ?>

    <?php $images = get_post_meta($post->ID, '_format_gallery_images', true); ?>

    <?php if ($images) : ?>
        <div class="wrapper-img">
            <ul class="bxslider">
                <?php foreach ($images as $image) : ?>
                    <?php $the_image = wp_get_attachment_image_src($image, 'full-thumb'); ?>
                    <?php $the_caption = get_post_field('post_excerpt', $image); ?>
                    <li><img src="<?php echo esc_url($the_image[0]); ?>"
                             <?php if ($the_caption) : ?>title="<?php echo  esc_attr($the_caption); ?>"<?php endif; ?> />
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <?php
    if ($atts['portfolio_layout'] == 'medium'): echo '</div>'; endif;
else: if (get_the_post_thumbnail()) :

    if ($atts['portfolio_layout'] == 'medium') {
        echo '<div class="' .  esc_attr($class) . '">';
    }
    ?>
    <div class="wrapper-img"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
            <?php the_post_thumbnail('full-thumb'); ?>
        </a>
        <?php if (!empty($atts['view_more'])) { ?>
            <div class="wrapper-mask">
                <div class="mask"><span class="readmore"><a href="<?php the_permalink(); ?>"
                                                            title="<?php the_title(); ?>"> <?php echo esc_html__('Read more', 'na-nano' )?> </a> </span></div>
            </div>
        <?php } ?>
    </div>
    <?php
    if ($atts['portfolio_layout'] == 'medium'): echo '</div>'; endif;
endif; endif; ?>