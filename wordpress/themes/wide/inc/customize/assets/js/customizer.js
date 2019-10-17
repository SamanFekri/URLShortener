(function ($) {
    "use strict";
    $(document).ready(function() {
        $( '.customize-control-layout label img' ).click(function() {
            $(this).prev().prop('checked');
            $(this).closest('.customize-control-layout').find('label').removeClass('selected');
            $(this).closest('label').addClass('selected');
        });

        // Input layout
        $( '.customize-control-layout input:radio' ).change( function () {

            $ ( this ).parent();
            // Get name of setting
            var setting = $ ( this ).data( 'id' );

            // Get the value of currently-checked radio input
            var image = $ ( this ).val();

            // Set new value
            wp.customize( setting, function ( obj ) {
                obj.set( image );
            } );

        } );

        // Input layout
        $( '.customize-control-boxcheck input' ).change( function () {

            // Get name of setting
            var setting = $ ( this ).data( 'id' );

            // Get the value of currently-checked radio input
            var checkbox = $ ( this ).val();

            // Set new value
            wp.customize( setting, function ( obj ) {
                obj.set( checkbox );
            } );

        } );

        //style check box
        $(".customize-control-checkbox label input[type='checkbox']").each ( function() {

            if( $(this).is(':checked')){
                $(this).parent().addClass("checked");
            }
            $(this).on('click',function() {
                if( $(this).is(':checked')){
                    $(this).parent().addClass("checked");
                }
                else{
                    $(this).parent().removeClass("checked");
                }
            });
        });

        // Checkbox toggle
        $( '.customize-control-toggle-checkbox input[type="checkbox"]' ).each( function() {

            if ( $(this).is(':checked') ) {
                $(this).parent().addClass('checked');
            }

            $(this).on( 'click', function() {

                if ( $(this).is(':checked') ) {
                    $(this).parent().addClass('checked');
                } else {
                    $(this).parent().removeClass('checked');
                }
            } );
        } );

        // slider
        var controlSlider = $( '.customize-control-slider' );

        controlSlider.each( function() {
            var inputField = $(this).find( '.wide-slider-range-input' ),
                sliderRange = $(this).find( '.wide-slider-range' );

            $(this).find('.wide-slider-range').slider({
                range: "min",
                min: sliderRange.data('min'),
                max: sliderRange.data('max'),
                step: sliderRange.data('step'),
                value: inputField.val(),
                animate: true,
                slide: function( event, ui ) {
                    $(this).next().val( ui.value );
                    inputField.trigger('change');
                }
            });
        } )

        $( '.wide-slider-range-input' ).on( 'keyup paste', function() {
            $(this).change();
            var sliderRange = $(this).prev();
            $(this).prev().slider({
                range: "min",
                min: sliderRange.data('min'),
                max: sliderRange.data('max'),
                value: $(this).val(),
                animate: true,
            });
        } );

        $( '.wide-slider-range-input' ).on( 'change', function() {

            $ ( this ).parent();

            // Get name of setting
            var setting = $ ( this ).data( 'id' );

            // Get the value of currently-checked radio input
            var range = $ ( this ).val();

            // Set new value
            wp.customize( setting, function ( obj ) {
                obj.set( range );
            } );
        } );

    });

})(jQuery);


