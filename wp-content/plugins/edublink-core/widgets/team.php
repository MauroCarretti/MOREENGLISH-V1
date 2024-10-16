<?php

namespace EduBlinkCore\Widgets;

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Repeater;
use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for team.
 *
 * @since 1.0.0
 */
class Team extends Widget_Base {
    use \EduBlink_Core\Traits\Slider_Arrows;
    use \EduBlink_Core\Traits\Slider_Dots;
    use \EduBlink_Core\Traits\Grid, \EduBlink_Core\Traits\Slider {
        \EduBlink_Core\Traits\Slider::settings insteadof \EduBlink_Core\Traits\Grid;
        \EduBlink_Core\Traits\Grid::settings as grid_settings;
    }
    
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
        return 'edublink-team';
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
        return __( 'Team / Instructor( Grid / Carousel )', 'edublink-core' );
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
        return 'edublink-elementor-icon eicon-person';
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
		return [ 'edublink', 'team', 'members', 'instructors' ];
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

    protected $desktop_max_slider     = 6;
    protected $desktop_default_slider = 3;
    protected $desktop_default_grid   = 3;
    protected $tablet_max_slider      = 3;
    protected $tablet_default_slider  = 2;
    protected $tablet_default_grid    = 2;
    protected $mobile_max_slider      = 2;
    protected $mobile_default_slider  = 1;
    protected $mobile_default_grid    = 1;
    protected $default_display_type;

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
            'section_team',
            [
                'label' => __( 'Team / Instructor', 'edublink-core' )
            ]
        );

        $this->add_control(
            'display_type',
            [
                'label'      => __( 'Display Type', 'edublink-core' ),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'grid',
                'options'    => [
                    'grid'   => __( 'Grid', 'edublink-core' ),
                    'slider' => __( 'Slider', 'edublink-core' )
                ]
            ]
        );

        $this->add_control(
            'style',
            [
                'label'      => __( 'Style', 'edublink-core' ),
                'type'       => Controls_Manager::SELECT,
                'default'    => '1',
                'options'    => [
                    '1'   => __( 'Style 1', 'edublink-core' ),
                    '2'   => __( 'Style 2', 'edublink-core' ),
                    '3'   => __( 'Style 3', 'edublink-core' ),
                    '4'   => __( 'Style 4', 'edublink-core' ),
                    '5'   => __( 'Style 5', 'edublink-core' ),
                    '6'   => __( 'Style 6', 'edublink-core' ),
                    '7'   => __( 'Style 7', 'edublink-core' ),
                    '8'   => __( 'Style 8', 'edublink-core' )
                ]
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'name', 
            [
                'label'       => __( 'Name', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => __( 'John Doe', 'edublink-core' )
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label'         => __( 'Profile Link', 'edublink-core' ),
                'type'          => Controls_Manager::URL,
                'show_external' => true,
                'placeholder'   => __( 'https://your-link.com', 'edublink-core' )
            ]
        );

        $repeater->add_control(
            'designation', 
            [
                'label'       => __( 'Designation', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => __( 'UI Designer', 'edublink-core' )
            ]
        );

        $repeater->add_control(
            'details', 
            [
                'label'       => __( 'Details', 'edublink-core' ),
                'type'        => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default'     => __( 'Consectetur adipisicing elit, sed do eius mod tempor incididunt', 'edublink-core' ),
                'description' => __( 'Only applicable for Style 3.', 'edublink-core' )
            ]
        );

        $repeater->add_control(
            'thumb', 
            [
                'label'       => __( 'Image', 'edublink-core' ),
                'type'        => Controls_Manager::MEDIA,
                'default'     => [
                    'url'     => get_template_directory_uri() . '/assets/images/team-placeholder.webp'
                ]
            ]
        );
        
        $repeater->add_control(
            'social_share', 
            [
                'label'       => __( 'Social Profile Links', 'edublink-core' ),
                'type'        => Controls_Manager::HEADING,
                'separator'   => 'before'
            ]
        );

        $repeater->add_control(
            'facebook', 
            [
                'label'       => __( 'Facebook', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => '#'
            ]
        );

        $repeater->add_control(
            'twitter', 
            [
                'label'       => __( 'Twitter', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => '#'
            ]
        );

        $repeater->add_control(
            'linkedin', 
            [
                'label'       => __( 'Linkedin', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => '#'
            ]
        );

        $this->add_control(
            'members',
            [
                'type'      => Controls_Manager::REPEATER,
                'fields'    => $repeater->get_controls(),
                'default'   => [
                    [ 'name'  => __( 'Jane Seymour', 'edublink-core' ) ],
                    [ 'name'  => __( 'Edward Norton', 'edublink-core' ) ],
                    [ 'name'  => __( 'Penelope Cruz', 'edublink-core' ) ],
                    [ 'name'  => __( 'John Travolta', 'edublink-core' ) ]
                ],
                'title_field' => '{{name}}'
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'thumb_size',
                'default'   => 'full'
            ]
        );

        $this->add_control(
            'open_social_link_new_tab', 
            [
                'label'        => __( 'Open Social Link in New Tab', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'default_scroll_animation',
            [
                'type'         => Controls_Manager::SWITCHER,
                'label'        => __( 'Default Scroll Animation', 'edublink-core' ),
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'yes',
                'return_value' => 'yes',
                'condition'    => [
                    'display_type' => 'grid'
                ]
            ]
        );

        $this->end_controls_section();

        $this->grid_settings();

        $this->settings();

        $this->arrows();

        $this->dots();
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
        $social_link_tab  = 'yes' === $settings['open_social_link_new_tab'] ? '_blank': '_self';
        $direction = is_rtl() ? 'true' : 'false';
        $members   = '';

        $this->add_render_attribute( 'wrapper', 'class', 'eb-team-wrapper' );
        $this->add_render_attribute( 'container', 'class', 'eb-team-container' );
        $this->add_render_attribute( 'container', 'class', 'eb-team-' . esc_attr( $settings['display_type'] ) );
        $this->add_render_attribute( 'single', 'class', 'edublink-team-' . esc_attr( $settings['style'] ) . '-widget' );

        if ( 'grid' === $settings['display_type'] ) :
            $this->add_render_attribute( 'container', 'class', 'edublink-row' );
            if ( '5' === $settings['desktop_grid_columns'] ) :
                $grid_desktop_column = 'el-5';
            else :
                $grid_desktop_column = 12/$settings['desktop_grid_columns'];
            endif;
            $grid_tablet_column  = 12/$settings['tablet_grid_columns'];
            $grid_mobile_column  = 12/$settings['mobile_grid_columns'];
            $grid_column = 'edublink-col-lg-' . esc_attr( $grid_desktop_column ) . ' edublink-col-md-' . esc_attr( $grid_tablet_column ) . ' edublink-col-sm-' . esc_attr( $grid_mobile_column );

            $this->add_render_attribute( 'single', 'class', $grid_column );
            if ( 'yes' === $settings['default_scroll_animation'] ) :
                $this->add_render_attribute( 'single', 'data-sal' );
            endif;
        else :
            $this->add_render_attribute( 'wrapper', 'class', 'eb-slider-wrapper' );
            $this->add_render_attribute( 'container', 'class', 'swiper swiper-container swiper-container-initialized' );
            $this->add_render_attribute( 'single', 'class', 'edublink-slider-item swiper-slide' );

            $this->add_render_attribute( 
                'swiper', 
                [
                    'class'                   => 'swiper-wrapper',
                    'data-slidestoshow'       => intval( esc_attr( $settings['desktop_columns']['size'] ) ),
                    'data-tablet-items'       => intval( esc_attr( $settings['tablet_columns']['size'] ) ),
                    'data-mobile-items'       => intval( esc_attr( $settings['mobile_columns']['size'] ) ), 
                    'data-small-mobile-items' => intval( esc_attr( $settings['small_mobile_columns']['size'] ) ),
                    'data-speed'              => intval( esc_attr( $settings['transition_duration'] ) ),
                    'data-direction'          => esc_attr( $direction )
                ]
            );
    
            if ( 'yes' === $settings['autoplay'] ) :
                $this->add_render_attribute( 'swiper', 'data-autoplay', 'true' );
                $this->add_render_attribute( 'swiper', 'data-autoplayspeed', intval( esc_attr( $settings['autoplay_speed'] ) ) );
            endif;
    
            if ( 'yes' === $settings['loop'] ) :
                $this->add_render_attribute( 'swiper', 'data-loop', 'true' );
            endif;

            if ( 'arrows' === $settings['arrows_and_dots'] || 'both' === $settings['arrows_and_dots'] ) :
                $this->add_render_attribute( 'wrapper', 'class', 'eb-slider-wrapper-arrows-enable' );
            endif;

            if ( 'dots' === $settings['arrows_and_dots'] || 'both' === $settings['arrows_and_dots'] ) :
                $this->add_render_attribute( 'wrapper', 'class', 'eb-slider-wrapper-dots-enable' );
                $this->add_render_attribute( 'container', 'class', 'eb-slider-dots-enable' );
            endif;
        endif;

        echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) . '>';
            echo '<div ' . $this->get_render_attribute_string( 'container' ) . '>';
                if ( 'slider' === $settings['display_type'] ) : 
                    echo '<div ' . $this->get_render_attribute_string( 'swiper' ) . '>';
                endif;

                foreach ( $settings['members'] as $key => $member ) :
                    $link_key      = 'link_' . $key;
                    $image         = $member['thumb'];
                    $image_src_url = Group_Control_Image_Size::get_attachment_image_src( $image['id'], 'thumb_size', $settings );

                    if ( empty( $image_src_url ) ) :
                        $image_url = $image['url']; 
                    else :
                        $image_url = $image_src_url;
                    endif;

                    if ( $member['link']['url'] ) :
                        $this->add_render_attribute( $link_key, 'href', esc_url( $member['link']['url'] ) );
                        if ( $member['link']['is_external'] ) :
                            $this->add_render_attribute( $link_key, 'target', '_blank' );
                        endif;
                        if ( $member['link']['nofollow'] ) :
                            $this->add_render_attribute( $link_key, 'rel', 'nofollow' );
                        endif;
                    endif;
                    echo '<div ' . $this->get_render_attribute_string( 'single' ) . '>';
                        include EDUBLINK_PLUGIN_DIR . 'widgets/styles/team/team-' . $settings['style'] . '.php';
                    echo '</div>';
                endforeach;

                if ( 'slider' === $settings['display_type'] ) : 
                    echo '</div>';
                endif;
                
                if ( 'slider' === $settings['display_type'] ) : 
                    if ( 'dots' === $settings['arrows_and_dots'] || 'both' === $settings['arrows_and_dots'] ) :
                        echo '<div class="swiper-pagination"></div>';
                    endif;
                endif;
            echo '</div>';

            if ( 'slider' === $settings['display_type'] ) : 
                if ( 'arrows' === $settings['arrows_and_dots'] || 'both' === $settings['arrows_and_dots'] ) :
                    echo '<div class="swiper-slide-controls slide-prev">';
                        echo '<i class="icon-west"></i>';
                    echo '</div>';
                    echo '<div class="swiper-slide-controls slide-next">';
                        echo '<i class="icon-east"></i>';
                    echo '</div>';
                endif;
            endif;
        echo '</div>';
        
    }
}