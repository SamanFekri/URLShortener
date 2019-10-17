<?php if(get_theme_mod('wide_enable_footer', '1')) { ?>
    <footer id="na-footer" class="na-footer  footer-2">

        <!--    Footer center-->
        <div class="footer-center clearfix">
            <div class="container">
                <div class="container-inner">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <?php dynamic_sidebar('footer-top'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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