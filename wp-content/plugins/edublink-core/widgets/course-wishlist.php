<?php

namespace EduBlinkCore\Widgets;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for post.
 *
 * @since 1.0.0
 */
class Course_Wishlist extends Widget_Base {
    use \EduBlink_Core\Traits\Grid;

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
        return 'edublink-course-wishlist';
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
        return __( 'Course Wishlist', 'edublink-core' );
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
        return 'eicon-posts-grid edublink-elementor-icon';
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

    protected $desktop_default_grid   = 3;
    protected $tablet_default_grid    = 2;
    protected $mobile_default_grid    = 1;
    protected $post_type              = LP_COURSE_CPT;
    protected $default_display_type = 'grid';

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function register_controls() {
                
        $this->start_controls_section(
            'section_courses',
            [
                'label' => __( 'Wishlist Courses', 'edublink-core' )
            ]
        );

        $this->add_control(
            'style',
            [
                'label'   => __( 'Style', 'edublink-core' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1' => __( 'One', 'edublink-core' ),
                    '2' => __( 'Two', 'edublink-core' ),
                    '3' => __( 'Three', 'edublink-core' ),
                    '4' => __( 'Four', 'edublink-core' ),
                    '5' => __( 'Five', 'edublink-core' ),
                    '6' => __( 'Six', 'edublink-core' ),
                    '7' => __( 'Seven', 'edublink-core' ),
                    '8' => __( 'Eight', 'edublink-core' ),
                    '9' => __( 'Nine', 'edublink-core' ),
                    '10' => __( 'Ten', 'edublink-core' ),
                    '11' => __( 'Eleven', 'edublink-core' ),
                    '12' => __( 'Twelve', 'edublink-core' ),
                    '13' => __( 'Thirteen', 'edublink-core' ),
                    '14' => __( 'Fourteen', 'edublink-core' ),
                    '15' => __( 'Fifteen', 'edublink-core' ),
                    '16' => __( 'Sixteen', 'edublink-core' ),
                    '17' => __( 'Seventeen', 'edublink-core' ),
                    'quran' => __( 'Quran', 'edublink-core' )
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
            'default_scroll_animation',
            [
                'type'         => Controls_Manager::SWITCHER,
                'label'        => __( 'Default Scroll Animation', 'edublink-core' ),
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'yes',
                'return_value' => 'yes',
                'condition'    => [
                    'display_type' => 'grid'
                ]
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
			'active_white_bg', [
				'label'        => __( 'Active White Background', 'edublink-core' ),
				'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
				'default'      => 'no',
				'return_value' => 'yes'
			]
		);

        $this->add_control(
            'enable_excerpt',
            [
                'label'        => __( 'Excerpt.', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );  

        $this->add_control(
            'excerpt_length',
            [
                'label'       => __( 'Number of Words', 'edublink-core' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 20,
                'description' => __( 'Number of excerpt words.', 'edublink-core' ),
                'condition'   => [
                    'enable_excerpt' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'excerpt_end',
            [
                'label'       => __( 'Excerpt End Text', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => '...',
                'description' => __( 'Content to show at the end of the excerpt. Default: ...', 'edublink-core' ),
                'condition'   => [
                    'enable_excerpt' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'no_course_found_text',
            [
                'label'       => __( 'No Course Found Text', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Sorry, No Course Found in Your Wishlist.', 'edublink-core' ),
                'description' => __( 'This text will be shown if wishlist is empty.', 'edublink-core' )
            ]
        );

        $this->end_controls_section();

        $this->settings();
    }

    /**
     * return course featured image
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render_image( $image_id, $settings ) {
        $image_size = $settings['thumb_size_size'];
        if ( 'custom' === $image_size ) :
            $image_src = Group_Control_Image_Size::get_attachment_image_src( $image_id, 'thumb_size', $settings );
        else :
            $image_src = wp_get_attachment_image_src( $image_id, $image_size );
            $image_src = $image_src[0];
        endif;
        return $image_src;
    }

    /**
     * return grid columns
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function grid( $settings ) {
        if ( '5' === $settings['desktop_grid_columns'] ) :
            $grid_desktop_column = 'el-5';
        else :
            $grid_desktop_column = 12/$settings['desktop_grid_columns'];
        endif;
        $grid_tablet_column  = 12/$settings['tablet_grid_columns'];
        $grid_mobile_column  = 12/$settings['mobile_grid_columns'];
        $grid_column = 'edublink-col-lg-' . esc_attr( $grid_desktop_column ) . ' edublink-col-md-' . esc_attr( $grid_tablet_column ) . ' edublink-col-sm-' . esc_attr( $grid_mobile_column );

        return $grid_column;
    }
}