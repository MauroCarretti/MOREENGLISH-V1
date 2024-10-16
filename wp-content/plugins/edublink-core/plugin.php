<?php
namespace EduBlinkCore;

/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.0.0
 */
class Plugin {

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) :
			self::$_instance = new self();
		endif;
		return self::$_instance;
	}

	/**
	 * registered_scripts
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function registered_scripts() {

		// FancyBox CSS
		wp_register_style( 'jquery-fancybox', get_template_directory_uri() . '/assets/css/jquery.fancybox.min.css', array(), EDUBLINK_THEME_VERSION );

		// Odometer CSS
		wp_register_style( 'jquery-odometer', plugins_url( '/assets/css/odometer.min.css', __FILE__ ), '', EDUBLINK_THEME_VERSION );

		// Odometer JS
		wp_register_script( 'jquery-odometer', plugins_url( '/assets/js/odometer.min.js', __FILE__ ), array( 'jquery' ), EDUBLINK_THEME_VERSION, true );

		// ViewPort JS
		wp_register_script( 'jquery-viewport', plugins_url( '/assets/js/isInViewport.jquery.min.js', __FILE__ ), array( 'jquery' ), EDUBLINK_THEME_VERSION, true );

		// Lottie JS
		wp_register_script( 'lottie-js', plugins_url( '/assets/js/lottie.min.js', __FILE__ ), array( 'jquery' ), EDUBLINK_THEME_VERSION, true );

		// EduBlink animation
		wp_register_script( 'edublink-animation', plugins_url( '/assets/js/edublink-animation.min.js', __FILE__ ), array( 'jquery' ), EDUBLINK_THEME_VERSION, true );

		// Conterup JS
		wp_register_script( 'jquery-counterup', plugins_url( '/assets/js/jquery.counterup.min.js', __FILE__ ), array( 'jquery' ), EDUBLINK_THEME_VERSION, true );

		// ConteTo JS
		wp_register_script( 'count-to', plugins_url( '/assets/js/jquery.countTo.min.js', __FILE__ ), array( 'jquery' ), EDUBLINK_THEME_VERSION, true );

        // Waypoints JS
        wp_register_script( 'jquery-waypoints', plugins_url( '/assets/js/jquery.waypoints.min.js', __FILE__ ), array( 'jquery' ), EDUBLINK_THEME_VERSION, true );

        // CountDown JS
        wp_register_script( 'jquery-countdown', get_template_directory_uri() . '/assets/js/jquery.countdown.min.js', array( 'jquery' ), EDUBLINK_THEME_VERSION, true );

        // Tilt JS
        wp_register_script( 'jquery-tilt', get_template_directory_uri() . '/assets/js/tilt.jquery.min.js', array( 'jquery' ), EDUBLINK_THEME_VERSION, true );

		// Lottie JS
		wp_register_script( 'lottie-js', plugins_url( '/assets/js/lottie.min.js', __FILE__ ), array( 'jquery' ), EDUBLINK_THEME_VERSION, true );

        // imagesLoaded JS
        wp_register_script( 'jquery-imagesloaded', plugins_url( '/assets/js/imagesloaded.pkgd.min.js', __FILE__ ), array( 'jquery' ), EDUBLINK_THEME_VERSION, true );

        // FancyBox JS
        wp_register_script( 'jquery-fancybox', get_template_directory_uri() . '/assets/js/jquery.fancybox.min.js', array( 'jquery' ), EDUBLINK_THEME_VERSION, true );

        // Animated Text JS
        wp_register_script( 'typed-js', plugins_url( '/assets/js/typed.min.js', __FILE__ ), array( 'jquery' ), EDUBLINK_THEME_VERSION, true );

		// Vivus Animation JS
		wp_register_script( 'vivus', plugins_url( '/assets/js/vivus.min.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );

		// Circle Progress JS
		wp_register_script( 'edublink-circle-progress', plugins_url( '/assets/js/circle-progress.min.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );

		// Marquee JS
		wp_register_script( 'edublink-marquee', plugins_url( '/assets/js/jquery.liMarquee.min.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
	}

	/**
	 * enqueued_scripts
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function enqueued_scripts() {

		wp_enqueue_style( 'edublink-core-main-css', plugins_url( '/assets/css/edublink-core-main.css', __FILE__ ), '', EDUBLINK_THEME_VERSION );

		wp_enqueue_script( 'edublink-core-animation-js', plugins_url( '/assets/js/edublink-core-animation.min.js', __FILE__ ), array( 'jquery' ), EDUBLINK_THEME_VERSION, true );

		wp_enqueue_script( 'edublink-core-init-js', plugins_url( '/assets/js/edublink-core-init.js', __FILE__ ), array( 'jquery' ), EDUBLINK_THEME_VERSION, true );
		
		wp_localize_script( 'edublink-core-init-js', 'edublink_frontend_ajax_object',
            array(
                'ajaxurl' => admin_url( 'admin-ajax.php' )
            ) 
        );
	}

	/**
	 * editor_enqueued_scripts
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function editor_enqueued_scripts() {
		wp_enqueue_style( 'edublink-elementor-editor', get_template_directory_uri() . '/assets/css/edublink-elementor-editor.css', '', EDUBLINK_THEME_VERSION );
	}

	/**
	 * Always Enqueued Scripts
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function edublink_core_enqueued_scripts() {
		wp_enqueue_script( 'edublink-core-essetial', plugins_url( '/assets/js/edublink-essential.js', __FILE__ ), array( 'jquery', 'edublink-sal-js', 'edublink-tipped' ), EDUBLINK_THEME_VERSION, true );
		
		$phpStringPass = array(
			'login_notice_lp_text' => __( 'You need to Login first.', 'edublink-core' )
		);

		wp_add_inline_script( 'edublink-core-essetial', 'const php_strings = ' . json_encode( $phpStringPass ), 'before' );

		wp_localize_script( 'edublink-core-essetial', 'edublink_wishlist_data', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'ajax_nonce' => wp_create_nonce( 'edublink-wishlist-ajax-connect' )
		));
	}

	private function plugin_active( $plugin ) {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( is_plugin_active( $plugin ) ) :
			return true;
		endif;

		return false;
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function include_widgets_files() {
		// include_once( __DIR__ . '/widgets/test.php' );
		include_once( __DIR__ . '/widgets/animation.php' );
		include_once( __DIR__ . '/widgets/accordion.php' );
		include_once( __DIR__ . '/widgets/button.php' );
		include_once( __DIR__ . '/widgets/circle-progress.php' );
		include_once( __DIR__ . '/widgets/contact-form-7.php' );
		include_once( __DIR__ . '/widgets/content-scroller.php' );
		include_once( __DIR__ . '/widgets/content-switcher.php' );
		include_once( __DIR__ . '/widgets/copyright.php' );
		include_once( __DIR__ . '/widgets/countdown.php' );
		include_once( __DIR__ . '/widgets/counterup.php' );
		include_once( __DIR__ . '/widgets/course-categories.php' );
		include_once( __DIR__ . '/widgets/courses.php' );
		include_once( __DIR__ . '/widgets/course-wishlist.php' );
		include_once( __DIR__ . '/widgets/course-search.php' );
		include_once( __DIR__ . '/widgets/faq.php' );
		include_once( __DIR__ . '/widgets/features.php' );
		include_once( __DIR__ . '/widgets/footer-menu.php' );
		include_once( __DIR__ . '/widgets/gallery-filter.php' );
		include_once( __DIR__ . '/widgets/heading.php' );
		include_once( __DIR__ . '/widgets/instagram.php' );
		include_once( __DIR__ . '/widgets/image-icon-box.php' );
		include_once( __DIR__ . '/widgets/mailchimp.php' );
		include_once( __DIR__ . '/widgets/post.php' );
		include_once( __DIR__ . '/widgets/post-classic.php' );
		include_once( __DIR__ . '/widgets/pricing-table.php' );
		include_once( __DIR__ . '/widgets/progress-bar.php' );
		include_once( __DIR__ . '/widgets/nav-menu.php' );
		include_once( __DIR__ . '/widgets/menu-list.php' );
		include_once( __DIR__ . '/widgets/site-logo.php' );
		// include_once( __DIR__ . '/widgets/slider.php' );
		include_once( __DIR__ . '/widgets/social-icons.php' );
		include_once( __DIR__ . '/widgets/svg-animation.php' );
		include_once( __DIR__ . '/widgets/tabs.php' );
		include_once( __DIR__ . '/widgets/team.php' );
		include_once( __DIR__ . '/widgets/testimonial.php' );
		include_once( __DIR__ . '/widgets/video-popup.php' );
		include_once( __DIR__ . '/widgets/lottie.php' );
		if ( edublink_is_learnpress_activated() ) :
			include_once( __DIR__ . '/widgets/lp-courses.php' );
			include_once( __DIR__ . '/widgets/lp-course-filter.php' );
			include_once( __DIR__ . '/widgets/lp-course-wishlist.php' );
			include_once( __DIR__ . '/widgets/lp-course-categories.php' );
			include_once( __DIR__ . '/widgets/lp-course-search.php' );
		endif;

		if ( edublink_is_learndash_activated() ) :
			include_once( __DIR__ . '/widgets/ld-courses.php' );
			include_once( __DIR__ . '/widgets/ld-course-filter.php' );
			include_once( __DIR__ . '/widgets/ld-course-wishlist.php' );
			include_once( __DIR__ . '/widgets/ld-course-categories.php' );
			include_once( __DIR__ . '/widgets/ld-course-search.php' );
		endif;

		if ( edublink_is_tutor_lms_activated() ) :
			include_once( __DIR__ . '/widgets/tl-courses.php' );
			include_once( __DIR__ . '/widgets/tl-course-filter.php' );
			// include_once( __DIR__ . '/widgets/tl-course-wishlist.php' );
			include_once( __DIR__ . '/widgets/tl-course-categories.php' );
			include_once( __DIR__ . '/widgets/tl-course-search.php' );
		endif; 

		if ( edublink_is_lifter_lms_activated() ) :
			include_once( __DIR__ . '/widgets/ll-courses.php' );
			include_once( __DIR__ . '/widgets/ll-course-filter.php' );
			include_once( __DIR__ . '/widgets/ll-course-wishlist.php' );
			include_once( __DIR__ . '/widgets/ll-course-categories.php' );
			include_once( __DIR__ . '/widgets/ll-course-search.php' );
		endif; 

		if ( edublink_is_sensei_lms_activated() ) :
			include_once( __DIR__ . '/widgets/ss-courses.php' );
			include_once( __DIR__ . '/widgets/ss-course-filter.php' );
			include_once( __DIR__ . '/widgets/ss-course-wishlist.php' );
			include_once( __DIR__ . '/widgets/ss-course-categories.php' );
			include_once( __DIR__ . '/widgets/ss-course-search.php' );
		endif; 

		if ( edublink_is_masterstudy_lms_activated() ) :
			include_once( __DIR__ . '/widgets/ms-courses.php' );
			include_once( __DIR__ . '/widgets/ms-course-filter.php' );
			include_once( __DIR__ . '/widgets/ms-course-wishlist.php' );
			include_once( __DIR__ . '/widgets/ms-course-categories.php' );
			include_once( __DIR__ . '/widgets/ms-course-search.php' );
		endif; 

		if ( edublink_is_wp_events_manager_activated() ) :
			include_once( __DIR__ . '/widgets/wp-events-manager.php' );
		endif; 

		if ( edublink_is_the_events_calendar_activated() ) :
			include_once( __DIR__ . '/widgets/the-events-calendar.php' );
		endif; 
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_widgets() {
		// Its is now safe to include Widgets files
		$this->include_widgets_files();

		// Register Widgets
		// \Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Test() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Animation() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Accordion() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Button() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\CircleProgress() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Contact_Form_Seven() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Content_Scroller() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Content_Switcher() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\CountDown() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Counter_Up() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\FAQ() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Features() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Gallery_Filter() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Heading() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Image_Icon_Box() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Instagram() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\MailChimp() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Post() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Post_Classic() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Pricing_Table() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\ProgressBar() );
		// \Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Slider() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\SVG_Animation() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Tabs() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Team() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Testimonial() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Video_PopUp() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Lottie() );
		\Elementor\Plugin::instance()->widgets_manager->register( new HF\Widgets\Copyright() );
		\Elementor\Plugin::instance()->widgets_manager->register( new HF\Widgets\Footer_Menu() );
		\Elementor\Plugin::instance()->widgets_manager->register( new HF\Widgets\Nav_Menu() );
		\Elementor\Plugin::instance()->widgets_manager->register( new HF\Widgets\Menu_List() );
		\Elementor\Plugin::instance()->widgets_manager->register( new HF\Widgets\Site_Logo() );
		\Elementor\Plugin::instance()->widgets_manager->register( new HF\Widgets\Social_Icons() );
		if ( edublink_is_learnpress_activated() ) :
			\Elementor\Plugin::instance()->widgets_manager->register( new LP\Widgets\Courses() );
			\Elementor\Plugin::instance()->widgets_manager->register( new LP\Widgets\Course_Filter() );
			\Elementor\Plugin::instance()->widgets_manager->register( new LP\Widgets\Wishlist() );
			\Elementor\Plugin::instance()->widgets_manager->register( new LP\Widgets\Course_Categories() );
			\Elementor\Plugin::instance()->widgets_manager->register( new LP\Widgets\Course_Search() );
		endif;

		if ( edublink_is_learndash_activated() ) :
			\Elementor\Plugin::instance()->widgets_manager->register( new LD\Widgets\Courses() );
			\Elementor\Plugin::instance()->widgets_manager->register( new LD\Widgets\Course_Filter() );
			\Elementor\Plugin::instance()->widgets_manager->register( new LD\Widgets\Wishlist() );
			\Elementor\Plugin::instance()->widgets_manager->register( new LD\Widgets\Course_Categories() );
			\Elementor\Plugin::instance()->widgets_manager->register( new LD\Widgets\Course_Search() );
		endif;

		if ( edublink_is_tutor_lms_activated() ) :
			\Elementor\Plugin::instance()->widgets_manager->register( new TL\Widgets\Courses() );
			\Elementor\Plugin::instance()->widgets_manager->register( new TL\Widgets\Course_Filter() );
			// \Elementor\Plugin::instance()->widgets_manager->register( new TL\Widgets\Wishlist() );
			\Elementor\Plugin::instance()->widgets_manager->register( new TL\Widgets\Course_Categories() );
			\Elementor\Plugin::instance()->widgets_manager->register( new TL\Widgets\Course_Search() );
		endif;
		
		if ( edublink_is_lifter_lms_activated() ) :
			\Elementor\Plugin::instance()->widgets_manager->register( new LL\Widgets\Courses() );
			\Elementor\Plugin::instance()->widgets_manager->register( new LL\Widgets\Course_Filter() );
			\Elementor\Plugin::instance()->widgets_manager->register( new LL\Widgets\Wishlist() );
			\Elementor\Plugin::instance()->widgets_manager->register( new LL\Widgets\Course_Categories() );
			\Elementor\Plugin::instance()->widgets_manager->register( new LL\Widgets\Course_Search() );
		endif;

		if ( edublink_is_sensei_lms_activated() ) :
			\Elementor\Plugin::instance()->widgets_manager->register( new SS\Widgets\Courses() );
			\Elementor\Plugin::instance()->widgets_manager->register( new SS\Widgets\Course_Filter() );
			\Elementor\Plugin::instance()->widgets_manager->register( new SS\Widgets\Wishlist() );
			\Elementor\Plugin::instance()->widgets_manager->register( new SS\Widgets\Course_Categories() );
			\Elementor\Plugin::instance()->widgets_manager->register( new SS\Widgets\Course_Search() );
		endif;

		if ( edublink_is_masterstudy_lms_activated() ) :
			\Elementor\Plugin::instance()->widgets_manager->register( new MS\Widgets\Courses() );
			\Elementor\Plugin::instance()->widgets_manager->register( new MS\Widgets\Course_Filter() );
			\Elementor\Plugin::instance()->widgets_manager->register( new MS\Widgets\Wishlist() );
			\Elementor\Plugin::instance()->widgets_manager->register( new MS\Widgets\Course_Categories() );
			\Elementor\Plugin::instance()->widgets_manager->register( new MS\Widgets\Course_Search() );
		endif;

		if ( edublink_is_wp_events_manager_activated() ) :
			\Elementor\Plugin::instance()->widgets_manager->register( new Events\Widgets\WP_Events_Manager() );
		endif;

		if ( edublink_is_the_events_calendar_activated() ) :
			\Elementor\Plugin::instance()->widgets_manager->register( new Events\Widgets\The_Events_Calendar() );
		endif;
	}

	/**
     * 
     * Includes all Files
     * @since 1.0.0
     * @access public
     */
	public function includes() {
		require_once( __DIR__ . '/inc/copyright-shortcode.php' );
		require_once( __DIR__ . '/inc/edublink-helper-class.php' );
		require_once( __DIR__ . '/inc/edublink-icons.php' );
		require_once( __DIR__ . '/inc/edublink-mailchimp-api.php' );
		require_once( __DIR__ . '/inc/edublink-shortcodes.php' );
		require_once( __DIR__ . '/inc/edublink-widget-functions.php' );
		require_once( __DIR__ . '/inc/wp-events-manager/helper-class.php' );
	}

	/**
     * 
     * Includes all Traits
     * @since 1.0.0
     * @access public
     */
	public function traits() {
		require_once( __DIR__ . '/inc/Traits/Button.php' );
		require_once( __DIR__ . '/inc/Traits/Grid.php' );
		require_once( __DIR__ . '/inc/Traits/Posts.php' );
		require_once( __DIR__ . '/inc/Traits/Slider.php' );
		require_once( __DIR__ . '/inc/Traits/Slider_Arrows.php' );
		require_once( __DIR__ . '/inc/Traits/Slider_Dots.php' );
		require_once( __DIR__ . '/inc/Traits/Taxonomy.php' );
		require_once( __DIR__ . '/inc/Traits/Users.php' );
	}

	/**
     * 
     * Includes all Post Types
     * @since 1.0.0
     * @access public
     */
	public function post_types() {
		require_once( __DIR__ . '/inc/post-types/megamenu.php' );
		require_once( __DIR__ . '/inc/post-types/header.php' );
		require_once( __DIR__ . '/inc/post-types/footer.php' );
	}

	/**
     * 
     * Includes all Widgets
     * @since 1.0.0
     * @access public
     */
	public function widgets() {
		require_once( __DIR__ . '/inc/widgets/posts.php' );
	}

	/**
     * 
     * extra entrance animation
     * @since 1.0.0
     * @access public
     */
	public function extra_entrance_animations( $animations = array() ) {
		$entrance_animations = array(
			'EduBlink Extra Animations' => [
				'edublink--scale'       => __( 'Scale', 'edublink-core' ),
				'edublink--fancy'       => __( 'Fancy', 'edublink-core' ),
				'edublink--slide-up'    => __( 'Slide Up', 'edublink-core' ),
				'edublink--slide-left'  => __( 'Slide Left', 'edublink-core' ),
				'edublink--slide-right' => __( 'Slide Right', 'edublink-core' ),
				'edublink--slide-down'  => __( 'Slide Down', 'edublink-core' )
			]
		);
		return array_merge( $animations, $entrance_animations );
	}

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		// Enqueued scripts
		add_action( 'wp_enqueue_scripts', [ $this, 'edublink_core_enqueued_scripts' ] );

		// Register widget scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'registered_scripts' ] );
		
		// Enqueued widget scripts
		add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'enqueued_scripts' ] );

		// Elementor Editor Styles
        add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'editor_enqueued_scripts' ] );
		
		// Register widgets
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );

		// Additional Entrance Animations
		add_filter( 'elementor/controls/animations/additional_animations', [ $this, 'extra_entrance_animations' ], 10 );

		// Load Files
		$this->includes();

		// Load Traits
		$this->traits();

		// Load Post Types
		$this->post_types();

		// Load Widgets
		$this->widgets();
	}
}

// Instantiate Plugin Class
$theme = wp_get_theme();
if ( 'EduBlink' === $theme->name || 'EduBlink' === $theme->parent_theme ) :
	Plugin::instance();
endif;