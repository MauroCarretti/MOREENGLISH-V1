<?php
namespace EduBlinkCore\Widgets;
use \Elementor\Controls_Manager;
use \Elementor\Icons_Manager;
use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for animated text.
 *
 * @since 1.0.0
 */

class SVG_Animation extends Widget_Base {
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
		return 'edublink-svg-animation';
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
		return __( 'SVG Animation', 'edublink-core' );
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
		return 'edublink-elementor-icon eicon-icon-box';
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
	public function get_keywords() {
		return [ 'edublink', 'animation', 'vivus', 'icon', 'svg animation', 'path animation' ];
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
		return [ 'vivus', 'jquery-waypoints' ];
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

		$helpLink = 'https://github.com/maxwellito/vivus#principles';

		$this->start_controls_section( 
			'section_svg_animation', 
			[
				'label' => __( 'Icon Box', 'edublink-core' )
			] 
		);

		$this->add_control( 'icon', 
			[
				'label'      => __( 'Icon', 'edublink-core' ),
				'show_label' => false,
				'type'       => Controls_Manager::ICONS,
				'default'    => [
					'value'   => 'fas fa-star',
					'library' => 'fa-solid'
				]
			] 
		);

		$this->end_controls_section();

		$this->start_controls_section( 
			'icon_svg_animate_section', 
			[
				'label'     => __( 'Icon SVG Animate', 'edublink-core' ),
				'condition' => [
					'icon[library]' => 'svg'
				]
			] 
		);

		$this->add_control( 'icon_svg_animate_alert', 
			[
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-control-field-description',
				'raw'             => sprintf( __( 'Note: Animate works only with Stroke SVG Icon. For more information please visit <a href="%s" target="_blank" rel="noopener">here</a>.', 'edublink-core' ), esc_url( $helpLink ) ),
				'separator'       => 'after'
			] 
		);

		$this->add_control( 'icon_svg_animate', 
			[
				'label' => __( 'SVG Animate', 'edublink-core' ),
				'type'  => Controls_Manager::SWITCHER
			] 
		);

		$this->add_control( 'icon_svg_animate_play_on_hover', 
			[
				'label' => __( 'Play on hover', 'edublink-core' ),
				'type'  => Controls_Manager::SWITCHER
			] 
		);
		$this->add_control( 'icon_svg_animate_play_on_hover_left', 
			[
				'label' => __( 'Play while leaving hover', 'edublink-core' ),
				'type'  => Controls_Manager::SWITCHER
			] 
		);

		$this->add_control( 'icon_svg_animate_type', 
			[
				'label'   => __( 'Type', 'edublink-core' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'delayed'  => __( 'Delayed', 'edublink-core' ),
					'sync'     => __( 'Sync', 'edublink-core' ),
					'oneByOne' => __( 'One By One', 'edublink-core' )
				],
				'default' => 'delayed'
			] 
		);

		$this->add_control( 'icon_svg_animate_duration', 
			[
				'label'   => __( 'Transition Duration', 'edublink-core' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 150
			] 
		);

		$this->end_controls_section();

		$this->start_controls_section(
            'icon_style',
            [
                'label'     => __( 'Icon', 'edublink-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
					'icon[library]' => 'svg'
				]
            ]
        );

        $this->add_responsive_control(
            'stroke_width',
            [
                'label'        => __( 'Stroke Width', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'step' => 1
                    ]
                ],
                'selectors'    => [
                    '{{WRAPPER}} .edublink-svg-animation-wrapper svg path' => 'stroke-width: {{SIZE}}'
                    
                ]
            ]
        );

        $this->add_control(
          'icon_stroke_color',
            [
                'label'     => __( 'Stroke Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-svg-animation-wrapper svg path' => 'stroke: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
          'icon_fill_color',
            [
                'label'     => __( 'Fill Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-svg-animation-wrapper svg path'   => 'fill: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
          'icon_stroke_hover_color',
            [
                'label'     => __( 'Stroke Color( Hover )', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-svg-animation-wrapper:hover svg path' => 'stroke: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
          'icon_fill_hover_color',
            [
                'label'     => __( 'Fill Color( Hover )', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-svg-animation-wrapper:hover svg path'   => 'fill: {{VALUE}};'
                ]
            ]
        );

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'box', 'class', 'edublink-svg-animation-wrapper' );

		if ( ! empty( $settings['icon_svg_animate'] ) && 'yes' === $settings['icon_svg_animate'] ) :
			$vivus_settings = [
				'enable'        => esc_attr( $settings['icon_svg_animate'] ),
				'type'          => esc_attr( $settings['icon_svg_animate_type'] ),
				'duration'      => esc_attr( $settings['icon_svg_animate_duration'] ),
				'play_on_hover' => esc_attr( $settings['icon_svg_animate_play_on_hover'] ),
			];
			$this->add_render_attribute( 'box', 'data-vivus', wp_json_encode( $vivus_settings ) );

			$enable_while_leaving = 'disable';
			if ( 'yes' === $settings['icon_svg_animate_play_on_hover_left'] ) :
				$enable_while_leaving = 'enable';
			endif;
			$this->add_render_attribute( 'box', 'data-hover-left', $enable_while_leaving );
		endif;
		
		echo '<div ' . $this->get_render_attribute_string( 'box' ) . '>';
			$this->print_icon( $settings );
		echo '</div>';
	}

	private function print_icon( array $settings ) {
		$is_svg = isset( $settings['icon']['library'] ) && 'svg' === $settings['icon']['library'] ? true : false;
		if ( $is_svg ) :
			$this->add_render_attribute( 'icon', 'class', 'edublink-icon-type-svg' );
		endif;
		
		echo '<div class="edublink-svg-icon">';
			Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
		echo '</div>';
	}
}