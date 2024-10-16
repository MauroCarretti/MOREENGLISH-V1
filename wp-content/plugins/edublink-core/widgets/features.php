<?php

namespace EduBlinkCore\Widgets;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Icons_Manager;
use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for features.
 *
 * @since 1.0.0
 */
class Features extends Widget_Base {

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
        return 'edublink-features';
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
        return __( 'Features', 'edublink-core' );
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
        return 'edublink-elementor-icon eicon-flash';
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
		return [ 'vivus' ];
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
		return [ 'edublink', 'features', 'vivus', 'animation', 'svg animation', 'path animation' ];
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
            'section_features',
            [
                'label' => __( 'Features', 'edublink-core' )
            ]
        );

        $this->add_control(
            'style',
            [
                'label'       => __( 'Style', 'edublink-core' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => '1',
                'options'     => [
                    '1'       => __( 'Style 1', 'edublink-core' ),
                    '2'       => __( 'Style 2', 'edublink-core' ),
                    '3'       => __( 'Style 3', 'edublink-core' ),
                    '3-alter' => __( 'Style 3 Alter', 'edublink-core' ),
                    '4'       => __( 'Style 4', 'edublink-core' ),
                    '5'       => __( 'Style 5', 'edublink-core' ),
                    '6'       => __( 'Style 6', 'edublink-core' )
                ]
            ]
        );

        $this->add_control(
            'title', 
            [
                'label'       => __( 'Title', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => __( 'The Title', 'edublink-core' )
            ]
        );

        $this->add_control(
            'details', 
            [
                'label'       => __( 'Details', 'edublink-core' ),
                'type'        => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default'     => __( 'Lorem ipsum dolor consec tur elit adicing sed umod tempor.', 'edublink-core' )
            ]
        );

        $this->add_control(
            'icon', 
            [
                'label'       => __( 'Icon', 'edublink-core' ),
                'type'        => Controls_Manager::ICONS,
                'default'     => [
                    'value'   => 'fas fa-star',
                    'library' => 'fa-solid'
                ],
                'condition'   => [
                    'style!'   => '4'
                ]
            ]
        );

        $this->add_control(
            'link',
            [
                'label'         => __( 'Link', 'edublink-core' ),
                'type'          => Controls_Manager::URL,
                'show_external' => true,
                'placeholder'   => __( 'https://your-link.com', 'edublink-core' )
            ]
        );

        $this->add_control(
            'image',
            [
                'type'      => Controls_Manager::MEDIA,
                'condition' => [
                    'style' => '6'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'thumbnail',
                'default'   => 'full',
                'condition' => [
                    'image[url]!' => '',
                    'style'       => '6'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section( 
			'svg_animate_section', 
			[
				'label' => __( 'Icon SVG Animate', 'edublink-core' ),
                'condition' => [
					'icon[library]' => 'svg',
					'style!'   => '4'
				]
			] 
		);

		$this->add_control( 
            'svg_animate_alert', 
			[
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-control-field-description',
				'raw'             => sprintf( __( 'Note: Animate works only with Stroke SVG Icon. For more information please visit <a href="%s" target="_blank" rel="noopener">here</a>.', 'edublink-core' ), esc_url( $helpLink ) ),
				'separator'       => 'after'
			] 
		);

		$this->add_control( 
            'svg_animate', 
			[
				'label' => __( 'SVG Animate', 'edublink-core' ),
				'type'  => Controls_Manager::SWITCHER
			] 
		);

		$this->add_control( 
            'play_on_hover', 
			[
				'label' => __( 'Play on Hover', 'edublink-core' ),
				'type'  => Controls_Manager::SWITCHER
			] 
		);
		$this->add_control( 
            'play_on_hover_left', 
			[
				'label' => __( 'Play While Leaving Hover', 'edublink-core' ),
				'type'  => Controls_Manager::SWITCHER
			] 
		);

		$this->add_control( 
            'svg_animate_type', 
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

		$this->add_control( 
            'svg_animate_duration', 
			[
				'label'   => __( 'Transition Duration', 'edublink-core' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 150
			] 
		);

        $this->end_controls_section();

        $this->start_controls_section(
			'feature_style',
			[
				'label'	=> __( 'Styling', 'edublink-core' ),
				'tab'	=> Controls_Manager::TAB_STYLE
			]
		);	

        $this->add_control(
            'color_light',
            [
                'label'     => __( 'Color( Light )', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-feature-item .icon' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'color_dark',
            [
                'label'     => __( 'Color( Dark )', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-feature-item .icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .edublink-feature-item:hover .icon, {{WRAPPER}} .edublink-feature-2-widget .edublink-feature-item .icon:after' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .edublink-feature-item .icon svg path, {{WRAPPER}} .edublink-feature-item .icon svg circle, {{WRAPPER}} .edublink-feature-item .icon svg line' => 'stroke: {{VALUE}};'
                ],
                'condition' => [
                    'style!' => '3-alter'
                ]
            ]
        );

        $this->add_control(
            'color_dark_for_style_alter_3',
            [
                'label'     => __( 'Color( Dark ) for Style Alter 3', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-feature-item:hover .icon' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .edublink-feature-item .icon svg path' => 'fill: {{VALUE}};'
                ],
                'condition' => [
                    'style' => '3-alter'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label'        => __( 'Icon Size', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'size_units'   => [ 'px'],
                'range'        => [
                    'px'       => [
                        'min'  => 20,
                        'max'  => 200,
                        'step' => 2
                    ]
                ],
                'selectors'    => [
                    '{{WRAPPER}} .edublink-feature-item .icon' => 'font-size: {{SIZE}}{{UNIT}};'
                ],
                'condition' => [
					'icon[library]!' => 'svg',
                    'style!'   => '4'
				]
            ]
        );

        $this->add_responsive_control(
            'svg_size',
            [
                'label'        => __( 'SVG Width', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'size_units'   => [ 'px'],
                'range'        => [
                    'px'       => [
                        'min'  => 20,
                        'max'  => 200,
                        'step' => 2
                    ]
                ],
                'selectors'    => [
                    '{{WRAPPER}} .edublink-feature-item .icon svg' => 'max-width: {{SIZE}}{{UNIT}} !important;'
                ],
                'description' => __( 'Only applicable for SVG icons.', 'edublink-core' ),
                'condition' => [
					'icon[library]' => 'svg',
                    'style!'   => '4'
				]
            ]
        );

        $this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'icon_box_shadow',
				'selector' => '{{WRAPPER}} .edublink-feature-3-widget .edublink-feature-item .icon,{{WRAPPER}} .edublink-feature-3-alter-widget .edublink-feature-item .icon',
                'condition' => [
                    'style' => ['3', '3-alter']
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
        $image_url = '';

        $this->add_render_attribute( 'container', 'class', 'edublink-feature-' . esc_attr( $settings['style'] ) . '-widget' );

        if ( isset( $settings['icon']['library'] ) && 'svg' === $settings['icon']['library'] ) :
            if ( 'yes' === $settings['svg_animate'] ) :
                $this->add_render_attribute( 'container', 'class', 'edublink-svg-path-animation' );
                $vivus_settings = [
                    'enable'        => 'yes' === $settings['svg_animate'] ? 'enable' : 'disable',
                    'type'          => esc_attr( $settings['svg_animate_type'] ),
                    'duration'      => esc_attr( $settings['svg_animate_duration'] ),
                    'play_on_hover' => 'yes' === $settings['play_on_hover'] ? 'enable' : 'disable'
                ];

                $vivus_settings['hover_left'] = 'yes' === $settings['play_on_hover_left'] ? 'enable' : 'disable'; 

                $this->add_render_attribute( 'container', 'data-vivus', wp_json_encode( $vivus_settings ) );
            endif;
		endif;

        if ( '6' === $settings['style'] & ! empty( $settings['image'] ) ) :
            $image     = $settings['image'];
            $image_url = Group_Control_Image_Size::get_attachment_image_src( $image['id'], 'thumbnail', $settings );
            if ( empty( $image_url ) ) :
                $image_url = $image['url'];
            else :
                $image_url = $image_url;
            endif;
        endif;
        
        if( $settings['link']['url'] ) :
            $this->add_render_attribute( 'link', 'href', esc_url( $settings['link']['url'] ) );
	        if( $settings['link']['is_external'] ) :
	            $this->add_render_attribute( 'link', 'target', '_blank' );
            endif;
	        if( $settings['link']['nofollow'] ) :
	            $this->add_render_attribute( 'link', 'rel', 'nofollow' );
            endif;
        endif;

        echo '<div ' . $this->get_render_attribute_string( 'container' ) . '>';
            include EDUBLINK_PLUGIN_DIR . 'widgets/styles/features/feature-' . $settings['style'] . '.php';
        echo '</div>';
        
    }

    /**
     * Print The Icon
     *
     * @since 1.0.0
     *
     * @access protected
     */
    private function print_icon( array $settings ) {
        $this->add_render_attribute( 'icon', 'class', 'icon' );
		$is_svg = isset( $settings['icon']['library'] ) && 'svg' === $settings['icon']['library'] ? true : false;
		if ( $is_svg && 'yes' === $settings['svg_animate'] ) :
			$this->add_render_attribute( 'icon', 'class', 'edublink-svg-icon' );
		endif;
		
		echo '<div ' . $this->get_render_attribute_string( 'icon' ) . '>';
			Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
		echo '</div>';
	}
}