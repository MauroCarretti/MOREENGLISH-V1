<?php

namespace EduBlink_Core\Traits;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use \EduBlinkCore\Helper;
use \Elementor\Controls_Manager;

trait Taxonomy {

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
            'items_to_show',
            [
                'label'       => __( 'Number of Category to Show.', 'edublink-core' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 0,
                'min'         => 0,
                'step'        => 1,
                'description' => __( 'Default 0. It will show all the category items.', 'edublink-core' )
            ]
        );

        $this->add_control(
            'include_categories',
            [
                'label'       => __( 'Include Specific Category', 'edublink-core' ),
                'label_block' => true,
                'type'        => Controls_Manager::SELECT2,
                'options'     => Helper::retrieve_categories( $this->taxomy_name ),
                'multiple'    => true
            ]
        );

        $this->add_control(
            'exclude_categories',
            [
                'label'       => __( 'Exclude Specific Category', 'edublink-core' ),
                'label_block' => true,
                'type'        => Controls_Manager::SELECT2,
                'options'     => Helper::retrieve_categories( $this->taxomy_name ),
                'multiple'    => true,
                'description' => __( 'Either use exclude or include, don\'t use both together.', 'edublink-core' )
            ]
        );

        $this->add_control(
            'order_by',
            [
                'type'    => Controls_Manager::SELECT,
                'label'   => __( 'Order by', 'edublink-core' ),
                'default' => 'name',
                'options' => [
                    'name'       => __( 'Name', 'edublink-core' ),
                    'id'         => __( 'ID', 'edublink-core' ),
                    'count'      => __( 'Count', 'edublink-core' ),
                    'slug'       => __( 'Slug', 'edublink-core' ),
                    'term_group' => __( 'Term Group', 'edublink-core' ),
                    'none'       => __( 'None', 'edublink-core' )
                ]
            ]
        );

        $this->add_control(
            'order',
            [
                'type'          => Controls_Manager::SELECT,
                'label'         => __( 'Order', 'edublink-core' ),
                'default'       => 'DESC',
                'options'       => [
                    'ASC'       => __( 'Ascending', 'edublink-core' ),
                    'DESC'      => __( 'Descending', 'edublink-core' )
                ]
            ]
        );

        $this->add_control(
            'enable_parent_only',
            [
                'type'         => Controls_Manager::SWITCHER,
                'label'        => __( 'Only Top Level Category?', 'edublink-core' ),
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'no',
                'return_value' => 'yes',
                'description'  => __( 'By enabling this option, only top level category will show.', 'edublink-core' )
            ]
        );

        $this->add_control(
            'hide_empty_cat',
            [
                'type'         => Controls_Manager::SWITCHER,
                'label'        => __( 'Empty Category', 'edublink-core' ),
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );

        $this->end_controls_section();
    }
}