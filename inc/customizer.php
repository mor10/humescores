<?php
/**
 * Humescores Theme Customizer.
 *
 * @package Humescores
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function humescores_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	
	/**
	 * Custom Customizer Customizations
	 */
	
	// Setting for header and footer background color
	$wp_customize->add_setting( 'theme_bg_color', array(
		'default'			=> '#002254',
		'transport'			=> 'postMessage',
		'type'				=> 'theme_mod',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	
	// Control for header and footer background color.
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'theme_bg_color', 
				array(
					'label'		=> __( 'Header and footer background color', 'humescores'),
					'section'	=> 'colors',
					'settings'	=> 'theme_bg_color'
				)
		)
	);
	
	// Create interactive color setting
	$wp_customize->add_setting( 'interactive_color' , 
		array(
			'default'			=> '#b51c35',
			'transport'			=> 'postMessage',
			'type'				=> 'theme_mod',
			'sanitize_callback'	=> 'sanitize_hex_color',
			'transport'			=> 'postMessage',
		)
	);
	
	// Add the controls
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'interactive_color', array(
				'label'		=> __( 'Interactive color (links etc)', 'humescores' ),
				'section'	=> 'colors',
				'settings'	=> 'interactive_color'
			)
		)
	);
	
	// Add option to select index content
	$wp_customize->add_section( 'theme_options', 
		array(
			'title'			=> __( 'Theme Options', 'humescores' ),
			'priority'		=> 95,
			'capability'	=> 'edit_theme_options',
			'description'	=> __( 'Change how much of a post is displayed on index and archive pages.', 'humescores' )
		)
	);
	
	// Create excerpt or full content settings
	$wp_customize->add_setting(	'length_setting',
		array(
			'default'			=> 'excerpt',
			'type'				=> 'theme_mod',
			'sanitize_callback' => 'humescores_sanitize_length', // Sanitization function appears further down
			'transport'			=> 'postMessage'
		)
	);

	// Add the controls
	$wp_customize->add_control(	'humescores_length_control',
		array(
			'type'		=> 'radio',
			'label'		=> __( 'Index/archive displays', 'humescores' ),
			'section'	=> 'theme_options',
			'choices'	=> array(
				'excerpt'		=> __( 'Excerpt (default)', 'humescores' ),
				'full-content'	=> __( 'Full content', 'humescores' )
			),
			'settings'	=> 'length_setting' // Matches setting ID from above
		)
	);
	
}
add_action( 'customize_register', 'humescores_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function humescores_customize_preview_js() {
	wp_enqueue_script( 'humescores_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'humescores_customize_preview_js' );


/**
 * Sanitize length options:
 * If something goes wrong and one of the two specified options are not used,
 * apply the default (excerpt).
 */

function humescores_sanitize_length( $value ) {
    if ( ! in_array( $value, array( 'excerpt', 'full-content' ) ) ) {
        $value = 'excerpt';
	}
    return $value;
}


if ( ! function_exists( 'humescores_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog.
 *
 * @see humescores_custom_header_setup().
 */
function humescores_header_style() {
	$header_text_color = get_header_textcolor();
	$header_bg_color = get_theme_mod( 'theme_bg_color' );
	$interactive_color = get_theme_mod('interactive_color');

	/*
	 * If no custom options for text are set, let's bail.
	 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: HEADER_TEXTCOLOR.
	 */
	if ( HEADER_TEXTCOLOR != $header_text_color ) {

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
			// Has the text been hidden?
			if ( ! display_header_text() ) :
		?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php
			// If the user has set a custom color for the text use that.
			else :
		?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
			.main-navigation a,
			button.dropdown-toggle,
			.menu-toggle,
			.site-footer,
			.site-footer a {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}

			.menu-toggle,
			.custom-logo-link:focus > img, .custom-logo-link:hover > img {
				outline-color: #<?php echo esc_attr( $header_text_color ); ?>;
			}

			button.menu-toggle:hover,
			button.menu-toggle:focus {
				color: <?php echo esc_attr( $header_bg_color ); ?>;
				background-color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		</style>
		<?php
	}
	
	/*
	 * Do we have a custom header background color?
	 */
	if ( '#002254' != $header_bg_color ) { ?>
		<style type="text/css">
			.site-header,
			.site-footer {
				background-color: <?php echo esc_attr( $header_bg_color ); ?>;
			}
		</style>
	<?php
	}
	
	/*
	 * Do we have a custom interactive color?
	 */
	if ( '#b51c35' != $interactive_color ) { ?>
		<style type="text/css">
			a:hover,
			a:focus, 
			a:active,
			.page-content a:focus, .page-content a:hover,
			.entry-content a:focus,
			.entry-content a:hover,
			.entry-summary a:focus,
			.entry-summary a:hover,
			.comment-content a:focus,
			.comment-content a:hover,
			.cat-links a {
				color: <?php echo esc_attr( $interactive_color ); ?>;
			}
			
			.page-content a,
			.entry-content a,
			.entry-summary a,
			.comment-content a,
			.post-navigation .post-title,
			.comment-navigation a:hover, 
			.comment-navigation a:focus,
			.posts-navigation a:hover,
			.posts-navigation a:focus,
			.post-navigation a:hover,
			.post-navigation a:focus,
			.paging-navigation a:hover,
			.paging-navigation a:focus,
			.entry-title a:hover, 
			.entry-title a:focus,
			.entry-meta a:focus, 
			.entry-meta a:hover,
			.entry-footer a:focus,
			.entry-footer a:hover,
			.reply a:hover, 
			.reply a:focus,
			.comment-form .form-submit input:hover, 
			.comment-form .form-submit input:focus,
			.widget a:hover, 
			.widget a:focus {
				border-color: <?php echo esc_attr( $interactive_color ); ?>;
			}
			
			.comment-navigation a:hover, 
			.comment-navigation a:focus,
			.posts-navigation a:hover,
			.posts-navigation a:focus,
			.post-navigation a:hover,
			.post-navigation a:focus,
			.paging-navigation a:hover,
			.paging-navigation a:focus,
			.continue-reading a:focus, 
			.continue-reading a:hover,
			.cat-links a:focus, 
			.cat-links a:hover,
			.reply a:hover, 
			.reply a:focus,
			.comment-form .form-submit input:hover, 
			.comment-form .form-submit input:focus {
				background-color: <?php echo esc_attr( $interactive_color ); ?>;
			}
			
			@media screen and (min-width: 900px) {
				.no-sidebar .post-content__wrap .entry-meta a:hover, 
				.no-sidebar .post-content__wrap .entry-meta a:focus {
					border-color: <?php echo esc_attr( $interactive_color ); ?>;
				}
			}
		</style>
	<?php
	} 
}
endif;
