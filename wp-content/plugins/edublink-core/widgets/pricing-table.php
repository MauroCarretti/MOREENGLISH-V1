<?php
namespace EduBlinkCore\Widgets;
use \Elementor\Controls_Manager;
use \Elementor\Icons_Manager;
use \Elementor\Repeater;
use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for pricing table.
 *
 * @since 1.0.0
 */
class Pricing_Table extends Widget_Base {

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
		return 'edublink-pricing-table';
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
		return __( 'Pricing Table', 'edublink-core' );
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
		return 'edublink-elementor-icon eicon-price-table';
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
        return [ 'edublink', 'pricing', 'table' ];
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
  			'pricing_content',
  			[
  				'label' => __( 'Contents', 'edublink-core' )
  			]
  		);

        $this->add_control(
            'title',
            [
                'label'       => __( 'Title', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'SILVER PLAN' , 'edublink-core' )
            ]
        );

        $this->add_control(
            'price',
            [
                'label'       => __( 'Price', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( '$29.00' , 'edublink-core' )
            ]
        );
        
        $this->add_control(
            'duration',
            [
                'label'       => __( 'Duration', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Per month' , 'edublink-core' )
            ]
        );

        $this->add_control(
            'description',
            [
                'label'       => __( 'Description', 'edublink-core' ),
                'type'        => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default'     => __( 'Lorem ipsum dolor sit amet consect adipisicing elit sed. do eilt sed' , 'edublink-core' )
            ]
        );

        $this->add_control(
			'button_text',
			[
				'label'       => __( 'Text', 'edublink-core' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => __( 'Select Plan', 'edublink-core' )
			]
		);

		$this->add_control(
            'url',
            [
                'label'         => __( 'Link', 'edublink-core' ),
                'type'          => Controls_Manager::URL,
                'label_block'   => true,
                'show_external' => true,
                'placeholder'   => __( 'https://your-link.com', 'edublink-core' ),
                'dynamic'        => [
                    'active'     => true
                ],
                'default'         => [
                    'url'         => '#',
                    'is_external' => ''
                ]
            ]
        );

        $this->add_control(
			'button_icon',
			[
				'label'       => __( 'Button Icon', 'edublink-core' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [
                    'value'   => 'icon-east',
                    'library' => 'edublink-custom-icons'
                ]
			]
		);

        $this->add_control(
			'active_mode',
			[
				'name'         => 'active_mode',
				'label'        => __( 'Active Mode?', 'edublink-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'no'
			]
        );

  		$repeater = new Repeater();
		
        $repeater->add_control(
			'feature', [
				'label'   => __( 'Feature', 'edublink-core' ),
				'type'    => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __( '24*7 Online Support', 'edublink-core' )
			]
		);

        $repeater->add_control(
			'icon',
			[
				'label'       => __( 'Icon', 'edublink-core' ),
				'type'        => Controls_Manager::ICONS,
				'default'     => [
                    'value'   => 'icon-20',
                    'library' => 'edublink-custom-icons'
                ]
			]
		);

        $repeater->add_control(
			'active_feature',
			[
				'name'         => 'active_feature',
				'label'        => __( 'Active Feature?', 'edublink-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes'
			]
        );

        $this->add_control(
			'features',
			[
				'type' 		=> Controls_Manager::REPEATER,
				'fields' 	=> $repeater->get_controls(),
				'title_field' => '{{feature}}',
				'default'	=> [
					[ 'feature' => __( 'Individual Course', 'edublink-core' ) ],
					[ 'feature' => __( 'Course Learning Checks', 'edublink-core' ) ],
					[ 'feature' => __( 'Offline Learning', 'edublink-core' ) ],
					[ 
                        'feature'     => __( 'Course Discussions', 'edublink-core' ),
                        'active_feature' => 'no'
                    ],
					[ 
                        'feature'     => __( 'One to One Guidance', 'edublink-core' ),
                        'active_feature' => 'no'
                    ]
				]
			]
		);

  		$this->end_controls_section();
	}

	protected function render() {
        $settings   = $this->get_settings_for_display();
        $this->add_render_attribute( 'button', 'class', 'edu-btn btn-border btn-medium' );
        echo '<div class="eb-pricing-table-wrapper' . esc_attr( $settings['active_mode'] === 'yes' ? ' active-mode' : '' ) . '">';
            echo '<div class="pricing-header">';
                echo $settings['title'] ? '<h6 class="title">' . wp_kses_post( $settings['title'] ) . '</h6>' : '';
                echo '<div class="price-wrap">';
                    echo $settings['price'] ? '<span class="amount">' . wp_kses_post( $settings['price'] ) . '</span>' : '';
                    echo $settings['duration'] ? '<span class="duration">' . wp_kses_post( $settings['duration'] ) . '</span>' : '';
                echo '</div>';
                echo $settings['description'] ? '<div class="description">' . wp_kses_post( $settings['description'] ) . '</div>' : '';
            echo '</div>';

            echo '<ul class="pricing-features">';
                foreach( $settings['features'] as $key => $feature ) : 
                    $each_item = $this->get_repeater_setting_key( 'title', 'features', $key );

                    $item_class = ['eb-price-feature'];
                    if ( 'yes' !== $feature['active_feature'] ) :
                        $item_class[] = 'item-disable';
                    endif;
                    $this->add_render_attribute( $each_item, 'class', $item_class );
                    $this->add_render_attribute( $each_item, 'class', 'elementor-repeater-item-'. esc_attr( $feature['_id'] ) );
                    
                    echo '<li ' . $this->get_render_attribute_string( $each_item ) . '>';
                        if ( ! empty( $feature['icon']['value'] ) ) :
                            echo '<span class="eb-pricing-icon">';
                                Icons_Manager::render_icon( $feature['icon'] );
                            echo '</span>';
                        endif;
                        echo wp_kses_post( $feature['feature'] );
                    echo '</li>';
                endforeach;
            echo '</ul>';

            if ( $settings['url']['url'] ) :
                $this->add_render_attribute( 'button', 'href', esc_url( $settings['url']['url'] ) );
                if ( $settings['url']['is_external'] ) :
                    $this->add_render_attribute( 'button', 'target', '_blank' );
                endif;
                if ( $settings['url']['nofollow'] ) :
                    $this->add_render_attribute( 'button', 'rel', 'nofollow' );
                endif;
            endif;

            echo '<a ' . $this->get_render_attribute_string( 'button' ) . '>';
                echo esc_html( $settings['button_text'] );
                if ( ! empty( $settings['button_icon']['value'] ) ) :
                    echo '<span class="eb-pricing-button_icon">';
                        Icons_Manager::render_icon( $settings['button_icon'] );
                    echo '</span>';
                endif;
            echo '</a>';
        echo '</div>';
    }
}