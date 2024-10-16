<?php

namespace EduBlinkCore\Widgets;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Css_Filter;
use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for lottie.
 *
 * @since 1.0.0
 */
class Lottie extends Widget_Base {

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
		return 'edublink-lottie';
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
		return __( 'Lottie', 'edublink-core' );
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
        return 'edublink-elementor-icon eicon-lottie';
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
        return [ 'lottie-js' ];
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
		return [ 'edublink', 'effect', 'animation', 'lottie' ];
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
    
        $this->start_controls_section(
            'section_lottie_animation',
            [
                'label' => __( 'Lottie Animation', 'edublink-core' )
            ]
        );

        $this->add_control(
            'source',
            [
                'label'   => __( 'Source', 'edublink-core' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'media-file',
                'options' => [
                    'media-file'   => __( 'Media File', 'edublink-core' ),
                    'external-url' => __( 'External URL', 'edublink-core' )
                ]
            ]
        );

        $this->add_control(
            'source_external_url',
            [
                'label'       => __( 'External URL', 'edublink-core' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => __( 'Enter your URL', 'edublink-core' ),
                'default'     => [
                    'url'     => EDUBLINK_ASSETS_URL . 'lotties/lottie_default.json'
                ],
                'condition'   => [
                    'source'  => 'external-url'
                ]
            ]
        );

        $this->add_control(
            'source_json',
            [
                'label'      => __( 'Upload JSON File( JSON Link )', 'edublink-core' ),
                'type'       => Controls_Manager::MEDIA,
                'media_type' => 'application/json',
                'default'    => [
                    'url'    => EDUBLINK_ASSETS_URL . 'lotties/lottie_default.json'
                ],
                'condition'  => [
                    'source' => 'media-file'
                ]
            ]
        );
        
        $this->add_responsive_control(
            'align',
            [
                'label'   => __( 'Alignment', 'edublink-core' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left'      => [
                        'title' => __( 'Left', 'edublink-core' ),
                        'icon'  => 'eicon-text-align-left'
                    ],
                    'center'    => [
                        'title' => __( 'Center', 'edublink-core' ),
                        'icon'  => 'eicon-text-align-center'
                    ],
                    'right'     => [
                        'title' => __( 'Right', 'edublink-core' ),
                        'icon'  => 'eicon-text-align-right'
                    ]
                ],
                'prefix_class'  => 'elementor%s-align-',
                'default'       => 'center'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_lottie_settings',
            [
                'label' => __( 'Settings', 'edublink-core' )
            ]
        );

        $this->add_control(
            'trigger',
            [
                'label'   => __( 'Trigger', 'edublink-core' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'autoplay',
                'options' => [
                    'arriving_to_viewport' => __( 'Viewport', 'edublink-core' ),
                    'on_click'             => __( 'On Click', 'edublink-core' ),
                    'on_hover'             => __( 'On Hover', 'edublink-core' ),
                    'autoplay'             => __( 'Autoplay', 'edublink-core' ),
                    'bind_to_scroll'       => __( 'Scroll', 'edublink-core' )
                ]
                
            ]
        );

        $this->add_control(
            'loop',
            [
                'label'        => __( 'Loop', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'speed',
            [
                'label'        => __( 'Play Speed', 'edublink-core' ) . ' (x)',
                'type'         => Controls_Manager::SLIDER,
                'size_units'   => [ 'px' ],
                'default'      => [
                    'unit'     => 'px',
                    'size'     => 1
                ],
                'range'        => [
                    'px'       => [
                        'min'  => 0.1,
                        'max'  => 10,
                        'step' => 0.1
                    ]
                ]                
            ]
        );

        $this->add_control(
            'reverse_animation',
            [
                'label'        => __( 'Reverse', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'renderer',
            [
                'label'      => __( 'Renderer', 'edublink-core' ),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'svg',
                'options'    => [
                    'svg'    => __( 'SVG', 'edublink-core' ),
                    'canvas' => __( 'Canvas', 'edublink-core' )
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'style',
            [
                'label' => __( 'Lottie', 'edublink-core' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'width',
            [
                'label'          => __( 'Width', 'edublink-core' ),
                'type'           => Controls_Manager::SLIDER,
                'default'        => [
                    'unit'       => '%'
                ],
                'tablet_default' => [
                    'unit'       => '%'
                ],
                'mobile_default' => [
                    'unit'       => '%'
                ],
                'size_units'     => [ '%', 'px', 'vw' ],
                'range'          => [
                    '%'          => [
                        'min'    => 1,
                        'max'    => 100,
                    ],
                    'px'         => [
                        'min'    => 1,
                        'max'    => 1000
                    ],
                    'vw'         => [
                        'min'    => 1,
                        'max'    => 100
                    ]
                ],
                'selectors'       => [
                    '{{WRAPPER}} .edublink-lottie-animation-wrapper svg' => 'max-width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'space',
            [
                'label'          => __( 'Max Width', 'edublink-core' ),
                'type'           => Controls_Manager::SLIDER,
                'default'        => [
                    'unit'       => '%'
                ],
                'tablet_default' => [
                    'unit'       => '%'
                ],
                'mobile_default' => [
                    'unit'       => '%',
                ],
                'size_units'     => [ '%', 'px', 'vw' ],
                'range'          => [
                    '%'          => [
                        'min'    => 1,
                        'max'    => 100
                    ],
                    'px'         => [
                        'min'    => 1,
                        'max'    => 1000
                    ],
                    'vw'         => [
                        'min'    => 1,
                        'max'    => 100
                    ]
                ],
                'selectors'      => [
                    '{{WRAPPER}} .edublink-lottie-animation-wrapper svg' => 'max-width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'separator_panel_style',
            [
                'type'  => Controls_Manager::DIVIDER,
                'style' => 'thick'
            ]
        );

        $this->start_controls_tabs( 'image_effects' );

            $this->start_controls_tab( 'normal', [ 'label' => __( 'Normal', 'edublink-core' ) ] );

            $this->add_control(
                'opacity',
                [
                    'label'           => __( 'Opacity', 'edublink-core' ),
                    'type'            => Controls_Manager::SLIDER,
                    'range'           => [
                        'px'          => [
                            'max'     => 1,
                            'min'     => 0.10,
                            'step'    => 0.01
                        ]
                    ],
                    'selectors'       => [
                        '{{WRAPPER}} .edublink-lottie-animation-wrapper svg' => 'opacity: {{SIZE}};'
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Css_Filter::get_type(),
                [
                    'name'     => 'css_filters',
                    'selector' => '{{WRAPPER}} .edublink-lottie-animation-wrapper svg'
                ]
            );

            $this->end_controls_tab();

            $this->start_controls_tab( 'hover', [ 'label' => __( 'Hover', 'edublink-core' ) ] );

            $this->add_control(
                'opacity_hover',
                [
                    'label'           => __( 'Opacity', 'edublink-core' ),
                    'type'            => Controls_Manager::SLIDER,
                    'range'           => [
                        'px'          => [
                            'max'     => 1,
                            'min'     => 0.10,
                            'step'    => 0.01
                        ]
                    ],
                    'selectors'       => [
                        '{{WRAPPER}} .edublink-lottie-animation-wrapper:hover svg' => 'opacity: {{SIZE}};'
                    ]
                ]
            );

            $this->add_group_control(
                Group_Control_Css_Filter::get_type(),
                [
                    'name'     => 'css_filters_hover',
                    'selector' => '{{WRAPPER}} .edublink-lottie-animation-wrapper:hover svg'
                ]
            );

            $this->add_control(
                'background_hover_transition',
                [
                    'label'           => __( 'Transition Duration', 'edublink-core' ),
                    'type'            => Controls_Manager::SLIDER,
                    'range'           => [
                        'px'          => [
                            'max'     => 3,
                            'step'    => 0.1
                        ]
                    ],
                    'selectors'       => [
                        '{{WRAPPER}} .edublink-lottie-animation-wrapper svg' => 'transition-duration: {{SIZE}}s'
                    ]
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
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 
            'container', 
            [ 
                'class'         => 'edublink-lottie-animation-wrapper',
                'data-source'   => esc_attr( $settings['source'] ),
                'data-renderer' => esc_attr( $settings['renderer'] ),
                'data-trigger'  => esc_attr( $settings['trigger'] )
            ]
        );

        if ( isset( $settings['speed'] ) ) :
            $this->add_render_attribute( 'container', 'data-speed', esc_attr( $settings['speed']['size'] ) );
        endif;

        if ( 'yes' === $settings['loop'] ) :
            $this->add_render_attribute( 'container', 'data-loop', 'true' );
        else :
            $this->add_render_attribute( 'container', 'data-loop', 'false' );
        endif;

        if ( 'yes' === $settings['reverse_animation'] ) :
            $this->add_render_attribute( 'container', 'data-reverse', 'true' );
        else :
            $this->add_render_attribute( 'container', 'data-reverse', 'false' );
        endif;
        
        if ( 'media-file' === $settings['source'] ) :
            $this->add_render_attribute( 'container', 'data-json', esc_url( $settings['source_json']['url'] ) );
        elseif( 'external-url' === $settings['source'] ) :
            $this->add_render_attribute( 'container', 'data-external', esc_url( $settings['source_external_url']['url'] ) );
        endif;
        
        echo '<div ' . $this->get_render_attribute_string( 'container' ) . '></div>';
    }
}