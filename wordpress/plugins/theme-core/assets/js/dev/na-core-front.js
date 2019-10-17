
(function ($) {
    "use strict";
    function customAttribute(){
        // Custom  }
        $( '.nano-custom-attribute > li' ).live( 'click', function(e) {
            e.preventDefault();

            var variation_value = $(this).data( 'value' ),
                selectId        = $(this).parent().data( 'attribute' ),
                select          = $( 'select#'+selectId );

            $(this).addClass( 'selected' ).siblings().removeClass( 'selected' );

            select.val( variation_value ).trigger( 'change' );
        } );

        $( '.variations_form' ).live( 'change', 'select[data-attribute_name]', function() {
            // Auto select option thas has only 1 choice availible
            setTimeout( function() {
                $( '.variations_form select[data-attribute_name]' ).each( function( i, e ) {
                    if ( $( e ).val() == '' && $( e ).children( '[value!=""]' ).length == 1 ) {
                        $( e ).val( $( e ).children( '[value!=""]' ).attr( 'value' ) ).trigger( 'change' );
                    }
                } );
            }, 50 );

            $( '.nano-custom-attribute[data-attribute]' ).each( function( i, e ) {
                ( function( e ) {
                    setTimeout( function() {
                        var option = $( e ).attr( 'data-attribute' ),
                            select = $( '#' + option );

                        $( e ).children().each( function( i2, e2 ) {
                            if ( select.children( '[value="' + $( e2 ).attr( 'data-value' ) + '"]' ).length == 1 ) {
                                $( e2 ).show();
                            } else {
                                $( e2 ).hide();
                            }
                        } );
                    }, 50 );
                } )( e );
            } );
        } );

        $( 'a.reset_variations' ).live( 'click',  function() {
            $( '.nano-custom-attribute' ).each( function( i, e ) {
                $( e ).find( 'li.selected' ).removeClass( 'selected' );
            } )
        } );
    }
    $(document).ready(function() {
        customAttribute();
    });

})(jQuery);
