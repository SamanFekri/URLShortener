<?php
/**
 * The default template for displaying content
 *
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */
$excerpt = get_theme_mod('wide_share_excerpt', true);
$view = get_theme_mod('wide_post_meta_view', true);
$like = get_theme_mod('wide_post_meta_like', true);
?>
<div class="box box-article">
    <article id="post-<?php the_ID(); ?>" <?php  post_class();?>>
        <?php if(has_post_format('gallery')) : ?>

            <?php $images = get_post_meta( $post->ID, '_format_gallery_images', true ); ?>

            <?php if($images) : ?>
                <div class="post-image single-image">
                    <ul class="owl-single">
                        <?php foreach($images as $image) : ?>
                            <?php $the_image = wp_get_attachment_image_src( $image, 'full-thumb' ); ?>
                            <?php $the_caption = get_post_field('post_excerpt', $image); ?>
                            <li><img src="<?php echo esc_url($the_image[0]); ?>" <?php if($the_caption) : ?>title="<?php echo esc_attr($the_caption); ?>"<?php endif; ?> /></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php elseif(has_post_format('video')) : ?>

                <div class="embed-responsive embed-responsive-16by9 post-video single-video embed-responsive embed-responsive-16by9">
                    <?php $sp_video = get_post_meta( get_the_ID(), '_format_video_embed', true ); ?>
                    <?php if(wp_oembed_get( $sp_video )) : ?>
                        <?php echo wp_oembed_get($sp_video); ?>
                    <?php else : ?>
                        <?php echo esc_url($sp_video); ?>
                    <?php endif; ?>
                </div>

            <?php elseif(has_post_format('audio')) : ?>

                <div class="post-image audio single-audio">
                    <?php $sp_audio = get_post_meta( $post->ID, '_format_audio_embed', true ); ?>
                    <?php if(wp_oembed_get( $sp_audio )) : ?>
                        <?php echo str_replace($search, $replace, wp_oembed_get($sp_audio)); ?>
                    <?php else : ?>
                        <?php echo str_replace('','', $sp_audio); ?>
                    <?php endif; ?>
                </div>

            <?php else : ?>

            <?php if(has_post_thumbnail()) : ?>
                <?php if(!get_theme_mod('sp_post_thumb')) : ?>
                    <div class="post-image single-image ">
                        <a href="<?php echo get_permalink() ?>"><?php the_post_thumbnail('full-thumb'); ?></a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

        <?php endif; ?>
        <div class="entry-header clearfix">
            <div class="article-meta-single">
                    <span class="post-cat"><?php echo wide_category(', '); ?></span>
            </div>

            <header class="entry-header-title">
                <?php  the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            </header>
            <!-- .entry-header -->
        </div>
        <?php if($excerpt) { wide_excerpt(); } ?>
        <div class="entry-avatar clearfix">
            <div class="main-avt-like">
                    <div class="by-title-date">
                        <?php
                        $author_bio_avatar_size = apply_filters( 'wide_author_bio_avatar_size', 50 );
                        echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
                        ?>
                        <span class="author-by"><?php echo esc_html__('by','wide')?></span>
                        <span class="author-title">
                            <a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
                                <?php echo esc_attr(get_the_author()); ?>
                            </a>
                        </span>
                        <span class="post-date">
                            <?php echo get_the_date('M d, Y'); ?>
                        </span>
                    </div>
                    <div class="view-like">
                    <?php if ($view) {?>
                        <div class="total-view post-info-item">
                            <i class="fa fa-eye"></i> <?php echo get_post_meta(get_the_ID(), 'post_views_count', true);?>
                        </div>
                    <?php } ?>
                    <?php if($like){ ?>
                        <?php
                        if (in_array('wti-like-post/wti_like_post.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                            GetWtiLikePost();
                        }
                        ?>
                    <?php }?>
                    </div>
           </div>
        </div>
        <div class="entry-content">
            <?php

                the_content();

                wp_link_pages( array(
                    'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'wide' ) . '</span>',
                    'after'       => '</div>',
                    'link_before' => '<span class="page-numbers">',
                    'link_after'  => '</span>',
                    'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'wide' ) . ' </span>%',
                    'separator'   => '<span class="screen-reader-text">, </span>',
                ) );

            ?>

        </div>
    <!--    Author bio.-->
        <?php
            get_template_part('templates/tag');
            get_template_part('templates/post_pagination');
        ?>
    </article>
</div>
<div class="box box-author">
    <?php
        if ( '' !== get_the_author_meta( 'description' ) ) {
            get_template_part('templates/about_author');
        }
    ?>
</div>
<?php get_template_part('templates/related_posts'); ?>
