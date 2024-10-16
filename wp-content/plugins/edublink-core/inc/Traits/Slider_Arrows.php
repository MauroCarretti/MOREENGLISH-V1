<?php

namespace EduBlink_Core\Traits;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Border;
use \Elementor\Group_Control_Box_Shadow;

trait Slider_Arrows {

	protected function arrows() {
		if( 'slider' === $this->default_display_type ) :
			$this->start_controls_section(
	            'arrows_style',
	            [
	                'label'     => __( 'Arrows', 'edublink-core' ),
	                'tab'       => Controls_Manager::TAB_STYLE,
	                'condition' => [
	                    'arrows_and_dots' => [ 'arrows', 'both' ]
	                ]
	            ]
	        );
	    else :
	    	$this->start_controls_section(
	            'arrows_style',
	            [
	                'label'     => __( 'Arrows', 'edublink-core' ),
	                'tab'       => Controls_Manager::TAB_STYLE,
	                'condition' => [
						'arrows_and_dots' => [ 'arrows', 'both' ],
						'display_type'    => 'slider'
	                ]
	            ]
	        );
	   	endif;

        $this->add_control(
            'arrows_position',
            [
                'label'       => __( 'Position', 'edublink-core' ),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'default',
                'options'     => [
                    'default'   => __( 'Default', 'edublink-core' ),
                    'top-right' => __( 'Top Right', 'edublink-core' )
                ]
            ]
        );

    	$this->end_controls_section();
	}
}