<?php
/**
 * Humescores functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Humescores
 */

if ( ! function_exists( 'humescores_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function humescores_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Humescores, use a find and replace
	 * to change 'humescores' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'humescores', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'humescores-full-bleed', 2000, 1200, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Header', 'humescores' ),
		'social' => esc_html__( 'Social Media Menu', 'humescores' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'humescores_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
	
	// Add theme support for Custom Logo
	add_theme_support( 'custom-logo', array(
		'width' => 90,
		'height' => 90,
		'flex-width' => true,
	));
	
}
endif;
add_action( 'after_setup_theme', 'humescores_setup' );


/**
 * Register custom fonts.
 */
function humescores_fonts_url() {
	$fonts_url = '';

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Source Sans Pro and PT Serif, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$source_sans_pro = _x( 'on', 'Source Sans Pro font: on or off', 'humescores' );
	$pt_serif = _x( 'on', 'PT Serif font: on or off', 'humescores' );

	$font_families = array();
	
	if ( 'off' !== $source_sans_pro ) {
		$font_families[] = 'Source Sans Pro:400,400i,700,900';
	}
	
	if ( 'off' !== $pt_serif ) {
		$font_families[] = 'PT Serif:400,400i,700,700i';
	}
	
	
	if ( in_array( 'on', array($source_sans_pro, $pt_serif) ) ) {

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function humescores_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'humescores-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'humescores_resource_hints', 10, 2 );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function humescores_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'humescores_content_width', 640 );
}
add_action( 'after_setup_theme', 'humescores_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function humescores_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'humescores' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'humescores' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'humescores_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function humescores_scripts() {
	// Enqueue Google Fonts: Source Sans Pro and PT Serif
	wp_enqueue_style( 'humescores-fonts', humescores_fonts_url() );
	
	wp_enqueue_style( 'humescores-style', get_stylesheet_uri() );

	wp_enqueue_script( 'humescores-navigation', get_template_directory_uri() . '/js/navigation.js', array('jquery'), '20151215', true );
	wp_localize_script( 'humescores-navigation', 'humescoresScreenReaderText', array(
		'expand' => __( 'Expand child menu', 'humescores'),
		'collapse' => __( 'Collapse child menu', 'humescores'),
	));

	wp_enqueue_script( 'humescores-functions', get_template_directory_uri() . '/js/functions.js', array('jquery'), '20161201', true );
	
	wp_enqueue_script( 'humescores-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'humescores_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
