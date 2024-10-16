<?php

namespace EduBlink_Core\Traits;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;

trait Slider_Dots {

	protected function dots() {
        if( 'slider' === $this->default_display_type ) :
            $this->start_controls_section(
                'dots_style',
                [
                    'label'     => __( 'Dots', 'edublink-core' ),
                    'tab'       => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'arrows_and_dots' => [ 'dots', 'both' ]
                    ]
                ]
            );
        else :
            $this->start_controls_section(
                'dots_style',
                [
                    'label'     => __( 'Dots', 'edublink-core' ),
                    'tab'       => Controls_Manager::TAB_STYLE,
                    'condition' => [
                        'arrows_and_dots' => [ 'dots', 'both' ],
                        'display_type'    => 'slider'
                    ]
                ]
            );
        endif;
            
		$this->add_responsive_control(
            'dots_top_spacing',
            [
                'label'        => __( 'Top Spacing', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'size_units'   => [ 'px' ],
                'range'        => [
                    'px'       => [
                        'min'  => -300,
                        'max'  => 50,
                        'step' => 1
                    ]
                ],
                'selectors'    => [
                    '{{WRAPPER}} .edublink-slider-item .slick-dots' => 'bottom: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();
	}
}