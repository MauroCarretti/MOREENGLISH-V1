<?php

namespace EduBlinkCore\Widgets;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Icons_Manager;
use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for Heading.
 *
 * @since 1.0.0
 */
class Heading extends Widget_Base {

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
		return 'edublink-heading';
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
		return __( 'Heading', 'edublink-core' );
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
        return 'edublink-elementor-icon eicon-heading';
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
		return [ 'edublink', 'section title', 'title', 'heading' ];
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
        $primary_color = edublink_set_value( 'primary_color', '#525FE1' );

        $this->start_controls_section(
            'heading_title',
            [
                'label' => __( 'Content', 'edublink-core' )
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label'          => __( 'Alignment', 'edublink-core' ),
                'type'           => Controls_Manager::CHOOSE,
                'toggle'         => true,
                'label_block'    => false,
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
                    '{{WRAPPER}} .edublink-section-heading' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'pre_heading',
            [
                'label'       => __( 'Pre Heading', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => __( 'PRE HEADING' , 'edublink-core' )
            ]
        );

        $this->add_control(
            'heading',
            [
                'label'       => __( 'Heading', 'edublink-core' ),
                'type'        => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default'     => __( 'Add Your Section Heading Text' , 'edublink-core' ),
                'description'  => __( 'Wrap any words with <strong>mark</strong> tag to make them highlight. ).', 'edublink-core' )
            ]
        );

        $this->add_control(
            'tag',
            [
                'label'    => __( 'Title HTML Tag', 'edublink-core' ),
                'type'     => Controls_Manager::SELECT,
                'default'  => 'h3',
                'options'  => [
                    'h1'   => 'H1',
                    'h2'   => 'H2',
                    'h3'   => 'H3',
                    'h4'   => 'H4',
                    'h5'   => 'H5',
                    'h6'   => 'H6',
                    'div'  => 'div',
                    'span' => 'span',
                    'p'    => 'p'
                ]
            ]
        );

        $this->add_control(
            'enable_shape_icon',
            [
                'label'        => __( 'Shape', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'shape_icon',
            [
                'label'   => __( 'Icon', 'edublink-core' ),
                'type'    => Controls_Manager::ICONS,
                'default'     => [
                    'value'   => 'icon-19',
                    'library' => 'edublink-custom-icons'
                ],
                'condition'    => [
                    'enable_shape_icon' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'sub_heading',
            [
                'label'   => __( 'Sub Heading', 'edublink-core' ),
                'type'    => Controls_Manager::WYSIWYG
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'pre_heading_style',
            [
                'label'      => __( 'Pre Heading', 'edublink-core' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'condition'  => [
                    'pre_heading!' => ''
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'pre_heading_typography',
                'selector' => '{{WRAPPER}} .edublink-section-heading .pre-heading'
            ]
        );

        $this->add_control(
          'pre_heading_color',
            [
                'label'     => __( 'Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-section-heading .pre-heading' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'heading_style',
            [
                'label'      => __( 'Heading', 'edublink-core' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'condition'  => [
                    'heading!' => ''
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'heading_typography',
                'selector' => '{{WRAPPER}} .edublink-section-heading .heading'
            ]
        );

        $this->add_control(
          'heading_color',
            [
                'label'     => __( 'Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-section-heading .heading' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
          'mark_heading_color',
            [
                'label'     => __( 'Mark Tag Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-section-heading .heading mark' => 'color: {{VALUE}};'
                ],
                'description'  => __( 'This style will only effect on the <strong>mark</strong> tag.', 'edublink-core' )
            ]
        );

        $this->add_responsive_control(
            'heading_spacing',
            [
                'label'       => __( 'Spacing', 'edublink-core' ),
                'type'        => Controls_Manager::SLIDER,        
                'selectors'   => [
                    '{{WRAPPER}} .edublink-section-heading .heading' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'sub_heading_style',
            [
                'label'      => __( 'Sub Heading', 'edublink-core' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'condition'  => [
                    'sub_heading!' => ''
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'sub_heading_typography',
                'selector' => '{{WRAPPER}} .edublink-section-heading .sub-heading, {{WRAPPER}} .edublink-section-heading p'
            ]
        );

        $this->add_control(
          'sub_heading_color',
            [
                'label'     => __( 'Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-section-heading .sub-heading, {{WRAPPER}} .edublink-section-heading p' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'sub_heading_spacing',
            [
                'label'       => __( 'Spacing', 'edublink-core' ),
                'type'        => Controls_Manager::SLIDER,        
                'selectors'   => [
                    '{{WRAPPER}} .edublink-section-heading .sub-heading' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'shape_icon_style',
            [
                'label'      => __( 'Shape Icon', 'edublink-core' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'condition'   => [
                    'enable_shape_icon' => 'yes',
                    'shape_icon[value]!' => ''
                ]
            ]
        );

        $this->add_control(
            'shape_icon_color',
              [
                  'label'     => __( 'Color', 'edublink-core' ),
                  'type'      => Controls_Manager::COLOR,
                  'selectors' => [
                      '{{WRAPPER}} .edublink-section-heading .title-shape' => 'color: {{VALUE}};'
                  ]
              ]
          );

        $this->add_responsive_control(
            'shape_icon_spacing',
            [
                'label'       => __( 'Spacing', 'edublink-core' ),
                'type'        => Controls_Manager::SLIDER,        
                'selectors'   => [
                    '{{WRAPPER}} .edublink-section-heading .title-shape' => 'margin-top: {{SIZE}}{{UNIT}};'
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
        $settings     = $this->get_settings_for_display();
        $this->add_render_attribute( 'wrapper', 'class', 'edublink-section-heading' );

        echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) . '>';
            echo $settings['pre_heading'] ? '<span class="pre-heading">' . wp_kses_post( $settings['pre_heading'] ) . '</span>' : '';
            echo $settings['heading'] ? '<' . esc_attr( $settings['tag'] ) . ' class="heading">' . wp_kses_post( $settings['heading'] ) . '</' . esc_attr( $settings['tag'] ) . '>' : '';
            
            if ( 'yes' === $settings['enable_shape_icon'] && ! empty( $settings['shape_icon']['value'] ) ) :
                echo '<div class="title-shape">';
                    Icons_Manager::render_icon( $settings['shape_icon'] );
                echo '</div>';
            endif;

            if ( ! empty( $settings['sub_heading'] ) ) :
                echo '<div class="sub-heading">';
                    echo wp_kses_post( $settings['sub_heading']);
                echo '</div>';
            endif;
        echo '</div>';
    }
}