<?php

namespace EduBlinkCore\Widgets;

use \EduBlinkCore\Helper;
use \Elementor\Controls_Manager;
use \Elementor\Plugin;
use \Elementor\Repeater;
use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for Tabs.
 *
 * @since 1.0.0
 */
class Tabs extends Widget_Base {
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
        return 'edublink-tabs';
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
        return __( 'Tabs', 'edublink-core' );
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
        return 'edublink-elementor-icon eicon-tabs';
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
        return [ 'edublink', 'tabs' ];
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
            'section_tabs',
            [
                'label' => __( 'Tabs', 'edublink-core' )
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
                'default'     => __( 'Tab Title', 'edublink-core' )
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
                    [ 'title'     => __( 'Tab #1', 'edublink-core' ) ],
                    [ 
                        'title'   => __( 'Tab #2', 'edublink-core' ) ,
                        'content' => __( 'The placeholder text, beginning with the line “Lorem ipsum dolor sit amet, consectetur adipiscing elit”, looks like Latin because in its youth, centuries ago, it was Latin.', 'edublink-core' ) 
                    ]
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'title_style',
            [
                'label'     => __( 'Title', 'edublink-core' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'title_alignment',
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
                    '{{WRAPPER}} .eb-tabs-title-wrapper' => 'justify-content: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label'        => __( 'Spacing', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => -15,
                        'max'  => 500,
                        'step' => 1
                    ]
                ],
                'selectors'    => [
                    '{{WRAPPER}} .eb-tabs-title-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'content_style',
            [
                'label'     => __( 'Content', 'edublink-core' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label'        => __( 'Margin', 'edublink-core' ),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => [ 'px', 'em', '%' ],
                'selectors'    => [
                    '{{WRAPPER}} .eb-tabs-content-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
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
        $settings  = $this->get_settings_for_display();
        $items     = $settings['items'];
        $this->add_render_attribute( 'container', 'class', 'eb-tabs-wrapper eb-tabs-style-' . esc_attr( $settings['style'] ) );

        if ( is_array( $items ) ) :
            echo '<div ' . $this->get_render_attribute_string( 'container' ) . '>';
                echo '<ul class="eb-tabs-title-wrapper">';
                    foreach ( $items as $key => $item ) :
                        echo '<li class="eb-tab-title">';
                            echo '<span class="eb-tab-title-heading">' . wp_kses_post( $item['title'] ) . '</span>';
                        echo '</li>';
                    endforeach;
                echo '</ul>';

                echo '<div class="eb-tabs-content-wrapper">';
                    foreach ( $items as $key => $item ) :
                        echo '<div class="eb-tab-content edublink-fade">';
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
        endif;
    }
}