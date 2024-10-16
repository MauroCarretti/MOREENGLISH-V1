<?php

namespace EduBlink_Core\Traits;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use \EduBlinkCore\Helper;
use \Elementor\Controls_Manager;
trait Users {

    protected function query() {
        if ( NULL === $this->default_content_type ) :
            $this->start_controls_section(
                'query_settings',
                [
                    'label'     => __( 'Query Settings', 'edublink-core' )
                ]
            );
        else :
            $this->start_controls_section(
                'query_settings',
                [
                    'label'     => __( 'Query Settings', 'edublink-core' ),
                    'condition' => [
                        'content_type' => 'dynamic'
                    ]
                ]
            );
        endif;

        $this->add_control(
            'image_size',
            [
                'label'       => __( 'Image Size', 'edublink-core' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px' ],
                'range'       => [
                    'px'      => [
                        'min' => 100,
                        'max' => 1200
                    ]
                ],
                'default'     => [
                    'unit'    => 'px',
                    'size'    => $this->image_size
                ]
            ]
        );

        $this->add_control(
            'per_page',
            [
                'label'         => __( 'Number Of Instructors', 'edublink-core' ),
                'type'          => Controls_Manager::SLIDER,
                'description'   =>  __( 'Number of instructors to show. Default -1, it will show all.', 'edublink-core' ),
                'default'       => [
                    'size'      => -1,
                ],
                'range'         => [
                    'px'        => [
                        'min'   => -1
                    ]
                ]
            ]
        ); 

        $this->add_control(
            'order',
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
            'order_by',
            [
                'type'              => Controls_Manager::SELECT,
                'label'             => __( 'Order by', 'edublink-core' ),
                'default'           => 'date',
                'description'       => __( 'Orderby', 'edublink-core' ),
                'options'           => [
                    'none'            => __( 'No order', 'edublink-core' ),
                    'ID'              => __( 'User ID', 'edublink-core' ),
                    'display_name'    => __( 'Display Name', 'edublink-core' ),
                    'user_name'       => __( 'User Name', 'edublink-core' ),
                    'include'         => __( 'Include', 'edublink-core' ),
                    'user_login'      => __( 'User Login', 'edublink-core' ),
                    'user_nicename'   => __( 'User Nicename', 'edublink-core' ),
                    'user_url'        => __( 'User URL', 'edublink-core' ),
                    'user_registered' => __( 'User Registered', 'edublink-core' ),
                    'post_count'      => __( 'Post Count', 'edublink-core' )
                ]
            ]
        );
        
        $this->add_control(
            'specific_user_include',
            [   
                'label'       => __( 'Specific Instructors( Include )', 'edublink-core' ),
                'label_block' => true,
                'type'        => Controls_Manager::SELECT2,
                'multiple'    => true,
                'options'     => edublink_get_all_instructors( $this->instructor ),
                'description' => __( 'It will show the selected instructors only.', 'edublink-core' )

            ]
        );

        $this->add_control(
            'specific_user_exclude',
            [   
                'label'       => __( 'Specific Instructors( Exclude )', 'edublink-core' ),
                'label_block' => true,
                'type'        => Controls_Manager::SELECT2,
                'multiple'    => true,
                'options'     => edublink_get_all_instructors( $this->instructor ),
                'description' => __( 'It will hide the selected instructors only.', 'edublink-core' )

            ]
        );

        $this->end_controls_section();
    }
}