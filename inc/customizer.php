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
		'default' => '#002254',
		'transport' => 'postMessage',
		'type' => 'theme_mod',
		'sanitize_callback' => 'sanitize_hex_color',
	));
	
	// Control for header and footer background color.
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'theme_bg_color', array(
				'label' => __( 'Header and footer background color', 'humescores'),
				'section' => 'colors',
				'settings' => 'theme_bg_color'
			)
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
