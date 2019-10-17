<?php
/**
 * The template for displaying the footer
 *
 * @author      NanoAgency
 * @link        http://nanoagency.co
 * @copyright   Copyright (c) 2015 NanoAgency
 * @license     GPL v2
 */
?>
        </div><!-- .site-content -->
        <?php
            $layout_footer = '';
            if(is_page()){
                $layout_footer = get_post_meta($post->ID, 'layout_footer', true);
            }
            if($layout_footer == 'global' || empty($layout_footer)){
                get_template_part('templates/footer/footer', get_theme_mod('wide_footer', '1'));
            }
            else{
                get_template_part('templates/footer/footer', $layout_footer);
            }
        ?>
    </div><!-- .site -->

<?php wp_footer(); ?>

</body>
</html>