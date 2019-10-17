<?php
/**
 * @package     wide
 * @version     1.0
 * @author      NanoAgency
 * @link        http://www.nanoagency.co
 * @copyright   Copyright (c) 2016 NanoAgency
 * @license     GPL v2
 */
class wide_tabs_post extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'tabs_post',__('+NA: Tabs Post','wide'),
            array('description'=>__('Tabs Post', 'wide'))
        );
    }

    public function widget( $args, $instance ) {
        extract( $args );
        $posts = $instance['posts'];
        $tags_count = $instance['tags'];
        $comment = get_theme_mod('wide_post_meta_comment', true);
        $view = get_theme_mod('wide_post_meta_view', true);
        $like = get_theme_mod('wide_post_meta_like', true);
        $show_popular_posts = isset($instance['show_popular_posts']) ? 'true' : 'false';
        $show_recent_posts = isset($instance['show_recent_posts']) ? 'true' : 'false';
        $show_comments = isset($instance['show_comments']) ? 'true' : 'false';

        $url                = get_permalink();

        echo ent2ncr($args['before_widget']);?>
        <ul class="nav nav-tabs widget-title">
            <?php if($show_popular_posts == 'true'): ?>
                <li class="active ">
                    <a href="#tab-popular" class="tabs-title-product" aria-expanded="true" data-toggle="tab" role="tab"><?php echo esc_html__('Most Views', 'wide' ); ?></a>
                </li>
            <?php endif; ?>
            <?php if($show_recent_posts == 'true'): ?>
                <li <?php if($show_popular_posts != 'true') echo 'class="active"'; ?>>
                    <a href="#tab-recent" class="tabs-title-product" aria-expanded="false" data-toggle="tab" role="tab"><?php echo esc_html__('Recent', 'wide' ); ?></a>
                </li>
            <?php endif; ?>
            <?php if($show_comments == 'true'): ?>
                <li <?php if($show_popular_posts != 'true' && $show_recent_posts != 'true' ) echo 'class="active"'; ?>>
                    <a href="#tab-comments" class="tabs-title-product" aria-expanded="false" data-toggle="tab" role="tab"><?php echo esc_html__('Comments', 'wide' ); ?></a>
                </li>
            <?php endif; ?>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <?php if($show_popular_posts == 'true'): ?>
                <div class="tab-pane active posts-listing" id="tab-popular">
                    <?php
                    $i=1;
                    $popular_posts = new WP_Query('showposts='.$posts.'&meta_key=post_views_count&orderby=meta_value_num&order=DESC');
                    if($popular_posts->have_posts()): ?>
                        <div class="post-widget">
                            <?php while($popular_posts->have_posts()): $popular_posts->the_post(); ?>
                                <article class="post media">
                                        <?php if ($i==1){?>
                                            <div class="post-thumb">
                                                <?php if ( has_post_thumbnail() ) {?>
                                                    <a href="<?php the_permalink(); ?>" title="">
                                                        <?php the_post_thumbnail('wide-widget-blog-large');?>
                                                    </a>
                                                <?php }?>
                                            </div>
                                            <div class="post-content">
                                                <h3 class="entry-title">
                                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                                        <?php the_title(); ?>
                                                    </a>
                                                </h3>
                                                <div class="entry-meta">

                                                    <div class="by-title-date">
                                                        <span class="author-by"><?php echo esc_html__('by','wide')?></span>
                                                        <span class="author-title">
                                                            <a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
                                                                <?php echo esc_attr(get_the_author()); ?>
                                                            </a>
                                                        </span>
                                                    </div>
                                                    <div class="view-like">
                                                        <?php if($comment){?>
                                                            <div class="meta-comment">
                                                                <?php $comments_facebook = get_theme_mod('wide_comments_single_facebook',false);?>
                                                                <?php if($comments_facebook){?>
                                                                    <span class="fb-comments-count" data-href="<?php echo esc_url(get_permalink()) ?>"></span><span class="txt"><?php echo esc_html__(' Comments','wide')?></span>
                                                                <?php } else{?>
                                                                    <span class="text-comment"><?php comments_number( '0', '1', '%' ); ?><i class="fa fa-comments" aria-hidden="true"></i></span>
                                                                <?php }?>
                                                            </div>
                                                        <?php }
                                                        if($like) {
                                                            if (in_array('wti-like-post/wti_like_post.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                                                                GetWtiLikePost();
                                                            }
                                                        }
                                                        if($view) {?>
                                                            <div class="total-view post-info-item">
                                                                <i class="fa fa-eye"></i> <?php echo get_post_meta(get_the_ID(), 'post_views_count', true);?>
                                                            </div>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }

                                        else {?>
                                            <div class="post-thumb pull-left">
                                                <?php if ( has_post_thumbnail() ) {?>
                                                    <a href="<?php the_permalink(); ?>" title="">
                                                        <?php the_post_thumbnail('wide-widget-blog');?>
                                                    </a>
                                                <?php }?>
                                            </div>
                                            <div class="post-content  media-body">
                                                <h3 class="entry-title">
                                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                                        <?php the_title(); ?>
                                                    </a>
                                                </h3>
                                                <div class="entry-meta">

                                                    <div class="by-title-date">
                                                        <span class="author-by"><?php echo esc_html__('by','wide')?></span>
                                                        <span class="author-title">
                                                            <a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
                                                                <?php echo esc_attr(get_the_author()); ?>
                                                            </a>
                                                        </span>
                                                    </div>
                                                    <div class="view-like">
                                                        <?php if($comment){?>
                                                            <div class="meta-comment">
                                                                <?php $comments_facebook = get_theme_mod('wide_comments_single_facebook',false);?>
                                                                <?php if($comments_facebook){?>
                                                                    <span class="fb-comments-count" data-href="<?php echo esc_url(get_permalink()) ?>"></span><span class="txt"><?php echo esc_html__(' Comments','wide')?></span>
                                                                <?php } else{?>
                                                                    <span class="text-comment"><?php comments_number( '0', '1', '%' ); ?><i class="fa fa-comments" aria-hidden="true"></i></span>
                                                                <?php }?>
                                                            </div>
                                                        <?php }
                                                        if($like) {
                                                            if (in_array('wti-like-post/wti_like_post.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                                                                GetWtiLikePost();
                                                            }
                                                        }
                                                        if($view) {?>
                                                            <div class="total-view post-info-item">
                                                                <i class="fa fa-eye"></i> <?php echo get_post_meta(get_the_ID(), 'post_views_count', true);?>
                                                            </div>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                </article>
                                <?php $i++; ?>
                            <?php endwhile;  wp_reset_postdata();?>

                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if($show_recent_posts == 'true'): ?>
                <div class="tab-pane" id="tab-recent">
                    <?php
                    $recent_posts = new WP_Query('showposts='.$tags_count);
                    $j=1;
                    if($recent_posts->have_posts()):
                        ?>
                        <div class="post-widget  posts-listing">
                            <?php while($recent_posts->have_posts()): $recent_posts->the_post(); ?>
                                <article class="post media">


                                        <?php if ($j==1){?>
                                            <div class="post-thumb">
                                                <?php if ( has_post_thumbnail() ) {?>
                                                    <a href="<?php the_permalink(); ?>" title="">
                                                        <?php the_post_thumbnail('wide-widget-blog-large');?>
                                                    </a>
                                                <?php }?>
                                            </div>
                                            <div class="post-content">
                                                <h3 class="entry-title">
                                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                                        <?php the_title(); ?>
                                                    </a>
                                                </h3>
                                                <div class="entry-meta">

                                                    <div class="by-title-date">
                                                        <span class="author-by"><?php echo esc_html__('by','wide')?></span>
                                                        <span class="author-title">
                                                            <a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
                                                                <?php echo esc_attr(get_the_author()); ?>
                                                            </a>
                                                        </span>
                                                    </div>
                                                    <div class="view-like">
                                                        <?php if($comment){?>
                                                            <div class="meta-comment">
                                                                <?php $comments_facebook = get_theme_mod('wide_comments_single_facebook',false);?>
                                                                <?php if($comments_facebook){?>
                                                                    <span class="fb-comments-count" data-href="<?php echo esc_url(get_permalink()) ?>"></span><span class="txt"><?php echo esc_html__(' Comments','wide')?></span>
                                                                <?php } else{?>
                                                                    <span class="text-comment"><?php comments_number( '0', '1', '%' ); ?><i class="fa fa-comments" aria-hidden="true"></i></span>
                                                                <?php }?>
                                                            </div>
                                                        <?php }
                                                        if($like) {
                                                            if (in_array('wti-like-post/wti_like_post.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                                                                GetWtiLikePost();
                                                            }
                                                        }
                                                        if($view) {?>
                                                            <div class="total-view post-info-item">
                                                                <i class="fa fa-eye"></i> <?php echo get_post_meta(get_the_ID(), 'post_views_count', true);?>
                                                            </div>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }

                                        else { ?>
                                            <div class="post-thumb pull-left">
                                                <?php if ( has_post_thumbnail() ) {?>
                                                    <a href="<?php the_permalink(); ?>" title="">
                                                        <?php the_post_thumbnail('wide-widget-blog');?>
                                                    </a>
                                                <?php }?>
                                            </div>
                                            <div class="post-content  media-body">
                                                <h3 class="entry-title">
                                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                                        <?php the_title(); ?>
                                                    </a>
                                                </h3>
                                                <div class="entry-meta">

                                                    <div class="by-title-date">
                                                        <span class="author-by"><?php echo esc_html__('by','wide')?></span>
                                                        <span class="author-title">
                                                            <a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
                                                                <?php echo esc_attr(get_the_author()); ?>
                                                            </a>
                                                        </span>
                                                    </div>
                                                    <div class="view-like">
                                                        <?php if($comment){?>
                                                            <div class="meta-comment">
                                                                <?php $comments_facebook = get_theme_mod('wide_comments_single_facebook',false);?>
                                                                <?php if($comments_facebook){?>
                                                                    <span class="fb-comments-count" data-href="<?php echo esc_url(get_permalink()) ?>"></span><span class="txt"><?php echo esc_html__(' Comments','wide')?></span>
                                                                <?php } else{?>
                                                                    <span class="text-comment"><?php comments_number( '0', '1', '%' ); ?><i class="fa fa-comments" aria-hidden="true"></i></span>
                                                                <?php }?>
                                                            </div>
                                                        <?php }
                                                        if($like) {
                                                            if (in_array('wti-like-post/wti_like_post.php', apply_filters('active_plugins', get_option('active_plugins')))) {
                                                                GetWtiLikePost();
                                                            }
                                                        }
                                                        if($view) {?>
                                                            <div class="total-view post-info-item">
                                                                <i class="fa fa-eye"></i> <?php echo get_post_meta(get_the_ID(), 'post_views_count', true);?>
                                                            </div>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                </article>
                                <?php $j++; ?>
                            <?php endwhile;   wp_reset_postdata();?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php if($show_comments == 'true'): ?>
                <div class="tab-pane" id="tab-comments">
                    <div class="comment-widget  posts-listing">
                        <?php
                        $number = $instance['comments'];
                        global $wpdb;
                        $the_comments = get_comments( array(
                            'number'    => $number,
                            'status'    => 'approve'
                        ) );
                        foreach($the_comments as $comment) { ?>
                            <article class=" post media clearfix">
                                <div class="avatar-comment-widget pull-left">
                                    <?php echo get_avatar($comment, '70'); ?>
                                </div>
                                <div class="content-comment-widget media-body">
                                    <h3 class="entry-title">
                                        <?php echo strip_tags($comment->comment_author); ?> <?php esc_html__('says', 'wide' ); ?>:
                                    </h3>
                                    <a class="comment-text-side" href="<?php echo get_permalink($comment->comment_post_ID); ?>#comment-<?php echo esc_attr($comment->comment_ID); ?>" title="<?php echo strip_tags($comment->comment_author); ?> on <?php echo esc_attr($comment->post_title); ?>">
                                        <?php echo wide_string_limit_words(strip_tags($comment->comment_content), 12); ?>...
                                    </a>
                                </div>
                            </article>
                        <?php } ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php
        echo ent2ncr($args['after_widget']);;
    }
// Widget Backend
    public function form( $instance ) {
        $instance = wp_parse_args($instance,array(
            'title'       =>  'Contact info',
            'posts' => 3,
            'comments' =>3,
            'tags' =>3,
            'show_popular_posts' => 'on',
            'show_recent_posts' => 'on',
            'show_comments' => 'on',
        ));
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('posts')); ?>"><?php echo esc_html__('Number of Most Views posts:', 'wide' ); ?></label>
            <input class="widefat" type="text" style="width: 30px;" id="<?php echo esc_attr($this->get_field_id('posts')); ?>" name="<?php echo esc_attr($this->get_field_name('posts')); ?>" value="<?php echo esc_attr($instance['posts']); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('tags')); ?>"><?php echo esc_html__('Number of recent posts:', 'wide' ); ?></label>
            <input class="widefat" type="text" style="width: 30px;" id="<?php echo esc_attr($this->get_field_id('tags')); ?>" name="<?php echo esc_attr($this->get_field_name('tags')); ?>" value="<?php echo esc_attr($instance['tags']); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('comments')); ?>"><?php echo esc_html__('Number of comments:', 'wide' ); ?></label>
            <input class="widefat" type="text" style="width: 30px;" id="<?php echo esc_attr($this->get_field_id('comments')); ?>" name="<?php echo esc_attr($this->get_field_name('comments')); ?>" value="<?php echo esc_attr($instance['comments']); ?>" />
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['show_popular_posts'], 'on'); ?> id="<?php echo esc_attr($this->get_field_id('show_popular_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('show_popular_posts')); ?>" />
            <label for="<?php echo esc_attr($this->get_field_id('show_popular_posts')); ?>"><?php echo esc_html__('Show Most Views posts', 'wide' ); ?></label>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['show_recent_posts'], 'on'); ?> id="<?php echo esc_attr($this->get_field_id('show_recent_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('show_recent_posts')); ?>" />
            <label for="<?php echo esc_attr($this->get_field_id('show_recent_posts')); ?>"><?php echo esc_html__('Show recent posts', 'wide' ); ?></label>
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['show_comments'], 'on'); ?> id="<?php echo esc_attr($this->get_field_id('show_comments')); ?>" name="<?php echo esc_attr($this->get_field_name('show_comments')); ?>" />
            <label for="<?php echo esc_attr($this->get_field_id('show_comments')); ?>"><?php echo esc_html__('Show comments', 'wide' ); ?></label>
        </p>
    <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['posts'] = $new_instance['posts'];
        $instance['tags'] = $new_instance['tags'];
        $instance['comments'] = $new_instance['comments'];
        $instance['show_popular_posts'] = $new_instance['show_popular_posts'];
        $instance['show_recent_posts'] = $new_instance['show_recent_posts'];
        $instance['show_comments'] = $new_instance['show_comments'];
        return $instance;

    }
}
function wide_tabs_post(){
    register_widget('wide_tabs_post');
}
add_action('widgets_init','wide_tabs_post');