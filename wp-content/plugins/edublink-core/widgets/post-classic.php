<?php

namespace EduBlinkCore\Widgets;

use \EduBlinkCore\Helper;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Image_Size;
use \Elementor\Widget_Base;
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for post.
 *
 * @since 1.0.0
 */
class Post_Classic extends Widget_Base {
    use \EduBlink_Core\Traits\Posts;

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
        return 'edublink-post-classic';
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
        return __( 'Post Classic Layout', 'edublink-core' );
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
        return 'edublink-elementor-icon eicon-post-list';
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
        return [ 'edublink', 'query', 'blog', 'post', 'archive', 'posts', 'loop' ];
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

    protected $category_taxonomy = 'category';

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function _register_controls() {

        $this->start_controls_section(
            'section_posts',
            [
                'label' => __( 'Post', 'edublink-core' )
            ]
        );
        
        $this->add_control(
            'layout',
            [
                'label'   => __( 'Layout', 'edublink-core' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1'   => __( 'Layout 1', 'edublink-core' ),
                    '2'   => __( 'Layout 2', 'edublink-core' ),
                    '3'   => __( 'Layout 3', 'edublink-core' )
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
                'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'date_format',
            [
                'type'            => Controls_Manager::SELECT,
                'label'           => __( 'Date Format', 'edublink-core' ),
                'default'         => 'default',
                'options'         => [
                    'default'     => __( 'Default', 'edublink-core' ),
                    'F j, Y'      => __( 'F j, Y', 'edublink-core' ),
                    'Y-m-d'       => __( 'Y-m-d', 'edublink-core' ),
                    'm/d/Y'       => __( 'm/d/Y', 'edublink-core' ),
                    'd/m/Y'       => __( 'd/m/Y', 'edublink-core' ),
                    'j M, Y'      => __( 'j M, Y', 'edublink-core' ),
                    'd M, Y'      => __( 'd M, Y', 'edublink-core' ),
                    'l F j, Y'    => __( 'l F j, Y', 'edublink-core' ),
                    'D M j'       => __( 'D M j', 'edublink-core' ),
                    'dS M Y'      => __( 'dS M Y', 'edublink-core' ),
                    'F Y'         => __( 'F Y', 'edublink-core' ),
                    'custom'      => __( 'Custom', 'edublink-core' )
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'featured_post_section',
            [
                'label' => __( 'Featured Post', 'edublink-core' )
            ]
        );

        $this->add_control(
			'always_show_the_latest_post', [
				'label'        => __( 'Always Show The Latest Post?', 'edublink-core' ),
				'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'description'  => __( 'Always show the latest post as the Featured Post', 'edublink-core' ),
				'default'      => 'yes',
				'return_value' => 'yes'
			]
		);

        $this->add_control(
            'featured_post',
            [   
                'label'       => __( 'Featured Post', 'edublink-core' ),
                'label_block' => true,
                'type'        => Controls_Manager::SELECT,
                'multiple'    => true,
                'default'     => array_key_first( Helper::retrieve_posts( 'post' ) ),
                'options'     => Helper::retrieve_posts( 'post' ),
                'condition'   => [
                    'always_show_the_latest_post!' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'featured_post_thumb_size',
                'default'   => 'edublink-post-thumb'
            ]
        );

        $this->add_control(
            'featured_post_must_have_featured_post',
            [
                'label'        => __( 'Only Has Featured Image', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,    
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'description'  => __( 'Featured Post Must Have a Featured Image.', 'edublink-core' ),           
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );

        $this->add_responsive_control(
            'featured_post_image_height',
            [
                'label'        => __( 'Image Height', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'size_units'   => [ 'px', 'em' ],
                'range'        => [
                    'px'       => [
                        'min'  => 300,
                        'step' => 5,
                        'max'  => 1250
                    ]
                ],
                'selectors'    => [
                    '{{WRAPPER}} .edublink-classic-post-layout .featured-post .thumbnail a img' => 'height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label'       => __( 'Number of Words', 'edublink-core' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 15,
                'description' => __( 'Number of excerpt words.', 'edublink-core' ),
                'condition'   => [
                    'layout'  => ['2']
                ]
            ]
        );

        $this->add_control(
            'excerpt_end',
            [
                'label'       => __( 'Excerpt End Text', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => '...',
                'description' => __( 'Content to show at the end of the excerpt. Default: ...', 'edublink-core' ),
                'condition'   => [
                    'layout'  => ['2']
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'specific_posts_section',
            [
                'label' => __( 'Other Specific Posts', 'edublink-core' )
            ]
        );

        $this->add_control(
            'specific_posts',
            [   
                'label'       => __( 'Specific Posts', 'edublink-core' ),
                'label_block' => true,
                'type'        => Controls_Manager::SELECT2,
                'multiple'    => true,
                'options'     => Helper::retrieve_posts( 'post' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'specific_posts_size',
                'default'   => 'edublink-post-thumb'
            ]
        );

        $this->add_control(
            'specific_posts_order',
            [
                'type'          => Controls_Manager::SELECT,
                'label'         => __( 'Order', 'edublink-core' ),
                'default'       => 'DESC',
                'description'   => __( 'Order', 'edublink-core' ),
                'options'       => [
                    'ASC'       => __( 'Ascending', 'edublink-core' ),
                    'DESC'      => __( 'Descending', 'edublink-core' )
                ]
            ]
        );        

        $this->add_control(
            'specific_posts_order_by',
            [
                'type'              => Controls_Manager::SELECT,
                'label'             => __( 'Order by', 'edublink-core' ),
                'default'           => 'date',
                'options'           => [
                    'none'            => __( 'No order', 'edublink-core' ),
                    'ID'              => __( 'Post ID', 'edublink-core' ),
                    'author'          => __( 'Author', 'edublink-core' ),
                    'title'           => __( 'Title', 'edublink-core' ),
                    'name'            => __( 'Name', 'edublink-core' ),
                    'type'            => __( 'Type', 'edublink-core' ),
                    'date'            => __( 'Published Date', 'edublink-core' ),
                    'modified'        => __( 'Modified Date', 'edublink-core' ),
                    'parent'          => __( 'By Parent', 'edublink-core' ),
                    'rand'            => __( 'Random Order', 'edublink-core' ),
                    'comment_count'   => __( 'Comment Count', 'edublink-core' ),
                    'relevance'       => __( 'Relevance', 'edublink-core' ),
                    'menu_order'      => __( 'Menu Order', 'edublink-core' ),
                    'meta_value'      => __( 'Meta Value', 'edublink-core' ),
                    'meta_value_num'  => __( 'Meta Value Num', 'edublink-core' ),
                    'post__in'        => __( 'Post In( by include order )', 'edublink-core' ),
                    'post_name__in'   => __( 'Post Name In', 'edublink-core' ),
                    'post_parent__in' => __( 'post Parent In', 'edublink-core' )
                ]
            ]
        );

        $this->add_control(
            'specific_posts_must_have_featured_post',
            [
                'label'        => __( 'Only Has Featured Image', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,    
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'description'  => __( 'Only show posts which has feature image set.', 'edublink-core' ),           
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );

        $this->add_responsive_control(
            'specific_posts_image_height',
            [
                'label'        => __( 'Image Height', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'size_units'   => [ 'px', 'em' ],
                'range'        => [
                    'px'       => [
                        'min'  => 100,
                        'step' => 1,
                        'max'  => 500
                    ]
                ],
                'selectors'    => [
                    '{{WRAPPER}} .edublink-classic-post-layout .specific-posts .thumbnail a img' => 'height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
			'specific_posts_active_white_bg', [
				'label'        => __( 'Active White Background', 'edublink-core' ),
				'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
				'default'      => 'no',
				'return_value' => 'yes'
			]
		);

        $this->add_control(
			'specific_posts_title_in_line_two', [
				'label'        => __( 'Post Title in 2 Lines(max)?', 'edublink-core' ),
				'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'description'  => __( 'By enabling this option, the post title will appear in a maximum of 2 lines.', 'edublink-core' ),
				'default'      => 'yes',
				'return_value' => 'yes'
			]
		);

        $this->end_controls_section();
    }

    /**
     * return post featured image
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render_image( $image_id, $settings ) {
        $image_size = $settings['thumb_size_size'];

        if ( 'custom' === $image_size ) :
            $image_src = Group_Control_Image_Size::get_attachment_image_src( $image_id, 'thumb_size', $settings );
        else :
            $image_src = wp_get_attachment_image_src( $image_id, $image_size );
            $image_src = $image_src[0];
        endif;
        
        return '<img src="' . esc_url( $image_src ). '" alt="' . esc_attr( edublink_thumbanil_alt_text( $image_id ) ) . '" />';
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
        $settings['comment_text'] = edublink_set_value( 'blog_post_comment_short_text', __( 'Com', 'edublink-core' ) );

        $this->add_render_attribute( 'container', 'class', 'edublink-classic-post-layout layout-' . esc_attr( $settings['layout'] ) );

        if ( 'yes' === $settings['specific_posts_title_in_line_two'] ) :
            $this->add_render_attribute( 'container', 'class', 'specific-post-title-line-two' );
        endif;

        if ( 'yes' === $settings['specific_posts_active_white_bg'] ) :
            $this->add_render_attribute( 'container', 'class', 'specific-post-active-white-bg' );
        endif;
        
        if ( 'yes' === $settings['always_show_the_latest_post'] ) :
            $featured_post_id = array_key_first( Helper::retrieve_posts( 'post' ) );
        else :
            $featured_post_id = $settings['featured_post'];
        endif;

        $this->add_render_attribute( 'featured-wrapper', 'class', 'eb-post-featured-item' );
        $this->add_render_attribute( 'specific-wrapper', 'class', 'eb-post-specific-item' );

        if ( 'yes' === $settings['default_scroll_animation'] ) :
            $this->add_render_attribute( 'featured-wrapper', 'data-sal' );
            $this->add_render_attribute( 'specific-wrapper', 'data-sal' );
        endif;
        
        $per_page = 2;
        if ( '2' === $settings['layout'] ) :
            $per_page = 3;
        elseif ( '3' === $settings['layout'] ) :
            $per_page = 4;
        endif;

        $args_for_featured_post = array(
            'post_type'           => 'post',
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
            'posts_per_page'      => 1,
            'post__in'            => array( $featured_post_id )
        );

        $args_for_specific_post = array(
            'post_type'           => 'post',
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
            'orderby'             => $settings['specific_posts_order_by'],
            'order'               => $settings['specific_posts_order'],
            'posts_per_page'      => $per_page,
            'post__in'            => $settings['specific_posts'],
            'post__not_in'        => array( $featured_post_id )
        );

        if ( 'default' === $settings['date_format'] ) :
            $date = get_option( 'date_format' );
        elseif ( 'custom' === $settings['date_format'] ) :
            $date = $settings['custom_date_format'];
        else :
            $date = $settings['date_format'];
        endif;

        if ( 'yes' === $settings['featured_post_must_have_featured_post'] ) :
            $args_for_featured_post['meta_query'][] = array( 'key' => '_thumbnail_id' );
        endif;

        if ( 'yes' === $settings['specific_posts_must_have_featured_post'] ) :
            $args_for_specific_post['meta_query'][] = array( 'key' => '_thumbnail_id' );
        endif;

        $wp_featured_post_query = new \WP_Query( $args_for_featured_post );
        $wp_specific_post_query = new \WP_Query( $args_for_specific_post );

        if ( $wp_featured_post_query->have_posts() || $wp_specific_post_query->have_posts() ) :
            echo '<div ' . $this->get_render_attribute_string( 'container' ) . '>';
                echo '<div class="edublink-row">';
                    include EDUBLINK_PLUGIN_DIR . 'widgets/styles/post-classic/layout-' . $settings['layout'] . '.php';
                echo '</div>';
            echo '</div>';
        endif;
    }

    /**
     * return image for featured post
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render_image_for_featured_post( $image_id, $settings ) {
        $image_size = $settings['featured_post_thumb_size_size'];

        if ( 'custom' === $image_size ) :
            $image_src = Group_Control_Image_Size::get_attachment_image_src( $image_id, 'featured_post_thumb_size', $settings );
        else :
            $image_src = wp_get_attachment_image_src( $image_id, $image_size );
            $image_src = $image_src[0];
        endif;
        
        return '<img src="' . esc_url( $image_src ). '" alt="' . esc_attr( edublink_thumbanil_alt_text( $image_id ) ) . '" />';
    }

    /**
     * return image for specific post
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render_image_for_specific_post( $image_id, $settings ) {
        $image_size = $settings['specific_posts_size_size'];

        if ( 'custom' === $image_size ) :
            $image_src = Group_Control_Image_Size::get_attachment_image_src( $image_id, 'specific_posts_size', $settings );
        else :
            $image_src = wp_get_attachment_image_src( $image_id, $image_size );
            $image_src = $image_src[0];
        endif;
        
        return '<img src="' . esc_url( $image_src ). '" alt="' . esc_attr( edublink_thumbanil_alt_text( $image_id ) ) . '" />';
    }
}