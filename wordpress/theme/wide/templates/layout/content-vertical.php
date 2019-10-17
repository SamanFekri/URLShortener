<?php
/**
 * The default template for displaying content
 *
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */
$format = get_post_format();
$add_class='';
?>

    <article id="post-<?php the_ID(); ?>" <?php post_class('post-item post-tran clearfix post-vertical'); ?>>
        <div class="article-image">
                <?php if(has_post_thumbnail()) : ?>
                    <?php if(!get_theme_mod('sp_post_thumb')) : ?>
                        <div class="post-image">
                            <a href="<?php echo get_permalink() ?>"><?php the_post_thumbnail('wide-blog-vertical'); ?></a>
                            <span class="post-format"><i class="ti-image"></i></span>
                            <?php if ( current_theme_supports( 'post-formats', $format ) ):?>
                                <a  href="<?php echo get_post_format_link( $format ); ?>" class="post-format"><i class="ti-image"></i></a>
                            <?php endif;?>
                        </div>
                    <?php endif; ?>
                <?php else :
                    $add_class='full-width';
                endif; ?>
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
                    echo wide_content(30);
                }
                ?>
            </div>
            <a class="btn-readmore" href="<?php echo get_permalink() ?>"><?php esc_html_e('Read more','wide'); ?></a>
        </div>
    </article><!-- #post-## -->
