<?php

$orig_post = $post;

$categories = get_the_category($post->ID);

if ($categories) {

	$category_ids = array();

	foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;

	$args = array(
		'category__in'     => $category_ids,
		'post__not_in'     => array($post->ID),
		'posts_per_page'   => 5,
		'ignore_sticky_posts' => 1,
		'orderby' => 'asc'
	);
	$add_class='';
	$my_query = new wp_query( $args );
	if( $my_query->have_posts() ) { ?>
		<div class="post-related">
			<div class="post-box">
				<h4 class="widgettitle">
					<?php esc_html_e('You may also like', 'wide'); ?>
				</h4>
			</div>
			<div class="related-content clearfix row">
				<div class="related-image pull-left col-md-6 col-sm-6">
					<?php $i=1;
                    while( $my_query->have_posts() ) {
                                $my_query->the_post();
                                ?>
                                <?php if ($i==1){ ?>
                                        <div class="related-image-inner">
                                            <?php if(has_post_thumbnail()) { ?>
                                                <?php if(!get_theme_mod('sp_post_thumb')) : ?>
                                                <div class="post-image<?php echo (is_single()) ? ' single-image' : ''; ?>">
                                                    <a href="<?php echo get_permalink() ?>"><?php the_post_thumbnail('full-thumb'); ?></a>
                                                </div>
                                                <?php endif; ?>
                                                <?php } else{
                                                    $add_class ='full-width';?>
                                                <?php } ?>
                                        </div>
                                <?php }?>
                        <?php
                        $i++;
                        } ?>
				</div>
				<div class="related-meta pull-left col-md-6 col-sm-6 <?php echo esc_attr($add_class);?>">
					<?php while( $my_query->have_posts() ) {
						$my_query->the_post();
						?>
							<div class="related-meta-inner">
								<h3 class="post-title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h3>
							</div>
					<?php
					}
		echo '</div></div></div>';
	}
}
$post = $orig_post;
wp_reset_postdata();

?>