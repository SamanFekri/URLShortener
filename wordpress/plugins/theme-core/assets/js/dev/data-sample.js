jQuery(function($){
    'use strict';
    jQuery(document).ready(function(){
        var $import_actions     = $('.import-actions');
        var $import_progress    = $('.nano-progress-import');
        var $import_button          = $import_actions.find('.nano-install-button');
        var $active_button          = $import_actions.find('.nano-active-button');
        var $deactivate_button      = $import_actions.find('.nano-deactivate-button');
        //install
        $import_button.click(function import_type(){
            jQuery(this).parent().parent().find('.nano-progress-import').show();
            jQuery(this).parent().parent().addClass('loading');
            $.ajax({
                url: NaScript.ajax_url,
                type: 'POST',
                data: { action: 'import_widget' },
                beforeSend: function() {
                    $import_progress.find('.note').append('<span>Widget importing ... </span>');
                },
                success:function(data) {
                    $import_progress.find('.note span').remove();
                    $import_progress.find('.meter span').animate({width: '20%'},'slow');
                    console.log(data);
                    jQuery.ajax({
                        url: NaScript.ajax_url,
                        type: 'POST',
                        data: {action: 'import_slider'},
                        beforeSend: function() {
                            $import_progress.find('.note').append('<span>Slider importing ... </span>');
                        },
                        success: function(){
                            $import_progress.find('.note span').remove();
                            $import_progress.find('.meter span').animate({width: '60%'},'slow');
                            jQuery.ajax({
                                url: NaScript.ajax_url,
                                type: 'POST',
                                data: {action: 'import_data'},
                                beforeSend: function() {
                                    $import_progress.find('.note').append('<span>Data xample importing ... </span>');
                                },
                                success: function(){
                                    $import_progress.find('.note span').remove();
                                    $import_progress.find('.meter span').animate({width: '100%'},'slow');
                                    jQuery(".nano-import .theme").removeClass('loading');
                                    $import_button.addClass('hidden');
                                    $active_button.removeClass('hidden')
                                    alert('Imported !');
                                },
                                error: function(){
									$import_progress.find('.note span').remove();
                                    $import_progress.find('.meter span').animate({width: '100%'},'slow');
                                    jQuery(".nano-import .theme").removeClass('loading');
                                    $import_button.addClass('hidden');
                                    $active_button.removeClass('hidden');
                                    alert('Imported ! Please active Home Page');
                                }
                            });
                        },
                        error: function(){
                            $import_progress.find('.note span').remove();
                            $import_progress.find('.note').append('<span>Failed to import slider !!! </span>');
                        }
                    });
                },
                error: function(data){
                    console.log(data);
                    $import_progress.find('.note span').remove();
                    $import_progress.find('.note').append('<span>Failed to import widget !!! </span>');
                }
            });
            return false;
        });
        //active
        $active_button.click(function import_type(){
            var $active_home=$(this).data("demo-slug");
            $.ajax({
                url: NaScript.ajax_url,
                type: 'POST',
                data: { action: 'active_home',active_home :$active_home },
                success:function(data) {

                },
                error: function(data){
                    console.log(data);
                }
            });
            $active_button.parent().parent().removeClass('active');
            $deactivate_button.addClass('hidden');
            $active_button.removeClass('hidden');
            $(this).parent().parent().addClass('active');
            $(this).parent().find('.nano-deactivate-button').removeClass('hidden');
            $(this).addClass('hidden');
            return false;
        });
        //deactivate
        $deactivate_button.click(function import_type(){
            $.ajax({
                url: NaScript.ajax_url,
                type: 'POST',
                data: { action: 'deactivate_home' },
                success:function(data) {
                },
                error: function(data){
                    console.log(data);
                }
            });
            $(this).parent().parent().removeClass('active');
            $(this).addClass('hidden');
            $(this).parent().find('.nano-active-button').removeClass('hidden');
            return false;
        });
    });
});
