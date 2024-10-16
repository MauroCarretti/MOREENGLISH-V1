<?php
namespace EduBlinkCore\Widgets;
use \EduBlinkCore\Helper;
use \Elementor\Plugin;
use \Elementor\Controls_Manager;
use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for content switcher.
 *
 * @since 1.0.0
 */
class Content_Switcher extends Widget_Base {

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
		return 'edublink-content-switcher';
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
		return __( 'Content Switcher', 'edublink-core' );
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
        return 'edublink-elementor-icon eicon-kit-details';
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
		return [ 'edublink', 'toggle', 'tab', 'content', 'switcher' ];
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
            'section_content_switcher',
            [
                'label' => __( 'Content Switcher', 'edublink-core' )
            ]
        );

        $this->add_responsive_control(
            'control_alignment',
            [
                'label'          => __( 'Control Alignment', 'edublink-core' ),
                'type'           => Controls_Manager::CHOOSE,
                'options'        => [
                    'flex-start'       => [
                        'title'  => __( 'Left', 'edublink-core' ),
                        'icon'   => 'eicon-text-align-left'
                    ],
                    'center'     => [
                        'title'  => __( 'Center', 'edublink-core' ),
                        'icon'   => 'eicon-text-align-center'
                    ],
                    'flex-end'      => [
                        'title'  => __( 'Right', 'edublink-core' ),
                        'icon'   => 'eicon-text-align-right'
                    ]
                ],
                'selectors'      => [
                    '{{WRAPPER}} .eb-content-switcher-toggle-wrapper' => 'justify-content: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'spacing',
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
                'default'      => [
                    'unit'     => 'px',
                    'size'     => 35
                ],
                'selectors'    => [
                    '{{WRAPPER}} .eb-content-switcher-toggle-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->start_controls_tabs( 'content_switcher_tabs' );

            $this->start_controls_tab( 'primary_content_tab', [ 'label' => __( 'Primary', 'edublink-core' ) ] );

                $this->add_control(
                    'primary_content_heading',
                    [
                        'label'       => __( 'Heading', 'edublink-core' ),
                        'type'        => Controls_Manager::TEXT,
                        'label_block' => true,
                        'default'     => __( 'Primary Heading', 'edublink-core' )
                    ]
                );

                $this->add_control(
                    'primary_content_type',
                    [
                        'label'   => __( 'Content Type', 'edublink-core' ),
                        'type'    => Controls_Manager::SELECT,
                        'default' => 'content',
                        'options' => [
                            'content'        => __( 'Content', 'edublink-core' ),
                            'saved_template' => __( 'Saved Template', 'edublink-core' ),
                            'shortcode'      => __( 'ShortCode', 'edublink-core' )
                        ]
                    ]
                );

                $this->add_control(
                    'primary_content',
                    [
                        'label'       => __( 'Content', 'edublink-core' ),
                        'type'        => Controls_Manager::WYSIWYG,
                        'default'     => __( 'Primary content is written here.', 'edublink-core' ),
                        'placeholder' => __( 'Type your description here', 'edublink-core' ),
                        'condition'   => [
                            'primary_content_type' => 'content'
                        ]
                    ]
                );

                $this->add_control(
                    'primary_content_saved_template',
                    [
                        'label'     => __( 'Select Section', 'edublink-core' ),
                        'type'      => Controls_Manager::SELECT,
                        'options'   => Helper::get_saved_template( 'section' ),
                        'default'   => '-1',
                        'condition' => [
                            'primary_content_type' => 'saved_template'
                        ]
                    ]
                );

                $this->add_control(
                    'primary_content_shortcode',
                    [
                        'label'       => __( 'Enter your shortcode', 'edublink-core' ),
                        'type'        => Controls_Manager::TEXT,
                        'label_block' => true,
                        'placeholder' => __( '[gallery]', 'edublink-core' ),
                        'condition'   => [
                            'primary_content_type' => 'shortcode'
                        ]
                    ]
                );

            $this->end_controls_tab();

            $this->start_controls_tab( 'secondary_content_tab', [ 'label' => __('Secondary', 'edublink-core' ) ] );

                $this->add_control(
                    'secondary_content_heading',
                    [
                        'label'       => __( 'Heading', 'edublink-core' ),
                        'type'        => Controls_Manager::TEXT,
                        'label_block' => true,
                        'default'     => __( 'Secondary Heading', 'edublink-core' )
                    ]
                );

                $this->add_control(
                    'secondary_content_type',
                    [
                        'label'   => __( 'Content Type', 'edublink-core' ),
                        'type'    => Controls_Manager::SELECT,
                        'default' => 'content',
                        'options' => [
                            'content'        => __( 'Content', 'edublink-core' ),
                            'saved_template' => __( 'Saved Template', 'edublink-core' ),
                            'shortcode'      => __( 'ShortCode', 'edublink-core' )
                        ]
                    ]
                );

                $this->add_control(
                    'secondary_content',
                    [
                        'label'       => __( 'Content', 'edublink-core' ),
                        'type'        => Controls_Manager::WYSIWYG,
                        'default'     => __( 'Secondary content is written here.', 'edublink-core' ),
                        'placeholder' => __( 'Type your description here', 'edublink-core' ),
                        'condition'   => [
                            'secondary_content_type' => 'content'
                        ]
                    ]
                );

                $this->add_control(
                    'secondary_content_saved_template',
                    [
                        'label'     => __( 'Select Section', 'edublink-core' ),
                        'type'      => Controls_Manager::SELECT,
                        'options'   => Helper::get_saved_template( 'section' ),
                        'default'   => '-1',
                        'condition' => [
                            'secondary_content_type' => 'saved_template'
                        ]
                    ]
                );

                $this->add_control(
                    'secondary_content_shortcode',
                    [
                        'label'       => __( 'Enter your shortcode', 'edublink-core' ),
                        'type'        => Controls_Manager::TEXT,
                        'label_block' => true,
                        'placeholder' => __( '[gallery]', 'edublink-core' ),
                        'condition'   => [
                            'secondary_content_type' => 'shortcode'
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

        echo '<div class="eb-content-switcher-wrapper">';
            echo '<div class="eb-content-switcher-toggle-wrapper">';
                echo '<h5 class="eb-content-switcher-primary-toggle-heading">';
                    echo esc_html( $settings['primary_content_heading'] );
                echo '</h5>';

                echo '<div class="eb-content-switcher-toggle">';
                    echo '<label class="eb-content-switcher-toggle-label">';
                        echo '<input class="input" type="checkbox">';
                        echo '<span class="eb-content-switcher-ball"></span>';
                    echo '</label>';
                echo '</div>';

                echo '<h5 class="eb-content-switcher-secondary-toggle-heading">';
                    echo esc_html( $settings['secondary_content_heading'] );
                echo '</h5>';
            echo '</div>';

            echo '<div class="eb-content-switcher-content-wrapper">';
                echo '<div class="eb-primary-content-switcher">';
                    if( 'content' === $settings['primary_content_type'] ) :
                        echo wp_kses_post( $settings['primary_content'] );
                    elseif( 'saved_template' === $settings['primary_content_type'] ) :
                        echo Plugin::$instance->frontend->get_builder_content_for_display( wp_kses_post( $settings['primary_content_saved_template'] ) );
                    elseif ( 'shortcode' === $settings['primary_content_type'] ) :
                        echo do_shortcode( $settings['primary_content_shortcode'] );
                    endif;
                echo '</div>';

                echo '<div class="eb-secondary-content-switcher">';
                    if( 'content' === $settings['secondary_content_type'] ) :
                        echo wp_kses_post( $settings['secondary_content'] );
                    elseif( 'saved_template' === $settings['secondary_content_type'] ) :
                        echo Plugin::$instance->frontend->get_builder_content_for_display( wp_kses_post( $settings['secondary_content_saved_template'] ) );
                    elseif ( 'shortcode' === $settings['secondary_content_type'] ) :
                        echo do_shortcode( $settings['secondary_content_shortcode'] );
                    endif;
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }
}