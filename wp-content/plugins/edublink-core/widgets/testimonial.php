<?php
namespace EduBlinkCore\Widgets;
use \Elementor\Controls_Manager;
use \Elementor\Control_Media;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Repeater;
use \Elementor\Utils;
use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for testimonial.
 *
 * @since 1.0.0
 */
class Testimonial extends Widget_Base {
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
		return 'edublink-testimonial';
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
		return __( 'Testimonial', 'edublink-core' );
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
		return 'edublink-elementor-icon eicon-testimonial';
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
		return [ 'edublink', 'testimonials', 'reviews', 'blockquote', 'feedback', 'slider', 'carousel' ];
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

        $rating_number = range( 1, 5 );
        $rating_number = array_combine( $rating_number, $rating_number );

        $this->start_controls_section(
            'section_testimonial',
            [
                'label' => __( 'Testimonial', 'edublink-core' )
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'name', 
            [
                'label'       => __( 'Name', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => __( 'Lorraine Raines', 'edublink-core' )
            ]
        );

        $repeater->add_control(
            'testimonial',
            [
                'label'       => __( 'Testimonial', 'edublink-core' ),
                'type'        => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default'     => __( 'Lorem ipsum dolor amet consec tur elit adicing sed do usmod zx tempor enim minim veniam quis nostrud exer citation.', 'edublink-core' )
            ]
        );

        $repeater->add_control(
            'designation', 
            [
                'label'       => __( 'Designation', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => __( 'Designer', 'edublink-core' )
            ]
        );

        $repeater->add_control(
            'thumb', 
            [
                'label'       => __( 'Reviewer Image', 'edublink-core' ),
                'type'        => Controls_Manager::MEDIA,
                'default'     => [
                    'url'     => Utils::get_placeholder_image_src()
                ]
            ]
        );

        $repeater->add_control(
            'rating', 
            [
                'label'       => __( 'Rating', 'edublink-core' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 5,
                'options'     => $rating_number
            ]
        );

        $repeater->add_control(
            'logo', 
            [
                'label'       => __( 'Brand Logo', 'edublink-core' ),
                'type'        => Controls_Manager::MEDIA,
                'default'     => [
                    'url'     => Utils::get_placeholder_image_src()
                ],
                'description' => __( 'Only visible at Style 3, 12 & 16.', 'edublink-core' )
            ]
        );

        $this->add_control(
            'testimonials',
            [
                'type'      => Controls_Manager::REPEATER,
                'fields'    => $repeater->get_controls(),
                'default'   => [
                    [ 'name'  => __( 'Robert Lane', 'edublink-core' ) ],
                    [ 'name'  => __( 'Thomas Lopez', 'edublink-core' ) ],
                    [ 'name'  => __( 'Amber Page', 'edublink-core' ) ],
                    [ 'name'  => __( 'Ray Sanchez', 'edublink-core' ) ]
                ],
                'title_field' => '{{name}}'
            ]
        );

        $this->add_control(
            'settings_separator_before',
            [
                'type' => Controls_Manager::DIVIDER
            ]
        );

        $this->add_control(
            'style',
            [
                'label'   => __( 'Style', 'edublink-core' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1'       => __( 'Style 1', 'edublink-core' ),
                    '2'       => __( 'Style 2', 'edublink-core' ),
                    '3'       => __( 'Style 3', 'edublink-core' ),
                    '4'       => __( 'Style 4', 'edublink-core' ),
                    '5'       => __( 'Style 5', 'edublink-core' ),
                    '6'       => __( 'Style 6', 'edublink-core' ),
                    '7'       => __( 'Style 7', 'edublink-core' ),
                    '8'       => __( 'Style 8', 'edublink-core' ),
                    '9'       => __( 'Style 9', 'edublink-core' ),
                    '10'      => __( 'Style 10', 'edublink-core' ),
                    '11'      => __( 'Style 11', 'edublink-core' ),
                    '12'      => __( 'Style 12', 'edublink-core' ),
                    '13'      => __( 'Style 13', 'edublink-core' ),
                    '14'      => __( 'Style 14', 'edublink-core' ),
                    '15'      => __( 'Style 15', 'edublink-core' ),
                    '16'      => __( 'Style 16', 'edublink-core' ),
                    '17'      => __( 'Style 17', 'edublink-core' ),
                    'card-1'  => __( 'Card 1', 'edublink-core' )
                ]
            ]
        );

        $this->add_control(
            'pre_heading',
            [
                'label'       => __( 'Pre Heading', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => __( 'TESTIMONIALS' , 'edublink-core' ),
                'condition'    => [
                    'style' => ['14', '15', '16']
                ]
            ]
        );

        $this->add_control(
            'heading',
            [
                'label'       => __( 'Heading', 'edublink-core' ),
                'type'        => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default'     => __( 'What Our Students Say' , 'edublink-core' ),
                'condition'    => [
                    'style' => ['14', '15', '16']
                ]
            ]
        );

        $this->add_control(
            'sub_heading',
            [
                'label'   => __( 'Sub Heading', 'edublink-core' ),
                'type'    => Controls_Manager::WYSIWYG,
                'default' => __( 'Lorem ipsum dolor sit amet consectur adipiscing elit sed eiusmod tempor incididunt labore dolore magna aliquaenim ad minim.' , 'edublink-core' ),
                'condition' => [
                    'style' => ['15', '16']
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'    => 'thumb_size',
                'default' => 'thumbnail'
            ]
        );

        $this->add_responsive_control(
            'custom_duration',
            [
                'label'        => __( 'Set Animation Duration', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 150,
                        'step' => 1
                    ]
                ],
                'description'  => __( 'Set custom animation duration in second( unit ).', 'edublink-core' ),
                'selectors'    => [
                    '{{WRAPPER}} .eb-testimonial-style-card-1 .testimonial-card-wrapper' => '-webkit-animation-duration: {{SIZE}}s; -moz-animation-duration: {{SIZE}}s; -ms-animation-duration: {{SIZE}}s; -o-animation-duration: {{SIZE}}s; animation-duration: {{SIZE}}s;'
                ],
                'condition'    => [
                    'style' => 'card-1'
                ]  
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'        => __( 'Autoplay', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'yes',
                'return_value' => 'yes',
                'condition'    => [
                    'style!' => ['7', '9', '13', 'card-1']
                ]
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label'        => __( 'Autoplay Speed', 'edublink-core' ),
                'type'         => Controls_Manager::NUMBER,
                'placeholder'  => 3000,
                'condition'    => [
                    'style!'   => ['7', '9', '13', 'card-1'],
                    'autoplay' => 'yes'
                ],
                'description'  => __( 'Speed in milliseconds. Example value: 3000', 'edublink-core' )
            ]
        );

        $this->add_control(
            'navigation',
            [
                'label'        => __( 'Navigation', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'yes',
                'return_value' => 'yes',
                'condition'    => [
                    'style' => ['6', '9', '10', '11', '12', '14', '15', '16']
                ]
            ]
        );

        $this->add_control(
            'pagination',
            [
                'label'        => __( 'Pagination', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'yes',
                'return_value' => 'yes',
                'condition'    => [
                    'style' => ['2', '3', '4', '5', '8', '17']
                ]
            ]
        );

  		$this->end_controls_section();
	}

    /**
     * echo testimonial rating
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function rating( $ratings ) {
        for ( $i = 1; $i <= 5; $i++ ) :
            if ( $ratings >= $i ) :
                $active_class = '<i class="icon-23"></i>';
            else :
                $active_class = '<i class="icon-23 deactive"></i>';
            endif;
            echo $active_class;
        endfor;
    }

	protected function render() {
        $settings = $this->get_settings_for_display();
        $direction = is_rtl() ? 'true' : 'false';

        $this->add_render_attribute( 'wrapper', 'class', 'eb-testimonial-wrapper eb-testimonial-wrapper-style-' . esc_attr( $settings['style'] ) );
        $this->add_render_attribute( 'container', 'class', 'eb-testimonial eb-testimonial-style-' . esc_attr( $settings['style'] ) );
        $sliderWrapper = 'swiper-wrapper';
        $sliderItem = 'swiper-slide';
        if ( $settings['style'] === 'card-1' ) :
            $sliderWrapper = 'testimonial-card-wrapper';
            $sliderItem = 'testimonial-card-item';
        else :
            $this->add_render_attribute( 'container', 'class', 'swiper swiper-container swiper-container-initialized' );
        endif;

        $this->add_render_attribute( 'swiper', 'class', $sliderWrapper );

        if ( $settings['style'] != 7 || $settings['style'] != 9 || $settings['style'] != 13 || $settings['style'] != 'card-1' ) :
            if ( 'yes' === $settings['autoplay'] ) :
                $this->add_render_attribute( 'swiper', 'data-autoplay', 'true' );
                $this->add_render_attribute( 'swiper', 'data-autoplayspeed', intval( esc_attr( $settings['autoplay_speed'] ) ) );
            endif;
        endif;

        echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) . '>';
            if ( $settings['style'] == 15 || $settings['style'] == 16 ) :
                echo '<div class="edublink-row">';
                    echo '<div class="edublink-col-lg-5">';
                        echo '<div class="edublink-section-heading">';
                            echo $settings['pre_heading'] ? '<span class="pre-heading edublink-color-secondary">' . esc_html( $settings['pre_heading'] ) . '</span>' : '';

                            if ( $settings['heading'] ) :
                                echo '<h3 class="heading">' . wp_kses_post( $settings['heading'] ) . '</h3>';
                                echo '<span class="title-shape"><i class="icon-19"></i></span>';
                            endif;
                            
                            if ( ! empty( $settings['sub_heading'] ) ) :
                                echo '<div class="sub-heading">';
                                    echo wp_kses_post( $settings['sub_heading']);
                                echo '</div>';
                            endif;
                        echo '</div>';

                        if ( 'yes' === $settings['navigation'] ) :
                            echo '<div class="swiper-navigation">';
                                echo '<div class="swiper-slide-controls swiper-btn-prv">';
                                    echo '<i class="icon-west"></i>';
                                echo '</div>';
                                echo '<div class="swiper-slide-controls swiper-btn-nxt">';
                                    echo '<i class="icon-east"></i>';
                                echo '</div>';
                            echo '</div>';
                        endif;
                    echo '</div>';

                    echo '<div class="edublink-col-lg-7">';
                        echo '<div ' . $this->get_render_attribute_string( 'container' ) . '>';
                            echo '<div ' . $this->get_render_attribute_string( 'swiper' ) . '>';
                                foreach( $settings['testimonials'] as $key => $testimonial ) : 
                                    $image         = $testimonial['thumb'];
                                    $image_src_url = Group_Control_Image_Size::get_attachment_image_src( $image['id'], 'thumb_size', $settings );

                                    if ( empty( $image_src_url ) ) :
                                        $image_url = $image['url']; 
                                    else :
                                        $image_url = $image_src_url;
                                    endif;

                                    $each_item = $this->get_repeater_setting_key('title', 'testimonials', $key);
                                    $item_class = ['eb-testimonial-item'];
                                    $this->add_render_attribute( $each_item, 'class', $item_class );
                                    $this->add_render_attribute( $each_item, 'class', 'elementor-repeater-item-'. esc_attr( $testimonial['_id'] ) );
                                    echo '<div class="' . esc_attr( $sliderItem ) . '">';
                                        echo '<div ' . $this->get_render_attribute_string( $each_item ) . '>';
                                            include EDUBLINK_PLUGIN_DIR . 'widgets/styles/testimonials/testimonial-' . $settings['style'] . '.php';
                                        echo '</div>';
                                    echo '</div>';
                                endforeach;
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            else :
                echo '<div ' . $this->get_render_attribute_string( 'container' ) . '>';
                    echo '<div ' . $this->get_render_attribute_string( 'swiper' ) . '>';
                        foreach( $settings['testimonials'] as $key => $testimonial ) : 
                            $image         = $testimonial['thumb'];
                            $image_src_url = Group_Control_Image_Size::get_attachment_image_src( $image['id'], 'thumb_size', $settings );

                            if ( empty( $image_src_url ) ) :
                                $image_url = $image['url']; 
                            else :
                                $image_url = $image_src_url;
                            endif;

                            $each_item = $this->get_repeater_setting_key('title', 'testimonials', $key);
                            $item_class = ['eb-testimonial-item'];
                            $this->add_render_attribute( $each_item, 'class', $item_class );
                            $this->add_render_attribute( $each_item, 'class', 'elementor-repeater-item-'. esc_attr( $testimonial['_id'] ) );
                            echo '<div class="' . esc_attr( $sliderItem ) . '">';
                                echo '<div ' . $this->get_render_attribute_string( $each_item ) . '>';
                                    include EDUBLINK_PLUGIN_DIR . 'widgets/styles/testimonials/testimonial-' . $settings['style'] . '.php';
                                echo '</div>';
                            echo '</div>';
                        endforeach;
                    echo '</div>';

                    if ( $settings['style'] == 2 || $settings['style'] == 3 || $settings['style'] == 4 || $settings['style'] == 5 || $settings['style'] == 8 || $settings['style'] == 17 ) :
                        if ( 'yes' === $settings['pagination'] ) :
                            echo '<div class="swiper-pagination"></div>';
                        endif;
                    endif;

                    if ( $settings['style'] == 14 ) :
                        if ( 'yes' === $settings['navigation'] ) :
                            echo '<div class="swiper-navigation">';
                                echo '<div class="swiper-slide-controls swiper-btn-prv">';
                                    echo '<i class="icon-west"></i>';
                                echo '</div>';
                                echo '<div class="swiper-slide-controls swiper-btn-nxt">';
                                    echo '<i class="icon-east"></i>';
                                echo '</div>';
                            echo '</div>';
                        endif;
                    endif;

                    if ( $settings['style'] == 6 || $settings['style'] == 10 ) :
                        if ( 'yes' === $settings['navigation'] ) :
                            echo '<div class="swiper-navigation">';
                                echo '<div class="swiper-slide-controls swiper-btn-prv">';
                                    echo '<img src="' . EDUBLINK_ASSETS_URL . 'images/slider/icon-left.svg" alt="slider left arrow">';
                                echo '</div>';
                                echo '<div class="swiper-slide-controls swiper-btn-nxt">';
                                    echo '<img src="' . EDUBLINK_ASSETS_URL . 'images/slider/icon-right.svg" alt="slider right arrow">';
                                echo '</div>';
                            echo '</div>';
                        endif;
                    endif;
                echo '</div>';
            endif;

            if ( $settings['style'] == 7 || $settings['style'] == 9 || $settings['style'] == 13 ) :
                echo '<div class="eb-testimonial-thumb eb-testimonial-thumb-style-' . esc_attr( $settings['style'] ) . '">';
                    echo '<div class="swiper-wrapper">';
                        foreach( $settings['testimonials'] as $key => $testimonial ) : 
                            $image         = $testimonial['thumb'];
                            $image_src_url = Group_Control_Image_Size::get_attachment_image_src( $image['id'], 'thumb_size', $settings );

                            if ( empty( $image_src_url ) ) :
                                $image_url = $image['url']; 
                            else :
                                $image_url = $image_src_url;
                            endif;
                            echo '<div class="nav-thumb swiper-slide">';
                                echo '<div class="clint-thumb">';
                                    echo '<img src="' . esc_url( $image_url ) . '" class="testimonial-author-avatar" alt="' . Control_Media::get_image_alt( $testimonial['thumb'] ) . '">';
                                echo '</div>';
                            echo '</div>';
                        endforeach;
                    echo '</div>';
                echo '</div>';
            endif;

            if ( $settings['style'] == 9 ) :
                if ( 'yes' === $settings['navigation'] ) :
                    echo '<div class="swiper-slide-controls slide-prev">';
                        echo '<i class="icon-west"></i>';
                    echo '</div>';
                    echo '<div class="swiper-slide-controls slide-next">';
                        echo '<i class="icon-east"></i>';
                    echo '</div>';
                endif;
            endif;

            if ( $settings['style'] == 11 || $settings['style'] == 12 ) :
                if ( 'yes' === $settings['navigation'] ) :
                    echo '<div class="swiper-navigation">';
                        echo '<div class="swiper-slide-controls swiper-btn-prv">';
                            echo '<img src="' . EDUBLINK_ASSETS_URL . 'images/slider/icon-left.svg" alt="slider left arrow">';
                        echo '</div>';
                        echo '<div class="swiper-slide-controls swiper-btn-nxt">';
                            echo '<img src="' . EDUBLINK_ASSETS_URL . 'images/slider/icon-right.svg" alt="slider right arrow">';
                        echo '</div>';
                    echo '</div>';
                endif;
            endif;
        echo '</div>';
    }
}