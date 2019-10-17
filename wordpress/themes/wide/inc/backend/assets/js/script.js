/**
 * Created with JetBrains PhpStorm.
 * User: nmc2010
 * Date: 8/26/16
 * Time: 1:59 PM
 * To change this template use File | Settings | File Templates.
 */
( function( $ ) {
    "use strict";
        // Init tabs.
        function init_tabs() {
            var navtab = $( '#tabs-container h2 a' ), tabPanel = $( '.tab-content .tab-pane' ), hashTab = window.location.hash, clickOutside = $( '.trigger-tab' );

            navtab.click( function( e ) {
                $( this ).addClass( 'active' );
                $( this ).siblings().removeClass( 'active' );
                var tab = $( this ).attr( 'href' );
                tabPanel.removeClass( 'active' );
                $( tab ).addClass( 'active' );

                var link = $( this ).attr( 'href' );
                history.pushState( {}, '', link );
                e.preventDefault();
            } );

            if ( hashTab ) {
                navtab.removeClass( 'active' );
                tabPanel.removeClass( 'active' );
                $( '#tabs-container h2 a[href="' + hashTab + '"]' ).addClass( 'active' );
                $( hashTab ).addClass( 'active' );
            }

            clickOutside.on( 'click', function( e ) {
                e.preventDefault();
                $( '.tab-content > div' ).removeClass( 'active' );
                $( '#demos' ).addClass( 'active' );
                $( navtab ).removeClass( 'active' );
                $( navtab[ 0 ] ).addClass( 'active' );
            } );
        }


    $( document ).ready( function() {
        init_tabs();
    } );

} )( jQuery );