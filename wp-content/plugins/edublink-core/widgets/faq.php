<?php

namespace EduBlinkCore\Widgets;

use \EduBlinkCore\Helper;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Icons_Manager;
use \Elementor\Plugin;
use \Elementor\Repeater;
use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for FAQ.
 *
 * @since 1.0.0
 */
class FAQ extends Widget_Base {

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
		return 'edublink-faq';
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
		return __( 'FAQ', 'edublink-core' );
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
        return 'edublink-elementor-icon eicon-check-circle';
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
		return [ 'edublink', 'query', 'question', 'pre sale question', 'frequently asked questions' ];
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
            'section_faq',
            [
                'label' => __( 'FAQ', 'edublink-core' )
            ]
        );

        $this->add_control(
            'style',
            [
                'label'   => __( 'Style', 'edublink-core' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1'   => __( 'Style 1', 'edublink-core' ),
                    '2'   => __( 'Style 2', 'edublink-core' )
                ]
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title', 
            [
                'label'       => __( 'Title', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => __( 'FAQ Title', 'edublink-core' )
            ]
        );

        $repeater->add_control(
            'content_type',
            [
                'label'   => __( 'Content Type', 'edublink-core' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'content',
                'options' => [
                    'content'        => __( 'Content', 'edublink-core' ),
                    'saved-template' => __( 'Saved Template', 'edublink-core' ),
                    'shortcode'      => __( 'ShortCode', 'edublink-core' )
                ]
            ]
        );

        $repeater->add_control(
            'content', 
            [
                'label'       => __( 'Content', 'edublink-core' ),
                'type'        => Controls_Manager::WYSIWYG,
                'label_block' => true,
                'default'     => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'edublink-core' ),
                'condition'   => [
                    'content_type' => 'content'
                ]
            ]
        );

        $repeater->add_control(
            'saved_template',
            [
                'label'     => __( 'Select Section', 'edublink-core' ),
                'type'      => Controls_Manager::SELECT,
                'options'   => Helper::get_saved_template( 'section' ),
                'default'   => '-1',
                'condition' => [
                    'content_type' => 'saved-template'
                ]
            ]
        );

        $repeater->add_control(
            'shortcode',
            [
                'label'       => __( 'Enter your shortcode', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => __( '[gallery]', 'edublink-core' ),
                'condition'   => [
                    'content_type' => 'shortcode'
                ]
            ]
        );

        $this->add_control(
            'items',
            [
                'type'            => Controls_Manager::REPEATER,
                'fields'          => $repeater->get_controls(),
                'title_field'     => '{{title}}',
                'default'         => [
                    [ 'title'     => __( 'Title #1', 'edublink-core' ) ],
                    [ 
                        'title'   => __( 'Title #2', 'edublink-core' ) ,
                        'content' => __( 'The placeholder text, beginning with the line “Lorem ipsum dolor sit amet, consectetur adipiscing elit”, looks like Latin because in its youth, centuries ago, it was Latin.', 'edublink-core' ) 
                    ]
                ]
            ]
        );

        $this->end_controls_section();

  		$this->start_controls_section(
            'section_faq_heading',
            [
                'label' => __( 'Heading', 'edublink-core' )
            ]
        );

        $this->add_control(
            'pre_heading',
            [
                'label'       => __( 'Pre Heading', 'edublink-core' ),
                'type'        => Controls_Manager::TEXTAREA,
                'label_block' => true
            ]
        );

        $this->add_control(
            'heading',
            [
                'label'       => __( 'Heading', 'edublink-core' ),
                'type'        => Controls_Manager::TEXTAREA,
                'label_block' => true
            ]
        );

        $this->add_control(
            'sub_heading',
            [
                'label'   => __( 'Sub Heading', 'edublink-core' ),
                'type'    => Controls_Manager::WYSIWYG
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

        $this->end_controls_section();

        $this->start_controls_section(
            'faq_title_style',
            [
                'label'      => __( 'FAQ Title', 'edublink-core' ),
                'tab'        => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'faq_title_spacing',
            [
                'label'       => __( 'Spacing', 'edublink-core' ),
                'type'        => Controls_Manager::SLIDER,        
                'selectors'   => [
                    '{{WRAPPER}} .eb-faq-heading-wrapper' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'faq_content_style',
            [
                'label'      => __( 'FAQ Content', 'edublink-core' ),
                'tab'        => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'faq_content_typography',
                'selector' => '{{WRAPPER}} .eb-faqs-content-wrapper .eb-faq-content'
            ]
        );

        $this->add_control(
          'faq_content_color',
            [
                'label'     => __( 'Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .eb-faqs-content-wrapper .eb-faq-content' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'faq_content_margin',
            [
                'label'        => __( 'Margin', 'edublink-core' ),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => [ 'px', '%', 'em' ],
                'selectors'    => [
                    '{{WRAPPER}} .eb-faqs-content-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
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
		$settings = $this->get_settings_for_display();
        $items    = $settings['items'];
        $this->add_render_attribute( 'container', 'class', 'eb-faq-wrapper eb-faq-style-' . esc_attr( $settings['style'] ) );
        $left_column = 1 == $settings['style'] ? 'edublink-col-lg-6' : 'edublink-col-lg-4';
        $right_column = 1 == $settings['style'] ? 'edublink-col-lg-6' : 'edublink-col-lg-8';

        echo '<div ' . $this->get_render_attribute_string( 'container' ) . '>';        
            echo '<div class="edublink-row">';
                echo '<div class="' . esc_attr( $left_column ) . '">';
                    echo '<div class="eb-faq-left-side">';
                        if ( $settings['pre_heading'] || $settings['heading'] || $settings['sub_heading'] ) :
                            echo '<div class="edublink-section-heading">';
                                echo $settings['pre_heading'] ? '<span class="pre-heading edublink-color-secondary">' . esc_html( $settings['pre_heading'] ) . '</span>' : '';

                                if ( $settings['heading'] ) :
                                    echo '<h3 class="heading">' . wp_kses_post( $settings['heading'] ) . '</h3>';
                                    if ( 'yes' === $settings['enable_shape_icon'] && ! empty( $settings['shape_icon']['value'] ) ) :
                                        echo '<div class="title-shape">';
                                            Icons_Manager::render_icon( $settings['shape_icon'] );
                                        echo '</div>';
                                    endif;
                                endif;
                                
                                if ( ! empty( $settings['sub_heading'] ) ) :
                                    echo '<div class="sub-heading">';
                                        echo wp_kses_post( $settings['sub_heading']);
                                    echo '</div>';
                                endif;
                            echo '</div>';
                        endif;

                        echo '<ul class="eb-faq-heading-wrapper">';
                            foreach ( $items as $key => $item ) :
                                echo '<li class="eb-faq-title">';
                                    echo '<span class="eb-faq-title-heading">' . wp_kses_post( $item['title'] ) . '</span>';
                                echo '</li>';
                            endforeach;
                        echo '</ul>';
                    echo '</div>';
                echo '</div>';

                echo '<div class="' . esc_attr( $right_column ) . '">';
                    echo '<div class="eb-faqs-content-wrapper">';
                        foreach ( $items as $key => $item ) :
                            echo '<div class="eb-faq-content edublink-fade">';
                                if ( 'saved-template' === $item['content_type'] ) :
                                    echo Plugin::$instance->frontend->get_builder_content_for_display( wp_kses_post( $item['saved_template'] ) );
                                elseif ( 'shortcode' === $item['content_type'] ) :
                                    echo do_shortcode( $item['shortcode'] );
                                else :
                                    echo wp_kses_post( $item['content'] );
                                endif;
                            echo '</div>';
                        endforeach;
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }
}