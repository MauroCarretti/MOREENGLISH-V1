<?php

namespace EduBlinkCore\Widgets;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Icons_Manager;
use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for button.
 *
 * @since 1.0.0
 */
class Button extends Widget_Base {

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
		return 'edublink-button';
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
		return __( 'Button', 'edublink-core' );
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
        return 'edublink-elementor-icon eicon-button';
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
		return [ 'edublink', 'button', 'link', 'url', 'btn' ];
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

        $icon_position = is_rtl() ? 'before' : 'after';
        $icon_name = is_rtl() ? 'west' : '4';

  		$this->start_controls_section(
            'section_button',
            [
                'label' => __( 'Button', 'edublink-core' )
            ]
        );

        $this->add_control(
            'style',
            [
                'label'   => __( 'Style', 'edublink-core' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => __( 'Default',   'edublink-core' ),
                    'two'     => __( 'Style 2',   'edublink-core' ),
                    'three'   => __( 'Style 3',   'edublink-core' ),
                    'four'    => __( 'Style 4',   'edublink-core' ),
                    'five'    => __( 'Style 5',   'edublink-core' ),
                    'curved'  => __( 'Curved',   'edublink-core' ),
                    'custom'  => __( 'Custom',   'edublink-core' )
                ]
            ]
        );

        $this->add_control(
            'size',
            [
                'label'   => __( 'Size', 'edublink-core' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'custom',
                'options' => [
                    'custom' => __( 'Custom',   'edublink-core' ),
                    'small'  => __( 'Small',   'edublink-core' ),
                    'medium' => __( 'Medium',   'edublink-core' ),
                    'large'  => __( 'Large',   'edublink-core' )
                ]
            ]
        );

        $this->add_control(
            'text',
            [
                'label'       => __( 'Text', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => __( 'Get Started', 'edublink-core' ),
                'placeholder' => __( 'Enter button text.', 'edublink-core' )
            ]
        );

        $this->add_control(
            'url',
            [
                'label'         => __( 'Link', 'edublink-core' ),
                'type'          => Controls_Manager::URL,
                'label_block'   => true,
                'show_external' => true,
                'placeholder'   => __( 'https://your-link.com', 'edublink-core' ),
                'dynamic'        => [
                    'active'     => true
                ],
                'default'         => [
                    'url'         => '#',
                    'is_external' => ''
                ]
            ]
        );

        $this->add_control(
            'icon',
            [
                'label'   => __( 'Icon', 'edublink-core' ),
                'type'    => Controls_Manager::ICONS,
                'default'     => [
                    'value'   => 'icon-' . $icon_name,
                    'library' => 'edublink-custom-icons'
                ]
            ]
        );

        $this->add_control(
            'icon_position',
            [
                'label'   => __( 'Icon Position', 'edublink-core' ),
                'type'    => Controls_Manager::SELECT,
                'default' => $icon_position,
                'options' => [
                    'before' => __( 'Before',   'edublink-core' ),
                    'after'  => __( 'After',    'edublink-core' )
                ],
                'condition'   => [
                    'icon[value]!' => ''
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label'       => __( 'Icon Size', 'edublink-core' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px' ],
                'range'       => [
                    'px'      => [
                        'max' => 60
                    ]
                ],
                'selectors'   => [
                    '{{WRAPPER}} .edublink-button-icon-position-before i, {{WRAPPER}} .edublink-button-icon-position-after i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .edublink-button-icon-position-before svg, {{WRAPPER}} .edublink-button-icon-position-after svg'  => 'width: {{SIZE}}{{UNIT}};'
                ],
                'condition'   => [
                    'icon[value]!' => ''
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_indent',
            [
                'label'       => __( 'Icon Spacing', 'edublink-core' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px' ],
                'range'       => [
                    'px'      => [
                        'max' => 50
                    ]
                ],
                'selectors'   => [
                    '{{WRAPPER}} .edublink-button-icon-position-before i, {{WRAPPER}} .edublink-button-icon-position-before svg' => 'padding-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .edublink-button-icon-position-after i, {{WRAPPER}} .edublink-button-icon-position-after svg'  => 'padding-left: {{SIZE}}{{UNIT}};'
                ],
                'condition'   => [
                    'icon[value]!' => ''
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_top_spacing',
            [
                'label'       => __( 'Icon Top Spacing', 'edublink-core' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px' ],
                'range'       => [
                    'px'      => [
                        'max' => 50
                    ]
                ],
                'selectors'   => [
                    '{{WRAPPER}} .edublink-button-icon-position-before i, {{WRAPPER}} .edublink-button-icon-position-before svg, {{WRAPPER}} .edublink-button-icon-position-after i, {{WRAPPER}} .edublink-button-icon-position-after svg'  => 'top: {{SIZE}}{{UNIT}};'
                ],
                'condition'   => [
                    'icon[value]!' => ''
                ]
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label'          => __( 'Alignment', 'edublink-core' ),
                'type'           => Controls_Manager::CHOOSE,
                'options'        => [
                    'flex-start' => [
                        'title'  => __( 'Left', 'edublink-core' ),
                        'icon'   => 'eicon-text-align-left'
                    ],
                    'center'     => [
                        'title'  => __( 'Center', 'edublink-core' ),
                        'icon'   => 'eicon-text-align-center'
                    ],
                    'flex-end'   => [
                        'title'  => __( 'Right', 'edublink-core' ),
                        'icon'   => 'eicon-text-align-right'
                    ]
                ],
                'selectors'      => [
                    '{{WRAPPER}} .edublink-button-widget-wrapper' => 'justify-content: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'container_style',
            [
                'label' => __( 'Container', 'edublink-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'size' => 'custom'
                ]
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label'      => __( 'Padding', 'edublink-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .edublink-button-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label'        => __( 'Height', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'size_units'   => [ 'px' ],
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 200,
                        'step' => 1
                    ]
                ],
                'selectors'    => [
                    '{{WRAPPER}} .edublink-button-item' => 'height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'line_height',
            [
                'label'        => __( 'Line Height', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'size_units'   => [ 'px' ],
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 200,
                        'step' => 1
                    ]
                ],
                'selectors'    => [
                    '{{WRAPPER}} .edublink-button-item' => 'line-height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'button_style',
            [
                'label' => __( 'Style', 'edublink-core' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'selector' => '{{WRAPPER}} .edublink-button-item'
            ]
        );

        $this->start_controls_tabs( 
            'style_tabs',
            [
                'condition' => [
                    'style' => 'custom'
                ]
            ]
        );

            $this->start_controls_tab( 'normal', [ 'label' => __( 'Normal', 'edublink-core' ) ] );

            $this->add_control(
                'color',
                [
                    'label'     => __( 'Color', 'edublink-core' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .edublink-button-item' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'bg_color',
                [
                    'label'     => __( 'Background Color', 'edublink-core' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .edublink-button-item' => 'background: {{VALUE}};'
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'     => 'border',
                    'selector' => '{{WRAPPER}} .edublink-button-item'
                ]
            );

            $this->add_responsive_control(
                'border_radius',
                [
                    'label'      => __( 'Border Radius', 'edublink-core' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors'  => [
                        '{{WRAPPER}} .edublink-button-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name'     => 'box_shadow',
                    'selector' => '{{WRAPPER}} .edublink-button-item'
                ]
            );

            $this->end_controls_tab();

            $this->start_controls_tab( 'hover', [ 'label' => __( 'Hover', 'edublink-core' ) ] );

            $this->add_control(
                'hover_color',
                [
                    'label'     => __( 'Color', 'edublink-core' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .edublink-button-item:hover, {{WRAPPER}} .edublink-button-item:focus, {{WRAPPER}} .edublink-button-item:active' => 'color: {{VALUE}};'
                    ]
                ]
            );

            $this->add_control(
                'hover_bg_color',
                [
                    'label'     => __( 'Background Color', 'edublink-core' ),
                    'type'      => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .edublink-button-item:hover' => 'background: {{VALUE}};'
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'     => 'hover_border',
                    'selector' => '{{WRAPPER}} .edublink-button-item:hover'
                ]
            );

            $this->add_responsive_control(
                'hover_border_radius',
                [
                    'label'      => __( 'Border Radius', 'edublink-core' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%' ],
                    'selectors'  => [
                        '{{WRAPPER}} .edublink-button-item:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Box_Shadow::get_type(),
                [
                    'name'     => 'hover_box_shadow',
                    'selector' => '{{WRAPPER}} .edublink-button-item:hover'
                ]
            );

            $this->end_controls_tab();

        $this->end_controls_tabs();

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
        $settings     = $this->get_settings_for_display();

        $this->add_render_attribute(
            'container',
            [
                'class' => [
                    'edublink-button-item',
                    'edublink-button-style-' . esc_attr( $settings['style'] ),
                    'edublink-button-size-' . esc_attr( $settings['size'] ),
                    'edublink-button-icon-position-' . esc_attr( $settings['icon_position'] )
                ]
            ]
        );

        if ( 'custom' !== $settings['style'] ) :
            $this->add_render_attribute( 'container', 'class', 'default-style' );
        endif;

        if ( $settings['url']['url'] ) :
            $this->add_render_attribute( 'container', 'href', esc_url( $settings['url']['url'] ) );
            if ( $settings['url']['is_external'] ) :
                $this->add_render_attribute( 'container', 'target', '_blank' );
            endif;
            if ( $settings['url']['nofollow'] ) :
                $this->add_render_attribute( 'container', 'rel', 'nofollow' );
            endif;
        endif;

        echo '<div class="edublink-button-widget-wrapper">';
            if ( $settings['text'] ) :
                echo '<a ' . $this->get_render_attribute_string( 'container' ) . '>';
                    if ( 'before' === $settings['icon_position'] && ! empty( $settings['icon']['value'] ) ) :
                        Icons_Manager::render_icon( $settings['icon'] );
                    endif;
                    echo esc_html( $settings['text'] );
                    if ( 'after' === $settings['icon_position'] && ! empty( $settings['icon']['value'] ) ) :
                        Icons_Manager::render_icon( $settings['icon'] );
                    endif;
                echo '</a>';
            endif;
        echo '</div>';
    }
}