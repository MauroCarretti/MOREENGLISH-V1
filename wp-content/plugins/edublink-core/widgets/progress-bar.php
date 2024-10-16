<?php

namespace EduBlinkCore\Widgets;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Background;
use \Elementor\Group_Control_Typography;
use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for progress bar.
 *
 * @since 1.0.0
 */
class ProgressBar extends Widget_Base {

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
        return 'edublink-progress-bar';
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
        return __( 'Progress Bar', 'edublink-core' );
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
        return 'edublink-elementor-icon eicon-skill-bar';
    }

    /**
	 * Retrieve the list of scripts the counter widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.3.0
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'count-to', 'jquery-waypoints' ];
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
		return [ 'edublink', 'skill bar', 'progress', 'bar', 'pie', 'pregressbar'];
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
    protected function register_controls() {

        $this->start_controls_section( 
            'section_circle_progress', 
            [
			    'label' => __( 'Circle Progress', 'edublink-core' )
            ] 
        );

        $this->add_control(
            'title',
            [
                'label'   => __( 'Title', 'edublink-core' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Online Learning', 'edublink-core' )
            ]
        );

		$this->add_control( 
            'progress', 
            [
                'label'        => __( 'Progress', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'default'      => [
                    'size'     => 80
                ],
                'range'        => [
                    'px'       => [
                        'min'  => 1,
                        'max'  => 100,
                        'step' => 1
                    ]
                ]
            ] 
        );

        $this->add_responsive_control(
            'height',
            [
                'label'      => __( 'Height', 'edublink-core' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px'     => [
                        'min'  => 5,
                        'max'  => 50,
                        'step' => 1
                    ]
                ],
                'default'    => [
                    'unit'   => 'px',
                    'size'   => 10
                ],
                'selectors'  => [
                    '{{WRAPPER}} .eb-single-progressbar .eb-progressbar, {{WRAPPER}} .eb-single-progressbar .eb-progressbar-inner' => 'height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'border_radius',
            [
                'label'      => __( 'Border Radius', 'edublink-core' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range'      => [
                    'px'     => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1
                    ]
                ],
                'default'    => [
                    'unit'   => 'px',
                    'size'   => 5
                ],
                'selectors'  => [
                    '{{WRAPPER}} .eb-single-progressbar .eb-progressbar, {{WRAPPER}} .eb-single-progressbar .eb-progressbar-inner' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'spacing',
            [
                'label'      => __( 'Spacing', 'edublink-core' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range'      => [
                    'px'     => [
                        'min'  => 5,
                        'max'  => 100,
                        'step' => 1
                    ]
                ],
                'selectors'  => [
                    '{{WRAPPER}} .eb-single-progressbar .eb-progressbar-content' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
			'color_separator',
			[
				'type'  => Controls_Manager::DIVIDER,
				'style' => 'default'
			]
		);
        
        $this->add_control(
			'background_color',
			[
				'label'		=> __( 'Background Color', 'edublink-core' ),
				'type'		=> Controls_Manager::COLOR,
				'default'	=> '#e6e6e6',
				'selectors'	=> [
					'{{WRAPPER}} .eb-single-progressbar .eb-progressbar' => 'background-color: {{VALUE}};'
				]
			]
		);

        $this->add_control(
            'active_progress_color',
            [
				'label' => __( 'Progress Active Color', 'edublink-core' ),
				'type'  => Controls_Manager::HEADING
            ]
        );

        $this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'active_progress_background',
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .eb-single-progressbar.sal-animate[data-sal] .eb-progressbar-inner'
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
        $settings = $this->get_settings_for_display();

        echo '<div class="eb-single-progressbar" data-sal data-width="' . esc_attr( $settings['progress']['size'] ) . '">';
        echo '<div class="eb-progressbar-content">';
            echo '<h6 class="eb-progressbar-title">' . esc_html( $settings['title'] ) . '</h6>';
            echo '<div class="eb-progressbar-counter-wrapper">';
                echo '<span class="eb-progressbar-counter">0</span><span>%</span>';
            echo '</div>';
        echo '</div>';
            echo '<div class="eb-progressbar">';
                echo '<div class="eb-progressbar-inner"></div>';
            echo '</div>';
        echo '</div>';
    }
}