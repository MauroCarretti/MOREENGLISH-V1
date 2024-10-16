<?php
namespace EduBlinkCore\Widgets;
use \Elementor\Controls_Manager;
use \Elementor\Repeater;
use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for accordion.
 *
 * @since 1.0.0
 */
class Accordion extends Widget_Base {

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
		return 'edublink-accordion';
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
		return __( 'Accordion', 'edublink-core' );
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
		return 'edublink-elementor-icon eicon-accordion';
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
		return [ 'edublink', 'toggle', 'tab' ];
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
  			'accordion_content',
  			[
  				'label' => __( 'Contents', 'edublink-core' )
  			]
  		);

  		$repeater = new Repeater();

        $repeater->add_control(
			'active_by_default', [
				'label'        => __( 'Active as Default', 'edublink-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'return_value' => 'yes'
			]
		);
		
        $repeater->add_control(
			'title', [
				'label'   => __( 'Title', 'edublink-core' ),
				'type'    => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __( 'Accordion Title', 'edublink-core' ),
				'dynamic' => [ 'active' => true ]
			]
		);
		
        $repeater->add_control(
			'content', [
				'label'   => __( 'Content', 'edublink-core' ),
				'type'    => Controls_Manager::WYSIWYG,
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'edublink-core' )
			]
		);

        $repeater->add_control(
            'header_each_bg',
            [
                'label'     => __( 'Header Background', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.eb-accordion-item .eb-accordion-header' => 'background: {{VALUE}};'
                ]
            ]
        );

        $repeater->add_control(
            'header_each_color',
            [
                'label'     => __( 'Header Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.eb-accordion-item .eb-accordion-header, {{WRAPPER}} {{CURRENT_ITEM}}.eb-accordion-item .eb-accordion-header:before' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
			'accordions',
			[
				'type' 		=> Controls_Manager::REPEATER,
				'fields' 	=> $repeater->get_controls(),
				'default'	=> [
					[ 
						'title'          => __( 'Accordion Title 1', 'edublink-core' ),
						'active_by_default' => 'yes'
					],
					[ 'title' => __( 'Accordion Title 2', 'edublink-core' ) ],
					[ 'title' => __( 'Accordion Title 3', 'edublink-core' ) ]
				],
				'title_field' => '{{title}}'
			]
		);

        $this->add_control(
            'tag',
            [
                'label'    => __( 'HTML Tag', 'edublink-core' ),
                'type'     => Controls_Manager::SELECT,
                'default'  => 'h5',
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
                ]
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
                'label'      => __( 'Overall Style', 'edublink-core' ),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'default',
                'options'    => [
                    'default'    => __( 'Default', 'edublink-core' ),
                    'radius-1' => __( 'Radius Style 1', 'edublink-core' )
                ]
            ]
        );

        $this->add_control(
            'header_bg_style',
            [
                'label'      => __( 'Header Background Style', 'edublink-core' ),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'default',
                'options'    => [
                    'default'    => __( 'Default', 'edublink-core' ),
                    'gradient-bg' => __( 'Gradient(Only Active)', 'edublink-core' ),
                    'gradient-all' => __( 'Gradient(All)', 'edublink-core' ),
                    'transparent-bg' => __( 'Transparent', 'edublink-core' )
                ]
            ]
        );

        $this->add_control(
            'header_border_style',
            [
                'label'      => __( 'Header Border Style', 'edublink-core' ),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'default',
                'options'    => [
                    'default' => __( 'Default', 'edublink-core' ),
                    'b-1'     => __( 'Border 1px', 'edublink-core' ),
                    'b-r-10'  => __( 'Border Radius 10px', 'edublink-core' )
                ]
            ]
        );

  		$this->end_controls_section();
	}

	protected function render() {
        $settings   = $this->get_settings_for_display();
        
        ?>
        <div class="eb-accordion header-<?php echo esc_attr( $settings['header_bg_style'] ); ?> border-<?php echo esc_attr( $settings['header_border_style'] ); ?> style-<?php echo esc_attr( $settings['style'] ); ?>">
            <?php foreach( $settings['accordions'] as $key => $accordion ) : 
                $each_item = $this->get_repeater_setting_key( 'title', 'accordions', $key );
                                
                $item_class = ['eb-accordion-item'];
                if ( $accordion['active_by_default'] === 'yes' ) :
                    $item_class[] = 'default-active';
                endif;
                $this->add_render_attribute( $each_item, 'class', $item_class );
                $this->add_render_attribute( $each_item, 'class', 'elementor-repeater-item-'. esc_attr( $accordion['_id'] ) );
            ?>
                <div <?php echo $this->get_render_attribute_string( $each_item ); ?>>
                    <?php echo '<' . esc_attr( $settings['tag'] ); ?>
                    class="eb-accordion-header<?php echo $accordion['active_by_default'] === 'yes' ? ' default-active' : ''; ?>">
                        <?php echo wp_kses_post($accordion['title']); ?>
                    <?php echo '</' . esc_attr( $settings['tag'] ) . '>'; ?>
                    <div class="eb-accordion-content">
                        <div class="eb-accordion-body<?php echo $accordion['active_by_default'] === 'yes' ? ' default-active' : ''; ?>">
                            <?php echo wp_kses_post( $accordion['content'] ); ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
    }
}