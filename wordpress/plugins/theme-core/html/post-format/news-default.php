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

if (has_post_format('video')):
?>
    <div class="na-wrapper-thumb">
        <?php $sp_video = get_post_meta(get_the_ID(), '_format_video_embed', true); ?>
        <?php if (wp_oembed_get($sp_video)) : ?>
            <?php echo esc_html(wp_oembed_get($sp_video)); ?>
        <?php else : ?>
            <?php echo esc_html($sp_video); ?>
        <?php endif; ?>
    </div>
    <?php
elseif (has_post_format('audio')) :?>

    <div class="na-wrapper-thumb">
        <?php $sp_audio = get_post_meta($post->ID, '_format_audio_embed', true); ?>
        <?php if (wp_oembed_get($sp_audio)) : ?>
            <?php echo esc_html(wp_oembed_get($sp_audio)); ?>
        <?php else : ?>
            <?php echo esc_html($sp_audio); ?>
        <?php endif; ?>
    </div>
    <?php
elseif (has_post_format('gallery')) : ?>

    <?php $images = get_post_meta($post->ID, '_format_gallery_images', true); ?>

    <?php if ($images) : ?>
        <div class="na-wrapper-thumb">
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
else: if (get_the_post_thumbnail()) :
    ?>
    <div class="na-wrapper-thumb">
        <a href="<?php esc_url(the_permalink())?>"  title="<?php esc_attr(the_title()); ?>">
            <?php if($atts['layout_type'] == 'vertical' || $atts['layout_type'] == 'normal'): the_post_thumbnail('thumbnail'); else: the_post_thumbnail('large'); endif; ?>
        </a>
        <div class="mask"></div>
    </div>
    <?php
    endif;
endif; ?>