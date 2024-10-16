<?php
namespace EduBlinkCore\Widgets;

use \Elementor\Controls_Manager;
use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for course search.
 *
 * @since 1.0.0
 */
class Course_Search extends Widget_Base {

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
		return 'edublink-course-search';
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
		return 'edublink-elementor-icon eicon-search';
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
		return [ 'edublink', 'course', 'search', 'live search', 'ajax search' ];
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

    protected $post_type = LP_COURSE_CPT;

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

		$this->start_controls_section(
			'section_course_search',
			[
				'label' => __( 'Course Search', 'edublink-core' )
			]
		);

        $this->add_control(
            'type',
            [
                'label'     => __( 'Type', 'edublink-core' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'search-icon',
                'options'   => [
					'search-icon' => __( 'Search Icon', 'edublink-core' ),
					'button'      => __( 'Button', 'edublink-core' )
                ]
            ]
        );

        $this->add_control(
            'button_text',
            [   
				'label'     => __( 'Button Text', 'edublink-core' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => __( 'Search', 'edublink-core' ),
				'condition' => [
                	'type'  => 'button'
                ]
            ]
        );

		$this->add_control(
            'placeholder',
            [   
                'label'       => __( 'Search placeholder', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => __( 'Search By Course Name, Just Type To Get Hint...', 'edublink-core' ),
                'description' => __( 'Placeholder text for the search box.', 'edublink-core' )
            ]
        );

        $this->add_control(
            'ajax_live_search',
            [
                'label'        => __( 'Ajax Live Search', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'return_value' => 'yes',
                'default'      => 'yes'
            ]
        );

        $this->add_control(
            'disable_submit_form',
            [
                'label'        => __( 'Submit Form Option', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'return_value' => 'yes',
                'default'      => 'no'
            ]
        );

		$this->add_responsive_control(
			'search_box_height',
			[
				'label'        => __( 'height', 'edublink-core' ),
				'type'         => Controls_Manager::SLIDER,
				'size_units'   => [ 'px', '%' ],
				'range'        => [
					'px'       => [
						'min'  => 20,
						'max'  => 150,
						'step' => 5
					]
				],
				'selectors'    => [
					'{{WRAPPER}} .edublink-course-serach-input-group input[type="text"]' => 'height: {{SIZE}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
			'search_box_width',
			[
				'label'        => __( 'Width', 'edublink-core' ),
				'type'         => Controls_Manager::SLIDER,
				'size_units'   => [ 'px', '%' ],
				'range'        => [
					'px'       => [
						'min'  => -1000,
						'max'  => 1000,
						'step' => 5
					],
					'%'        => [
						'min'  => 0,
						'max'  => 100
					]
				],
				'default'      => [
					'unit'     => '%',
					'size'     => 100
				],
				'selectors'    => [
					'{{WRAPPER}} .edublink-course-search-box-wrapper' => 'width: {{SIZE}}{{UNIT}};'
				]
			]
		);

        $this->add_responsive_control(
            'alignment',
            [
                'label'          => __( 'Alignment', 'edublink-core' ),
                'type'           => Controls_Manager::CHOOSE,
                'options'        => [
                    '0' => [
                        'title'  => __( 'Left', 'edublink-core' ),
                        'icon'   => 'eicon-text-align-left'
                    ],
                    '0 auto'     => [
                        'title'  => __( 'Center', 'edublink-core' ),
                        'icon'   => 'eicon-text-align-center'
                    ],
                    '0 0 0 auto' => [
                        'title'  => __( 'Right', 'edublink-core' ),
                        'icon'   => 'eicon-text-align-right'
                    ]
                ],
                'selectors'      => [
                    '{{WRAPPER}} .edublink-course-search-box-wrapper' => 'margin: {{VALUE}};'
                ]
            ]
        );

		$this->end_controls_section();

        $this->start_controls_section(
			'container_style',
			[
				'label' => __( 'Container', 'edublink-core' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);

        $this->add_control(
            'text_color',
            [
                'label'     => __( 'Text Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-course-serach-input-group input[type="text"]' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'text_placeholder_color',
            [
                'label'     => __( 'Placeholder Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-course-serach-input-group input[type="text"]::placeholder' => 'color: {{VALUE}} !important;'
                ]
            ]
        );

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings    = $this->get_settings_for_display();
		$placeholder = $settings['placeholder'];
		$disable_submit_form = false;

        $this->add_render_attribute( 'container', 'class', 'edublink-course-search-box-wrapper' );
        $this->add_render_attribute( 'container', 'class', 'edublink-course-search-by-' . esc_attr( $settings['type'] ) );

        if ( 'yes' === $settings['ajax_live_search'] ) :
            $this->add_render_attribute( 'container', 'data-ajax-search', 'enable' );
        endif;

		if ( 'yes' === $settings['disable_submit_form'] || 'edublink-ms-course-search' === $this->get_name() ) :
			$disable_submit_form = true;
		endif;

		$this->add_render_attribute( 'container', 'class', 'edublink-course-search-form' );
		$this->add_render_attribute( 'container', 'role', 'search' );
		if ( $disable_submit_form ) :
			$this->add_render_attribute( 'container', 'onsubmit', 'return false' );
		else :
			$this->add_render_attribute( 'container', 'action', esc_url( get_post_type_archive_link( $this->post_type ) ) );
		endif;

		echo '<div ' . $this->get_render_attribute_string( 'container' ) . '>';
			echo '<div class="edublink-course-search">';
				echo '<form ' . $this->get_render_attribute_string( 'container' ) . '>';
					echo '<fieldset>';
						echo '<div class="edublink-course-serach-input-group">';
							if ( is_search() ) :
								echo '<input id="edublink-course-search-id-' . $this->get_id() . '" class="edublink-course-search-field" type="text" name="s" value="' . esc_attr( apply_filters( 'the_search_query', get_search_query() ) ) . '"/>';
							else :
								echo '<input id="edublink-course-search-id-' . $this->get_id() . '" class="edublink-course-search-field" type="text" name="s" placeholder="' . esc_attr( $placeholder ) . '"/>';
							endif;

							echo '<input type="hidden" value="course" name="ref" />';
                            
							echo '<span class="edublink-course-search-btn">';
                                if ( 'search-icon' === $settings['type'] ) :
                                    echo '<button type="submit" class="edublink-course-ajax-search-icon"><i class="icon-2" aria-hidden="true"></i></button>';
                                else :
                                    echo '<button type="submit" class="edublink-course-ajax-search-button">' . esc_html( $settings['button_text'] ) . '</button>';
                                endif;
							echo '</span>';
						echo '</div>';
					echo '</fieldset>';
				echo '</form>';

                if ( 'yes' === $settings['ajax_live_search'] ) :
                    echo '<div class="edublink-course-ajax-search-result-area">';
                        echo '<div id="edublink-course-search-id-' . esc_attr( $this->get_id() ) . '" class="edublink-course-ajax-search-result-inner"></div>';
                    echo '</div>';
                endif;
			echo '</div>';
		echo '</div>';
	}
}