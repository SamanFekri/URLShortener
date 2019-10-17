<div class="entry-footer clearfix">
    <div class="tags-link-wrap pull-left">
        <?php if (has_tag()) { ?>
            <div class="tags-wrap">
                <span><?php echo esc_html__("Tags: ",'wide')?></span>
                <span class="tags">
                    <?php the_tags(' ', '', ' '); ?>
                </span>
            </div>
        <?php } ?>
    </div>
    <div class="comment-text pull-right">
       <?php
             get_template_part('templates/share');
       ?>
    </div>
</div>
