<?php
/**
 * EduBlink functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage EduBlink
 * @since EduBlink 1.0.0
 */

define( 'EDUBLINK_THEME_VERSION', wp_get_theme()->get( 'Version') );

if ( ! defined( 'LP_COURSE_CPT' ) ) define( 'LP_COURSE_CPT', 'lp_course' );

if ( ! function_exists( 'edublink_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function edublink_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on edublink_, use a find and replace
		 * to change 'edublink' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'edublink', get_template_directory() . '/languages' );

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

		// Add support for Block Styles.
        add_theme_support( 'wp-block-styles' );

        // Add support for full and wide align images.
        add_theme_support( 'align-wide' );

        // Add support for editor styles.
        add_theme_support( 'editor-styles' );

        // Add support for responsive embedded content.
        add_theme_support( 'responsive-embeds' );

		/*
		 * Adding Images size.
		 *
		 * @link https://developer.wordpress.org/reference/functions/add_image_size/
		 */
		$height = edublink_set_value( 'featured_image_height', 430 );
		$width  = edublink_set_value( 'featured_image_width', 590 );
		add_image_size( 'edublink-post-thumb', $width, $height, true );
		add_image_size( 'edublink-post-thumb-2', 750, 750, true );
		add_image_size( 'edublink-course-thumb', 450, 550, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary' => __( 'Primary Menu', 'edublink' ),
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
		add_theme_support( 'custom-background', apply_filters( 'edublink_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 80,
			'width'       => 200,
			'flex-width'  => true,
			'flex-height' => true,
		) );  

		/**
		 * Registers an editor stylesheet for the theme.
		 * @link https://developer.wordpress.org/reference/functions/add_editor_style
		 * followed twentyseventeen theme and the link above
		 */
		add_editor_style( array( 'assets/css/style-editor.css', edublink_main_fonts_url() ) );

		remove_theme_support( 'widgets-block-editor' );
	}
endif;
add_action( 'after_setup_theme', 'edublink_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function edublink_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'edublink_content_width', 640 );
}
add_action( 'after_setup_theme', 'edublink_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function edublink_widgets_init() {

	register_sidebar( 
		apply_filters(
			'edublink_default_sidebar_params',
			array(
				'name'          => __( 'Sidebar Default', 'edublink' ),
				'id'            => 'sidebar-default',
				'description'   => __( 'Add widgets here.', 'edublink' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>'
			)
		)
	);

	register_sidebar( 
		apply_filters(
			'edublink_blog_sidebar_params',
			array(
				'name'          => __( 'Blog Sidebar', 'edublink' ),
				'id'            => 'blog-sidebar',
				'description'   => __( 'Add widgets here.', 'edublink' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>'
			)
		)
	);
}
add_action( 'widgets_init', 'edublink_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function edublink_scripts() {
	$sticky_header = edublink_set_value( 'sticky_header', false );

	wp_enqueue_style( 'edublink-style', get_stylesheet_uri() );

	wp_enqueue_style( 'remixicon', get_template_directory_uri() . '/assets/css/remixicon.css', array(), EDUBLINK_THEME_VERSION );

	$box_icon_enable = apply_filters( 'edublink_box_icon_enable', false );
	if ( $box_icon_enable ) :
		wp_enqueue_style( 'boxicons', get_template_directory_uri() . '/assets/css/boxicons.min.css', array(), EDUBLINK_THEME_VERSION );
	endif;

	wp_enqueue_style( 'edublink-custom-icons', get_template_directory_uri() . '/assets/css/edublink-custom-icons.css', array(), EDUBLINK_THEME_VERSION );

	// Swiper Slider CSS
	wp_enqueue_style( 'edublink-swiper', get_template_directory_uri() . '/assets/css/swiper-bundle.min.css', array(), EDUBLINK_THEME_VERSION );

	wp_enqueue_style( 'metismenu', get_template_directory_uri() . '/assets/css/metisMenu.min.css', array(), EDUBLINK_THEME_VERSION );

	wp_enqueue_style( 'edublink-tipped', get_template_directory_uri() . '/assets/css/tipped.min.css', array(), EDUBLINK_THEME_VERSION );

	wp_enqueue_style( 'nice-select', get_template_directory_uri() . '/assets/css/nice-select.css', array(), EDUBLINK_THEME_VERSION );
	
	wp_enqueue_style( 'edublink-main', get_template_directory_uri() . '/assets/css/main.css', array(), EDUBLINK_THEME_VERSION );
	
	if ( edublink_set_value( 'eb_dark_mode', false ) ) :
		$edublink_dark_dependency = [];
		$edublink_dark_dependency = apply_filters( 'edublink_dark_css_dependency', $edublink_dark_dependency );
		wp_enqueue_style( 'edublink-dark', get_template_directory_uri() . '/assets/css/dark.css', $edublink_dark_dependency, EDUBLINK_THEME_VERSION );
	endif;

	if( is_rtl() ) :
		$edublink_rtl_dependency = array();
		if ( class_exists( 'EduBlink_Core' ) ) :
			array_push( $edublink_rtl_dependency, 'edublink-core-main-css' );
		endif;
		$edublink_rtl_dependency = apply_filters( 'edublink_rtl_css_dependency', $edublink_rtl_dependency );
		wp_enqueue_style( 'edublink-rtl', get_template_directory_uri() . '/rtl.css', $edublink_rtl_dependency, EDUBLINK_THEME_VERSION );
	endif;

	wp_register_script( 'jquery-countdown', get_template_directory_uri() . '/assets/js/jquery.countdown.min.js', array( 'jquery' ), EDUBLINK_THEME_VERSION, true );

	wp_enqueue_script( 'metismenu', get_template_directory_uri() . '/assets/js/metisMenu.min.js', array( 'jquery' ), EDUBLINK_THEME_VERSION, true );

	wp_enqueue_script( 'edublink-swiper', get_template_directory_uri() . '/assets/js/swiper-bundle.min.js', array( 'jquery' ), EDUBLINK_THEME_VERSION, true );

	wp_enqueue_script( 'edublink-mouse-animation', get_template_directory_uri() . '/assets/js/edublink-mouse-move-animation.js', array( 'jquery' ), EDUBLINK_THEME_VERSION, true );

	wp_enqueue_script( 'edublink-sal-js', get_template_directory_uri() . '/assets/js/sal.min.js', array( 'jquery' ), EDUBLINK_THEME_VERSION, true );

	wp_enqueue_script( 'jquery-imagesloaded', get_template_directory_uri() . '/assets/js/imagesloaded.pkgd.min.js', array( 'jquery' ), EDUBLINK_THEME_VERSION, true );

	wp_enqueue_script( 'jquery-isotope', get_template_directory_uri() . '/assets/js/isotope.min.js', array( 'jquery' ), EDUBLINK_THEME_VERSION, true );

	wp_enqueue_script( 'edublink-navigation', get_template_directory_uri() . '/assets/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'edublink-skip-link-focus-fix', get_template_directory_uri() . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) :
		wp_enqueue_script( 'comment-reply' );
	endif;

	wp_register_style( 'jquery-fancybox', get_template_directory_uri() . '/assets/css/jquery.fancybox.min.css', array(), EDUBLINK_THEME_VERSION );

	wp_register_script( 'jquery-fancybox', get_template_directory_uri() . '/assets/js/jquery.fancybox.min.js', array( 'jquery' ), EDUBLINK_THEME_VERSION, true );

	$key = apply_filters( 'edublink_map_api_key', 'AIzaSyDNsicAsP6-VuGtAb1O9riI3oc_NOb7IOU' );
	wp_register_script( 'gmap-api-js', '//maps.googleapis.com/maps/api/js?sensor=false&libraries=places&key=' . $key );

	wp_enqueue_script( 'edublink-tipped', get_template_directory_uri() . '/assets/js/tipped.min.js', array( 'jquery' ), EDUBLINK_THEME_VERSION, true );

	wp_enqueue_script( 'nice-select', get_template_directory_uri() . '/assets/js/nice-select.min.js', array( 'jquery' ), EDUBLINK_THEME_VERSION, true );

	wp_register_script( 'theia-sticky-sidebar', get_template_directory_uri() . '/assets/js/theia-sticky-sidebar.min.js', array( 'jquery' ), EDUBLINK_THEME_VERSION, true );

	if ( edublink_set_value( 'scroll_to_top', true ) ) :
		wp_enqueue_script( 'edublink-back-to-top', get_template_directory_uri() . '/assets/js/back-to-top.js', array(), EDUBLINK_THEME_VERSION, true );
	endif;

	if ( edublink_set_value( 'smooth_scroll', false ) ) :
		wp_enqueue_script( 'edublink-smooth-scroll', get_template_directory_uri() . '/assets/js/smooth-scroll.min.js', array(), EDUBLINK_THEME_VERSION, true );
	endif;

	wp_enqueue_script( 'edublink-init', get_template_directory_uri() . '/assets/js/init.js', array( 'jquery' ), EDUBLINK_THEME_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'edublink_scripts' );

/**
 * edublink Core Functions
 */
require_once get_template_directory() . '/inc/edublink-core-functions.php';

/**
 * edublink root variables
 */
require_once get_template_directory() . '/inc/root-css.php';

/**
 * Load CMB2 metabox file.
 */
require_once get_template_directory() . '/inc/vendors/cmb2/functions.php';

/**
 * Load Redux file.
 */
require_once get_template_directory() . '/inc/vendors/redux/functions.php';

/**
 * Load Once Click Demo Import File.
 */
require_once get_template_directory() . '/inc/vendors/one-click-demo-import/functions.php';

/**
 * Implement the Custom Header feature.
 */
require_once get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require_once get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require_once get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require_once get_template_directory() . '/inc/customizer.php';

/**
 * Bootstrap Nav Walker Class
 */
require_once get_template_directory() . '/inc/wp-bootstrap-navwalker.php';

/**
 * LearnPress Essentials
 */
if ( edublink_is_learnpress_activated() ) :
	require_once get_template_directory() . '/learnpress/custom/functions.php';
endif;

/**
 * LearnDash Essentials
 */
if ( edublink_is_learndash_activated() ) :
	require_once get_template_directory() . '/learndash/custom/functions.php';
endif;

/**
 * Totor LMS Essentials
 */
if ( edublink_is_tutor_lms_activated() ) :
	require_once get_template_directory() . '/tutor/custom/functions.php';
endif;

/**
 * Lifter LMS Essentials
 */
if ( edublink_is_lifter_lms_activated() ) :
	require_once get_template_directory() . '/lifterlms/custom/functions.php';
endif;

/**
 * Sensei LMS Essentials
 */
if ( edublink_is_sensei_lms_activated() ) :
	require_once get_template_directory() . '/sensei/custom/functions.php';
endif;

/**
 * Masterstudy LMS Essentials
 */
if ( edublink_is_masterstudy_lms_activated() ) :
	require_once get_template_directory() . '/stm-lms-templates/custom/functions.php';
endif;

/**
 * LMS Filter Class
 */
require_once get_template_directory() . '/inc/edublink-course-filter-class.php';

/**
 * Wishlist Ajax Support
 */
require_once get_template_directory() . '/inc/class-wishlist.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) :
	require_once get_template_directory() . '/inc/jetpack.php';
endif;

/**
 * WooCommerce Essentials.
 */
if ( edublink_is_woocommerce_activated() ) :
	require_once get_template_directory() . '/woocommerce/custom/functions.php';
endif;

/**
 * Elementor Essentials
 */
require_once get_template_directory() . '/inc/vendors/elementor/functions.php';


/**
 * Admin Script
 */
require_once get_template_directory() . '/inc/admin-scripts.php';

/**
 * TGM Plugin Installer
 */
if ( ! class_exists( 'TGM_Plugin_Activation' ) ) :
	require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';
endif;
