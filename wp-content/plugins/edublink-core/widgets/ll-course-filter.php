<?php

namespace EduBlinkCore\LL\Widgets;

use \Elementor\Controls_Manager;
use \EduBlink\Filter;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for Course Filter.
 *
 * @since 1.0.0
 */
class Course_Filter extends Widget_Base {

    /**
     * Retrieve the widget name.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'edublink-ll-course-filter';
    }

    /**
     * Retrieve the widget title.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'Course Filter Sidebar(Lifter LMS)', 'edublink-core' );
    }

    /**
     * Retrieve the widget icon.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'edublink-elementor-icon eicon-filter';
    }

    /**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'edublink', 'query', 'courses', 'lms', 'lifter lms', 'archive', 'loop','filter', 'sidebar filter', 'filter sidebar' ];
	}

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return [ 'edublink_elementor_widgets' ];
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function _register_controls() {
        $filter_options = apply_filters( 'edublink_course_filter_options', [
            'search'     => __( 'Search Field', 'edublink-core' ),
            'category'   => __( 'Category', 'edublink-core' ),
            'tags'       => __( 'Tags', 'edublink-core' ),
            'instructor' => __( 'Instructor', 'edublink-core' ),
            'll_level'   => __( 'Level', 'edublink-core' )
        ] );

        $this->start_controls_section(
            'filter_section',
            [
                'label' => __( 'Course Filter', 'edublink-core' )
            ]
        );

        $this->add_control(
            'filter_options',
            [
                'label'         => __( 'Filter Options', 'edublink-core' ),
                'label_block'   => true,
                'type'          => Controls_Manager::SELECT2,
                'default'       => ['category', 'tags'],
                'multiple'      => true,
                'options'       => $filter_options                   
            ]
        );

        $this->add_control(
            'content_type',
            [
                'label'     => __( 'Content Type', 'edublink-core' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'grid-list',
                'options'   => [
                    'grid-list' => __( 'Grid & List Both', 'edublink-core' ),
                    'grid'      => __( 'Grid Only', 'edublink-core' ),
                    'list'      => __( 'List Only', 'edublink-core' )
                ]
            ]
        );

        $this->add_control(
            'default_layout',
            [
                'label'     => __( 'Default Active Layout', 'edublink-core' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'grid',
                'options'   => [
                    'grid'  => __( 'Grid', 'edublink-core' ),
                    'list'  => __( 'List', 'edublink-core' )
                ],
                'condition'        => [
                    'content_type' => 'grid-list'
                ]
            ]
        );

        $this->add_control(
            'filter_layout',
            [
                'label'     => __( 'Filter Layout', 'edublink-core' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'filter-left-align',
                'options'   => [
                    'filter-left-align'  => __( 'Filter Left Side', 'edublink-core' ),
                    'filter-right-align' => __( 'Filter Right Side', 'edublink-core' )
                ]
            ]
        );

        $this->add_control(
            'enable_ordering',
            [
                'label'        => __( 'Ordering', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,    
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'order_default_text',
            [
                'type'                => Controls_Manager::TEXT,
                'label'               => __( 'Order Default Text', 'edublink-core' ),
                'default'             => __( 'Filters', 'edublink-core' ),
                'condition'           => [
                    'enable_ordering' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'enable_found_text',
            [
                'label'        => __( 'Course Found Text', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,    
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'found_text_type',
            [
                'label'         => __( 'Found Text Type', 'edublink-core' ),
                'type'          => Controls_Manager::SELECT,
                'default'       => 'default',
                'options'       => [
                    'default'   => __( 'Default', 'edublink-core' ),
                    'alter'     => __( 'Alter', 'edublink-core' ),
                    'secondary' => __( 'Secondary', 'edublink-core' )
                ],
                'condition'     => [
                    'enable_found_text' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'search_placeholder_text',
            [
                'type'               => Controls_Manager::TEXT,
                'label'              => __( 'Search Placeholder Text', 'edublink-core' ),
                'default'            => __( 'Search Courses...', 'edublink-core' ),
                'condition'          => [
                    'filter_options' => 'search'
                ]
            ]
        );

        $this->add_control(
            'category_label_text',
            [
                'type'               => Controls_Manager::TEXT,
                'label'              => __( 'Category Label Text', 'edublink-core' ),
                'default'            => __( 'Categories', 'edublink-core' ),
                'condition'          => [
                    'filter_options' => 'category'
                ]
            ]
        );

        $this->add_control(
            'category_number',
            [
                'label'              => __( 'Number of Categories', 'edublink-core' ),
                'type'               => Controls_Manager::NUMBER,
                'default'            => 0,
                'description'        => __( 'Number of categories to show. By default the value is 0, which shows all the categories.', 'edublink-core' ),
                'condition'          => [
                    'filter_options' => 'category'
                ]
            ]
        );

        $this->add_control(
            'tags_label_text',
            [
                'type'               => Controls_Manager::TEXT,
                'label'              => __( 'Tags Label Text', 'edublink-core' ),
                'default'            => __( 'Tags', 'edublink-core' ),
                'condition'          => [
                    'filter_options' => 'tags'
                ]
            ]
        );

        $this->add_control(
            'instructor_label_text',
            [
                'type'               => Controls_Manager::TEXT,
                'label'              => __( 'Instructor Label Text', 'edublink-core' ),
                'default'            => __( 'Instructor', 'edublink-core' ),
                'condition'          => [
                    'filter_options' => 'instructor'
                ]
            ]
        );

        $this->add_control(
            'difficulties_label_text',
            [
                'type'               => Controls_Manager::TEXT,
                'label'              => __( 'Level Label Text', 'edublink-core' ),
                'default'            => __( 'Level', 'edublink-core' ),
                'condition'          => [
                    'filter_options' => 'll_level'
                ]
            ]
        );

        $this->add_control(
            'grid_filter_text',
            [
                'type'             => Controls_Manager::TEXT,
                'label'            => __( 'Grid Filter Text', 'edublink-core' ),
                'default'          => __( 'Grid', 'edublink-core' ),
                'condition'        => [
                    'content_type' => 'grid-list'
                ]
            ]
        );

        $this->add_control(
            'list_filter_text',
            [
                'type'      => Controls_Manager::TEXT,
                'label'     => __( 'List Filter Text', 'edublink-core' ),
                'default'   => __( 'List', 'edublink-core' ),
                'condition' => [
                    'content_type' => 'grid-list'
                ]
            ]
        );

        $this->add_control(
            'filter_resposnive_status',
            [
                'label'          => __( 'Enable Sidebar Filter Toggle at Small Device?', 'edublink-core' ),
                'type'           => Controls_Manager::SWITCHER,    
                'label_on'       => __( 'Enable', 'edublink-core' ),
                'label_off'      => __( 'Disable', 'edublink-core' ),
                'default'        => 'yes',
                'return_value'   => 'yes',
                'description'    => __( 'Enabling this option activates the sidebar filter via a toggle button when the screen width is below 992px.', 'edublink-core' )
            ]
        );

        $this->add_control(
            'filter_resposnive_toggle_text',
            [
                'type'        => Controls_Manager::TEXT,
                'label'       => __( 'Filter Toggle Text', 'edublink-core' ),
                'default'     => __( 'Filter Sidebar', 'edublink-core' ),
                'description' => __( 'This value will be shown for toggle the sidebar filter when the screen width is below 992px.', 'edublink-core' ),
                'condition'   => [
                    'filter_resposnive_status' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_courses',
            [
                'label' => __( 'Courses', 'edublink-core' )
            ]
        );

        $this->add_control(
            'per_page',
            [
                'label'         => __( 'Number Of Courses', 'edublink-core' ),
                'type'          => Controls_Manager::SLIDER,
                'description'   =>  __( 'Number of courses to show. Default 9. If you want to show all the courses then put <b>-1</b>', 'edublink-core' ),
                'default'       => [
                    'size'      => 9
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -1
                    ]
                ]
            ]
        ); 

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'thumb_size',
                'default'   => 'edublink-post-thumb'
            ]
        );

        $this->add_control(
            'excerpt_end',
            [
                'label'       => __( 'Excerpt End Text', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => '...',
                'description' => __( 'Content to show at the end of the excerpt. Default: ...', 'edublink-core' )
            ]
        );

        $this->add_control(
            'no_course_found_text',
            [
                'label'       => __( 'No Course Found Text', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Sorry, No Course Found.', 'edublink-core' ),
                'description' => __( 'This text will be shown if wishlist is empty.', 'edublink-core' )
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label'       => __( 'Button Text', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => false
            ]
        );

        $this->add_control(
            'default_scroll_animation',
            [
                'type'         => Controls_Manager::SWITCHER,
                'label'        => __( 'Default Scroll Animation', 'edublink-core' ),
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'grid_layout',
            [
                'label'     => __( 'Grid Layout', 'edublink-core' ),
                'condition' => [
                    'content_type!' => 'list'
                ]
            ]
        );

        $this->add_control(
            'grid_style',
            [
                'label'     => __( 'Grid Course Style', 'edublink-core' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => '1',
                'options'   => Filter::grid_layout()
            ]
        );

        $this->add_control(
            'grid_excerpt_length',
            [
                'label'       => __( 'Number of Words', 'edublink-core' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 20,
                'description' => __( 'Number of excerpt words.', 'edublink-core' )
            ]
        );

        $this->add_control(
            'enable_masonry',
            [
                'type'         => Controls_Manager::SWITCHER,
                'label'        => __( 'Masonry Layout', 'edublink-core' ),
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'no',
                'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'container_alert_text',
            [
                'type'            => Controls_Manager::RAW_HTML,
                'raw'             => __( '<strong>The Masonry Layout might not work on the Elementor Editor Page. But, it\'ll definitely work on the FrontEnd of your site.</strong>', 'edublink-core' ),
                'content_classes' => 'edublink-elementor-widget-alert elementor-panel-alert elementor-panel-alert-info',
                'condition'       => [
                    'enable_masonry' => 'yes'
                ]
            ]
        );
        
        $this->add_control(
            'large_desktop_grid_columns',
            [
                'label'       => __( 'Large Desktop Columns', 'edublink-core' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 2,
                'description' => __( 'Only for grid layout and required a width of minimum 1200px.', 'edublink-core' ),
                'options'     => [
                    '1' => __( '1 Column', 'edublink-core' ),
                    '2' => __( '2 Columns', 'edublink-core' ),
                    '3' => __( '3 Columns', 'edublink-core' )
                ]
            ]
        );

        $this->add_control(
            'desktop_grid_columns',
            [
                'label'       => __( 'Desktop Columns', 'edublink-core' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 2,
                'description' => __( 'Only for grid layout and required a width of minimum 992px.', 'edublink-core' ),
                'options'     => [
                    '1' => __( '1 Column', 'edublink-core' ),
                    '2' => __( '2 Columns', 'edublink-core' ),
                    '3' => __( '3 Columns', 'edublink-core' )
                ]
            ]
        );

        $this->add_control(
            'tablet_grid_columns',
            [
                'label'        => __( 'Tablet Columns', 'edublink-core' ),
                'type'         => Controls_Manager::SELECT,
                'default'      => 2,
                'options'      => [
                    '1' => __( '1 Column', 'edublink-core' ),
                    '2' => __( '2 Columns', 'edublink-core' ),
                    '3' => __( '3 Columns', 'edublink-core' ),
                    '4' => __( '4 Columns', 'edublink-core' ),
                    '6' => __( '6 Columns', 'edublink-core' )
                ],
                'description'  => __( 'Number of columns in tablet( up to 992 px ) and only applicable for Grid layout.', 'edublink-core' )
            ]
        );

        $this->add_control(
            'mobile_grid_columns',
            [
                'label'        => __( 'Mobile Columns', 'edublink-core' ),
                'type'         => Controls_Manager::SELECT,
                'default'      => 2,
                'options'      => [
                    '1' => __( '1 Column', 'edublink-core' ),
                    '2' => __( '2 Columns', 'edublink-core' ),
                    '3' => __( '3 Columns', 'edublink-core' ),
                    '4' => __( '4 Columns', 'edublink-core' ),
                    '6' => __( '6 Columns', 'edublink-core' )
                ],
                'description'  => __( 'Number of columns in mobile( works between 768 to 576 px ) and only applicable for Grid layout.', 'edublink-core' )
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'list_layout',
            [
                'label'     => __( 'List Layout', 'edublink-core' ),
                'condition' => [
                    'content_type!' => 'grid'
                ]
            ]
        );

        $this->add_control(
            'list_style',
            [
                'label'     => __( 'Grid Course Style', 'edublink-core' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => '18',
                'options'   => Filter::list_layout()
            ]
        );

        $this->add_control(
            'list_excerpt_length',
            [
                'label'       => __( 'Number of Words', 'edublink-core' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 24,
                'description' => __( 'Number of excerpt words.', 'edublink-core' )
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'button_section',
            [
                'label' => __( 'Button', 'edublink-core' )
            ]
        );

        $this->add_control(
            'apply_filter_button',
            [
                'label'      => __( 'Apply Filter Button', 'edublink-core' ),
                'type'       => Controls_Manager::TEXT,
                'default'    => __( 'Apply Filter', 'edublink-core' )
            ]
        );

        $this->add_control(
            'reset_filter_button',
            [
                'label'      => __( 'Reset Filter Button', 'edublink-core' ),
                'type'       => Controls_Manager::TEXT,
                'default'    => __( 'Reset Filter', 'edublink-core' )
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'pagination_section',
            [
                'label' => __( 'Pagination', 'edublink-core' )
            ]
        );

        $this->add_control(
            'pagination',
            [
                'label'        => __( 'Pagination', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,    
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'pagination_show_all',
            [
                'label'          => __( 'Show All?', 'edublink-core' ),
                'type'           => Controls_Manager::SWITCHER,    
                'label_on'       => __( 'Enable', 'edublink-core' ),
                'label_off'      => __( 'Disable', 'edublink-core' ),
                'default'        => 'no',
                'return_value'   => 'yes',
                'description'    => __( 'Whether to show all pages. Default disable.', 'edublink-core' ),
                'condition'      => [
                    'pagination' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'pagination_end_size',
            [
                'label'          => __( 'End Size?', 'edublink-core' ),
                'type'           => Controls_Manager::NUMBER,
                'default'        => 1,
                'description'    => __( 'How many numbers on either the start and the end list edges. Default 1.', 'edublink-core' ),
                'condition'      => [
                    'pagination' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'pagination_mid_size',
            [
                'label'          => __( 'Mid Size?', 'edublink-core' ),
                'type'           => Controls_Manager::NUMBER,
                'default'        => 2,
                'description'    => __( 'How many numbers to either side of the current pages. Default 2.', 'edublink-core' ),
                'condition'      => [
                    'pagination' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        global $wp_query;
        $settings = $this->get_settings_for_display();
        $settings['course_cpt'] = 'course'; 

        // Initialize filtered categories, tags & levels as empty arrays
        $filtered_category = ! empty( $_GET['course_cats'] ) ? ( array ) $_GET['course_cats'] : array();
        $filtered_category = array_map( 'sanitize_text_field', $filtered_category );
        $filtered_category = array_map( 'intval', $filtered_category );

        $filtered_tags = ! empty( $_GET['course_tags'] ) ? ( array ) $_GET['course_tags'] : array();
        $filtered_tags = array_map( 'sanitize_text_field', $filtered_tags );
        $filtered_tags = array_map( 'intval', $filtered_tags );

        $filtered_difficulties = ! empty( $_GET['course_difficulties'] ) ? ( array ) $_GET['course_difficulties'] : array();
        $filtered_difficulties = array_map( 'sanitize_text_field', $filtered_difficulties );
        $filtered_difficulties = array_map( 'intval', $filtered_difficulties );
        
        $filtered_level = ! empty( $_GET['course_level'] ) ? ( array ) $_GET['course_level'] : array( 'all_levels' );
        $filtered_level = array_map( 'sanitize_text_field', $filtered_level );

        $filtered_instructor = ! empty( $_GET['course_instructor'] ) ? ( array ) $_GET['course_instructor'] : array();
        $filtered_instructor = array_map( 'sanitize_text_field', $filtered_instructor );

        $search_value = ! empty( $_GET['course_search'] ) ? $_GET['course_search'] : '';

        if ( isset( $wp_query->queried_object->term_id ) ) :
            $filtered_category = array( $wp_query->queried_object->term_id );
        endif;

        $course_ordering = apply_filters( 'edublink_course_order_default', 'default' );
        if ( isset( $_GET['course_serialize'] ) && ! empty( $_GET['course_serialize'] ) ) :
            $course_ordering = wp_unslash( $_GET['course_serialize'] );
        endif;
        
        // Handle the reset button for category, tags, search value & course ordering
        if ( isset( $_GET['reset'] ) ) :
            $filtered_category = array();
            $filtered_tags = array();
            $filtered_difficulties = array();
            $filtered_instructor = array();
            $search_value = '';
            $course_ordering = 'newest_first';
        endif;

        $search_placeholder_text = $category_label_text = $level_label_text = '';
        $category_number = 0;

        if ( in_array( 'search', $settings['filter_options'] ) ) :
            $search_placeholder_text = $settings['search_placeholder_text'];
            $settings['search_value'] = $search_value;
            $settings['search_placeholder_text'] = $search_placeholder_text;
        endif;

        if ( in_array( 'category', $settings['filter_options'] ) ) :
            $category_label_text = $settings['category_label_text'];
            $category_number = $settings['category_number'];
            $settings['category_number'] = $category_number;
            $settings['filtered_category'] = $filtered_category;
            $settings['course_category'] = 'course_cat';
            $settings['course_cats'] = 'course_cats';
            $settings['category_label_text'] = $category_label_text;
        endif;

        if ( in_array( 'tags', $settings['filter_options'] ) ) :
            $tags_label_text = $settings['tags_label_text'];
            $settings['tags_label_text'] = $tags_label_text;
            $settings['filtered_tags'] = $filtered_tags;
            $settings['course_tag'] = 'course_tag';
            $settings['course_tags'] = 'course_tags';
        endif;

        if ( in_array( 'll_level', $settings['filter_options'] ) ) :
            $difficulties_label_text = $settings['difficulties_label_text'];
            $settings['difficulty_label_text'] = $difficulties_label_text;
            $settings['filtered_difficulties'] = $filtered_difficulties;
            $settings['course_difficulty'] = 'course_difficulty';
            $settings['course_difficulties'] = 'course_difficulties';
        endif;

        if ( in_array( 'instructor', $settings['filter_options'] ) ) :
            $instructor_label_text = $settings['instructor_label_text'];
            $settings['instructor_label_text'] = $instructor_label_text;
            $settings['filtered_instructor'] = $filtered_instructor;
        endif;
        
        if ( in_array( 'll_level', $settings['filter_options'] ) ) :
            $level_label_text = $settings['level_label_text'];
            $settings['filtered_level'] = $filtered_level;
            $settings['level_label_text'] = $level_label_text;
        endif;

        $settings['orderby_types'] = apply_filters( 'edublink_courses_orderby', array(
            'newest_first'    => __( 'Newest', 'edublink-core' ),
            'oldest_first'    => __( 'Oldest', 'edublink-core' ),
            'course_title_az' => __( 'Course Title (a-z)', 'edublink-core' ),
            'course_title_za' => __( 'Course Title (z-a)', 'edublink-core' )
        ) );

        $this->add_render_attribute( 'wrapper', 'class', 'edublink-row' );
        $this->add_render_attribute( 'wrapper', 'class', esc_attr( $settings['filter_layout'] ) );
        $this->add_render_attribute( 'wrapper', 'class', 'content-layout-type-' . esc_attr( $settings['content_type'] ) );
        if ( 'yes' === $settings['filter_resposnive_status'] ) :
            $this->add_render_attribute( 'wrapper', 'class', 'eb-sidebar-toggle-activated' );
        endif;
        $this->add_render_attribute( 'grid', 'class', 'edublink-row' );
        $this->add_render_attribute( 'list', 'class', 'edublink-row' );

        if ( 'list' !== $settings['content_type'] ) :
            $this->add_render_attribute( 'grid_single', 'class', esc_attr( Filter::column( $settings ) ) );

            if ( 'yes' === $settings['enable_masonry'] ) :
                $this->add_render_attribute( 'grid', 'class', 'eb-masonry-grid-wrapper' );
                $this->add_render_attribute( 'grid_single', 'class', 'eb-masonry-item' );
            endif;
        endif;

        if ( 'grid' !== $settings['content_type'] ) :
            $this->add_render_attribute( 'list_single', 'class', 'edublink-col-lg-12' );
        endif;

        $settings['course_ordering'] = $course_ordering;
        $args = Filter::query( $filtered_category, $filtered_tags, $settings );

        $paged = ( get_query_var( 'paged' ) ) ? get_query_var('paged') : 1;
        $args['posts_per_page'] = $settings['per_page']['size'] ? $settings['per_page']['size'] : -1;
        $args['paged'] = $paged;

        if ( 'yes' === $settings['filter_resposnive_status'] ) :
            echo '<div class="edublink-filter-active-overlay"></div>';
        endif;

        echo '<div class="edublink-course-filter-sidebar">';
            echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) . '>';
                Filter::sidebar( $settings );
                echo '<div class="edublink-col-lg-9 filter-course-column">';
                    echo '<div class="filtered-courses">';
                    
                        if ( in_array( 'tags', $settings['filter_options'] ) ) :
                            $args['tax_query'][] = [
                                'taxonomy' => $settings['course_difficulty'],
                                'field'    => 'term_id',
                                'terms'    => $settings['filtered_difficulties'],
                                'operator' => ! empty( $settings['filtered_difficulties'] ) ? 'IN' : 'NOT IN'
                            ];
                        endif;

                        $args = apply_filters( 'edublink_ll_course_filter_args', $args );
                        $query = new \WP_Query( $args );

                        if ( $query->have_posts() ) :
                            $block_data = [];
                            $block_data['enable_excerpt'] = true;

                            if ( $settings['excerpt_end'] ) :
                                $block_data['excerpt_end'] = $settings['excerpt_end'];
                            endif;
        
                            if ( $settings['button_text'] ) :
                                $block_data['button_text'] = $settings['button_text'];
                            endif;
                
                            $animation_attribute = '';
                            if ( 'yes' === $settings['default_scroll_animation'] ) :
                                $animation_attribute = ' data-sal';
                            endif;

                            Filter::top_filter( $settings, $query );

                            if ( 'list' !== $settings['content_type'] ) :
                                $this->add_render_attribute( 'grid', 'class', 'display-layout-grid edublink-course-archive' );
                                if( 'grid' === $settings['content_type'] ) :
                                    $this->add_render_attribute( 'grid', 'class', 'active' );
                                elseif( 'grid-list' === $settings['content_type'] && 'grid' === $settings['default_layout'] ) :
                                    $this->add_render_attribute( 'grid', 'class', 'active' );
                                endif;

                                echo '<div ' . $this->get_render_attribute_string( 'grid' ) . '>';
                                    while ( $query->have_posts() ) : $query->the_post();
                                        global $post; 
                                        $thumb_url = '';
                                        if ( has_post_thumbnail() && get_the_post_thumbnail_url() ) :
                                            $thumb_url = Filter::render_image( get_post_thumbnail_id( $post->ID ), $settings );
                                        else :
                                            $thumb_url = get_template_directory_uri() . '/assets/images/no-image-found.png';
                                        endif;
                                        $block_data['thumb_url'] = $thumb_url;
                                        
                                        echo '<div ' . $this->get_render_attribute_string( 'grid_single' ) . '>';
                                            $block_data['style'] = $settings['grid_style'];
                                            if ( $settings['grid_excerpt_length'] ) :
                                                $block_data['excerpt_length'] = $settings['grid_excerpt_length'];
                                            endif;
                                            $post_class = 'edublink-course-style-' . esc_attr( $settings['grid_style'] );
                                        ?>
                                            <div id="post-<?php the_ID(); ?>" <?php post_class( $post_class ); ?>  <?php echo esc_attr( $animation_attribute ); ?>>
                                            <?php
                                                llms_get_template( 'custom/course-block/blocks.php', compact( 'block_data' ) );
                                            echo '</div>';  
                                        echo '</div>';  
                                    endwhile;
                                    wp_reset_postdata();
                                    wp_reset_query();
                                echo '</div>';  
                            endif;

                            if ( 'grid' !== $settings['content_type'] ) :
                                $this->add_render_attribute( 'list', 'class', 'display-layout-list' );
                                $this->add_render_attribute( 'list', 'class', 'course-list-style-' . esc_attr( $settings['list_style'] ) );
                                if( 'list' === $settings['content_type'] ) :
                                    $this->add_render_attribute( 'list', 'class', 'active' );
                                elseif( 'grid-list' === $settings['content_type'] && 'list' === $settings['default_layout'] ) :
                                    $this->add_render_attribute( 'list', 'class', 'active' );
                                endif;

                                echo '<div ' . $this->get_render_attribute_string( 'list' ) . '>';
                                    while ( $query->have_posts() ) : $query->the_post();
                                        global $post; 
                                        $thumb_url = '';
                                        if ( has_post_thumbnail() && get_the_post_thumbnail_url() ) :
                                            $thumb_url = Filter::render_image( get_post_thumbnail_id( $post->ID ), $settings );
                                        else :
                                            $thumb_url = get_template_directory_uri() . '/assets/images/no-image-found.png';
                                        endif;
                                        $block_data['thumb_url'] = $thumb_url;

                                        echo '<div ' . $this->get_render_attribute_string( 'list_single' ) . '>';

                                            $block_data['style'] = $settings['list_style'];
                                            if ( $settings['list_excerpt_length'] ) :
                                                $block_data['excerpt_length'] = $settings['list_excerpt_length'];
                                            endif;
                                        ?>
                                            <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>  <?php echo esc_attr( $animation_attribute ); ?>>
                                            <?php
                                                llms_get_template( 'custom/course-block/blocks.php', compact( 'block_data' ) );
                                            echo '</div>';  
                                        echo '</div>';  
                                    endwhile;
                                    wp_reset_postdata();
                                    wp_reset_query();
                                echo '</div>';  
                            endif;
                            Filter::pagination( $query, $settings );
                        else :
                            echo '<h3 class="no-course-found filter-course">' . esc_html( $settings['no_course_found_text'] ). '</h3>';
                        endif;
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    } 
} 
