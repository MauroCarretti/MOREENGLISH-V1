<?php

namespace EduBlink_Core\Traits;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use \Elementor\Controls_Manager;

trait Slider {

	protected function settings() {

        if( 'slider' === $this->default_display_type ) :
            $this->start_controls_section(
                'slider_settings',
                [
                    'label' => __( 'Slider Settings', 'edublink-core' )
                ]
            );
        else :
            $this->start_controls_section(
                'slider_settings',
                [
                    'label'     => __( 'Slider Settings', 'edublink-core' ),
                    'condition' => [
                        'display_type'    => 'slider'
                    ]
                ]
            );
        endif;

        $this->add_control(
            'desktop_columns',
            [
                'label'        => __( 'Desktop Columns', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 1,
                        'max'  => $this->desktop_max_slider,
                        'step' => 1
                    ]
                ],
                'default'      => [
                    'size'     => $this->desktop_default_slider
                ],
                'description'  => __( 'Number of columns( starts from 1200px ). A maximum of ' . $this->desktop_max_slider . ' items are allowed.', 'edublink-core' )
            ]
        );

        $this->add_control(
            'tablet_columns',
            [
                'label'        => __( 'Tablet Columns', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 1,
                        'max'  => $this->tablet_max_slider,
                        'step' => 1
                    ]
                ],
                'default'      => [
                    'size'     => $this->tablet_default_slider
                ],
                'description'  => __( 'Number of columns in tablet( 768px to 1199px ). A maximum of ' . $this->tablet_max_slider . ' items are allowed.', 'edublink-core' )
            ]
        );

        $this->add_control(
            'mobile_columns',
            [
                'label'        => __( 'Mobile Columns', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 1,
                        'max'  => $this->mobile_max_slider,
                        'step' => 1
                    ]
                ],
                'default'      => [
                    'size'     => $this->mobile_default_slider
                ],
                'description'  => __( 'Number of columns in mobile( 576px to 767px ). A maximum of ' . $this->mobile_max_slider . ' items are allowed.', 'edublink-core' )
            ]
        );

        $this->add_control(
            'small_mobile_columns',
            [
                'label'        => __( 'Small Mobile Columns', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 1,
                        'max'  => 2,
                        'step' => 1
                    ]
                ],
                'default'      => [
                    'size'     => 1
                ],
                'description'  => __( 'Number of columns in mobile( 300px to 575px ). A maximum of 2 items are allowed.', 'edublink-core' )
            ]
        );

        $this->add_control(
            'transition_duration',
            [
                'label'     => __( 'Transition Duration', 'edublink-core' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 1000
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
                'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label'     => __( 'Autoplay Speed', 'edublink-core' ),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 3000,
                'condition' => [
                    'autoplay' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'loop',
            [
                'label'        => __( 'Infinite Loop', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'arrows_and_dots',
            [
                'label'      => __( 'Arrows and Dots', 'edublink-core' ),
                'type'       => Controls_Manager::SELECT,
                'default'    => 'none',
                'options'    => [
                    'arrows' => __( 'Arrows', 'edublink-core' ),
                    'dots'   => __( 'Dots', 'edublink-core' ),
                    'both'   => __( 'Arrows and Dots', 'edublink-core' ),
                    'none'   => __( 'None', 'edublink-core' )
                ]
            ]
        );

        $this->end_controls_section();
	}
}