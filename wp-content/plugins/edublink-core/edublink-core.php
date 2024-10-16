<?php
/**
 * Plugin Name: EduBlink Core
 * Description: This plugin contains all necessary custom post types, functionalities, widgets and custom Elementor widget for EduBlink Theme.
 * Version:     1.0.15
 * Author:      DevsBlink
 * Author URI:  https://devsblink.com/
 * Text Domain: edublink-core
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! defined( 'EDUBLINK_PLUGIN_DIR' ) ) define( 'EDUBLINK_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
if ( ! defined( 'EDUBLINK_PLUGIN_URL' ) ) define( 'EDUBLINK_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
if ( ! defined( 'EDUBLINK_CORE_URL' ) ) define( 'EDUBLINK_CORE_URL', plugins_url( '/', __FILE__ ) );
if ( ! defined( 'EDUBLINK_ASSETS_URL' ) ) define( 'EDUBLINK_ASSETS_URL', EDUBLINK_CORE_URL . 'assets/' );
if ( ! defined( 'EDUBLINK_CORE_VERSION' ) ) define( 'EDUBLINK_CORE_VERSION', '1.0.0' );

/**
 * Main EduBlink Core Class
 *
 * The init class that runs the EduBlink Core plugin.
 * Intended To make sure that the plugin's minimum requirements are met.
 *
 * Any custom code should go inside Plugin Class in the plugin.php file.
 * @since 1.0.0
 */
final class EduBlink_Core {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.1.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {

		// Load translation
		add_action( 'init', array( $this, 'i18n' ) );

		// Init Plugin
		add_action( 'plugins_loaded', array( $this, 'init' ) );
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function i18n() {
		load_plugin_textdomain( 'edublink-core', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}

	/**
	 * Initialize the plugin
	 *
	 * Validates that Elementor is already loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed include the plugin class.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) :
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		endif;

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) :
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		endif;

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) :
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		endif;

 		// Custom Elementor Widegt Category
		add_action( 'elementor/init', array( $this, 'edublink_custom_elementor_category' ) );

		// Once we get here, We have passed all validation checks so we can safely include our plugin
		require_once( 'plugin.php' );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) :
			unset( $_GET['activate'] );
		endif;

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'edublink-core' ),
			'<strong>' . esc_html__( 'EduBlink Core', 'edublink-core' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'edublink-core' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function edublink_custom_elementor_category(){
        \Elementor\Plugin::instance()->elements_manager->add_category(
            'edublink_elementor_widgets',
            array(
                'title' => esc_html__( 'EduBlink', 'edublink-core' ),
            ),
            1
        );
        \Elementor\Plugin::instance()->elements_manager->add_category(
            'edublink_hf_elementor_widgets',
            array(
                'title' => esc_html__( 'EduBlink Header Footer Elements', 'edublink-core' ),
            ),
            1
        );
    }

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) :
			unset( $_GET['activate'] );
		endif;

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'edublink-core' ),
			'<strong>' . esc_html__( 'EduBlink Core', 'edublink-core' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'edublink-core' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) :
			unset( $_GET['activate'] );
		endif;

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'edublink-core' ),
			'<strong>' . esc_html__( 'EduBlink Core', 'edublink-core' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'edublink-core' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
}

// Instantiate EduBlink_Core.
new EduBlink_Core();



