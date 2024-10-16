<?php
namespace EduBlinkCore\Widgets;
use \Elementor\Controls_Manager;
use \Elementor\Control_Media;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Icons_Manager;
use \Elementor\Utils;
use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for icon box.
 *
 * @since 1.0.0
 */
class Image_Icon_Box extends Widget_Base {

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
		return 'edublink-icon-box';
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
		return __( 'Icon/Image Box', 'edublink-core' );
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
		return [ 'edublink', 'icon box', 'image box', 'image', 'icon', 'animation', 'svg animation', 'path animation' ];
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
        $left_spacing = is_rtl() ? '0' : '15';
        $right_spacing = is_rtl() ? '15' : '0';

        $this->start_controls_section(
            'section_icon_box',
            [
                'label' => __( 'Image/Icon Box', 'edublink-core' )
            ]
        );

        $this->add_control(
	        'icon_or_image',
	        [
				'label'         => __( 'Icon/Image', 'edublink-core' ),
				'type'          => Controls_Manager::CHOOSE,
				'toggle'        => false,
				'label_block'   => true,
				'default'       => 'img',
	            'options'       => [
					'icon'      => [
						'title' => __( 'Icon', 'edublink-core' ),
						'icon'  => 'eicon-info-circle'
					],
					'img'       => [
						'title' => __( 'Image', 'edublink-core' ),
						'icon'  => 'eicon-image-bold'
					]
				]
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
                    'icon_or_image' => 'icon'
                ]
            ]
        );

        $this->add_control(
	        'image',
	        [
				'type'      => Controls_Manager::MEDIA,
				'default'   => [
	                'url'   => Utils::get_placeholder_image_src()
	            ],
	            'condition' => [
	                'icon_or_image' => 'img'
	            ]
	        ]
	    );

        $this->add_control(
            'title',
            [
                'label'       => __( 'Title', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'This is the heading', 'edublink-core' ),
                'placeholder' => __( 'Enter your title', 'edublink-core' ),
                'label_block' => true
            ]
        );

        $this->add_control(
            'details',
            [
                'label'       => __( 'Details', 'edublink-core' ),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'edublink-core' ),
                'placeholder' => __( 'Enter your description', 'edublink-core' ),
                'rows'        => 10
            ]
        );

        $this->add_control(
            'link',
            [
                'label'       => __( 'Link', 'edublink-core' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => __( 'https://your-link.com', 'edublink-core' ),
                'separator'   => 'before'
            ]
        );

        $this->add_control(
            'position',
            [
                'label'          => __( 'Icon Position', 'edublink-core' ),
                'type'           => Controls_Manager::CHOOSE,
                'options'        => [
                    'left'       => [
                        'title'  => __( 'Left', 'edublink-core' ),
                        'icon'   => 'eicon-h-align-left'
                    ],
                    'top'        => [
                        'title'  => __( 'Top', 'edublink-core' ),
                        'icon'   => 'eicon-v-align-top'
                    ],
                    'right'      => [
                        'title'  => __( 'Right', 'edublink-core' ),
                        'icon'   => 'eicon-h-align-right'
                    ]
                ]
            ]
        );

        $this->add_control(
            'icon_position_vertical_on_mobile',
            [
                'label'        => __( 'Vertical On Mobile', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'no',
                'return_value' => 'yes',
                'condition'    => [
                    'position!' => 'top'
                ]
            ]
        );

        $this->add_control(
            'title_tag',
            [
                'label'    => __( 'Title HTML Tag', 'edublink-core' ),
                'type'     => Controls_Manager::SELECT,
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
                ],
                'default'  => 'h6'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section( 
			'svg_animate_section', 
			[
				'label' => __( 'Icon SVG Animate', 'edublink-core' ),
                'condition' => [
                    'icon_or_image' => 'icon',
					'icon[library]' => 'svg'
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
          'icon_style',
            [
                'label'     => __( 'Icon', 'edublink-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'icon_or_image' => 'icon',
                    'icon[value]!' => ''
                ]
            ]
        );

        $this->add_control(
            'icon_box',
            [
                'label'        => __( 'Icon Box', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'no',
                'return_value' => 'yes'
            ]
        );

        $this->add_responsive_control(
            'icon_box_size',
            [
                'label'        => __( 'Box Size', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 25,
                        'max'  => 1000
                    ]
                ],
                'default'      => [
                    'size'     => 150
                ],
                'selectors'    => [
                    '{{WRAPPER}} .edublink-icon-box-wrapper .edublink-icon-box-icon.edublink-icon-box-enable' => 'min-width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};'
                ],
                'condition'    => [
                    'icon_box' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_box_line_height',
            [
                'label'        => __( 'Icon Line Height', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 25,
                        'max'  => 1000
                    ]
                ],
                'selectors'    => [
                    '{{WRAPPER}} .edublink-icon-box-wrapper .edublink-icon-box-icon.edublink-icon-box-enable' => 'line-height: {{SIZE}}{{UNIT}} !important;'
                ],
                'condition'    => [
                    'icon_box' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label'       => __( 'Size', 'edublink-core' ),
                'type'        => Controls_Manager::SLIDER,
                'range'       => [
                    'px'      => [
                        'min' => 15,
                        'max' => 200
                    ]
                ],
                'default'     => [
                    'size'    => 30
                ],
                'selectors'   => [
                    '{{WRAPPER}} .edublink-icon-box-wrapper .edublink-icon-box-icon, {{WRAPPER}} .edublink-icon-box-wrapper .edublink-icon-box-icon i' => 'font-size: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
          'icon_color',
            [
                'label'     => __( 'Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-icon-box-wrapper .edublink-icon-box-icon i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .edublink-icon-box-wrapper .edublink-icon-box-icon svg' => 'fill: {{VALUE}};'
                ],
                'condition' => [
					'icon[library]!' => 'svg'
				]
            ]
        );

        $this->add_control(
          'icon_bg_color',
            [
                'label'     => __( 'Background Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-icon-box-wrapper .edublink-icon-box-icon.edublink-icon-box-enable' => 'background-color: {{VALUE}};'
                ],
                'condition'    => [
                    'icon_box' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_padding',
            [
                'label'      => __( 'Padding', 'edublink-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .edublink-icon-box-wrapper .edublink-icon-box-icon.edublink-icon-box-enable' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'condition'  => [
                    'icon_box' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_margin',
            [
                'label'        => __( 'Top Spacing', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => -200,
                        'max'  => 200
                    ]
                ],
                'selectors'    => [
                    '{{WRAPPER}} .edublink-icon-box-wrapper .edublink-icon-box-icon.edublink-icon-box-enable' => 'margin-top: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
                ],
                'condition'    => [
                    'icon_box' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'icon_border',
                'selector'  => '{{WRAPPER}} .edublink-icon-box-wrapper .edublink-icon-box-icon.edublink-icon-box-enable',
                'condition' => [
                    'icon_box' => 'yes'
                ]
            ]
        );
        
        $this->add_responsive_control(
          'icon_border_radius',
            [
                'label'      => __( 'Border Radius', 'edublink-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .edublink-icon-box-wrapper .edublink-icon-box-icon.edublink-icon-box-enable'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'condition'  => [
                    'icon_box' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'icon_box_shadow',
                'selector'  => '{{WRAPPER}} .edublink-icon-box-wrapper .edublink-icon-box-icon.edublink-icon-box-enable',
                'condition' => [
                    'icon_box' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'icon_hover_style',
            [
                'label'     => __( 'Hover Style( While Hover On Icon Box )', 'edublink-core' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition'  => [
                    'icon_box' => 'yes',
                    'icon[library]!' => 'svg'
                ]
            ]
        );

        $this->add_control(
            'icon_hover_color',
            [
                'label'     => __( 'Hover Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-edublink-icon-box:hover .edublink-icon-box-icon i' => 'color: {{VALUE}};'
                ],
                'condition'  => [
                    'icon_box' => 'yes',
                    'icon[library]!' => 'svg'
                ]
            ]
        );
  
        $this->add_control(
            'icon_hover_bg_color',
            [
                'label'     => __( 'Hover Background Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-edublink-icon-box:hover .edublink-icon-box-icon.edublink-icon-box-enable' => 'background-color: {{VALUE}};'
                ],
                'condition'    => [
                    'icon_box' => 'yes',
                    'icon[library]!' => 'svg'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'svg_icon_style',
            [
                'label'     => __( 'SVG Icon', 'edublink-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'icon_box' => 'yes',
                    'icon[library]' => 'svg'
                ]
            ]
        );

        $this->add_control(
            'svg_icon_color',
            [
                'label'     => __( 'Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-icon-box-icon svg path, {{WRAPPER}} .edublink-icon-box-icon svg circle, {{WRAPPER}} .edublink-icon-box-icon svg line' => 'stroke: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'svg_icon_color_while_hover_box',
            [
                'label'     => __( 'Color( When Hover Over Box )', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-icon-box-icon:hover svg path, {{WRAPPER}} .edublink-icon-box-icon:hover svg circle, {{WRAPPER}} .edublink-icon-box-icon:hover svg line' => 'stroke: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'svg_icon_path_color',
            [
                'label'     => __( 'Path Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-icon-box-icon svg path, {{WRAPPER}} .edublink-icon-box-icon svg circle, {{WRAPPER}} .edublink-icon-box-icon svg line' => 'fill: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'svg_icon_path_color_while_hover_box',
            [
                'label'     => __( 'Path Color( When Hover Over Box )', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-icon-box-icon:hover svg path, {{WRAPPER}} .edublink-icon-box-icon:hover svg circle, {{WRAPPER}} .edublink-icon-box-icon:hover svg line' => 'fill: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'svg_hover_bg_color',
            [
                'label'     => __( 'Path Background Color( When Hover Over Box )', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-edublink-icon-box:hover .edublink-icon-box-icon.edublink-icon-box-enable' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
          'image_style',
            [
                'label'     => __( 'Image', 'edublink-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'icon_or_image' => 'img',
                    'image[url]!'   => ''
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
				'name'      => 'img_size',
				'default'   => 'thumbnail',
				'condition' => [
					'icon_or_image'   => 'img',
                    'image[url]!' => ''
				]
            ]
        );

        $this->add_control(
            'image_box',
            [
                'label'        => __( 'Image Box', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'no',
                'return_value' => 'yes'
            ]
        );

        $this->add_responsive_control(
            'image_box_size',
            [
                'label'        => __( 'Box Size', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 25,
                        'max'  => 1000
                    ]
                ],
                'default'      => [
                    'size'     => 150
                ],
                'selectors'    => [
                    '{{WRAPPER}} .edublink-icon-box-wrapper .edublink-icon-box-icon.edublink-icon-box-enable' => 'min-width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
                ],
                'condition'    => [
                    'image_box' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'image_size',
            [
                'label'       => __( 'Size', 'edublink-core' ),
                'type'        => Controls_Manager::SLIDER,
                'selectors'   => [
                    '{{WRAPPER}} .edublink-icon-box-wrapper .edublink-icon-box-icon img' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'image_bg_color',
              [
                  'label'     => __( 'Background Color', 'edublink-core' ),
                  'type'      => Controls_Manager::COLOR,
                  'selectors' => [
                      '{{WRAPPER}} .edublink-icon-box-wrapper .edublink-icon-box-icon.edublink-icon-box-enable' => 'background-color: {{VALUE}};'
                  ],
                  'condition'    => [
                      'image_box' => 'yes'
                  ]
              ]
          );

        $this->add_responsive_control(
            'image_padding',
            [
                'label'      => __( 'Padding', 'edublink-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .edublink-icon-box-wrapper .edublink-icon-box-icon.edublink-icon-box-enable' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'condition'  => [
                    'image_box' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'image_border',
                'selector'  => '{{WRAPPER}} .edublink-icon-box-wrapper .edublink-icon-box-icon.edublink-icon-box-enable',
                'condition' => [
                    'image_box' => 'yes'
                ]
            ]
        );
        
        $this->add_responsive_control(
          'image_border_radius',
            [
                'label'      => __( 'Border Radius', 'edublink-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .edublink-icon-box-wrapper .edublink-icon-box-icon.edublink-icon-box-enable'=> 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'condition'  => [
                    'image_box' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'      => 'image_box_shadow',
                'selector'  => '{{WRAPPER}} .edublink-icon-box-wrapper .edublink-icon-box-icon.edublink-icon-box-enable',
                'condition' => [
                    'image_box' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_content',
            [
                'label' => __( 'Content', 'edublink-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'vertical_alignment',
            [
                'label'     => __( 'Vertical Alignment', 'edublink-core' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'flex-start',
                'options'   => [
                    'flex-start' => __( 'Top', 'elementor' ),
                    'center'     => __( 'Middle', 'elementor' ),
                    'flex-end'   => __( 'Bottom', 'elementor' )
                ],
                'selectors' => [
                    '{{WRAPPER}} .edublink-icon-box-wrapper' => 'align-items: {{VALUE}};'
                ],
                'condition' => [
                    'position!' => 'top'
                ]
            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label'        => __( 'Margin', 'edublink-core' ),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => [ 'px', '%', 'em' ],
                'default'      => [ 
                    'top'      => '0',
                    'right'    => $right_spacing,
                    'bottom'   => '0',
                    'left'     => $left_spacing,
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'    => [
                    '{{WRAPPER}} .edublink-icon-box-wrapper .edublink-icon-box-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'title_style',
            [
                'label'      => __( 'Title', 'edublink-core' ),
                'type'       => Controls_Manager::HEADING,
                'separator'  => 'before',
                'condition'  => [
                    'title!' => ''
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .edublink-icon-box-wrapper .edublink-icon-box-title'
            ]
        );

        $this->add_control(
          'title_color',
            [
                'label'     => __( 'Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-icon-box-wrapper .edublink-icon-box-title' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
          'title_hover_color',
            [
                'label'       => __( 'Hover Color', 'edublink-core' ),
                'type'        => Controls_Manager::COLOR,
                'description' => __( 'Only applicable if there is any link.', 'edublink-core' ),
                'selectors'   => [
                    '{{WRAPPER}} .edublink-icon-box-wrapper a:hover .edublink-icon-box-title' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => __( 'Margin', 'edublink-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .edublink-icon-box-wrapper .edublink-icon-box-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'description_style',
            [
                'label'      => __( 'Description', 'edublink-core' ),
                'type'       => Controls_Manager::HEADING,
                'separator'  => 'before',
                'condition'  => [
                    'details!' => ''
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'description_typography',
                'selector' => '{{WRAPPER}} .edublink-icon-box-wrapper .edublink-icon-box-content, {{WRAPPER}} .edublink-icon-box-wrapper .edublink-icon-box-content p',
                'condition'  => [
                    'details!' => ''
                ]
            ]
        );

        $this->add_control(
          'description_color',
            [
                'label'     => __( 'Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-icon-box-wrapper .edublink-icon-box-content, {{WRAPPER}} .edublink-icon-box-wrapper .edublink-icon-box-content p'   => 'color: {{VALUE}};',
                    'condition'  => [
                        'details!' => ''
                    ]
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

        $this->add_render_attribute(
            'container',
            [
                'class' => [
                    'edublink-icon-box-wrapper',
                    'edublink-icon-box-' . esc_attr( $settings['icon_or_image'] ),
                    'edublink-icon-box-icon-position-' . esc_attr( $settings['position'] )
                ]
            ]
        );

        if ( 'icon' === $settings['icon_or_image'] ) :
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
                    $this->add_render_attribute( 'icon', 'class', 'edublink-svg-icon' );
                endif;
            endif;
        endif;

        if ( 'top' !== $settings['position'] ) :
            if ( 'yes' === $settings['icon_position_vertical_on_mobile'] ) :
                $this->add_render_attribute( 'container', 'class', 'edublink-icon-box-vertical-on-mobile' );
            endif;
        endif;

        $icon_box = 'yes' === $settings['icon_box'] || $settings['image_box'] ? 'enable' : 'disable';
        $this->add_render_attribute( 'icon', 'class', 'edublink-icon-box-icon edublink-icon-box-' . esc_attr( $icon_box ) );

        echo '<div ' . $this->get_render_attribute_string( 'container' ) . '>';
            echo '<div ' . $this->get_render_attribute_string( 'icon' ) . '>';
                if ( 'icon' === $settings['icon_or_image'] && ! empty( $settings['icon']['value'] ) ) :
                    Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
                elseif ( 'img' === $settings['icon_or_image'] && ! empty( $settings['image']['url'] ) ) :
                    $image = $settings['image'];
                    $image_url = Group_Control_Image_Size::get_attachment_image_src( $image['id'], 'img_size', $settings );
                    if ( empty( $image_url ) ) :
                        $image_url = $image['url'];
                    else :
                        $image_url = $image_url;
                    endif;
                    echo '<img src="' . esc_url( $image_url ) . '" alt="' . Control_Media::get_image_alt( $settings['image'] ) . '">';
                endif;
            echo '</div>';
            echo '<div class="edublink-icon-box-content">';
                if ( isset( $settings['title'] ) && ! empty( $settings['title'] ) ) :
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

                    echo '<' . esc_attr( $settings['title_tag'] ) . ' class="edublink-icon-box-title">';
                        echo wp_kses_post( $settings['title'] );
                    echo '</' . esc_attr( $settings['title_tag'] ) . '>';

                    if ( ! empty( $settings['link']['url'] ) ) :
                        echo '</a>';
                    endif;
                endif;
                echo '<div class="edublink-icon-box-details">' . wpautop( wp_kses_post( $settings['details'] ) ) . '</div>';
            echo '</div>';
        echo '</div>';
    }
}