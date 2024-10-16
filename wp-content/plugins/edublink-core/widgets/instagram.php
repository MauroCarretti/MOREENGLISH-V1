<?php

namespace EduBlinkCore\Widgets;

use \Elementor\Controls_Manager;
use \Elementor\Icons_Manager;
use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for instagram.
 *
 * @since 1.0.0
 */
class Instagram extends Widget_Base {
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
        return 'edublink-instagram';
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
        return __( 'Instagram', 'edublink-core' );
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
        return 'edublink-elementor-icon eicon-instagram-gallery';
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
		return [ 'edublink', 'instagram', 'social sharing' ];
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
        $helpLink = 'https://developers.facebook.com/docs/instagram-basic-display-api/getting-started';

        $this->start_controls_section(
            'section_instagram',
            [
                'label' => __( 'Instagram', 'edublink-core' )
            ]
        );

        // https://www.youtube.com/watch?v=OWvooUvR_kA
        $this->add_control(
            'access_token', 
            [
                'label'       => __( 'Access Token', 'edublink-core' ),
                'type'        => Controls_Manager::TEXTAREA,
                'label_block' => true,
				'raw'             => sprintf( __( '<a href="%s" target="_blank" rel="noopener">Access Token Documentation</a>. This <a href="https://www.youtube.com/watch?v=IEXDGIeIq_8" target="_blank">Video</a> might help you.', 'edublink-core' ), esc_url( $helpLink ) )
            ]
        );

        $this->add_control( 
            'items_limit', 
			[
				'label'   => __( 'Items Limit', 'edublink-core' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 8
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
            'title', 
            [
                'label'       => __( 'Title', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => '@EduBlink.Cooking'
            ]
        );

        $this->add_control(
            'icon',
            [
                'label'   => __( 'Icon', 'edublink-core' ),
                'type'    => Controls_Manager::ICONS,
                'default'     => [
                    'value'   => 'icon-instagram',
                    'library' => 'edublink-custom-icons'
                ]
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

        $this->start_controls_section(
            'grid_container_style',
            [
				'label' => __( 'Content', 'edublink-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
					'display_type' => 'grid'
				]
            ]
        );
        
        $this->add_responsive_control(
			'container_grid_spacing',
			[
				'label'       => __( 'Spacing', 'edublink-core' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => [ 'px' ],
				'selectors'   => [
					'{{WRAPPER}} .eb-instagram-grid.edublink-row' => 'margin: 0 calc(-{{SIZE}}px / 2) -{{SIZE}}px;',
					'{{WRAPPER}} .edublink-row>*' => 'margin-bottom: {{SIZE}}px !important; padding: 0 calc({{SIZE}}px / 2);'
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
        $direction = is_rtl() ? 'true' : 'false';

        $this->add_render_attribute( 'wrapper', 'class', 'eb-instagram-wrapper' );
        $this->add_render_attribute( 'container', 'class', 'eb-instagram-container' );
        $this->add_render_attribute( 'container', 'class', 'eb-instagram-' . esc_attr( $settings['display_type'] ) );

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

        $limit = $settings['items_limit'] ? $settings['items_limit'] : 8;
        $access_token = $settings['access_token'];

        $id         = $this->get_id();
        $transient_var  = $id . '_' . $limit;
        delete_transient( $transient_var );
        $cache_duration = MINUTE_IN_SECONDS;

        if( empty( $access_token ) ) :
            echo '<p class="eb-insta-token-notice">' . __( 'Please Provide Your Instagram Access Token.', 'edublink-core' ) . '</p>';
            return;
        endif;

        $url = 'https://graph.instagram.com/me/media?fields=id,caption,media_type,media_url,permalink,thumbnail_url,timestamp,username&limit=200&access_token=' . esc_attr( $access_token );

        $fetched_data = wp_remote_retrieve_body( wp_remote_get( $url ) );

        $fetched_data = json_decode( $fetched_data, true );
        
        if ( ! is_wp_error( $fetched_data ) ) :
            
            if ( isset( $fetched_data['error']['message'] ) ) :
                echo '<p>' . __( 'Incorrect access token specified.', 'edublink-addons' ) . '</p>';
            endif;

            $instagram_items = array();

            if( is_array( $fetched_data['data'] ) && $fetched_data['data'] ) :
                foreach ( $fetched_data['data'] as $each_item ) :
                    $image_src = ( $each_item['media_type'] == 'VIDEO' ) ? $each_item['thumbnail_url'] : $each_item['media_url'];
                    $item['id']         = $each_item['id'];
                    $item['media_type'] = $each_item['media_type'];
                    $item['src']        = $image_src;
                    $item['username']   = $each_item['username'];
                    $item['link']       = $each_item['permalink'];
                    $item['timestamp']  = $each_item['timestamp'];
                    $item['caption']    = ! empty( $each_item['caption'] ) ? $each_item['caption'] : '';
                    $instagram_items[]  = $item;
                endforeach;
            endif;
            set_transient( $transient_var, $instagram_items, 1 * $cache_duration );
        endif;

        echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) . '>';
            echo '<div ' . $this->get_render_attribute_string( 'container' ) . '>';
                if ( 'slider' === $settings['display_type'] ) : 
                    echo '<div ' . $this->get_render_attribute_string( 'swiper' ) . '>';
                endif;

                $display_images = array_slice( $instagram_items, 0, $limit );

                if ( is_array( $display_images ) && ! empty( $display_images )):
                    foreach ( $display_images as $item ):
                        echo '<div ' . $this->get_render_attribute_string( 'single' ) . '>';
                            echo '<div class="eb-instagram-item">';
                                echo '<a href="' . esc_url( $item['link'] ) . '">';
                                    echo '<img src="' . esc_url( $item['src'] ) . '" alt="' . esc_attr__( $item['username'],'edublink-addons' ) . '">';
                                    echo '<span class="user-info">';
                                        if ( ! empty( $settings['icon']['value'] ) ) :
                                            echo '<span class="icon">';
                                                Icons_Manager::render_icon( $settings['icon'] );
                                            echo '</span>';
                                        endif;

                                        echo $settings['title'] ? '<span class="user-name">' . esc_html( $settings['title'] ) . '</span>' : '';
                                    echo '</span>';
                                echo '</a>';
                            echo '</div>';
                        echo '</div>';
                    endforeach; 
                endif;

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