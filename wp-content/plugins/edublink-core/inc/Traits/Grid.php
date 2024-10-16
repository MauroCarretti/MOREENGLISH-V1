<?php

namespace EduBlink_Core\Traits;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use \Elementor\Controls_Manager;

trait Grid {

	protected function settings() {

        if( 'grid' === $this->default_display_type ) :
            $this->start_controls_section(
                'grid_settings',
                [
                    'label'     => __( 'Grid Settings', 'edublink-core' )
                ]
            );
        else :
            $this->start_controls_section(
                'grid_settings',
                [
                    'label'     => __( 'Grid Settings', 'edublink-core' ),
                    'condition' => [
                        'display_type' => 'grid'
                    ]
                ]
            );
        endif;

        $this->add_control(
            'desktop_grid_columns',
            [
                'label'        => __( 'Desktop Columns', 'edublink-core' ),
                'type'         => Controls_Manager::SELECT,
                'default'      => $this->desktop_default_grid,
                'options'      => [
                    '1' => __( '1 Column', 'edublink-core' ),
                    '2' => __( '2 Columns', 'edublink-core' ),
                    '3' => __( '3 Columns', 'edublink-core' ),
                    '4' => __( '4 Columns', 'edublink-core' ),
                    '5' => __( '5 Columns', 'edublink-core' ),
                    '6' => __( '6 Columns', 'edublink-core' )
                ]
            ]
        );

        $this->add_control(
            'tablet_grid_columns',
            [
                'label'        => __( 'Tablet Columns', 'edublink-core' ),
                'type'         => Controls_Manager::SELECT,
                'default'      => $this->tablet_default_grid,
                'options'      => [
                    '1' => __( '1 Column', 'edublink-core' ),
                    '2' => __( '2 Columns', 'edublink-core' ),
                    '3' => __( '3 Columns', 'edublink-core' ),
                    '4' => __( '4 Columns', 'edublink-core' ),
                    '6' => __( '6 Columns', 'edublink-core' )
                ],
                'description'  => __( 'Number of columns in tablet( up to 992 px ).', 'edublink-core' )
            ]
        );

        $this->add_control(
            'mobile_grid_columns',
            [
                'label'        => __( 'Mobile Columns', 'edublink-core' ),
                'type'         => Controls_Manager::SELECT,
                'default'      => $this->mobile_default_grid,
                'options'      => [
                    '1' => __( '1 Column', 'edublink-core' ),
                    '2' => __( '2 Columns', 'edublink-core' ),
                    '3' => __( '3 Columns', 'edublink-core' ),
                    '4' => __( '4 Columns', 'edublink-core' ),
                    '6' => __( '6 Columns', 'edublink-core' )
                ],
                'description'  => __( 'Number of columns in mobile( works between 768 to 576 px ).', 'edublink-core' )
            ]
        );

        $this->end_controls_section();
	}
}