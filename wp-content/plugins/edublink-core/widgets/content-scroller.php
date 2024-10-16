<?php
namespace EduBlinkCore\Widgets;
use \Elementor\Control_Media;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Group_Control_Typography;
use \Elementor\Icons_Manager;
use \Elementor\Utils;
use \Elementor\Repeater;
use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for animated text.
 *
 * @since 1.0.0
 */

class Content_Scroller extends Widget_Base {
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
		return 'edublink-content-scroller';
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
		return __( 'Content Scroller', 'edublink-core' );
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
		return 'edublink-elementor-icon eicon-scroll';
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
		return [ 'edublink', 'animation', 'marquee animation' ];
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
		return [ 'edublink-marquee' ];
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

        $spacing = is_rtl() ? 'left' : 'right';

		$this->start_controls_section( 
			'section_marquee_animation', 
			[
				'label' => __( 'Content Scroller', 'edublink-core' )
			] 
		);

        $repeater = new Repeater();

		$repeater->add_control(
            'content_type',
            [
                'label'     => __( 'Content Type', 'edublink-core' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'text',
                'options'   => [
                    'text'  => 'Text',
                    'icon'  => 'Icon',
                    'image' => 'Image'
                ]
            ]
        );

        $repeater->add_control(
            'title', 
            [
                'label'       => __( 'title', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => __( 'DIGITAL MARKETING', 'edublink-core' ),
                'condition'   => [
                    'content_type' => 'text'
                ]
            ]
        );

        $repeater->add_control(
            'image', 
            [
                'label'       => __( 'Image', 'edublink-core' ),
                'type'        => Controls_Manager::MEDIA,
                'default'     => [
                    'url'     => Utils::get_placeholder_image_src()
                ],
                'condition'   => [
                    'content_type' => 'image'
                ]
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label'      => __( 'Link', 'edublink-core' ),
                'type'       => Controls_Manager::URL
            ]
        );

        $this->add_control(
            'icon',
            [
                'label'       => __( 'Icon', 'edublink-core' ),
                'type'        => Controls_Manager::ICONS,
                'default'     => [
                    'value'   => 'fas fa-ambulance',
                    'library' => 'fa-solid'
                ],
                'condition'   => [
                    'content_type' => 'icon'
                ]
            ]
        );

        $this->add_control(
            'items',
            [
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{title}}',
                'default'     => [
                    [ 'title' => __( 'Marquee Title 1', 'edublink-core' ) ],
                    [ 'title' => __( 'Marquee Title 2', 'edublink-core' ) ],
                    [ 'title' => __( 'Marquee Title 3', 'edublink-core' ) ],
                    [ 'title' => __( 'Marquee Title 4', 'edublink-core' ) ]
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'scroll_content_settings',
            [
                'label' => __( 'Settings', 'edublink-core' )
            ]
        );

        $this->add_control(
            'animation_type',
            [
                'label'     => __( 'Animation Type', 'edublink-core' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'normal',
                'options'   => [
                    'normal'       => __( 'Normal', 'edublink-core' ),
                    'drag-n-drop'  => __( 'Drag & Drop', 'edublink-core' )
                ],
                'description' => __( 'Sets the direction of the Marquee.', 'edublink-core' )
            ]
        );

        $this->add_control(
            'direction',
            [
                'label'     => __( 'Direction', 'edublink-core' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'left',
                'options'   => [
                    'left'  => __( 'Left to Right', 'edublink-core' ),
                    'right' => __( 'Right to Left', 'edublink-core' )
                ],
                'description' => __( 'Sets the direction of the Marquee.', 'edublink-core' )
            ]
        );

        $this->add_control(
            'drag',
            [
                'label'        => __( 'Drag', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'return_value' => 'yes',
                'default'      => 'no',
                'description'  => __( 'Enable the opportunity to drag the Marquee by the mouse.', 'edublink-core' ),
                'condition'    => [
                    'animation_type' => 'drag-n-drop'
                ]
            ]
        );

        $this->add_control(
            'stop_on_hover',
            [
                'label'        => __( 'Hover Stop', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'description'  => __( 'Enable the opportunity to pause the Marquee when mouse hover.', 'edublink-core' ),
                'condition'    => [
                    'animation_type' => 'drag-n-drop'
                ]
            ]
        );

        $this->add_control(
            'scroll_amount',
            [
                'label'       => __( 'Scroll Amount', 'edublink-core' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 70,
                'description' => __( 'Sets the amount of scrolling at each interval in pixels.', 'edublink-core' ),
                'condition'    => [
                    'animation_type' => 'drag-n-drop'
                ]
            ]
        );

        $this->add_control(
            'scroll_delay',
            [
                'label'       => __( 'Scroll Delay', 'edublink-core' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 0,
                'description' => __( 'Sets the interval between each scroll movement in milliseconds.', 'edublink-core' ),
                'condition'   => [
                    'animation_type' => 'drag-n-drop'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'content_scroller_style',
            [
                'label'     => __( 'Styling', 'edublink-core' ),
                'tab'       => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image_size',
                'default'   => 'full'
            ]
        );

        $this->add_responsive_control(
            'inner_spacing',
            [
                'label'        => __( 'Spacing', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'size_units'   => [ 'px' ],
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'step' => 1,
                        'max'  => 300
                    ]
                ],
                'default'      => [
                    'size'     => 40
                ],
                'selectors'    => [
                    '{{WRAPPER}} .eb-content-scroller-wrapper .eb-content-scroller-item:not(:last-child)' => 'margin-' . $spacing . ': {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'image_top_spacing',
            [
                'label'        => __( 'Image Top Spacing', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'size_units'   => [ 'px' ],
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'step' => 1,
                        'max'  => 300
                    ]
                ],
                'selectors'    => [
                    '{{WRAPPER}} .eb-content-scroller-type-image' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'text_typography',
                'selector' => '{{WRAPPER}} .eb-content-scroller-type-text, {{WRAPPER}} .eb-content-scroller-type-text a'
            ]
        );

        $this->add_control( 
            'text_color', 
            [
                'label'   => __( 'Text Color', 'edublink-core' ),
                'type'    => Controls_Manager::COLOR,
                'selectors'    => [
                    '{{WRAPPER}} .eb-content-scroller-type-text, {{WRAPPER}} .eb-content-scroller-type-text a' => 'color: {{VALUE}};'
                ]
            ] 
        );

        $this->add_control( 
            'text_hover_color', 
            [
                'label'   => __( 'Text Hover Color', 'edublink-core' ),
                'type'    => Controls_Manager::COLOR,
                'selectors'    => [
                    '{{WRAPPER}} .eb-content-scroller-type-text:hover, {{WRAPPER}} .eb-content-scroller-type-text a:hover' => 'color: {{VALUE}};'
                ]
            ] 
        );

        $this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
        $this->add_render_attribute( 'container', 'class', 'eb-content-scroller-wrapper' );
        if ( 'drag-n-drop' === $settings['animation_type'] ) :
            $this->add_render_attribute( 
                'container', 
                [
                    'class'             => 'eb-content-scroller-container',
                    'data-direction'    => esc_attr( $settings['direction'] ),
                    'data-drag'         => 'yes' === $settings['drag'] ? true : false,
                    'data-hoverstop'    => 'yes' === $settings['stop_on_hover'] ? true : false,
                    'data-scrollamount' => $settings['scroll_amount'],
                    'data-scrolldelay'  => $settings['scroll_delay']
                ]
            );
        else :
            $this->add_render_attribute( 'container', 'class', 'eb-content-scroller-infinite' );
            $this->add_render_attribute( 'container', 'class', 'direction-to-' . esc_attr( $settings['direction'] ) );
        endif;

		echo '<div ' . $this->get_render_attribute_string( 'container' ) . '>';
            foreach ( $settings['items'] as $key => $item ) :
                $link_key = 'link_' . $key;
                $this->add_render_attribute( $link_key, 'class', 'eb-content-scroller-item eb-content-scroller-type-' . esc_attr( $item['content_type'] ) . ' elementor-repeater-item-'. esc_attr( $item['_id'] ) );
                echo '<span ' . $this->get_render_attribute_string( $link_key ) . '>';
                
                    if ( $item['link']['url'] ) :
                        $this->add_render_attribute( $link_key, 'href', esc_url( $item['link']['url'] ) );
                        if ( $item['link']['is_external'] ) :
                            $this->add_render_attribute( $link_key, 'target', '_blank' );
                        endif;
                        if ( $item['link']['nofollow'] ) :
                            $this->add_render_attribute( $link_key, 'rel', 'nofollow' );
                        endif;
                        echo '<a ' . $this->get_render_attribute_string( $link_key ) . '>';
                    endif;

                    if ( 'text' === $item['content_type'] ) :
                        echo wp_kses_post( $item['title'] );
                    elseif ( 'icon' === $item['content_type'] ) :
                        Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
                    elseif ( 'image' === $item['content_type'] ) :
                        $image         = $item['image'];
                        $image_src_url = Group_Control_Image_Size::get_attachment_image_src( $image['id'], 'image_size', $settings );

                        if ( empty( $image_src_url ) ) :
                            $image_url = $image['url']; 
                        else :
                            $image_url = $image_src_url;
                        endif;
                        echo '<img src="' . esc_url( $image_url ) . '" alt="' . Control_Media::get_image_alt( $item['image'] ) . '">';
                    endif;

                    if ( ! empty( $item['link']['url'] ) ) :
                        echo '</a>';
                    endif;
                echo '</span>';
            endforeach;
		echo '</div>';
	}
}