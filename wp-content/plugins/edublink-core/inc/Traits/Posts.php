<?php

namespace EduBlink_Core\Traits;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use \EduBlinkCore\Helper;
use \Elementor\Controls_Manager;
trait Posts {

    protected function query() {

        if ( NULL === $this->post_type ) :
            $this->post_type = 'post';
        endif;

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
            'per_page',
            [
                'label'         => __( 'Number Of Posts', 'edublink-core' ),
                'type'          => Controls_Manager::SLIDER,
                'description'   =>  __( 'Number of posts to show. Default 6. If you want to show all the posts then put <b>-1</b>', 'edublink-core' ),
                'default'       => [
                    'size'      => 6,
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
            'specific_post_include',
            [   
                'label'       => __( 'Specific Posts( Include )', 'edublink-core' ),
                'label_block' => true,
                'type'        => Controls_Manager::SELECT2,
                'multiple'    => true,
                'options'     => Helper::retrieve_posts( $this->post_type ),
                'description' => __( 'It will show the selected posts only.', 'edublink-core' )

            ]
        );

        $this->add_control(
            'specific_post_exclude',
            [   
                'label'       => __( 'Specific Posts( Exclude )', 'edublink-core' ),
                'label_block' => true,
                'type'        => Controls_Manager::SELECT2,
                'multiple'    => true,
                'options'     => Helper::retrieve_posts( $this->post_type ),
                'description' => __( 'It will hide the selected posts only.', 'edublink-core' )

            ]
        );

        $this->add_control(
            'enable_only_featured_posts',
            [
                'label'        => __( 'Only Has Featured Image', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,    
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'description'  => __( 'Only show posts which has feature image set.', 'edublink-core' ),           
                'default'      => 'no',
                'return_value' => 'yes'
            ]
        );

        if ( 'post' === $this->post_type ) :
            $this->add_control(
                'ignore_sticky',
                [
                    'type'         => Controls_Manager::SWITCHER,
                    'label'        => __( 'Ignore Sticky Posts?', 'edublink-core' ),
                    'label_on'     => __( 'Enable', 'edublink-core' ),
                    'label_off'    => __( 'Disable', 'edublink-core' ),
                    'default'      => 'no',
                    'return_value' => 'yes'
                ]
            );
        endif;

        $this->add_control(
            'enable_date',
            [
                'type'         => Controls_Manager::SWITCHER,
                'label'        => __( 'Date', 'edublink-core' ),
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
                ],
                'condition'       => [
                    'enable_date' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'custom_date_format',
            [   
                'label'           => __( 'Custom Date Format', 'edublink-core' ),
                'type'            => Controls_Manager::TEXT,
                'default'         => __( 'F j, Y', 'edublink-core' ),
                'condition'       => [
                    'enable_date' => 'yes',
                    'date_format' => 'custom'
                ]
            ]
        );

        $this->add_control(
            'enable_excerpt',
            [
                'label'        => __( 'Excerpt.', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );  

        $this->add_control(
            'excerpt_length',
            [
                'label'       => __( 'Number of Words', 'edublink-core' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 20,
                'description' => __( 'Number of excerpt words.', 'edublink-core' ),
                'condition'   => [
                    'enable_excerpt' => 'yes'
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
                    'enable_excerpt' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'include_categories',
            [
                'label'       => __( 'Include Specific Category', 'edublink-core' ),
                'label_block' => true,
                'type'        => Controls_Manager::SELECT2,
                'options'     => Helper::retrieve_categories( $this->category_taxonomy, true ),
                'multiple'    => true
            ]
        );

        $this->end_controls_section();
    }
}