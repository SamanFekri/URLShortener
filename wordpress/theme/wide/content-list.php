<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package     wide
 * @version     1.0
 * @author      NanoAgency
 * @link        http://www.nanoagency.co
 * @copyright   Copyright (c) 2016 NanoAgency
 * @license     GPL v2
 */
?>
2
<article id="post-<?php the_ID(); ?>" <?php (is_single()) ? post_class() : post_class('post-item'); ?>>

    <?php if(has_post_format('gallery')) : ?>

        <?php $images = get_post_meta( $post->ID, '_format_gallery_images', true ); ?>

        <?php if($images) : ?>
            <div class="post-image<?php echo (is_single()) ? ' single-image' : ''; ?>">
                <ul class="bxslider">
                    <?php foreach($images as $image) : ?>

                        <?php $the_image = wp_get_attachment_image_src( $image, 'full-thumb' ); ?>
                        <?php $the_caption = get_post_field('post_excerpt', $image); ?>
                        <li><img src="<?php echo esc_url($the_image[0]); ?>" <?php if($the_caption) : ?>title="<?php echo esc_attr($the_caption); ?>"<?php endif; ?> /></li>

                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

    <?php elseif(has_post_format('video')) : ?>

        <div class="post-image<?php echo (is_single()) ? ' single-video embed-responsive embed-responsive-16by9' : ''; ?>">
            <?php $sp_video = get_post_meta( $post->ID, '_format_video_embed', true ); ?>
            <?php if(wp_oembed_get( $sp_video )) : ?>
                <?php echo str_replace($search, $replace, wp_oembed_get($sp_video)); ?>
            <?php else : ?>
                <?php echo str_replace($search, $replace, $sp_video); ?>
            <?php endif; ?>
        </div>

    <?php elseif(has_post_format('audio')) : ?>

        <div class="post-image audio<?php echo (is_single()) ? ' single-audio' : ''; ?>">
            <?php $sp_audio = get_post_meta( $post->ID, '_format_audio_embed', true ); ?>
            <?php if(wp_oembed_get( $sp_audio )) : ?>
                <?php echo str_replace($search, $replace, wp_oembed_get($sp_audio)); ?>
            <?php else : ?>
                <?php echo str_replace($search, $replace, $sp_audio); ?>
            <?php endif; ?>
        </div>

    <?php else : ?>

        <?php if(has_post_thumbnail()) : ?>
            <?php if(!get_theme_mod('sp_post_thumb')) : ?>
                <div class="post-image<?php echo (is_single()) ? ' single-image' : ''; ?>">
                    <a href="<?php echo get_permalink() ?>"><?php the_post_thumbnail('full-thumb'); ?></a>
                </div>
            <?php endif; ?>
        <?php endif; ?>

    <?php endif; ?>

	<header class="entry-header">
		<?php
			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			endif;
		?>
	</header><!-- .entry-header -->

    <div class="article-meta">
        <span class="post-cat"><i class="fa fa-eye"></i><?php echo esc_attr(wide_category(', ')); ?></span>

        <div class="pull-right">
            <span class="post-date pul-left"><i class="fa fa-clock-o"></i><?php echo get_the_date('F jS, Y'); ?></span>
            <span class="post-comment"><a href="<?php echo esc_url(the_permalink()); ?>#comments"><i class="fa fa-comment-o"></i><?php comments_number( '0 Comment', '1 Comment', '% Comments' ); ?></a></span>
        </div>
    </div>

	<div class="entry-content">
		<?php
            if(is_single()){
                the_content();
            } else {
                echo wide_content(50);
            }
        ?>
	</div><!-- .entry-content -->

	<?php
		// Author bio.
		if ( is_single() && get_the_author_meta( 'description' ) ) :
			get_template_part( 'author-bio' );
		endif;
	?>

</article><!-- #post-## -->
