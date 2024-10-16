<?php

namespace EduBlinkCore\Widgets;

use \EduBlinkCore\Helper;
use \Elementor\Controls_Manager;
use \Elementor\Group_Control_Typography;
use \Elementor\Group_Control_Box_Shadow;
use \Elementor\Group_Control_Border;
use \Elementor\Icons_Manager;
use \Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * EduBlink Core
 *
 * Elementor widget for mailchimp.
 *
 * @since 1.0.0
 */
class MailChimp extends Widget_Base {

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
        return 'edublink-mailchimp';
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
        return __( 'MailChimp', 'edublink-core' );
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
        return 'edublink-elementor-icon eicon-mailchimp';
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
        return [ 'edublink', 'mailchimp', 'subscription', 'mailing', 'form', 'email', 'collection' ];
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
        return [ 'edublink-core' ];
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

        $admin_link    = admin_url( 'admin.php?page=edublink_options&tab=1' );
        $api_link      = 'https://rudrastyh.com/mailchimp-api/subscription.html#api';

        $this->start_controls_section(
            'section_mailchimp',
            [
                'label' => __( 'MailChimp', 'edublink-core' )
            ]
        );

        $this->add_control(
            'mailchimp_items',
            [
                'label'       => __( 'Mailchimp List', 'edublink-core' ),
                'type'        => Controls_Manager::SELECT,
                'label_block' => false,
                'options'     => Helper::retrieve_mailchimp_items(),
                'description' => sprintf( __( 'To display MailChimp without an issue, you need to configure MailChimp API key. Please configure API key from the "API Keys" tab <a href="%s" target="_blank" rel="noopener">here</a>. This <a href="%s" target="_blank" rel="noopener">article</a> will help you to find out your API.', 'edublink-core' ), esc_url( $admin_link ), esc_url( $api_link ) )
            ]
        );

        $this->add_control(
            'display_type',
            [
                'label'          => __( 'Display Type', 'edublink-core' ),
                'type'           => Controls_Manager::SELECT,
                'default'        => 'horizontal',
                'options'        => [
                    'horizontal' => __( 'Horizontal', 'edublink-core' ),
                    'vertical'   => __( 'Vertical', 'edublink-core' )
                ]
            ]
        );

        $this->add_control(
            'enable_horizontal_to_vertical',
            [
                'label'       => __( 'Vertical On Mobile', 'edublink-core' ),
                'type'        => Controls_Manager::SWITCHER,
                'label_on'    => __( 'Enable', 'edublink-core' ),
                'label_off'   => __( 'Disable', 'edublink-core' ),
                'default'     => 'yes',
                'description' => __( 'This option will only mobile devices which screen size is less than 768px. ', 'edublink-core' ),
                'condition'   => [
                    'display_type' => 'horizontal'
                ]
            ]
        );

        $this->add_control(
            'enable_label',
            [
                'label'        => __( 'Label', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'no',
                'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'enable_placeholder',
            [
                'label'        => __( 'Enable Placeholder', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'yes',
                'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'email_label',
            [
                'label'       => __( 'Label for Email', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => false,
                'default'     => __( 'Email', 'edublink-core' ),
                'condition'   => [
                    'enable_label' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'email_placeholder',
            [
                'label'       => __( 'Placeholder for Email', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => false,
                'default'     => __( 'Email', 'edublink-core' ),
                'condition'   => [
                    'enable_placeholder' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'enable_mail_icon',
            [
                'label'        => __( 'Mail Icon', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'no',
                'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'mail_icon',
            [
                'label'       => __( 'Mail Icon', 'edublink-core' ),
                'type'        => Controls_Manager::ICONS,
                'condition'   => [
                    'enable_mail_icon' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'enable_firstname',
            [
                'label'        => __( 'First Name', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'no',
                'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'firstname_label',
            [
                'label'       => __( 'Label for First Name', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => false,
                'default'     => __( 'First Name', 'edublink-core' ),
                'condition'   => [
                    'enable_firstname' => 'yes',
                    'enable_label'     => 'yes'
                ]
            ]
        );

        $this->add_control(
            'firstname_placeholder',
            [
                'label'       => __( 'Placeholder for First Name', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => false,
                'default'     => __( 'First Name', 'edublink-core' ),
                'condition'   => [
                    'enable_firstname'   => 'yes',
                    'enable_placeholder' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'enable_lastname',
            [
                'label'        => __( 'Last Name', 'edublink-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => __( 'Enable', 'edublink-core' ),
                'label_off'    => __( 'Disable', 'edublink-core' ),
                'default'      => 'no',
                'return_value' => 'yes'
            ]
        );

        $this->add_control(
            'lastname_label',
            [
                'label'       => __( 'Label for Last Name', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => false,
                'default'     => __( 'Last Name', 'edublink-core' ),
                'condition'   => [
                    'enable_lastname' => 'yes',
                    'enable_label'    => 'yes'
                ]
            ]
        );

        $this->add_control(
            'lastname_placeholder',
            [
                'label'       => __( 'Placeholder for Last Name', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => false,
                'default'     => __( 'Last Name', 'edublink-core' ),
                'condition'   => [
                    'enable_lastname'    => 'yes',
                    'enable_placeholder' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label'       => __( 'Button Text', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => false,
                'default'     => __( 'Subscribe', 'edublink-core' )
            ]
        );

        $this->add_control(
            'button_icon',
            [
                'label'       => __( 'Button Icon', 'edublink-core' ),
                'type'        => Controls_Manager::ICONS
            ]
        );

        $this->add_control(
            'loading_text',
            [
                'label'       => __( 'Loading Text', 'edublink-core' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => false,
                'default'     => __( 'Submitting...', 'edublink-core' )
            ]
        );

        $this->add_control(
            'success_text',
            [
                'label'       => __( 'Success Text', 'edublink-core' ),
                'type'        => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default'     => __( 'You have subscribed successfully...', 'edublink-core' )
            ]
        );

        $this->add_control(
            'error_text',
            [
                'label'       => __( 'Error Text', 'edublink-core' ),
                'type'        => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default'     => __( 'Something went wrong, please try again later.', 'edublink-core' )
            ]
        );

        $this->add_control(
            'notification_text',
            [
                'label'       => __( 'Notification Text', 'edublink-core' ),
                'type'        => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'default'     => __( 'Please insert your API key first.', 'edublink-core' )
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
          'mailchimp_style',
            [
                'label' => __( 'Field', 'edublink-core' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'horizontal_alignment',
            [
                'label'     => __( 'Horizontal Content Alignment', 'edublink-core' ),
                'type'      => Controls_Manager::CHOOSE,
                'default'   => 'flex-start',
                'options'   => [
                    'flex-start' => [
                        'title'  => __( 'Left', 'edublink-core' ),
                        'icon'   => 'eicon-text-align-left'
                    ],
                    'center'     => [
                        'title'  => __( 'Center', 'edublink-core' ),
                        'icon'   => 'eicon-text-align-center'
                    ],
                    'flex-end'   => [
                        'title'  => __( 'Right', 'edublink-core' ),
                        'icon'   => 'eicon-text-align-right'
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .edublink-mailchimp-wrapper.edublink-mailchimp-horizontal-type .edublink-mailchimp-form-container' => 'justify-content: {{VALUE}};'
                ],
                'condition' => [
                    'display_type' => 'horizontal'
                ]
            ]
        );

        $this->add_control(
            'vertical_alignment',
            [
                'label'     => __( 'Vertical Content Alignment', 'edublink-core' ),
                'type'      => Controls_Manager::CHOOSE,
                'default'   => 'default',
                'options'       => [
                    'default'   => [
                        'title' => __( 'Default', 'edublink-core' ),
                        'icon'  => 'eicon-ban'
                    ],
                    'left'      => [
                        'title' => __( 'Left', 'edublink-core' ),
                        'icon'  => 'eicon-text-align-left'
                    ],
                    'center'    => [
                        'title' => __( 'Center', 'edublink-core' ),
                        'icon'  => 'eicon-text-align-center'
                    ],
                    'right'     => [
                        'title' => __( 'Right', 'edublink-core' ),
                        'icon'  => 'eicon-text-align-right'
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .edublink-mailchimp-wrapper.edublink-mailchimp-vertical-type .edublink-mailchimp-item, {{WRAPPER}} .edublink-mailchimp-submit-btn' => 'text-align: {{VALUE}};'
                ],
                'condition' => [
                    'display_type' => 'vertical'
                ],
                'description' => __( 'It only work if you set a width except 100%.', 'edublink-core' )
            ]
        );
        
        $this->add_responsive_control(
            'field_width',
            [
                'label'       => __( 'Width', 'edublink-core' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px', '%' ],
                'range'       => [
                    'px'      => [
                        'min' => 100,
                        'max' => 1500
                    ],
                    '%'       => [
                        'min' => 1,
                        'max' => 100
                    ]
                ],
                'default'     => [
                    'unit'    => '%',
                    'size'    => 100
                ],
                'selectors'   => [
                    '{{WRAPPER}} .edublink-mailchimp-form-container .edublink-mailchimp-input-field' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'field_height',
            [
                'label'       => __( 'Height', 'edublink-core' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px', '%' ],
                'range'       => [
                    'px'      => [
                        'min' => 0,
                        'max' => 300
                    ]
                ],
                'default'     => [
                    'unit'    => 'px',
                    'size'    => 60
                ],
                'selectors'   => [
                    '{{WRAPPER}} .edublink-mailchimp-form-container .edublink-mailchimp-input-field' => 'height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'field_color',
            [
                'label'     => __( 'Text Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,         
                'selectors' => [
                    '{{WRAPPER}} .edublink-mailchimp-wrapper .edublink-mailchimp-input-field' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'field_bg_color',
            [
                'label'     => __( 'Background Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-mailchimp-wrapper .edublink-mailchimp-input-field' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'field_padding',
            [
                'label'      => __( 'Padding', 'edublink-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'default'    => [
                    'top'      => '13',
                    'right'    => '12',
                    'bottom'   => '13',
                    'left'     => '52',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .edublink-mailchimp-wrapper .edublink-mailchimp-input-field' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $spacing = is_rtl() ? 'left' : 'right';
        $reverse_spacing = is_rtl() ? 'right' : 'left';
        $this->add_responsive_control(
            'field_spacing',
            [
                'label'        => __( 'Spacing', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'range'        => [
                    'px'       => [
                        'min'  => 0,
                        'max'  => 200,
                        'step' => 1
                    ]
                ],
                'default'      => [
                    'unit'     => 'px',
                    'size'     => 30
                ],
                'size_units'   => [ 'px', 'em', '%' ],
                'selectors'    => [
                    '{{WRAPPER}} .edublink-mailchimp-wrapper.edublink-mailchimp-horizontal-type .edublink-mailchimp-item:not(:last-child)' => 'margin-' . $spacing . ': {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .edublink-mailchimp-wrapper.edublink-mailchimp-vertical-type .edublink-mailchimp-item:not(:last-child)'   => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'field_border_radius',
            [
                'label'      => __( 'Border Radius', 'edublink-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .edublink-mailchimp-wrapper .edublink-mailchimp-input-field' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'field_typography',
                'selector' => '{{WRAPPER}} .edublink-mailchimp-wrapper .edublink-mailchimp-input-field'
            ]
        );
        
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'                   => 'field_box_shadow',
                'selector'               => '{{WRAPPER}} .edublink-mailchimp-wrapper .edublink-mailchimp-input-field'
            ]
        );   

        $this->start_controls_tabs( 'field_tabs' );

            $this->start_controls_tab( 'field_normal', [ 'label' => __( 'Normal', 'edublink-core' ) ] );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'               => 'field_border',
                    'fields_options'     => [
                        'border'         => [
                            'default'    => 'solid'
                        ],
                        'width'          => [
                            'default'    => [
                                'top'    => '1',
                                'right'  => '1',
                                'bottom' => '1',
                                'left'   => '1'
                            ]
                        ],
                        'color'          => [
                            'default'    => '#000000'
                        ]
                    ],
                    'selector'           => '{{WRAPPER}} .edublink-mailchimp-wrapper .edublink-mailchimp-input-field'
                ]
            );

            $this->end_controls_tab();

            $this->start_controls_tab( 'field_focus', [ 'label' => __( 'Focus', 'edublink-core' ) ] );

            $this->add_group_control(
                Group_Control_Border::get_type(),
                [
                    'name'            => 'field_border_on_focus',
                    'selector'        => '{{WRAPPER}} .edublink-mailchimp-wrapper .edublink-mailchimp-input-field:focus'
                ]
            );

            $this->end_controls_tab();
        
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
          'label_style',
            [
                'label'     => __( 'Label', 'edublink-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'enable_label' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'label_typography',
                'selector' => '{{WRAPPER}} .edublink-mailchimp-wrapper label'
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label'     => __( 'Text Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-mailchimp-wrapper label' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'label_spacing',
            [
                'label'       => __( 'Spacing', 'edublink-core' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px' ],
                'selectors'   => [
                    '{{WRAPPER}} .edublink-mailchimp-wrapper .edublink-mailchimp-form-container label' => 'margin-bottom: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'mail_icon_style',
            [
                'label' => __( 'Mail Icon', 'edublink-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition'   => [
                    'enable_mail_icon' => 'yes',
                    'mail_icon[value]!'  => ''
                ]
            ]
        );

        $this->add_responsive_control(
            'mail_icon_font_size',
            [
                'label'        => __( 'Size', 'edublink-core' ),
                'type'         => Controls_Manager::SLIDER,
                'size_units'   => [ 'px' ],
                'selectors'   => [
                    '{{WRAPPER}} .edublink-mailchimp-email .mail-icon i' => 'font-size: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'mail_icon_top_spacing',
            [
                'label'         => __( 'Top Spacing', 'edublink-core' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => -250,
                        'max'   => 250
                    ]
                ],              
                'selectors'     => [
                    '{{WRAPPER}} .edublink-mailchimp-email .mail-icon' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'mail_icon_side_spacing',
            [
                'label'         => __( 'Side Spacing', 'edublink-core' ),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'max'   => 250
                    ]
                ],              
                'selectors'     => [
                    '{{WRAPPER}} .edublink-mailchimp-email .mail-icon' => 'left: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
          'placeholder_style',
            [
                'label'     => __( 'Placeholder', 'edublink-core' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'enable_placeholder' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'placeholder_color',
            [
                'label'     => __( 'Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,         
                'selectors' => [
                    '{{WRAPPER}} .edublink-mailchimp-wrapper ::-webkit-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .edublink-mailchimp-wrapper ::-moz-placeholder'          => 'color: {{VALUE}};',
                    '{{WRAPPER}} .edublink-mailchimp-wrapper ::-ms-input-placeholder'     => 'color: {{VALUE}};'
                ]
            ]
        );  

        $this->end_controls_section();

        $this->start_controls_section(
            'submit_button_style',
            [
                'label' => __( 'Submit Button', 'edublink-core' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'submit_button_color_style',
            [
                'label'        => __( 'Color Style', 'edublink-core' ),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'default',
                'options'      => [
                    'default'  => __( 'Default', 'edublink-core' ),
                    'style-1'  => __( 'Hover Gradient', 'edublink-core' ),
                    'style-2'  => __( 'Style 2', 'edublink-core' )
                ]
            ]
        );

        $this->add_control(
            'submit_button_border_style',
            [
                'label'        => __( 'Border Style', 'edublink-core' ),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'b-default',
                'options'      => [
                    'b-default'  => __( 'Default', 'edublink-core' ),
                    'b-style-1'  => __( 'Curved Border', 'edublink-core' )
                ]
            ]
        );

        $this->add_responsive_control(
            'submit_buttn_width',
            [
                'label'       => __( 'Button Width', 'edublink-core' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px', 'em', '%' ],
                'range'       => [
                    'px'      => [
                        'min' => 10,
                        'max' => 1500
                    ]
                ],
                'selectors'   => [
                    '{{WRAPPER}} button.edublink-mailchimp-subscribe-btn.edublink-button-item' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'button_height',
            [
                'label'       => __( 'Height', 'edublink-core' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px' ],
                'range'       => [
                    'px'      => [
                        'min' => 0,
                        'max' => 300
                    ]
                ],
                'selectors'   => [
                    '{{WRAPPER}} .edublink-mailchimp-form-container .edublink-button-item' => 'height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'button_line_height',
            [
                'label'       => __( 'Line Height', 'edublink-core' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px' ],
                'range'       => [
                    'px'      => [
                        'min' => 0,
                        'max' => 300
                    ]
                ],
                'selectors'   => [
                    '{{WRAPPER}} .edublink-mailchimp-form-container .edublink-button-item' => 'line-height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'submit_buttn_icon_spacing',
            [
                'label'       => __( 'Icon Spacing', 'edublink-core' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px' ],
                'range'       => [
                    'px'      => [
                        'min' => 0,
                        'max' => 50
                    ]
                ],
                'selectors'   => [
                    '{{WRAPPER}} .edublink-mailchimp-wrapper .edublink-mailchimp-subscribe-btn-icon' => 'margin-' . $reverse_spacing . ': {{SIZE}}{{UNIT}};'
                ],
                'condition'   => [
                    'button_icon[value]!'  => ''
                ]
            ]
        );

        $this->add_responsive_control(
            'submit_buttn_icon_top_spacing',
            [
                'label'       => __( 'Icon Top Spacing', 'edublink-core' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px' ],
                'range'       => [
                    'px'      => [
                        'min' => 0,
                        'max' => 50
                    ]
                ],
                'selectors'   => [
                    '{{WRAPPER}} .edublink-mailchimp-wrapper .edublink-mailchimp-subscribe-btn i' => 'top: {{SIZE}}{{UNIT}};'
                ],
                'condition'   => [
                    'button_icon[value]!'  => ''
                ]
            ]
        );
        
        $this->add_control(
            'submit_buttn_alignment',
            [
                'label'         => __( 'Alignment', 'edublink-core' ),
                'type'          => Controls_Manager::CHOOSE,
                'label_block'   => true,
                'default'       => 'default',
                'options'       => [
                    'default'   => [
                        'title' => __( 'Default', 'edublink-core' ),
                        'icon'  => 'eicon-ban'
                    ],
                    'left'      => [
                        'title' => __( 'Left', 'edublink-core' ),
                        'icon'  => 'eicon-text-align-left'
                    ],
                    'center'    => [
                        'title' => __( 'Center', 'edublink-core' ),
                        'icon'  => 'eicon-text-align-center'
                    ],
                    'right'     => [
                        'title' => __( 'Right', 'edublink-core' ),
                        'icon'  => 'eicon-text-align-right'
                    ]
                ],
                'selectors' => [
                    '{{WRAPPER}} .edublink-mailchimp-wrapper .edublink-mailchimp-submit-btn' => 'text-align: {{VALUE}};'
                ],
                'condition'     => [
                    'display_type' => 'vertical'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'submit_buttn_typography',
                'selector' => '{{WRAPPER}} button.edublink-mailchimp-subscribe-btn.edublink-button-item'
            ]
        );

        $this->add_responsive_control(
            'submit_buttn_spacing',
            [
                'label'       => __( 'Spacing', 'edublink-core' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => [ 'px' ],
                'range'       => [
                    'px'      => [
                        'min' => 0,
                        'max' => 50
                    ]
                ],
                'selectors'   => [
                    '{{WRAPPER}} button.edublink-mailchimp-subscribe-btn.edublink-button-item' => 'margin-top: {{SIZE}}{{UNIT}};'
                ]
            ]
        ); 
        
        $this->add_responsive_control(
            'submit_buttn_padding',
            [
                'label'        => __( 'Padding', 'edublink-core' ),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => [ 'px', 'em', '%' ],
                'selectors'    => [
                    '{{WRAPPER}} button.edublink-mailchimp-subscribe-btn.edublink-button-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );      
        
        $this->add_responsive_control(
            'submit_buttn_margin',
            [
                'label'        => __( 'Margin', 'edublink-core' ),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => [ 'px', 'em', '%' ],
                'selectors'    => [
                    '{{WRAPPER}} .edublink-mailchimp-submit-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );      

        $this->add_responsive_control(
            'submit_buttn_border_radius',
            [
                'label'        => __( 'Border Radius', 'edublink-core' ),
                'type'         => Controls_Manager::DIMENSIONS,
                'size_units'   => ['px', '%'],
                'default'      => [
                    'top'      => '5',
                    'right'    => '5',
                    'bottom'   => '5',
                    'left'     => '5',
                    'unit'     => 'px',
                    'isLinked' => true,
                ],
                'selectors'    => [
                    '{{WRAPPER}} button.edublink-mailchimp-subscribe-btn.edublink-button-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'condition' => [
                    'submit_button_border_style' => 'b-default'
                ]
            ]
        );
        
        $this->start_controls_tabs( 
            'submit_button_tabs',
            [
                'condition'   => [
                    'submit_button_color_style' => 'default'
                ]
            ]
        );

        $this->start_controls_tab( 'submit_button_normal', [ 'label' => __( 'Normal', 'edublink-core' ) ] );

        $this->add_responsive_control(
            'submit_buttn_text_color',
            [
                'label'     => __( 'Text Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} button.edublink-mailchimp-subscribe-btn.edublink-button-item' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'submit_buttn_background_color',
            [
                'label'     => __( 'Background Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} button.edublink-mailchimp-subscribe-btn.edublink-button-item' => 'background-color: {{VALUE}};'
                ]
            ]
        );
        
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'submit_buttn_border',
                'selector' => '{{WRAPPER}} button.edublink-mailchimp-subscribe-btn.edublink-button-item'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'submit_buttn_box_shadow',
                'selector' => '{{WRAPPER}} button.edublink-mailchimp-subscribe-btn.edublink-button-item'
            ]
        ); 
        
        $this->end_controls_tab();

        $this->start_controls_tab( 'submit_button_hover', [ 'label' => __( 'Hover', 'edublink-core' ) ] );

        $this->add_responsive_control(
            'submit_buttn_hover_text_color',
            [
                'label'     => __( 'Text Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} button.edublink-mailchimp-subscribe-btn.edublink-button-item:hover' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'submit_buttn_hover_background_color',
            [
                'label'     => __( 'Background Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} button.edublink-mailchimp-subscribe-btn.edublink-button-item:hover' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'submit_buttn_hover_border',
                'selector' => '{{WRAPPER}} button.edublink-mailchimp-subscribe-btn.edublink-button-item:hover'
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'submit_buttn_hover_box_shadow',
                'selector' => '{{WRAPPER}} button.edublink-mailchimp-subscribe-btn.edublink-button-item:hover'
            ]
        ); 
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->end_controls_section();

        $this->start_controls_section(
            'message_style',
            [
                'label' => __( 'Message', 'edublink-core' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'success_message_style',
            [
                'label' => __( 'Success Message', 'edublink-core' ),
                'type'  => Controls_Manager::HEADING
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'success_message_typography',
                'selector' => '{{WRAPPER}} .edublink-mailchimp-success-message p'
            ]
        );

        $this->add_control(
            'success_message_color',
            [
                'label'     => __( 'Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-mailchimp-success-message p' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'error_message_style',
            [
                'label'     => __( 'Error Message', 'edublink-core' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'error_message_typography',
                'selector' => '{{WRAPPER}} .edublink-mailchimp-error-message p'
            ]
        );

        $this->add_control(
            'error_message_color',
            [
                'label'     => __( 'Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-mailchimp-error-message p' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'notification_message_style',
            [
                'label'     => __( 'Notification Message', 'edublink-core' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'notification_message_typography',
                'selector' => '{{WRAPPER}} .edublink-mailchimp-notification-message p'
            ]
        );

        $this->add_control(
            'notification_message_color',
            [
                'label'     => __( 'Color', 'edublink-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .edublink-mailchimp-notification-message p' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();
      
    }

    protected function render() {
        $settings          = $this->get_settings();
        $api_key           = edublink_set_value( 'mailchimp_api' );
        $email_placeholder = $firsname_placeholder = $lastname_placeholder = '';

        if ( 'yes' === $settings['enable_placeholder'] ) :
            $email_placeholder    = $settings['email_placeholder'];
            $firsname_placeholder = $settings['firstname_placeholder'];
            $lastname_placeholder = $settings['lastname_placeholder'];
        endif;

        $this->add_render_attribute(
            'edublink-mailchimp-wrapper',
            [
                'class'             => [ 
                    'edublink-mailchimp-wrapper', 
                    'edublink-mailchimp-' . esc_attr( $settings['display_type'] ) . '-type'
                ],
                'data-mailchimp-id' => esc_attr( $this->get_id() ),
                'data-api-key'      => esc_attr( $api_key ),
                'data-list-id'      => esc_attr( $settings['mailchimp_items'] ),
                'data-button-text'  => esc_attr( $settings['button_text'] ),
                'data-success-text' => esc_attr( $settings['success_text'] ),
                'data-error-text'   => esc_attr( $settings['error_text'] ),
                'data-loading-text' => esc_attr( $settings['loading_text'] )
            ]
        );

        if ( 'vertical' === $settings['display_type'] ) :
            $this->add_render_attribute( 'edublink-mailchimp-wrapper', 'class', 'button-align-' . esc_attr( $settings['submit_buttn_alignment'] ) );
        else :
            $this->add_render_attribute( 'edublink-mailchimp-wrapper', 'class', 'edublink-mailchimp-mobile-' . esc_attr( $settings['enable_horizontal_to_vertical'] ) );
        endif;
        
        if ( ! empty( $api_key ) ) :
            echo '<div ' . $this->get_render_attribute_string( 'edublink-mailchimp-wrapper' ) . '>';
                echo '<form id="edublink-mailchimp-form-' . esc_attr( $this->get_id() ) . '" method="POST">';
                    echo '<div class="edublink-mailchimp-form-container">';
                        echo '<div class="edublink-mailchimp-item edublink-mailchimp-email">';
                            if ( 'yes' === $settings['enable_label'] ) :
                                echo $settings['email_label'] ? '<label for="' . esc_attr( $settings['email_label'] ) . '">' . esc_html( $settings['email_label'] ) . '</label>' : '';
                            endif;
                            echo '<input type="email" name="edublink_mailchimp_email" class="edublink-mailchimp-input-field" placeholder="' . esc_attr( $email_placeholder ) . '" required="required">';

                            if ( 'yes' === $settings['enable_mail_icon'] ) :
                                if ( ! empty( $settings['mail_icon']['value'] ) ) :
                                    echo '<span class="mail-icon">';
                                        Icons_Manager::render_icon( $settings['mail_icon'], [ 'aria-hidden' => 'true' ] );
                                    echo '</span>';
                                endif;
                            endif;
                        echo '</div>';

                        if ( 'yes' === $settings['enable_firstname'] ) :
                            echo '<div class="edublink-mailchimp-item edublink-mailchimp-firstname">';
                                if ( 'yes' === $settings['enable_label'] ) :
                                    echo $settings['firstname_label'] ? '<label for="' . esc_attr( $settings['firstname_label'] ) . '">' . esc_html( $settings['firstname_label'] ) . '</label>' : '';
                                endif;
                                echo '<input type="text" name="edublink_mailchimp_firstname" class="edublink-mailchimp-input-field" placeholder="' . esc_attr( $firsname_placeholder ) . '">';
                            echo '</div>';
                        endif;

                        if ( 'yes' === $settings['enable_lastname'] ) :
                            echo '<div class="edublink-mailchimp-item edublink-mailchimp-lastname">';
                                if ( 'yes' === $settings['enable_label'] ) :
                                    echo $settings['lastname_label'] ? '<label for="' . esc_attr( $settings['lastname_label'] ) . '">' . esc_html( $settings['lastname_label'] ) . '</label>' : '';
                                endif;
                                echo '<input type="text" name="edublink_mailchimp_lastname" class="edublink-mailchimp-input-field" placeholder="' . esc_attr( $lastname_placeholder ) . '">';
                            echo '</div>';
                        endif;

                        echo '<div class="edublink-mailchimp-submit-btn">';
                            echo '<button class="edublink-mailchimp-subscribe-btn edublink-button-item edublink-button-type-fill ' . esc_attr( $settings['submit_button_color_style'] ) . ' ' . esc_attr( $settings['submit_button_border_style'] ) . '">';
                                echo $settings['button_text'] ? '<span class="edublink-mailchimp-subscribe-btn-text">' . esc_html( $settings['button_text'] ) . '</span>' : '';
                                if ( ! empty( $settings['button_icon']['value'] ) ) :
                                    echo '<span class="edublink-mailchimp-subscribe-btn-icon">';
                                        Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] );
                                    echo '</span>';
                                endif;
                            echo '</button>';
                        echo '</div>';
                    echo '</div>';
                echo '</form>';
            echo '</div>';
        else :
            echo $settings['notification_text'] ? '<p class="edublink-mailchimp-notification-message">' . esc_html( $settings['notification_text'] ) . '</p>' : '';
        endif;
    }
}