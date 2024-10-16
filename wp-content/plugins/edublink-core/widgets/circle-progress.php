<?php

namespace EduBlinkCore\Widgets;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for circle progress.
 *
 * @since 1.0.0
 */
class CircleProgress extends Widget_Base {

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
        return 'edublink-circle-progress';
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
        return __( 'Circle Progress', 'edublink-core' );
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
        return 'edublink-elementor-icon eicon-counter-circle';
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
	public function get_script_depends() {
		return [ 'edublink-circle-progress', 'jquery-waypoints' ];
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
		return [ 'edublink', 'circle', 'progress', 'chart', 'pie', 'progressbar', 'counter circle' ];
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
            'progress', 
            [
                'label'   => __( 'Progress', 'edublink-core' ),
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

		$this->add_control( 
            'size', 
            [
                'label'   => __( 'Size', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'default'      => [
                    'size'     => 200
                ],
                'range'        => [
                    'px'       => [
                        'min'  => 100,
                        'max'  => 1000,
                        'step' => 1
                    ]
                ]
            ] 
        );

		$this->add_control( 
            'thickness', 
            [
                'label'   => __( 'Thickness', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'default'      => [
                    'size'     => 5
                ],
                'range'        => [
                    'px'       => [
                        'min'  => 1,
                        'max'  => 40,
                        'step' => 1
                    ]
                ]
            ] 
        );

        $this->add_control( 
            'style', 
            [
                'label'      => __( 'Style', 'edublink-core' ),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'round',
                'options'    => [
                    'round'  => __( 'Round', 'edublink-core' ),
                    'square' => __( 'Square', 'edublink-core' ),
                    'butt'   => __( 'Butt', 'edublink-core' )
                ]
            ] 
        );

		$this->add_control( 
            'reverse_animation', 
            [
                'label'        => __( 'Reverse Animation?', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'no',
                'return_value' => 'yes'
            ] 
        );

		$this->add_control( 
            'content_type',
            [
                'label'   => __( 'Content Type', 'edublink-core' ),
                'type'    => Controls_Manager::SELECT,
			    'default' => 'counterup',
                'options' => [
                    'counterup' => __( 'Counter Up Number', 'edublink-core' ),
                    'text'      => __( 'Custom Text', 'edublink-core' )
                ]
            ] 
        );

		$this->add_control( 
            'text', 
            [
                'label'     => __( 'Text', 'edublink-core' ),
                'type'      => Controls_Manager::TEXT,
                'condition' => [
                    'content_type' => 'text'
                ]
            ]
        );

		$this->add_control( 
            'sign', 
            [
                'label'       => __( 'Measuring Sign', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => '%',
                'condition' => [
                    'content_type' => 'counterup'
                ]
            ] 
        );

        $this->add_control(
            'duration',
            [
                'label'     => __( 'Duration', 'edublink-core' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 1500,
                'description' => __( 'Value in millisecond.', 'edublink-core' )
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label'          => __( 'Alignment', 'edublink-core' ),
                'type'           => Controls_Manager::CHOOSE,
                'toggle'         => true,
                'label_block'    => false,
                'default'        => 'center',
                'options'        => [
                    'left' => [
                        'title'  => __( 'Left', 'edublink-core' ),
                        'icon'   => 'eicon-h-align-left'
                    ],
                    'center'     => [
                        'title'  => __( 'Center', 'edublink-core' ),
                        'icon'   => 'eicon-h-align-center'
                    ],
                    'right'   => [
                        'title'  => __( 'Right', 'edublink-core' ),
                        'icon'   => 'eicon-h-align-right'
                    ]
                ],
                'selectors'     => [
                    '{{WRAPPER}} .edublink-circle-progress-container' => 'text-align: {{VALUE}};'
                ]
            ]
        );

		$this->end_controls_section();

        $this->start_controls_section( 
            'style_circle_progress', 
            [
                'label' => __( 'Circle Progress', 'edublink-core' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ] 
        );

		$this->add_control( 
            'full_bar_color', 
            [
                'label'   => __( 'Bar Color', 'edublink-core' ),
                'type'    => Controls_Manager::COLOR,
                'default' => '#e6e2e1'
            ] 
        );

        $this->add_control( 
            'progress_color_type', 
            [
                'label'      => __( 'Progress Color Type', 'edublink-core' ),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'color',
                'options'    => [
                    'color'    => __( 'Color', 'edublink-core' ),
                    'gradient' => __( 'Gradient', 'edublink-core' )
                ]
            ] 
        );

		$this->add_control( 
            'progress_color', 
            [
                'label'  => __( 'Progress Bar Color', 'edublink-core' ),
                'type'   => Controls_Manager::COLOR,
                'condition' => [
                    'progress_color_type' => 'color'
                ]
            ] 
        );

        $this->add_control( 
            'progress_gradient_color', 
            [
                'label'       => __( 'Gradient Color', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => '["#3aeabb", "#fdd250"]',
                'description' => __( 'Value like <strong>["#3aeabb", "#fdd250"]</strong>. Please note: gradient color value might not work at Elementor Editor page, but it\'ll work on the frontend of your website.', 'edublink-core' ),
                'condition'   => [
                    'progress_color_type' => 'gradient'
                ]
            ]
        );

		$this->end_controls_section();

        $this->start_controls_section( 
            'style_content_progress', 
            [
                'label' => __( 'Content', 'edublink-core' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ] 
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'selector' => '{{WRAPPER}} .edublink-circle-progress-container .edublink-circle-progress-digit'
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label'     => __( 'Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-circle-progress-container .edublink-circle-progress-digit' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'content_spacing',
            [
                'label'        => __( 'Spacing', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'size_units'   => [ 'px' ],
                'range'        => [
                    'px'       => [
                        'min'  => -50,
                        'max'  => 100,
                        'step' => 1
                    ]
                ],
                'selectors'    => [
                    '{{WRAPPER}} .edublink-circle-progress-container .edublink-circle-progress-digit'  => 'margin-top: {{SIZE}}{{UNIT}};'
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
        $settings = $this->get_settings_for_display();

		$value = (int)$settings['progress']['size'] / 100;

		$this->add_render_attribute( 'container', 'class', 'edublink-circle-progress-container' );
        $this->add_render_attribute( 'container', 'data-duration', intval( esc_attr( $settings['duration'] ) ) );
        $this->add_render_attribute( 'container', 'data-percentage', esc_attr( $settings['progress']['size'] ) );

		if ( 'counterup' === $settings['content_type'] ) :
			$this->add_render_attribute( 'container', 'data-counterup', 'enable' );
            $this->add_render_attribute( 'container', 'data-sign', esc_attr( $settings['sign'] ) );
        endif;

		$this->add_render_attribute( 'circle', [
			'class'           => 'edublink-circle-progress',
			'data-value'      => esc_attr( $value ),
			'data-line-cap'   => esc_attr( $settings['style'] ),
			'data-thickness'  => esc_attr( $settings['thickness']['size'] ),
			'data-size'       => esc_attr( $settings['size']['size'] ),
			'data-empty-fill' => esc_attr( $settings['full_bar_color'] ),
			'style'           => sprintf( 'width: %1$spx; height: %1$spx;', esc_attr( $settings['size']['size'] ) )
		] );

        if ( 'color' === $settings['progress_color_type'] ) :
            $progress_color = ! empty( $settings['progress_color'] ) ? $settings['progress_color'] : '#000000';
		    $progress_color = '{ "color": "' . esc_attr( $progress_color ) . '" }';
        else :
            $progress_color = ! empty( $settings['progress_gradient_color'] ) ? $settings['progress_gradient_color'] : ["#3aeabb", "#fdd250"];
		    $progress_color = '{ "gradient": ' . esc_attr( $progress_color ) . ' }';
        endif;
		$this->add_render_attribute( 'circle', 'data-fill', esc_attr( $progress_color ) );

		if ( 'yes' === $settings['reverse_animation'] ) {
			$this->add_render_attribute( 'circle', 'data-reverse', true );
		}

		$this->add_render_attribute( 'digit', 'class', 'edublink-circle-progress-digit' );

        echo '<div ' . $this->get_render_attribute_string( 'container' ) . '>';
			echo '<div class="edublink-circle-progress-inner">';
                echo '<div ' . $this->get_render_attribute_string( 'circle' ) . '>';
                    echo '<div class="edublink-circle-progress-content">';
						if ( 'counterup' === $settings['content_type'] ) :
							echo '<h5 ' . $this->get_render_attribute_string( 'digit' ) . '>0</h5>';
						else :
							echo '<h5 class="edublink-circle-progress-digit">';
                                echo esc_html( $settings['text'] );
                            echo '</h5>';
						endif;
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
    }
}