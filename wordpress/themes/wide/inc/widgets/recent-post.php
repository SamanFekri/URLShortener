<?php
/**
 * Plugin Name: Latest Posts Widget
 */

add_action( 'widgets_init', 'wide_latest_news_load_widget' );

function wide_latest_news_load_widget() {
    register_widget( 'wide_latest_news_widget' );
}

class wide_latest_news_widget extends WP_Widget {

    /**
     * Widget setup.
     */
    function wide_latest_news_widget() {
        /* Widget settings. */
        $widget_ops = array( 'classname' => 'wide_latest_news_widget', 'description' => esc_html__('A widget that displays your latest posts from all categories or a certain', 'wide') );

        /* Widget control settings. */
        $control_ops = array( 'width' => 250, 'height' => 350, 'id_base' => 'wide_latest_news_widget' );

        /* Create the widget. */
        parent::__construct( 'wide_latest_news_widget', esc_html__('+NA: Latest Posts', 'wide'), $widget_ops, $control_ops );
    }

    /**
     * How to display the widget on the screen.
     */
    function widget( $args, $instance ) {
        extract( $args );

        /* Our variables from the widget settings. */
        $title = apply_filters('widget_title', $instance['title'] );
        $categories = $instance['categories'];
        $number = $instance['number'];


        $query = array('showposts' => $number, 'nopaging' => 0, 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'cat' => $categories);

        $loop = new WP_Query($query);
        if ($loop->have_posts()) :

            /* Before widget (defined by themes). */
            echo ent2ncr($args['before_widget']);


            if($title) {
                echo ent2ncr($args['before_title']) . esc_html($title) . ent2ncr($args['after_title']);
            }
            ?>
            <ul class="recent-post-widgets">

            <?php  while ($loop->have_posts()) : $loop->the_post(); ?>

            <li>

                <div class="side-item clearfix">

                    <?php if (  (function_exists('has_post_thumbnail')) && (has_post_thumbnail())  ) : ?>
                        <div class="post-image">
                            <a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_post_thumbnail('wide-widget-blog', array('class' => 'side-item-thumb')); ?></a>
                        </div>
                    <?php endif; ?>

                    <div class="side-item-text">
                        <h5 class="entry-title" ><a href="<?php echo get_permalink() ?>" rel="bookmark" title="Permanent Link: <?php the_title(); ?>"><?php the_title(); ?></a></h5>
                        <span class="article-meta"><?php the_time( get_option('date_format') ); ?></span>

                    </div>

                </div>

            </li>

        <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        <?php endif; ?>

        </ul>

        <?php

        /* After widget (defined by themes). */
        echo ent2ncr($args['after_widget']);
    }

    /**
     * Update the widget settings.
     */
    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;

        /* Strip tags for title and name to remove HTML (important for text inputs). */
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['categories'] = $new_instance['categories'];
        $instance['number'] = strip_tags( $new_instance['number'] );

        return $instance;
    }


    function form( $instance ) {

        /* Set up some default widget settings. */
        $defaults = array( 'title' => esc_html__('Latest Posts', 'wide'), 'number' => 5, 'categories' => '');
        $instance = wp_parse_args( (array) $instance, $defaults ); ?>

        <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e('Title:', 'wide'); ?></label>
            <input  type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title')); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>"  />
        </p>

        <!-- Category -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('categories')); ?>">Filter by Category:</label>
            <select id="<?php echo esc_attr($this->get_field_id('categories')); ?>" name="<?php echo esc_attr($this->get_field_name('categories')); ?>" class="widefat categories" style="width:100%;">
                <option value='all' <?php if ('all' == $instance['categories']) echo 'selected="selected"'; ?>>All categories</option>
                <?php $categories = get_categories('hide_empty=0&depth=1&type=post'); ?>
                <?php foreach($categories as $category) { ?>
                    <option value='<?php echo esc_attr($category->term_id); ?>' <?php if ($category->term_id == $instance['categories']) echo 'selected="selected"'; ?>><?php echo esc_attr($category->cat_name); ?></option>
                <?php } ?>
            </select>
        </p>

        <!-- Number of posts -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>"><?php esc_html_e('Number of posts to show:', 'wide'); ?></label>
            <input  type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number')); ?>" value="<?php echo esc_attr($instance['number']); ?>" size="3" />
        </p>


    <?php
    }
}

?>