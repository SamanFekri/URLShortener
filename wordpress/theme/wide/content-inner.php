<?php
/**
 * The default template for displaying content
 *
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */
$number_posts=get_theme_mod('wide_number_post_cat', '4');

if($number_posts ==='2'){
    $class='col-md-6';
}
elseif($number_posts ==='3'){
    $class='col-md-4';
}
elseif($number_posts ==='4'){
    $class='col-md-3';
}
else{
    $class='col-md-12';
}
$format = get_post_format();
$add_class='';
?>
<div class="<?php echo esc_attr($class); ?> post-grid">
    <article id="post-<?php the_ID(); ?>" <?php post_class('post-item post-list clearfix'); ?>>
        <div class="article-image">
            <?php if(has_post_format('gallery')) : ?>
                <?php $images = get_post_meta( $post->ID, '_format_gallery_images', true ); ?>
                <?php if($images) : ?>
                    <div class="post-gallery">
                        <a href="<?php echo get_permalink() ?>"><?php the_post_thumbnail('wide-blog-gird'); ?></a>
                        <?php if ( current_theme_supports( 'post-formats', $format ) ):?>
                            <a  href="<?php echo get_post_format_link( $format ); ?>" class="post-format"><i class="ti-camera"></i></a>
                        <?php endif;?>
                    </div>
                <?php endif; ?>

            <?php elseif(has_post_format('video')) : ?>
                <div class="post-video">
                    <a href="<?php echo get_permalink() ?>"><?php the_post_thumbnail('wide-blog-gird'); ?></a>
                    <?php if ( current_theme_supports( 'post-formats', $format ) ):?>
                        <a  href="<?php echo get_post_format_link( $format ); ?>" class="post-format"><i class="ti-control-play"></i></a>
                    <?php endif;?>
                </div>
            <?php elseif(has_post_format('audio')) : ?>
                <div class="post-audio">
                    <a href="<?php echo get_permalink() ?>"><?php the_post_thumbnail('wide-blog-gird'); ?></a>
                    <?php if ( current_theme_supports( 'post-formats', $format ) ):?>
                        <a  href="<?php echo get_post_format_link( $format ); ?>" class="post-format"><i class="ti-headphone"></i></a>
                    <?php endif;?>
                </div>
            <?php elseif(has_post_format('quote')) : ?>
                <div class="post-quote">
                    <?php $sp_quote = get_post_meta( $post->ID, '_format_quote_source_name', true ); ?>
                    <a href="<?php echo get_permalink() ?>"><?php the_post_thumbnail('wide-blog-gird'); ?></a>
                    <?php if ( current_theme_supports( 'post-formats', $format ) ):?>
                        <a  href="<?php echo get_post_format_link( $format ); ?>" class="post-format"><i class="ti-quote-left"></i></a>
                    <?php endif;?>
                </div>
            <?php else : ?>
                <?php if(has_post_thumbnail()) : ?>
                    <?php if(!get_theme_mod('sp_post_thumb')) : ?>
                        <div class="post-image">
                            <a href="<?php echo get_permalink() ?>"><?php the_post_thumbnail('wide-blog-gird'); ?></a>
                            <span class="post-format"><i class="ti-image"></i></span>
                            <?php if ( current_theme_supports( 'post-formats', $format ) ):?>
                                <a  href="<?php echo get_post_format_link( $format ); ?>" class="post-format"><i class="ti-image"></i></a>
                            <?php endif;?>
                        </div>
                    <?php endif; ?>
                <?php else :
                    $add_class='full-width';
                endif; ?>

            <?php endif; ?>
        </div>
        <div class="article-content <?php echo esc_attr($add_class);?>">
            <div class="entry-header clearfix">
                 <span class="post-cat"><?php echo wide_category(', '); ?></span>
                <header class="entry-header-title">
                    <?php
                        the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
                    ?>
                </header>
                <!-- .entry-header -->
                <?php
                    if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) && !get_the_title()) {
                        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

                        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
                            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
                        }

                        $time_string = sprintf( $time_string,
                            esc_attr( get_the_date( 'c' ) ),
                            get_the_date(),
                            esc_attr( get_the_modified_date( 'c' ) ),
                            get_the_modified_date()
                        );

                        printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark"><i class="icon icon-clock"></i> %3$s</a></span>',
                            _x( 'Posted on', 'Used before publish date.', 'wide' ),
                            esc_url( get_permalink() ),
                            $time_string
                        );
                    }
                ?>
            </div>
            <div class="entry-content">
                <?php
                    if ( has_excerpt() || is_search() ){
                        wide_excerpt();
                    }
                    else{
                        echo wide_content(25);
                    }

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
            <div class="article-meta clearfix">
                <?php wide_entry_meta(); ?>
            </div>
        </div>
    </article><!-- #post-## -->
</div>