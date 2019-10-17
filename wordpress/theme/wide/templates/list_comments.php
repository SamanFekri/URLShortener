<?php

$GLOBALS['comment'] = $comment;
$add_below = '';

?>
<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">

	<div class="the-comment ">
		<div class="about-author media clearfix">
			<div class="avatar media-left">
				<?php echo get_avatar($comment, 70); ?>
			</div>
			<div class="comment-author meta media-body">
				<div class="ground-user pull-left ">
					<strong class="text-user">
						<?php echo get_comment_author_link(); ?>
					</strong>
					<span class="comment-time"><?php echo human_time_diff( get_comment_date('U'), current_time('timestamp') ) . esc_html__(' ago', 'wide'); ?></span>
				</div>
				<small class="pull-right meta-user">
					<?php edit_comment_link(__('Edit', 'wide'),'  ',' ') ?>
					<?php comment_reply_link(array_merge( $args, array( 'reply_text' => esc_html__('Reply', 'wide'), 'add_below' => 'comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</small>
			</div>
		</div>

		<div class="comment-box ">

			<div class="comment-text">
				<?php if ($comment->comment_approved == '0') : ?>
				<em><?php esc_html_e('Your comment is awaiting moderation.', 'wide') ?></em>
				<br />
				<?php endif; ?>
				<?php comment_text() ?>
			</div>
		</div>

	</div>