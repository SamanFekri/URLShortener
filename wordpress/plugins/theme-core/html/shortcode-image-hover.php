<div class="na-element-builder na-element-image-hover <?php echo esc_attr(($atts['el_class']) ? $atts['el_class'] : ''); ?>">
    <div class="image-hover-inner">
        <?php if($atts['image']) {?>
            <a href="<?php echo esc_url($atts['link']); ?>">
                <?php echo wp_get_attachment_image($atts['image'], 'full'); ?>
            </a>
        <?php } ?>
        <?php if($atts['title'] || $atts['sub_title'] || $atts['text_link']) { ?>
            <div class="image-content-hover">
                <div class="border-mask"></div>
                <div class="content">
                    <?php
                        $html = '';
                        if($atts['title']){
                            $html .= '<h3>'. esc_html($atts['title']) .'</h3>';
                        }
                        if($atts['sub_title']){
                            $html .= '<h4>'. esc_html($atts['sub_title']) .'</h4>';
                        }
                        if($atts['text_link']){
                            $html .= '<a href="'.esc_html($atts['link']).'">'.esc_html($atts['text_link']).'</a>';
                        }
                        echo $html;
                    ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
