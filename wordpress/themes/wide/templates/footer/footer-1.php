
<?php if(get_theme_mod('wide_enable_footer', '1')) { ?>
    <footer id="na-footer" class="na-footer  footer-1">

        <?php
        if(is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' )){ ?>
<!--    Footer center-->
            <div class="footer-center clearfix">
                <div class="container">
                    <div class="container-inner">
                        <div class="row">
                            <div class="col-md-4 col-sm-4">
                                <?php dynamic_sidebar('footer-1'); ?>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <?php dynamic_sidebar('footer-2'); ?>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <?php dynamic_sidebar('footer-3'); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }?>
<!--    Footer bottom-->
            <div class="footer-bottom clearfix">
                <div class="container">
                    <div class="container-inner">
                        <div class="row">

                            <div class="col-md-12 col-sm-12">
                                <?php if(get_theme_mod('wide_enable_copyright', '1')) { ?>
                                <div class="coppy-right">
                                <?php if(get_theme_mod('wide_copyright_text')) {?>
                                    <span><?php echo get_theme_mod('wide_copyright_text');?></span>
                                <?php } else {
                                    echo '<span>'.esc_html('Copyright @').' '.date("Y").' '.esc_html('WordPress  Themes by').' <a href="'.esc_url('http://nanoagency.co').'">'.esc_html('NanoAgency').'</a></span>'.esc_html('. All rights reserved.').'';
                                } ?>
                            </div><!-- .site-info -->
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


    </footer><!-- .site-footer -->
    <div id="scrollup" class="scrollup"><i class="fa fa-angle-up"></i></div>
<?php } ?>