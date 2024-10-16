<?php
namespace EduBlinkCore\Widgets;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for animated text.
 *
 * @since 1.0.0
 */
class Animated_Text extends Widget_Base {

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
		return 'edublink-animated-text';
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
		return __( 'Animated Text', 'edublink-core' );
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
        return 'edublink-elementor-icon eicon-animation-text';
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
		return [ 'typed-js' ];
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
		return [ 'edublink', 'animated', 'animation', 'text', 'headline', 'heading', 'title' ];
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
        $primary_color = edublink_set_value( 'primary_color', '#1ab69d' );
        $this->start_controls_section(
            'section_animatd_text',
            [
                'label' => __( 'Content', 'edublink-core' )
            ]
        );
        
        $this->add_control(
            'before_text',
            [
                'label'   => __( 'Before Text', 'edublink-core' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => __( 'DevsBlink Brings', 'edublink-core' )
            ]
        );

        $this->add_control(
            'animated_text',
            [
                'label'       => __( 'Animated Text', 'edublink-core' ),
                'type'        => Controls_Manager::TEXTAREA,
                'placeholder' => __( 'Enter your animated text with comma separated.', 'edublink-core' ),
                'description' => __( '<b>Enter animated text with comma separated. Example: EduBlink, LMS, Theme</b>', 'edublink-core' ),
                'default'     => __( 'EduBlink, LMS, Theme', 'edublink-core' )
            ]
        );
        
        $this->add_control(
            'after_text',
            [
                'label'   => __( 'After Text', 'edublink-core' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => __( 'For You.', 'edublink-core' )
            ]
        );

        $this->add_control(
            'link',
            [
                'label'      => __( 'Link', 'edublink-core' ),
                'type'       => Controls_Manager::URL,
                'dynamic'    => [
                    'active' => true
                ]
            ]
        );

        $this->add_control(
            'tag',
            [
                'label'    => __( 'HTML Tag', 'edublink-core' ),
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
                    '{{WRAPPER}} .edublink-animated-text-wrapper' => 'justify-content: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'settings_animatd_text',
            [
                'label' => __( 'Settings', 'edublink-core' )
            ]
        );

        $this->add_control(
            'speed',
            [
                'label'       => __( 'Type Speed', 'edublink-core' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 40,
                'min'         => 0,
                'max'         => 100,
                'step'        => 5,
                'description' => __( 'Type speed in milliseconds.', 'edublink-core' )
            ]
        );

        $this->add_control(
            'back_speed',
            [
                'label'       => __( 'Back Type Speed', 'edublink-core' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 20,
                'min'         => 0,
                'max'         => 100,
                'step'        => 5,
                'description' => __( 'Backspacing speed in milliseconds.', 'edublink-core' )
            ]
        );

        $this->add_control(
            'start_delay',
            [
                'label'       => __( 'Start Delay', 'edublink-core' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 0,
                'min'         => 0,
                'max'         => 10000,
                'step'        => 5,
                'description' => __( 'Time before typing starts in milliseconds.', 'edublink-core' )
            ]
        );

        $this->add_control(
            'back_delay',
            [
                'label'     => __( 'Back Delay', 'edublink-core' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 700,
                'min'       => 100,
                'max'       => 10000,
                'step'      => 5,
                'description' => __( 'Time before backspacing in milliseconds.', 'edublink-core' )
            ]
        );

        $this->add_control(
            'loop',
            [
                'label'        => __( 'Loop', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'return_value' => 'yes',
                'default'      => 'yes'
            ]
        );

        $this->add_control(
            'smart_backspace',
            [
                'label'        => __( 'Smart Backspace', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'return_value' => 'yes',
                'default'      => 'yes'
            ]
        );

        $this->add_control(
            'shuffle',
            [
                'label'        => __( 'Shuffle', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'return_value' => 'yes',
                'default'      => 'no'
            ]
        );

        $this->add_control(
            'fade_out',
            [
                'label'        => __( 'Fade Out', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'return_value' => 'yes',
                'default'      => 'no'
            ]
        );

        $this->add_control(
            'fade_out_delay',
            [
                'label'        => __( 'Fade Out Delay', 'edublink-core' ),
                'type'         => Controls_Manager::NUMBER,
                'default'      => 500,
                'min'          => 0,
                'max'          => 10000,
                'step'         => 5,
                'description'  => __( 'Fade out delay in milliseconds.', 'edublink-core' ),
                'condition'    => [
                    'fade_out' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'cursor',
            [
                'label'        => __( 'Cursor', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'return_value' => 'yes',
                'default'      => 'yes'
            ]
        );

        $this->add_control(
            'cursor_char',
            [
                'label'      => __( 'Character For Cursor', 'edublink-core' ),
                'type'       => Controls_Manager::TEXT,
                'default'    => __( '|', 'edublink-core' ),
                'condition'  => [
                    'cursor' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'before_text_style',
            [
                'label'     => __( 'Before Text', 'edublink-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'before_text!' => ''
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'before_text_typography',
                'selector' => '{{WRAPPER}} .edublink-animated-text-before-content'
            ]
        );

        $this->add_control(
            'before_text_color',
            [
                'label'     => __( 'Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-animated-text-before-content' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'animated_text_style',
            [
                'label'     => __( 'Animated Text', 'edublink-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'animated_text!' => ''
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'animated_text_typography',
                'selector' => '{{WRAPPER}} .edublink-animated-text, {{WRAPPER}} .typed-cursor'
            ]
        );

        $this->add_control(
            'animated_text_color',
            [
                'label'     => __( 'Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} .edublink-animated-text, {{WRAPPER}} .typed-cursor' => 'color: {{VALUE}}'
                ]
            ]
        );

        $this->add_responsive_control(
            'animated_text_inner_spacing',
            [
                'label'        => __( 'Inner Spacing( Left and Right )', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'size_units'   => [ 'px'],
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 30,
                        'step' => 2
                    ]
                ],
                'default'      => [
                    'unit'     => 'px',
                    'size'     => 5
                ],
                'selectors'    => [
                    '{{WRAPPER}} .edublink-animated-text' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'cursor_style',
            [
                'label'     => __( 'Cursor', 'edublink-core' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'cursor'       => 'yes',
                    'cursor_char!' => ''
                ]
            ]
        );

        $this->add_control(
            'cursor_color',
            [
                'label'     => __( 'Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-animated-text-wrapper .typed-cursor' => 'color: {{VALUE}}'
                ],
                'condition' => [
                    'cursor'       => 'yes',
                    'cursor_char!' => ''
                ]
            ]
        );

        $this->add_responsive_control(
            'cursor_size',
            [
                'label'      => __( 'Size', 'edublink-core' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px'],
                'selectors'  => [
                    '{{WRAPPER}} .edublink-animated-text-wrapper .typed-cursor' => 'font-size: {{SIZE}}{{UNIT}};'
                ],
                'condition'  => [
                    'cursor'       => 'yes',
                    'cursor_char!' => ''
                ]
            ]
        );

        $spacing = is_rtl() ? 'left' : 'right';
        $this->add_responsive_control(
            'cursor_spacing',
            [
                'label'        => __( 'Spacing', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'size_units'   => [ 'px'],
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 30,
                        'step' => 2
                    ]
                ],
                'default'      => [
                    'unit'     => 'px',
                    'size'     => 5
                ],
                'selectors'    => [
                    '{{WRAPPER}} .edublink-animated-text-wrapper .typed-cursor' => 'margin-' . $spacing . ': {{SIZE}}{{UNIT}};'
                ],
                'condition'    => [
                    'cursor'       => 'yes',
                    'cursor_char!' => ''
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'after_text_style',
            [
                'label'     => __( 'After Text', 'edublink-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'after_text!' => ''
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'after_text_typography',
                'selector' => '{{WRAPPER}} .edublink-animated-text-after-content'
            ]
        );

        $this->add_control(
            'after_text_color',
            [
                'label'     => __( 'Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-animated-text-after-content' => 'color: {{VALUE}}'
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
        $heading  = explode( ', ', $settings['animated_text'] );

        $this->add_render_attribute( 'animated-text',
            [
                'id'                   => 'edublink-animated-text-' . esc_attr( $this->get_id() ),
                'class'                => 'edublink-animated-text',
                'data-animated-text'   => esc_attr( json_encode( $heading ) ),
                'data-speed'           => esc_attr( $settings['speed'] ),
                'data-back-speed'      => esc_attr( $settings['back_speed'] ),
                'data-start-delay'     => esc_attr( $settings['start_delay'] ),
                'data-back-delay'      => esc_attr( $settings['back_delay'] ),
                'data-loop'            => esc_attr( $settings['loop'] ),
                'data-smart-backspace' => esc_attr( $settings['smart_backspace'] ),
                'data-shuffle'         => esc_attr( $settings['shuffle'] ),
                'data-fade-out'        => esc_attr( $settings['fade_out'] ),
                'data-cursor'          => esc_attr( $settings['cursor'] )
            ]
        );

        if ( 'yes' === $settings['fade_out'] ) :
            $this->add_render_attribute( 'animated-text', 'data-fade-out-delay', esc_attr( $settings['fade_out_delay'] ) );
        endif;

        if ( 'yes' === $settings['cursor'] ) :
            $this->add_render_attribute( 'animated-text', 'data-cursor-char', esc_attr( $settings['cursor_char'] ) );
        endif;

        if ( ! empty( $settings['link']['url'] ) ) :
            $this->add_render_attribute( 'url', 'href', esc_url( $settings['link']['url'] ) );
            if ( $settings['link']['is_external'] ) :
                $this->add_render_attribute( 'url', 'target', '_blank' );
            endif;
            if ( $settings['link']['nofollow'] ) :
                $this->add_render_attribute( 'url', 'rel', 'nofollow' );
            endif;
            echo '<a ' . $this->get_render_attribute_string( 'url' ) . '>';
        endif;

        echo '<' . esc_attr( $settings['tag'] ) . ' class="edublink-animated-text-wrapper">';
            echo $settings['before_text'] ? '<span class="edublink-animated-text-before-content">' . wp_kses_post( $settings['before_text'] ) . '</span>' : '';
            echo '<span ' . $this->get_render_attribute_string( 'animated-text' ) . '></span>';
            echo $settings['after_text'] ? '<span class="edublink-animated-text-after-content">' . wp_kses_post( $settings['after_text'] ) . '</span>' : '';
        echo '</' . esc_attr( $settings['tag'] ) . '>';

        if ( ! empty( $settings['link']['url'] ) ) :
            echo '</a>';
        endif;
    }
}