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
 * Elementor widget for slider.
 *
 * @since 1.0.0
 */
class Slider extends Widget_Base {
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
		return 'edublink-slider';
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
		return __( 'Slider', 'edublink-core' );
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
		return 'edublink-elementor-icon eicon-slider-full-screen';
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
		return [ 'edublink', 'slider', 'carousel', 'image', 'slider full screen' ];
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

        $this->start_controls_section(
            'section_slider',
            [
                'label' => __( 'Slider', 'edublink-core' )
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'title', 
            [
                'label'       => __( 'Title', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => __( 'Lorraine Raines', 'edublink-core' )
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label'       => __( 'Description', 'edublink-core' ),
                'type'        => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default'     => __( 'Lorem ipsum dolor amet consec tur elit adicing sed do usmod zx tempor enim minim veniam quis nostrud exer citation.', 'edublink-core' )
            ]
        );

        $repeater->add_control(
            'thumb', 
            [
                'label'       => __( 'Image', 'edublink-core' ),
                'type'        => Controls_Manager::MEDIA,
                'default'     => [
                    'url'     => Utils::get_placeholder_image_src()
                ]
            ]
        );

        $this->add_control(
            'sliders',
            [
                'type'      => Controls_Manager::REPEATER,
                'fields'    => $repeater->get_controls(),
                'default'   => [
                    [ 'title'  => __( 'Robert Lane', 'edublink-core' ) ],
                    [ 'title'  => __( 'Thomas Lopez', 'edublink-core' ) ],
                    [ 'title'  => __( 'Amber Page', 'edublink-core' ) ],
                    [ 'title'  => __( 'Ray Sanchez', 'edublink-core' ) ]
                ],
                'title_field' => '{{title}}'
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
                    '1'   => __( 'Style 1', 'edublink-core' ),
                    '2'   => __( 'Style 2', 'edublink-core' ),
                    '3'   => __( 'Style 3', 'edublink-core' )
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

  		$this->end_controls_section();
	}

	protected function render() {
        $settings = $this->get_settings_for_display();
        $direction = is_rtl() ? 'true' : 'false';

        $this->add_render_attribute( 'container', 'class', 'eb-slider-wrapper eb-slider-style-' . esc_attr( $settings['style'] ) );
        $this->add_render_attribute( 'container', 'class', 'swiper swiper-container swiper-container-initialized' );

        $sliderWrapper = 'swiper-wrapper';
        $sliderItem = 'swiper-slide';

        $this->add_render_attribute( 'swiper', 'class', $sliderWrapper );

        include EDUBLINK_PLUGIN_DIR . 'widgets/styles/sliders/slider-' . $settings['style'] . '.php';

        // echo '<div ' . $this->get_render_attribute_string( 'container' ) . '>';
        //     echo '<div ' . $this->get_render_attribute_string( 'swiper' ) . '>';
        //         foreach( $settings['sliders'] as $key => $slider ) : 
        //             $image         = $slider['thumb'];
        //             $image_src_url = Group_Control_Image_Size::get_attachment_image_src( $image['id'], 'thumb_size', $settings );

        //             if ( empty( $image_src_url ) ) :
        //                 $image_url = $image['url']; 
        //             else :
        //                 $image_url = $image_src_url;
        //             endif;

        //             $each_item = $this->get_repeater_setting_key('title', 'sliders', $key);
        //             $item_class = ['eb-slider-item'];
        //             $this->add_render_attribute( $each_item, 'class', $item_class );
        //             $this->add_render_attribute( $each_item, 'class', 'elementor-repeater-item-'. esc_attr( $slider['_id'] ) );
        //             echo '<div class="' . esc_attr( $sliderItem ) . '">';
        //                 echo '<div ' . $this->get_render_attribute_string( $each_item ) . '>';
        //                     echo $slider['title'];
        //                     // include EDUBLINK_PLUGIN_DIR . 'widgets/styles/sliders/slider-' . $settings['style'] . '.php';
        //                 echo '</div>';
        //             echo '</div>';
        //         endforeach;
        //     echo '</div>';
        // echo '</div>';
        ?>


        <?php
    }
}