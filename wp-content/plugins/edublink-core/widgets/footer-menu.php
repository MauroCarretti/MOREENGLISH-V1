<?php

namespace EduBlinkCore\HF\Widgets;

use \EduBlink\Navwalker\EduBlink_NavWalker;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for footer menu.
 *
 * @since 1.0.0
 */
class Footer_Menu extends Widget_Base {

    /**
     * Menu index.
     *
     * @access protected
     * @var $nav_menu_index
     */
    protected $nav_menu_index = 1;

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
		return 'edublink-footer-menu';
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
		return __( 'Footer Menu', 'edublink-core' );
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
        return 'edublink-elementor-icon eicon-nav-menu';
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
		return [ 'edublink', 'menu', 'nav', 'navigation' ];
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
		return [ 'edublink_hf_elementor_widgets' ];
	}

    /**
     * Retrieve the menu index.
     *
     * Used to get index of nav menu.
     *
     * @since 1.0.0
     * @access protected
     *
     * @return string nav index.
     */
    protected function get_nav_menu_index() {
        return $this->nav_menu_index++;
    }

    /**
     * Retrieve the list of available menus.
     *
     * Used to get the list of available menus.
     *
     * @since 1.0.0
     * @access private
     *
     * @return array get WordPress menus list.
     */
    private function get_available_menus() {

        $menus   = wp_get_nav_menus();
        $options = [];
        foreach ( $menus as $menu ) :
            $options[ $menu->slug ] = $menu->name;
        endforeach;
        return $options;
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
            'section_nav_menu',
            [
                'label' => __( 'Nav Menu', 'edublink-core' )
            ]
        );

        $menus = $this->get_available_menus();

        if ( ! empty( $menus ) ) :
            $this->add_control(
                'menu',
                [
                    'label'        => __( 'Menu', 'edublink-core' ),
                    'type'         => Controls_Manager::SELECT,
                    'options'      => $menus,
                    'default'      => array_keys( $menus )[0],
                    'save_default' => true,
                    'separator'    => 'after',
                    'description'  => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'edublink-core' ), admin_url( 'nav-menus.php' ) )
                ]
            );
        else :
            $this->add_control(
                'menu_alert',
                [
                    'type'            => Controls_Manager::RAW_HTML,
                    'raw'             => sprintf( __( '<strong>There are no menus in your site.</strong><br>Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'edublink-core' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
                    'separator'       => 'after',
                    'content_classes' => 'elementor-panel-alert elementor-panel-alert-info'
                ]
            );
        endif;

        $this->end_controls_section();

        $this->start_controls_section(
            'footer_menu_style',
            [
                'label' => __( 'Footer Menu', 'edublink-core' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'menu_typography',
                'selector' => '{{WRAPPER}} ul.footer-navigation-menu li a'
            ]
        );

        $this->add_responsive_control(
            'space_between',
            [
                'label'       => __( 'Space Between', 'edublink-core' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px' ],
                'selectors'   => [
                    '{{WRAPPER}} ul.footer-navigation-menu li:not(:first-child)'  => 'margin-top: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} ul.footer-navigation-menu li ul li:first-child'  => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'menu_color',
            [
                'label'     => __( 'Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ul.footer-navigation-menu li a' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'menu_hover_color',
            [
                'label'     => __( 'Hover Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => $primary_color,
                'selectors' => [
                    '{{WRAPPER}} ul.footer-navigation-menu li a:hover' => 'color: {{VALUE}};'
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
        $args = [
            'echo'        => false,
            'menu'        => $settings['menu'],
            'depth'       => apply_filters( 'edublink_footer_menu_depth', 1 ),
            'menu_class'  => 'footer-navigation-menu',
            'menu_id'     => 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id(),
            'fallback_cb' => '__return_empty_string',
            'container'   => '',
            'walker'      => new EduBlink_NavWalker
        ];

        $menu_html = wp_nav_menu( $args );

        $this->add_render_attribute( 'menu', 'class', 'edublink-nav-menu-wrapper' );

        echo '<nav ' . $this->get_render_attribute_string( 'menu' ) . '>';
            echo trim( $menu_html );
        echo '</nav>';
    }
}