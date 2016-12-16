/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to
				} );
			}
			$( '.main-navigation a,button.dropdown-toggle,.menu-toggle,.site-footer,.site-footer a' ).css( {
				'color': to
			} );
			$( '.menu-toggle,.custom-logo-link:focus > img, .custom-logo-link:hover > img' ).css( {
				'outline-color': to
			} );
			$( 'button.menu-toggle:hover,button.menu-toggle:focus' ).css( {
				'background-color:': to
			} );
		} );
	} );

	// Background color for header and footer.
	wp.customize( 'theme_bg_color', function( value ) {
		value.bind( function( to ) {
			$( '.site-header, .site-footer' ).css( {
				'background-color': to
			} );
		} );
	} );
	
	// Interactive color for links etc.
	wp.customize( 'interactive_color', function( value ) {
		value.bind( function( to ) {
			$( 'a:hover,a:focus,a:active,.page-content a:focus, .page-content a:hover,.entry-content a:focus,.entry-content a:hover,.entry-summary a:focus,.entry-summary a:hover,.comment-content a:focus,.comment-content a:hover,.cat-links a' ).css( {
				'color': to
			} );
			$( '.page-content a,.entry-content a,.entry-summary a,.comment-content a,.post-navigation .post-title,.comment-navigation a:hover,.comment-navigation a:focus,.posts-navigation a:hover,.posts-navigation a:focus,.post-navigation a:hover,.post-navigation a:focus,.paging-navigation a:hover,.paging-navigation a:focus,.entry-title a:hover,.entry-title a:focus,.entry-meta a:focus,.entry-meta a:hover,.entry-footer a:focus,.entry-footer a:hover,.reply a:hover,.reply a:focus,.comment-form .form-submit input:hover,.comment-form .form-submit input:focus,.widget a:hover,.widget a:focus' ).css( {
				'border-color': to
			} );
			$( '.comment-navigation a:hover,.comment-navigation a:focus,.posts-navigation a:hover,.posts-navigation a:focus,.post-navigation a:hover,.post-navigation a:focus,.paging-navigation a:hover,.paging-navigation a:focus,.continue-reading a:focus,.continue-reading a:hover,.cat-links a:focus,.cat-links a:hover,.reply a:hover,.reply a:focus,.comment-form .form-submit input:hover,.comment-form .form-submit input:focus' ).css( {
				'background-color': to
			} );
		} );
	} );
} )( jQuery );
