<?php

namespace EduBlinkCore\HF\Widgets;

use \EduBlink\Navwalker\EduBlink_NavWalker;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Typography;
use \Elementor\Icons_Manager;
use \Elementor\Plugin;
use \Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for navigation menu.
 *
 * @since 1.0.0
 */
class Nav_Menu extends Widget_Base {

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
		return 'edublink-nav-menu';
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
		return __( 'Nav Menu', 'edublink-core' );
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

        $this->add_responsive_control(
            'alignment',
            [
                'label'             => __( 'Alignment', 'edublink-core' ),
                'type'              => Controls_Manager::CHOOSE,
                'toggle'            => true,
                'options'           => [
                    'flex-start'    => [
                        'title'     => __( 'Left', 'edublink-core' ),
                        'icon'      => 'eicon-h-align-left'
                    ],
                    'center'        => [
                        'title'     => __( 'Center', 'edublink-core' ),
                        'icon'      => 'eicon-h-align-center'
                    ],
                    'flex-end'      => [
                        'title'     => __( 'Right', 'edublink-core' ),
                        'icon'      => 'eicon-h-align-right'
                    ],
                    'space-between' => [
                        'title'     => __( 'Justify', 'edublink-core' ),
                        'icon'      => 'eicon-h-align-stretch'
                    ]
                ],
                'selectors'         => [
                    '{{WRAPPER}} .edublink-navbar-expand-lg .edublink-navbar-nav' => 'justify-content: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'nav_menu_responsive',
            [
                'label' => __( 'Responsive', 'edublink-core' )
            ]
        );

        $this->add_control(
            'breakpoint',
            [
                'label'        => __( 'Breakpoint', 'edublink-core' ),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'big-tablet',
                'options'      => [
                    'mobile'   => __( 'Mobile (768px >)', 'edublink-core' ),
                    'tablet'   => __( 'Tablet (992px >)', 'edublink-core' ),
                    'big-tablet' => __( 'Big Tablet (1200px >)', 'edublink-core' ),
                    'none'     => __( 'None', 'edublink-core' )
                ],
                'prefix_class' => 'edublink-nav-menu-breakpoint-'
            ]
        );

        $this->add_control(
            'menu_icon',
            [
                'label'       => __( 'Responsive Menu Icon', 'edublink-core' ),
                'type'        => Controls_Manager::ICONS,
                'default'     => [
                    'value'   => 'fas fa-bars',
                    'library' => 'fa-solid'
                ]
            ]
        );

        $this->add_control(
            'close_icon',
            [
                'label'       => __( 'Icon', 'edublink-core' ),
                'type'        => Controls_Manager::ICONS,
                'default'     => [
                    'value'   => 'icon-73',
                    'library' => 'edublink-custom-icons'
                ]
            ]
        );

        $spacing = is_rtl() ? 'left' : 'right';
        $this->add_control(
            'toggle_alignment',
            [
                'label'          => __( 'Toggle Alignment', 'edublink-core' ),
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
                    '{{WRAPPER}} .edublink-elementor-mobile-hamburger-menu' => 'justify-content: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'reponsie_nav_size',
            [
                'label'      => __( 'Responsive Menu Icon Size', 'edublink-core' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px'],
                'range'        => [
                    'px'       => [
                        'min'  => 10,
                        'step' => 1,
                        'max'  => 80
                    ]
                ],
                'default'     => [
                    'unit'    => 'px',
                    'size'    => 18
                ],
                'selectors'  => [
                    '{{WRAPPER}} .edublink-elementor-mobile-hamburger-menu i,{{WRAPPER}} .edublink-elementor-mobile-hamburger-menu svg' => 'font-size: {{SIZE}}{{UNIT}};width: {{SIZE}}{{UNIT}};'
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
            'menu_class'  => 'edublink-navbar-nav edublink-navbar-right nav-menu edublink-nav-ul-wrapper',
            'menu_id'     => 'menu-' . $this->get_nav_menu_index() . '-' . $this->get_id(),
            'fallback_cb' => '__return_empty_string',
            'container'   => '',
            'walker'      => new EduBlink_NavWalker
        ];

        $menu_html = wp_nav_menu( $args );

        $this->add_render_attribute( 'wrapper', 'class', 'edublink-nav-menu-wrapper edublink-header-area edublink-navbar-expand-lg edublink-elementor-nav-menu-wrapper' );

        $this->add_render_attribute( 'menu', 'class', 'main-navigation edublink-navbar-collapse edublink-elementor-nav' );

        echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) . '>';
            echo '<nav ' . $this->get_render_attribute_string( 'menu' ) . '>';
                echo trim( $menu_html );
            echo '</nav>';

            echo '<div class="edublink-default-header-mobile-navbar edublink-mobile-menu">';
                echo '<div class="edublink-elementor-mobile-menu-overlay"></div>';
                echo '<div class="edublink-elementor-mobile-hamburger-menu">';
                    echo '<a href="javascript:void(0);">';
                        Icons_Manager::render_icon( $settings['menu_icon'], [ 'aria-hidden' => 'true' ] );
                    echo '</a>';
                echo '</div>';
                echo '<div class="edublink-mobile-menu-nav-wrapper edublink-elementor-mobile-menu-nav-wrapper">';
                    echo '<div class="edublink-elementor-mobile-menu-close">';
                        echo '<a href="javascript:void(0);">';
                            Icons_Manager::render_icon( $settings['close_icon'], [ 'aria-hidden' => 'true' ] );
                        echo '</a>';
                    echo '</div>';

                    do_action( 'edublink_mobile_menu_before_nav' );
                    
                    wp_nav_menu( array(
                        'menu'       => $settings['menu'],
                        'depth'      => 4,
                        'container'  => 'ul',
                        'walker'     => new \EduBlink\Navwalker\EduBlink_NavWalker(),
                        'menu_id'    => 'edublink-elementor-mobile-menu-item',
                        'menu_class' => 'edublink-elementor-mobile-menu-item'                     
                    ) );

                    do_action( 'edublink_mobile_menu_after_nav' );	
                echo '</div>';
            echo '</div>';
        echo '</div>';

        if ( Plugin::$instance->editor->is_edit_mode() ) :
            $this->render_editor_script();
        endif;
    }

    private function render_editor_script(){ 
        ?>
        <script type="text/javascript">
            jQuery( document ).ready( function($) {
                $( '.main-navigation ul > li.mega-menu' ).each( function() {
                    let items       = $(this).find( ' > ul.edublink-dropdown-menu > li' ).length,
                    bodyWidth       = $( 'body' ).outerWidth(),
                    parentLinkWidth = $(this).find( ' > a' ).outerWidth(),
                    parentLinkpos   = $(this).find( ' > a' ).offset().left,
                    width           = items * 250,
                    left            = width / 2 - parentLinkWidth / 2,
                    linkleftWidth   = parentLinkpos + parentLinkWidth / 2,
                    linkRightWidth  = bodyWidth - (parentLinkpos + parentLinkWidth);

                    if (width / 2 > linkleftWidth) {
                        $(this).find( ' > ul.edublink-dropdown-menu' ).css( {
                            width: width + 'px',
                            right: 'inherit',
                            left: '-' + parentLinkpos + 'px'
                        } );
                    } else if (width / 2 > linkRightWidth) {
                        $(this).find( ' > ul.edublink-dropdown-menu' ).css( {
                            width: width + 'px',
                            left: 'inherit',
                            right: '-' + linkRightWidth + 'px'
                        } );
                    } else {
                        $(this).find( ' > ul.edublink-dropdown-menu' ).css( {
                            width: width + 'px',
                            left: '-' + left + 'px'
                        } );
                    }
                } );
            } );
        </script>
        <?php
    }
}