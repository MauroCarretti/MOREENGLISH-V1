<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

if ( ! class_exists( 'EduBlink_Redux_Framework_Config' ) ) :
	class EduBlink_Redux_Framework_Config {

		public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {
            if ( ! class_exists( 'ReduxFramework' ) ) :
                return;
            endif;
            add_action( 'init', array( $this, 'initSettings' ), 10 );
        }

        public function initSettings() {
            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Create the sections and fields
            $this->setSections();

            if ( ! isset( $this->args['opt_name'] ) ) : // No errors please
                return;
            endif;

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        public function setSections() {

            $columns = array( 
                '1' => __( '1 Column', 'edublink' ),
                '2' => __( '2 Columns', 'edublink' ),
                '3' => __( '3 Columns', 'edublink' ),
                '4' => __( '4 Columns', 'edublink' )
            );

            global $wp_registered_sidebars;
            $sidebars = array();

            if ( is_admin() && ! empty( $wp_registered_sidebars ) ) :
                foreach ( $wp_registered_sidebars as $sidebar ) :
                    $sidebars[$sidebar['id']] = $sidebar['name'];
                endforeach;
            endif;

            // General
            $this->sections[] = array(
                'icon'   => 'el el-website',
                'title'  => __( 'General Settings', 'edublink' ),
                'fields' => array(
                    array(
                        'id'      => 'preloader',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'edublink' ),
                        'off'     => __( 'Disable', 'edublink' ),
                        'title'   => __( 'Preloader', 'edublink' ),
                        'default' => false
                    ),
                    array(
                        'id'       => 'preloader_type',
                        'type'     => 'select',
                        'title'    => __( 'Preloader Type', 'edublink' ),
                        'subtitle' => __( 'Choose a preloader for your website.', 'edublink' ),
                        'default'  => '3',
                        'options'  => array(
                            '1'    => 'Preloader 1',
                            '2'    => 'Preloader 2',
                            '3'    => 'Preloader 3'
                        ),
                        'required' => array( 'preloader', 'equals', true )
                    ),
                    array(
                        'id'      => 'smooth_scroll',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'edublink' ),
                        'off'     => __( 'Disable', 'edublink' ),
                        'title'   => __( 'Smooth Scroll', 'edublink' ),
                        'default' => false
                    ),
                    array(
                        'id'      => 'eb_dark_mode',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'edublink' ),
                        'off'     => __( 'Disable', 'edublink' ),
                        'title'   => __( 'Dark Mode', 'edublink' ),
                        'default' => false
                    ),
                    array(
                        'id'      => 'mailchimp_api',
                        'type'    => 'text',
                        'default' => '6b38881989adf4b2160cd9290974f7d5-us2',
                        'title'   => __( 'MailChimp API Key', 'edublink' )
                    ),
                    array(
                        'id'       => 'theme_color_section',
                        'type'     => 'section',
                        'title'    => __( 'Color', 'edublink' ),
                        'indent'   => true
                    ),
                    array(
                        'id'       => 'eb_primary_color',
                        'type'     => 'switch',
                        'on'       => __( 'Enable', 'edublink' ),
                        'off'      => __( 'Disable', 'edublink' ),
                        'title'    => __( 'Header Top Bar Status', 'edublink' ),
                        'default'  => false
                    ),
                    array(
                        'id'       => 'eb_primary_color',
                        'type'     => 'color',
                        'title'    => __( 'Primary Color', 'edublink' ), 
                        'subtitle' => __( 'default: #1ab69d', 'edublink' ),
                        'default'  => '#1ab69d',
                        'validate' => 'color'
                    ),
                    array(
                        'id'       => 'eb_primary_color_alter',
                        'type'     => 'color',
                        'title'    => __( 'Primary Color(Alter)', 'edublink' ), 
                        'subtitle' => __( 'default: #31b978', 'edublink' ),
                        'default'  => '#31b978',
                        'validate' => 'color'
                    ),
                    array(
                        'id'       => 'eb_secondary_color',
                        'type'     => 'color',
                        'title'    => __( 'Secondary Color', 'edublink' ), 
                        'subtitle' => __( 'default: #ee4a62', 'edublink' ),
                        'default'  => '#ee4a62',
                        'validate' => 'color'
                    ),
                    array(
                        'id'       => 'eb_body_color',
                        'type'     => 'color',
                        'title'    => __( 'Body Color', 'edublink' ), 
                        'subtitle' => __( 'default: #808080', 'edublink' ),
                        'default'  => '#808080',
                        'validate' => 'color'
                    ),
                    array(
                        'id'       => 'eb_heading_color',
                        'type'     => 'color',
                        'title'    => __( 'Heading Color', 'edublink' ), 
                        'subtitle' => __( 'default: #181818', 'edublink' ),
                        'default'  => '#181818',
                        'validate' => 'color',
                        'required' => array( 'eb_dark_mode', '!=', true )
                    ),
                    array(
                        'id'       => 'theme_typography_section',
                        'type'     => 'section',
                        'title'    => __( 'Typography', 'edublink' ),
                        'indent'   => true
                    ),
                    array(
                        'id'          => 'theme_body_typo',
                        'type'        => 'typography',
                        'title'       => __( 'Body', 'edublink' ),
                        'text-align'  => false,
                        'line-height' => false,
                        'font-weight' => false,
                        'font-style'  => false,
                        'color'       => false,
                        'subsets'     => false,
                        'default'     => array(
                            'google'      => true,
                            'font-family' => 'Poppins',
                            'font-size'   => '15px'
                        )
                    ),
                    array(
                        'id'          => 'theme_heading_typo',
                        'type'        => 'typography',
                        'title'       => __( 'Heading', 'edublink' ),
                        'text-align'  => false,
                        'line-height' => false,
                        'font-weight' => false,
                        'font-size'   => false,
                        'font-style'  => false,
                        'color'       => false,
                        'subsets'     => false,
                        'default'     => array(
                            'google'      => true,
                            'font-family' => 'Spartan'
                        )
                    )
                )
            );
            
            // Header
            $this->sections[] = array(
				'icon'   => 'el el-website',
				'title'  => __( 'Header Settings', 'edublink' ),
				'fields' => array(
                    array(
						'id'       => 'header_type',
						'type'     => 'select',
						'title'    => __( 'Header Layout Type', 'edublink' ),
						'subtitle' => __( 'Choose a header for your website.', 'edublink' ),'default'  => 'theme-default-header',
						'options'  => edublink_fetch_header_layouts(),
						'desc'     => sprintf( wp_kses( __( 'You can add or edit a header in <a href="%s" target="_blank">Headers Builder</a>. For the demo purpose, we have created different headers for different pages. If you set a value from here and can not see any changes in a page then it means we have made specific changes for that specific page which overwrites this Global Settings. All you need to go to the edit section of the page and set all the value like Header Top Bar Status, Header Top Bar Type, Header Layout Type etc to Global Settings.', 'edublink' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'edit.php?post_type=edublink_header' ) ) )
                    ),
                    array(
                        'id'       => 'header_white_logo',
                        'type'     => 'media',
                        'title'    => __( 'Header White Logo', 'edublink' ),
                        'subtitle' => __( 'Please note this is the white logo( not the main logo of your website ) visible only if you enable the values of "Header Transparent" & "Header White Logo" from page options. To upload the main logo please go to Appearance > Customize > Site Identity.', 'edublink' ),
                        'default'  => array(
                            'url'  => get_template_directory_uri() . '/assets/images/logo-white.png'
                        )
                    ),
                    array(
                        'id'      => 'sticky_header',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'edublink' ),
                        'off'     => __( 'Disable', 'edublink' ),
                        'title'   => __( 'Sticky Header', 'edublink' ),
                        'default' => false
                    ),
                    array(
                        'id'       => 'header_category_status',
                        'type'     => 'switch',
                        'on'       => __( 'Enable', 'edublink' ),
                        'off'      => __( 'Disable', 'edublink' ),
                        'title'    => __( 'Header Category Option', 'edublink' ),
                        'default'  => true
                    ),
                    array(
                        'id'      => 'heading_category_text',
                        'type'    => 'text',
                        'title'   => __( 'Category Title', 'edublink' ),
                        'default' => __( 'Category', 'edublink' ),
                        'required' => array( 'header_category_status', 'equals', true )
                    ),
                    array(
                        'id'        => 'heading_category_items',
                        'type'      => 'slider',
                        'title'     => __( 'Number of Courses Categories', 'edublink' ),
                        'default'   => 10,
                        'min'       => -1,
                        'step'      => 1,
                        'max'       => 15,
                        'desc'      => __( 'Number of categories you want to show. Pass 0, if you want to show all the categories.', 'edublink' ),
                        'required' => array( 'header_category_status', 'equals', true )
                    ),
                    array(
                        'id'       => 'header_button_status',
                        'type'     => 'switch',
                        'on'       => __( 'Enable', 'edublink' ),
                        'off'      => __( 'Disable', 'edublink' ),
                        'title'    => __( 'Button at header', 'edublink' ),
                        'default'  => true
                    ),
                    array(
                        'id'       => 'header_button_text',
                        'type'     => 'text',
                        'title'    => __( 'Header Button Text', 'edublink' ),
                        'desc'     => __( 'This text will replace the default "Try for free" text at Header.', 'edublink' ),
                        'required' => array( 'header_button_status', 'equals', true )
                    ),
                    array(
                        'id'       => 'header_button_url',
                        'type'     => 'text',
                        'title'    => __( 'Header Button URL', 'edublink' ),
                        'default'  => __( '#', 'edublink' ),
                        'required' => array( 'header_button_status', 'equals', true )
                    ),
                    array(
                        'id'       => 'header_button_text_after_logged_in',
                        'type'     => 'text',
                        'title'    => __( 'Header Button Text(only for logged in users)', 'edublink' ),
                    ),
                    array(
                        'id'       => 'header_button_url_after_logged_in',
                        'type'     => 'text',
                        'title'    => __( 'Header Button URL(only for logged in users)', 'edublink' ),
                    ),
                    array(
                        'id'       => 'header_button_open_same_tab',
                        'type'     => 'switch',
                        'on'       => __( 'Enable', 'edublink' ),
                        'off'      => __( 'Disable', 'edublink' ),
                        'title'    => __( 'Open In Same Tab', 'edublink' ),
                        'default'  => true,
                        'required' => array( 'header_button_status', 'equals', true )
                    ),
                    array(
                        'id'       => 'header_search_status',
                        'type'     => 'switch',
                        'on'       => __( 'Enable', 'edublink' ),
                        'off'      => __( 'Disable', 'edublink' ),
                        'title'    => __( 'Search field/toggle in header', 'edublink' ),
                        'default'  => true
                    ),
                    array(
                        'id'       => 'header_cart_status',
                        'type'     => 'switch',
                        'on'       => __( 'Enable', 'edublink' ),
                        'off'      => __( 'Disable', 'edublink' ),
                        'title'    => __( 'Cart in header', 'edublink' ),
                        'default'  => true
                    ),
                    array(
                        'id'       => 'header_top_bar_section',
                        'type'     => 'section',
                        'title'    => __( 'Header Top Bar', 'edublink' ),
                        'indent'   => true
                    ),
                    array(
                        'id'       => 'header_top_bar_status',
                        'type'     => 'switch',
                        'on'       => __( 'Enable', 'edublink' ),
                        'off'      => __( 'Disable', 'edublink' ),
                        'title'    => __( 'Header Top Bar Status', 'edublink' ),
                        'default'  => false
                    ),
                    array(
                        'id'       => 'header_top_bar_type',
                        'type'     => 'select',
                        'title'    => __( 'Header Top Bar Type', 'edublink' ),
                        'default'  => '1',
                        'options'  => array(
                            '1'       => 'Top Bar 1',
                            '2'       => 'Top Bar 2'
                        )
                    ),
                    array(
                        'id'       => 'header_top_button_status',
                        'type'     => 'switch',
                        'on'       => __( 'Enable', 'edublink' ),
                        'off'      => __( 'Disable', 'edublink' ),
                        'title'    => __( 'Header Top Button', 'edublink' ),
                        'default'  => true
                    ),
                    array(
                        'id'       => 'header_top_button_text',
                        'type'     => 'text',
                        'title'    => __( 'Header Top Button Text', 'edublink' ),
                        'desc'     => __( 'This text will replace the default "Apply Now" text at Header.', 'edublink' ),
                        'desc'     => __( 'Only applicable for "Top Bar 2".', 'edublink' ),
                        'required' => array( 'header_top_button_status', 'equals', true )
                    ),
                    array(
                        'id'       => 'header_top_button_url',
                        'type'     => 'text',
                        'title'    => __( 'Header Top Button URL', 'edublink' ),
                        'default'  => __( '#', 'edublink' ),
                        'desc'     => __( 'Only applicable for "Top Bar 2".', 'edublink' ),
                        'required' => array( 'header_top_button_status', 'equals', true )
                    ),
                    array(
                        'id'       => 'header_top_button_text_after_logged_in',
                        'type'     => 'text',
                        'title'    => __( 'Header Top Button Text(only for logged in users)', 'edublink' ),
                        'desc'     => __( 'This text will replace the default "Apply Now" text at Header.', 'edublink' ),
                        'desc'     => __( 'Only applicable for "Top Bar 2".', 'edublink' ),
                        'required' => array( 'header_top_button_status', 'equals', true )
                    ),
                    array(
                        'id'       => 'header_top_button_url_after_logged_in',
                        'type'     => 'text',
                        'title'    => __( 'Header Top Button URL(only for logged in users)', 'edublink' ),
                        'desc'     => __( 'Only applicable for "Top Bar 2".', 'edublink' ),
                        'required' => array( 'header_top_button_status', 'equals', true )
                    ),
                    array(
                        'id'       => 'header_top_button_open_same_tab',
                        'type'     => 'switch',
                        'on'       => __( 'Enable', 'edublink' ),
                        'off'      => __( 'Disable', 'edublink' ),
                        'title'    => __( 'Open In Same Tab', 'edublink' ),
                        'default'  => true,
                        'required' => array( 'header_top_button_status', 'equals', true )
                    ),
                    array(
                        'id'       => 'header_top_message_text',
                        'type'     => 'text',
                        'title'    => __( 'Header Top Message', 'edublink' ),
                        'default'  => __( 'First 20 students get 50% discount.', 'edublink' ),
                        'desc'     => __( 'Only applicable for "Top Bar 1".', 'edublink' )
                    ),
                    array(
                        'id'       => 'header_top_phone_text',
                        'type'     => 'text',
                        'title'    => __( 'Header Top Phone Text', 'edublink' ),
                        'default'  => __( 'Call:', 'edublink' )
                    ),
                    array(
                        'id'       => 'header_top_phone_number',
                        'type'     => 'text',
                        'title'    => __( 'Header Top Phone Number', 'edublink' ),
                        'default'  => __( '123 4561 5523', 'edublink' )
                    ),
                    array(
                        'id'       => 'header_top_email_text',
                        'type'     => 'text',
                        'title'    => __( 'Header Top Email Text', 'edublink' ),
                        'default'  => __( 'Email:', 'edublink' )
                    ),
                    array(
                        'id'       => 'header_top_email_address',
                        'type'     => 'text',
                        'title'    => __( 'Header Top Phone Number', 'edublink' ),
                        'default'  => __( 'info@edublink.co', 'edublink' )
                    ),
                    array(
                        'id'       => 'header_login_register_popup',
                        'type'     => 'switch',
                        'on'       => __( 'Enable', 'edublink' ),
                        'off'      => __( 'Disable', 'edublink' ),
                        'title'    => __( 'Header Top Login/Register', 'edublink' ),
                        'default'  => true
                    ),
                    array(
                        'id'       => 'header_login_register_popup_text',
                        'type'     => 'text',
                        'title'    => __( 'Header Top Login/Register PopUp Text', 'edublink' ),
                        'default'  => __( 'Login/Register', 'edublink' )
                    ),
                    array(
                        'id'       => 'header_logout_text',
                        'type'     => 'text',
                        'title'    => __( 'Header Top Logout Text', 'edublink' ),
                        'default'  => __( 'Logout', 'edublink' )
                    ),
                    array(
                        'id'       => 'header_top_social_share',
                        'type'     => 'switch',
                        'on'       => __( 'Enable', 'edublink' ),
                        'off'      => __( 'Disable', 'edublink' ),
                        'title'    => __( 'Header Top Social Share Icons', 'edublink' ),
                        'default'  => true,
                        'desc'     => __( 'Only applicable for "Top Bar 1".', 'edublink' )
                    ),
                    array(
                        'id'       => 'header_top_facebook_address',
                        'type'     => 'text',
                        'title'    => __( 'Header Top Facebook Link', 'edublink' ),
                        'default'  => __( '#', 'edublink' )
                    ),
                    array(
                        'id'       => 'header_top_instagram_address',
                        'type'     => 'text',
                        'title'    => __( 'Header Top Instagram Link', 'edublink' ),
                        'default'  => __( '#', 'edublink' )
                    ),
                    array(
                        'id'       => 'header_top_twitter_address',
                        'type'     => 'text',
                        'title'    => __( 'Header Top Twitter Link', 'edublink' ),
                        'default'  => __( '#', 'edublink' )
                    ),
                    array(
                        'id'       => 'header_top_linkedin_address',
                        'type'     => 'text',
                        'title'    => __( 'Header Top LinkedIn Link', 'edublink' ),
                        'default'  => __( '#', 'edublink' )
                    ),
                    array(
                        'id'       => 'header_top_youtube_address',
                        'type'     => 'text',
                        'title'    => __( 'Header Top YouTube Link', 'edublink' )
                    ),
                    array(
                        'id'       => 'header_top_tiktok_address',
                        'type'     => 'text',
                        'title'    => __( 'Header Top TikTok Link', 'edublink' )
                    ),
                    array(
                        'id'      => 'header_top_social_share_open_tab',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'edublink' ),
                        'off'     => __( 'Disable', 'edublink' ),
                        'title'   => __( 'Social Share Open in New Tab?', 'edublink' ),
                        'default' => true,
                        'desc'    => __( 'By enabling it, while visitor will click on the social share icons, it will redirect the user in a new tab rather then the same tab.', 'edublink' ),
                        'default'  => true
                    ),
                    array(
                        'id'       => 'header_breadcurmb_section',
                        'type'     => 'section',
                        'title'    => __( 'Breadcrumb', 'edublink' ),
                        'indent'   => true
                    ),
                    array(
                        'id'      => 'global_breadcrumb_visibility',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'edublink' ),
                        'off'     => __( 'Disable', 'edublink' ),
                        'title'   => __( 'Breadcrumb On Your Site?', 'edublink' ),
                        'default' => true
                    ),
                    array(
                        'id'       => 'global_breadcrumb_style_type',
                        'type'     => 'select',
                        'title'    => __( 'Global Breadcrumb Style', 'edublink' ),
                        'default'  => 'default',
                        'options'  => array(
                            'default' => 'Default Style',
                            '1'       => 'Style 1',
                            '2'       => 'Style 2'
                        )
                    ),
                    array(
                        'id'       => 'global_breadcrumb_bg_type',
                        'type'     => 'button_set',
                        'title'    => __( 'Global Breadcrumb Background Type', 'edublink' ),
                        'options'  => array(
                            'image'    => __( 'Background Image', 'edublink' ),
                            'color'  => __( 'Background Color', 'edublink' )
                        ),
                        'default' => 'image',
                        'required' => array( 'global_breadcrumb_visibility', 'equals', 'true' )
                    ),
                    array(
                        'id'       => 'global_breadcrumb_bg_image',
                        'type'     => 'media',
                        'title'    => __( 'Global Breadcrumb Background', 'edublink' ),
                        'subtitle' => __( 'Upload a .jpg or .png image that will be your breadcrumbs background image.', 'edublink' ),
                        'default'  => array(
                            'url'  => get_template_directory_uri() . '/assets/images/edublink-breadcrumb-bg.webp'
                        ),
                        'required'    => array( 
                            array( 'global_breadcrumb_bg_type', 'equals', 'image' ),
                            array( 'global_breadcrumb_visibility', 'equals', true )    
                        )
                    ),
                    array(
                        'id'       => 'global_breadcrumb_bg_image_overlay',
                        'type'     => 'slider',
                        'title'    => __( 'Breadcrumb Overlay Opacity (in %)', 'edublink' ),
                        'min'      => 0,
                        'max'      => 100,
                        'step'     => 1,
                        'default'  => 0,
                        'display_value' => 'label',
                        'required'    => array( 
                            array( 'global_breadcrumb_bg_type', 'equals', 'image' ),
                            array( 'global_breadcrumb_visibility', 'equals', true )    
                        )
                    ), 
                    array(
                        'id'       => 'global_breadcrumb_bg_color',
                        'type'     => 'color',
                        'title'    => __( 'Breadcrumb Background Color', 'edublink'), 
                        'validate' => 'color',
                        'required'    => array( 
                            array( 'global_breadcrumb_bg_type', 'equals', 'color' ),
                            array( 'global_breadcrumb_visibility', 'equals', true )    
                        )
                    )
                )
            );

            // Footer
            $this->sections[] = array(
                'icon'   => 'el el-website',
                'title'  => __( 'Footer Settings', 'edublink' ),
                'fields' => array(
                    array(
                        'id'       => 'footer_type',
                        'type'     => 'select',
                        'title'    => __( 'Footer Layout Type', 'edublink' ),
                        'subtitle' => __( 'Choose a footer for your website.', 'edublink' ),
                        'default'  => 'theme-default-footer',
                        'options'  => edublink_get_footer_layouts(),
                        'desc'     => sprintf( wp_kses( __( 'You can add or edit a footer in <a href="%s" target="_blank">Footers Builder</a>', 'edublink' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'edit.php?post_type=edublink_footer' ) ) )
                    ),
                    array(
                        'id'       => 'footer_custom_copyright_text',
                        'type'     => 'text',
                        'title'    => __( 'Footer Custom Copyright Text', 'edublink' ),
                        'desc'     => __( 'This text will replace the footer copyright text of <b>Theme Default Footer</b> only.', 'edublink' )
                    ),
                    array(
                        'id'       => 'scroll_to_top',
                        'type'     => 'switch',
                        'on'       => __( 'Enable', 'edublink' ),
                        'off'      => __( 'Disable', 'edublink' ),
                        'title'    => __( 'Scroll To Top Button', 'edublink' ),
                        'subtitle' => __( 'Toggle whether or not to enable a scroll to top button on your pages.', 'edublink' ),
                        'default'  => true
                    )
                )
            );

            // Page settings
            $this->sections[] = array(
                'icon'   => 'el el-pencil',
                'title'  => __( 'Page Settings', 'edublink' ),
                'fields' => array(
                    array(
                        'id'      => 'show_page_breadcrumb',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'edublink' ),
                        'off'     => __( 'Disable', 'edublink' ),
                        'title'   => __( 'Breadcrumbs', 'edublink' ),
                        'default' => true,
                        'desc'     => sprintf( 'If you set <strong>"Global Breadcrumb Background"</strong> to <strong>"Disbale"</strong> then you can\'t enable it here.', 'edublink' )
                    ),
                    array(
                        'id'      => 'default_breadcrumb_at_page',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'edublink' ),
                        'off'     => __( 'Disable', 'edublink' ),
                        'title'   => __( 'Default Breadcrumb Settings', 'edublink' ),
                        'default' => true,
                        'required' => array( 'show_page_breadcrumb', 'equals', true )
                    ),
                    array(
                        'id'       => 'page_breadcrumb_image',
                        'type'     => 'media',
                        'title'    => __( 'Breadcrumbs Background', 'edublink' ),
                        'subtitle' => __( 'Upload a .jpg or .png image that will be your breadcrumbs. <strong>The background image will only visible for "Style 1" which is located at Header Settings > Global Breadcrumb Style > Style 1.</strong>', 'edublink' ),
                        'default'  => array(
                            'url' => get_template_directory_uri() . '/assets/images/edublink-breadcrumb-bg.webp'
                        ),
                        'required'    => array( 
                            array( 'show_page_breadcrumb', 'equals', true ),
                            array( 'default_breadcrumb_at_page', '!=', true )    
                        )
                    ),
                    array (
                        'id'          => 'page_breadcrumb_color',
                        'title'       => __( 'Breadcrumbs Background Color', 'edublink' ),
                        'subtitle'    => '<em>' . __( 'If you uploaded an image at <strong>Global Breadcrumb Background</strong> then this field option won\'t work.', 'edublink' ) . '</em>',
                        'type'        => 'color',
                        'required'    => array( 
                            array( 'show_page_breadcrumb', 'equals', true ),
                            array( 'default_breadcrumb_at_page', '!=', true )    
                        )
                    )
                )
            );

            // Blog settings
            $this->sections[] = array(
                'icon'   => 'el el-pencil',
                'title'  => __( 'Blog Settings', 'edublink' ),
                'fields' => array(
                    array(
                        'id'      => 'show_blog_breadcrumb',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'edublink' ),
                        'off'     => __( 'Disable', 'edublink' ),
                        'title'   => __( 'Breadcrumbs', 'edublink' ),
                        // 'default' => true,
                        'default' => true,
                        'desc'     => sprintf( 'If you set <strong>"Global Breadcrumb Background"</strong> to <strong>"Disbale"</strong> then you can\'t enable it here.', 'edublink' )
                    ),
                    array(
                        'id'      => 'default_breadcrumb_at_blog',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'edublink' ),
                        'off'     => __( 'Disable', 'edublink' ),
                        'title'   => __( 'Default Breadcrumb Settings', 'edublink' ),
                        'default' => true,
                        'required' => array( 'show_blog_breadcrumb', 'equals', true )
                    ),
                    array(
                        'id'       => 'blog_breadcrumb_image',
                        'type'     => 'media',
                        'title'    => __( 'Breadcrumbs Background', 'edublink' ),
                        'subtitle' => __( 'Upload a .jpg or .png image that will be your breadcrumbs. <strong>The background image will only visible for "Style 1" which is located at Header Settings > Global Breadcrumb Style > Style 1.</strong>', 'edublink' ),
                        'default'  => array(
                            'url' => get_template_directory_uri() . '/assets/images/edublink-breadcrumb-bg.webp'
                        ),
                        'required'    => array( 
                            array( 'show_blog_breadcrumb', 'equals', true ),
                            array( 'default_breadcrumb_at_blog', '!=', true )    
                        )
                    ),
                    array (
                        'id'          => 'blog_breadcrumb_color',
                        'title'       => __( 'Breadcrumbs Background Color', 'edublink' ),
                        'subtitle'    => '<em>' . __( 'If you uploaded an image at <strong>Global Breadcrumb Background</strong> then this field option won\'t work.', 'edublink' ) . '</em>',
                        'type'        => 'color',
                        'required'    => array( 
                            array( 'show_blog_breadcrumb', 'equals', true ),
                            array( 'default_breadcrumb_at_blog', '!=', true )    
                        )
                    )
                )
            );

            // Archive Blogs settings
            $this->sections[] = array(
                'subsection' => true,
                'title'      => __( 'Blog/Post Archive', 'edublink' ),
                'fields'     => array(
                    array(
                        'id'       => 'blog_archive_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => __( 'Layout', 'edublink' ),
                        'default'  => 'right-sidebar',
                        'options'  => array(
                            'no-sidebar' => array(
                                'title'  => __( 'No Sidebar', 'edublink' ),
                                'alt'    => __( 'No Sidebar', 'edublink' ),
                                'img'    => get_template_directory_uri() . '/assets/images/sidebar-none.png'
                            ),
                            'left-sidebar'  => array(
                                'title'  => __( 'Left Sidebar', 'edublink' ),
                                'alt'    => __( 'Left Sidebar', 'edublink' ),
                                'img'    => get_template_directory_uri() . '/assets/images/sidebar-left.png'
                            ),
                            'right-sidebar' => array(
                                'title'  => __( 'Right Sidebar', 'edublink' ),
                                'alt'    => __( 'Right Sidebar', 'edublink' ),
                                'img'    => get_template_directory_uri() . '/assets/images/sidebar-right.png'
                            )
                        )
                    ),
                    array(
                        'id'       => 'blog_archive_sidebar_name',
                        'type'     => 'select',
                        'default'  => 'blog-sidebar',
                        'title'    => __( 'Select Sidebar', 'edublink' ),
                        'options'  => $sidebars,
                        'required' => array( 'blog_archive_layout', '!=', 'no-sidebar' )
                    ),
                    array(
                        'id'       => 'blog_post_style',
                        'type'     => 'select',
                        'title'    => __( 'Post Style', 'edublink' ),
                        'default'  => 'standard',
                        'options'  => array(
                            1      => 'Post 1',
                            2      => 'Post 2',
                            3      => 'Post 3',
                            'standard' => 'Post Standard'
                        )
                    ),
                    array(
                        'id'       => 'blog_post_columns',
                        'type'     => 'select',
                        'title'    => __( 'Post Columns', 'edublink' ),
                        'options'  => $columns,
                        'default'  => 2, // it's mandatory value is 2, before changing it, search for the param blog_post_columns and analyze it.
                        'desc'     => __( 'The Column option is not applicable for "Post Standard".', 'edublink' )
                    ),
                    array(
                        'id'        => 'blog_post_excerpt_length',
                        'type'      => 'slider',
                        'title'     => __( 'Excerpt Length', 'edublink' ),
                        'default'   => 10,
                        'min'       => -1,
                        'step'      => 1,
                        'max'       => 250
                    ),
                    array(
                        'id'        => 'blog_post_masonry_layout',
                        'type'      => 'switch',
                        'on'        => __( 'Enable', 'edublink' ),
                        'off'       => __( 'Disable', 'edublink' ),
                        'title'     => __( 'Masonry Layout', 'edublink' ),
                        'default'   => true
                    ),
                    array(
                        'id'       => 'blog_post_button_text',
                        'type'     => 'text',
                        'title'    => __( 'Text for Button', 'edublink' ),
                        'default'  => __( 'Learn More', 'edublink' ),
                    ),
                    array(
                        'id'       => 'blog_post_comment_short_text',
                        'type'     => 'text',
                        'title'    => __( 'Short Text for Comment', 'edublink' ),
                        'default'  => __( 'Com', 'edublink' ),
                    )
                )
            );

            // Single Blog settings
            $this->sections[] = array(
                'subsection' => true,
                'title'      => __( 'Post Single', 'edublink' ),
                'fields'     => array(
                    array(
                        'id'       => 'blog_single_layout',
                        'type'     => 'image_select',
                        'compiler' => true,
                        'title'    => __( 'Layout', 'edublink' ),
                        'default'  => 'right-sidebar',
                        'options'  => array(
                            'no-sidebar' => array(
                                'title'  => __( 'No Sidebar', 'edublink' ),
                                'alt'    => __( 'No Sidebar', 'edublink' ),
                                'img'    => get_template_directory_uri() . '/assets/images/sidebar-none.png'
                            ),
                            'left-sidebar'  => array(
                                'title'  => __( 'Left Sidebar', 'edublink' ),
                                'alt'    => __( 'Left Sidebar', 'edublink' ),
                                'img'    => get_template_directory_uri() . '/assets/images/sidebar-left.png'
                            ),
                            'right-sidebar' => array(
                                'title'  => __( 'Right Sidebar', 'edublink' ),
                                'alt'    => __( 'Right Sidebar', 'edublink' ),
                                'img'    => get_template_directory_uri() . '/assets/images/sidebar-right.png'
                            )
                        )
                    ),
                    array(
                        'id'       => 'blog_single_sidebar_name',
                        'type'     => 'select',
                        'default'  => 'blog-sidebar',
                        'title'    => __( 'Select Sidebar', 'edublink' ),
                        'options'  => $sidebars,
                        'required' => array( 'blog_single_layout', '!=', 'no-sidebar' )
                    ),                    
                    array(
                        'id'        => 'featured_image_height',
                        'type'      => 'slider',
                        'title'     => __( 'Blog Feature Image Height', 'edublink' ),
                        'default'   => 450,
                        'min'       => 300,
                        'step'      => 1,
                        'max'       => 1250,
                        'desc'      => __( 'If you changed the image size, you have to regenerate thumbnails. You can use any regenerate thumbnails plugin for that.', 'edublink' )
                    ),
                    array(
                        'id'        => 'featured_image_width',
                        'type'      => 'slider',
                        'title'     => __( 'Blog Feature Image Width', 'edublink' ),
                        'default'   => 770,
                        'min'       => 500,
                        'step'      => 1,
                        'max'       => 1500
                    ),
                    array(
                        'id'        => 'blog_single_tags_and_social_share',
                        'type'      => 'switch',
                        'on'        => __( 'Enable', 'edublink' ),
                        'off'       => __( 'Disable', 'edublink' ),
                        'title'     => __( 'Tags & Social Share', 'edublink' ),
                        'default'   => true
                    ),
                    array(
                        'id'        => 'blog_single_author_bio',
                        'type'      => 'switch',
                        'on'        => __( 'Enable', 'edublink' ),
                        'off'       => __( 'Disable', 'edublink' ),
                        'title'     => __( 'Author Bio', 'edublink' ),
                        'default'   => true
                    )
                )
            );

            // Course settings
            $this->sections[] = array(
                'icon'   => 'el el-pencil',
                'title'  => __( 'Course', 'edublink' ),
                'fields' => array(
                    array(
                        'id'      => 'show_course_breadcrumb',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'edublink' ),
                        'off'     => __( 'Disable', 'edublink' ),
                        'title'   => __( 'Breadcrumbs', 'edublink' ),
                        'default' => true
                    ),
                    array(
                        'id'      => 'show_default_breadcrumb_at_course',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'edublink' ),
                        'off'     => __( 'Disable', 'edublink' ),
                        'title'   => __( 'Show Default Breadcrumb Background', 'edublink' ),
                        'default' => true,
                        'required' => array( 'show_course_breadcrumb', 'equals', true )
                    ),
                    array (
                        'title'       => __( 'Breadcrumbs Background Color', 'edublink' ),
                        'subtitle'    => '<em>' . __( 'The breadcrumbs background color of the site. If there is no background image available only then this background color will be visible.', 'edublink' ) . '</em>',
                        'id'          => 'course_breadcrumb_color',
                        'type'        => 'color',
                        'required'    => array( 
                            array( 'show_page_breadcrumb', 'equals', true ),
                            array( 'show_default_breadcrumb_at_course', '!=', true )    
                        )
                    ),
                    array(
                        'id'       => 'course_breadcrumb_image',
                        'type'     => 'media',
                        'title'    => __( 'Breadcrumbs Background', 'edublink' ),
                        'subtitle' => __( 'Upload a .jpg or .png image that will be your breadcrumbs. <strong>The background image will only visible for "Style 1" which is located at Header Settings > Global Breadcrumb Style > Style 1.</strong>', 'edublink' ),
                        'default'  => array(
                            'url' => get_template_directory_uri() . '/assets/images/edublink-breadcrumb-bg.webp'
                        ),
                        'required'    => array( 
                            array( 'show_page_breadcrumb', 'equals', true ),
                            array( 'show_default_breadcrumb_at_course', '!=', true )    
                        )
                    ),
                    array(
                        'id'      => 'text_for_rating',
                        'type'    => 'text',
                        'title'   => __( 'Text for Rating', 'edublink' ),
                        'default' => __( 'Rating', 'edublink' ),
                        'desc'    => __( 'Label for Course Rating. This text is applicable only for cases with a single rating.', 'edublink' )
                    ),
                    array(
                        'id'      => 'text_for_ratings',
                        'type'    => 'text',
                        'title'   => __( 'Text for Ratings', 'edublink' ),
                        'default' => __( 'Ratings', 'edublink' ),
                        'desc'    => __( 'Label for Course Ratings. This text is applicable in cases where the total number of ratings is not equal to 1.', 'edublink' )
                    )
                )
            );

            if ( edublink_is_learnpress_activated() ) :
                // LearnPress Course Archive settings
                $this->sections[] = array(
                    'subsection' => true,
                    'title'      => __( 'Courses Archive(LearnPress)', 'edublink' ),
                    'fields'     => array(
                        array(
                            'id'       => 'lp_course_style',
                            'type'     => 'select',
                            'title'    => __( 'Course Style', 'edublink' ),
                            'default'  => 1,
                            'options'  => array(
                                '1'     => __( 'One', 'edublink' ),
                                '2'     => __( 'Two', 'edublink' ),
                                '3'     => __( 'Three', 'edublink' ),
                                '4'     => __( 'Four', 'edublink' ),
                                '5'     => __( 'Five', 'edublink' ),
                                '6'     => __( 'Six', 'edublink' ),
                                '7'     => __( 'Seven', 'edublink' ),
                                '8'     => __( 'Eight', 'edublink' ),
                                '9'     => __( 'Nine', 'edublink' ),
                                '10'    => __( 'Ten', 'edublink' ),
                                '11'    => __( 'Eleven', 'edublink' ),
                                '12'    => __( 'Twelve', 'edublink' ),
                                '13'    => __( 'Thirteen', 'edublink' ),
                                '14'    => __( 'Fourteen', 'edublink' ),
                                '15'    => __( 'Fifteen', 'edublink' ),
                                '16'    => __( 'Sixteen', 'edublink' ),
                                '17'    => __( 'Seventeen', 'edublink' ),
                                'quran' => __( 'Quran', 'edublink' )
                            )
                        ),
                        array(
                            'id'        => 'lp_course_masonry_layout',
                            'type'      => 'switch',
                            'on'        => __( 'Enable', 'edublink' ),
                            'off'       => __( 'Disable', 'edublink' ),
                            'title'     => __( 'Masonry Layout', 'edublink' ),
                            'default'   => true
                        ),
                        array(
                            'id'      => 'lp_course_archive_top_bar',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Enable Top Bar on Course Archive Page.', 'edublink' ),
                            'default' => true
                        ),
                        array(
                            'id'       => 'lp_course_index',
                            'type'     => 'switch',
                            'on'       => __( 'Enable', 'edublink' ),
                            'off'      => __( 'Disable', 'edublink' ),
                            'title'    => __( 'Total Number of Courses', 'edublink' ),
                            'default'  => true,
                            'required' => array( 'lp_course_archive_top_bar', 'equals', true )
                        ),
                        array(
                            'id'       => 'lp_course_search_bar',
                            'type'     => 'switch',
                            'on'       => __( 'Enable', 'edublink' ),
                            'off'      => __( 'Disable', 'edublink' ),
                            'title'    => __( 'Course Search Bar', 'edublink' ),
                            'default'  => true,
                            'required' => array( 'lp_course_archive_top_bar', 'equals', true )
                        ),
                        array(
                            'id'      => 'lp_course_white_bg',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Enable White Background', 'edublink' ),
                            'default' => false
                        ),
                        array(
                            'id'       => 'lp_course_image_size',
                            'type'     => 'select',
                            'title'    => __( 'Course image size', 'edublink' ),
                            'options'  => edublink_available_thumb_size(),
                            'default'  => 'edublink-post-thumb'
                        ),
                        array(
                            'id'        => 'lp_course_excerpt_length',
                            'type'      => 'slider',
                            'title'     => __( 'Excerpt Length', 'edublink' ),
                            'default'   => 25,
                            'min'       => 1,
                            'step'      => 1,
                            'max'       => 250
                        ),
                        array(
                            'id'       => 'lp_course_archive_breadcrumb_heading',
                            'type'     => 'text',
                            'title'    => __( 'Page Title at Breadcrumb', 'edublink' ),
                            'desc'     => __( 'This field will override the default page title at the Breadcrumb section of course archive page.', 'edublink' )
                        ),
                        array(
                            'id'       => 'lp_course_button_text',
                            'type'     => 'text',
                            'title'    => __( 'Button Text', 'edublink' ),
                            'default'  => __( 'Enroll Now', 'edublink' ),
                            'desc'     => __( 'Default Text: Enroll Now', 'edublink' )
                        ),
                        array(
                            'id'       => 'header_top_bar_for_lp',
                            'type'     => 'section',
                            'title'    => __( 'Header Top Bar Specific Conditions for LearnPress', 'edublink' ),
                            'indent'   => true
                        ),
                        array(
                            'id'      => 'lp_header_top_username_show',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Show Username instead of "Logout" at Header Top after logged in.', 'edublink' ),
                            'desc'   => __( 'Show Username which redirects to the profile page while clicking on it instead of "Logout" at Header Top after logged in.', 'edublink' ),
                            'default' => false
                        )
                    )
                );

                // LearnPress Single Course settings
                $this->sections[] = array(
                    'subsection' => true,
                    'title'      => __( 'Course Single(LearnPress)', 'edublink' ),
                    'fields'     => array(
                        array(
                            'id'          => 'lp_course_details_style',
                            'type'        => 'select',
                            'title'       => __( 'Course Details Style', 'edublink' ),
                            'default'     => 1,
                            'options'     => array(
                                '1'       => 'Style 1',
                                '2'       => 'Style 2',
                                '3'       => 'Style 3',
                                '4'       => 'Style 4',
                                '5'       => 'Style 5',
                                '6'       => 'Style 6'
                            )
                        ),
                        array(
                            'id'       => 'lp_course_breadcrumb_image',
                            'type'     => 'media',
                            'title'    => __( 'Breadcrumb Background', 'edublink' ),
                            'subtitle' => __( 'Upload a .jpg or .png image that will be your breadcrumbs. <strong>Only applicable for Course Details Style > Style 4.</strong>', 'edublink' ),
                            'default'  => array(
                                'url'  => get_template_directory_uri() . '/assets/images/edublink-breadcrumb-bg.webp'
                            ),
                        ),
                        array(
                            'id'      => 'lp_course_preview_thumb',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Course Preview Thumb', 'edublink' ),
                            'default' => true,
                            'required' => array( 'lp_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'      => 'lp_course_preview_video_popup',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Course Preview Video PopUp', 'edublink' ),
                            'default' => true,
                            'required' => array( 'lp_course_preview_thumb', 'equals', true )
                        ),
                        array(
                            'id'       => 'lp_related_course_options',
                            'type'     => 'section',
                            'title'    => __( 'Related Course', 'edublink' ),
                            'indent'   => true
                        ),
                        array(
                            'id'      => 'lp_related_courses',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Related Courses', 'edublink' ),
                            'default' => true
                        ),
                        array(
                            'id'          => 'lp_related_course_style',
                            'type'        => 'select',
                            'title'       => __( 'Related Course Style', 'edublink' ),
                            'default'     => 'default',
                            'options'     => array(
                                'default' => 'Default',
                                '1'     => __( 'One', 'edublink' ),
                                '2'     => __( 'Two', 'edublink' ),
                                '3'     => __( 'Three', 'edublink' ),
                                '4'     => __( 'Four', 'edublink' ),
                                '5'     => __( 'Five', 'edublink' ),
                                '6'     => __( 'Six', 'edublink' ),
                                '7'     => __( 'Seven', 'edublink' ),
                                '8'     => __( 'Eight', 'edublink' ),
                                '9'     => __( 'Nine', 'edublink' ),
                                '10'    => __( 'Ten', 'edublink' ),
                                '11'    => __( 'Eleven', 'edublink' ),
                                '12'    => __( 'Twelve', 'edublink' ),
                                '13'    => __( 'Thirteen', 'edublink' ),
                                '14'    => __( 'Fourteen', 'edublink' ),
                                '15'    => __( 'Fifteen', 'edublink' ),
                                '16'    => __( 'Sixteen', 'edublink' ),
                                '17'    => __( 'Seventeen', 'edublink' ),
                                'quran' => __( 'Quran', 'edublink' )
                            ),
                            'required' => array( 'lp_related_courses', 'equals', true )
                        ),
                        array(
                            'id'       => 'lp_related_course_title',
                            'type'     => 'text',
                            'title'    => __( 'Related Courses Title', 'edublink' ),
                            'default'  => __( 'Courses You May Like', 'edublink' ),
                            'required' => array( 'lp_related_courses', 'equals', true )
                        ),
                        array(
                            'id'       => 'lp_course_tab_options',
                            'type'     => 'section',
                            'title'    => __( 'Course Tab Options', 'edublink' ),
                            'indent'   => true
                        ),
                        array(
                            'id'       => 'lp_overview_tab_title',
                            'type'     => 'text',
                            'default'  => __( 'Overview', 'edublink' ),
                            'title'    => __( 'Overview Tab Title', 'edublink' ),
                        ),
                        array(
                            'id'      => 'lp_curriculum_tab',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Curriculum Tab', 'edublink' ),
                            'default' => true
                        ),
                        array(
                            'id'       => 'lp_curriculum_tab_title',
                            'type'     => 'text',
                            'default'  => __( 'Curriculum', 'edublink' ),
                            'title'    => __( 'Curriculum Tab Title', 'edublink' ),
                            'required' => array( 'lp_curriculum_tab', 'equals', true )
                        ),
                        array(
                            'id'      => 'lp_instructor_tab',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Instructor Tab', 'edublink' ),
                            'default' => true
                        ),
                        array(
                            'id'       => 'lp_instructor_tab_title',
                            'type'     => 'text',
                            'default'  => __( 'Instructor', 'edublink' ),
                            'title'    => __( 'Instructor Tab Title', 'edublink' ),
                            'required' => array( 'lp_instructor_tab', 'equals', true )
                        ),
                        array(
                            'id'      => 'lp_instructor_tab',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Instructor Tab', 'edublink' ),
                            'default' => true
                        ),
                        array(
                            'id'       => 'lp_instructor_tab_title',
                            'type'     => 'text',
                            'default'  => __( 'Instructor', 'edublink' ),
                            'title'    => __( 'Instructor Tab Title', 'edublink' ),
                            'required' => array( 'lp_instructor_tab', 'equals', true )
                        ),
                        array(
                            'id'      => 'lp_reviews_tab',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Review Tab', 'edublink' ),
                            'desc'    => __( 'This option will only work if <strong>LearnPress - Course Review</strong> plugin is activated.', 'edublink' ),
                            'default' => true
                        ),
                        array(
                            'id'       => 'lp_reviews_tab_title',
                            'type'     => 'text',
                            'default'  => __( 'Reviews', 'edublink' ),
                            'title'    => __( 'Review Tab Title', 'edublink' ),
                            'required' => array( 'lp_reviews_tab', 'equals', true )
                        ),
                        array(
                            'id'       => 'lp_course_sidebar_options',
                            'type'     => 'section',
                            'title'    => __( 'Course Sidebar Options', 'edublink' ),
                            'indent'   => true
                        ),
                        array(
                            'id'      => 'lp_course_details_sidebar_status',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Course Details Sidebar', 'edublink' ),
                            'default' => true
                        ),
                        array(
                            'id'      => 'lp_course_details_sidebar_sticky',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Course Details Sidebar Sticky', 'edublink' ),
                            'default' => false,
                            'desc'    => __( 'By enabling this option, the sidebar will get sticky until the parallal side content is finished while scrolling. Please note that, the sticky will only work at Style 3 & 4.', 'edublink' ),
                            'required' => array( 'lp_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'      => 'lp_course_sidebar_heading_status',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Heading', 'edublink' ),
                            'default' => true,
                            'required' => array( 'lp_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'lp_course_sidebar_heading_text',
                            'type'     => 'text',
                            'title'    => __( 'Heading Text', 'edublink' ),
                            'desc'     => __( 'Value of Course Sidebar Heading', 'edublink' ),
                            'default'  => __( 'Course Includes:', 'edublink' ),
                            'required' => array( 
                                array( 'lp_course_details_sidebar_status', 'equals', true ),
                                array( 'lp_course_sidebar_heading_status', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'lp_course_sidebar_price_status',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Price', 'edublink' ),
                            'default' => true,
                            'required' => array( 'lp_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'lp_course_sidebar_price_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Price', 'edublink' ),
                            'default'  => __( 'Price:', 'edublink' ),
                            'desc'     => __( 'Default Value: Price:', 'edublink' ),
                            'required' => array( 
                                array( 'lp_course_details_sidebar_status', 'equals', true ),
                                array( 'lp_course_sidebar_price_status', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'lp_course_instructor',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Instructor', 'edublink' ),
                            'default' => true,
                            'required' => array( 'lp_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'lp_course_instructor_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Instructor', 'edublink' ),
                            'default'  => __( 'Instructor:', 'edublink' ),
                            'desc'     => __( 'Default Value: Instructor:', 'edublink' ),
                            'required' => array( 
                                array( 'lp_course_details_sidebar_status', 'equals', true ),
                                array( 'lp_course_instructor', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'lp_course_duration',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Duration', 'edublink' ),
                            'default' => true,
                            'required' => array( 'lp_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'lp_course_duration_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Duration', 'edublink' ),
                            'default'  => __( 'Duration:', 'edublink' ),
                            'desc'     => __( 'Default Value: Duration:', 'edublink' ),
                            'required' => array( 
                                array( 'lp_course_details_sidebar_status', 'equals', true ),
                                array( 'lp_course_duration', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'lp_course_lessons',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Lessons', 'edublink' ),
                            'default' => true,
                            'required' => array( 'lp_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'lp_course_lessons_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Lessons', 'edublink' ),
                            'default'  => __( 'Lessons:', 'edublink' ),
                            'desc'     => __( 'Default Value: Lessons:', 'edublink' ),
                            'required' => array( 
                                array( 'lp_course_details_sidebar_status', 'equals', true ),
                                array( 'lp_course_lessons', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'lp_course_students',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Students', 'edublink' ),
                            'default' => true,
                            'required' => array( 'lp_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'lp_course_students_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Students', 'edublink' ),
                            'default'  => __( 'Students:', 'edublink' ),
                            'desc'     => __( 'Default Value: Students:', 'edublink' ),
                            'required' => array( 
                                array( 'lp_course_details_sidebar_status', 'equals', true ),
                                array( 'lp_course_students', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'lp_course_language',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Language', 'edublink' ),
                            'default' => true,
                            'required' => array( 'lp_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'lp_course_language_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Language', 'edublink' ),
                            'default'  => __( 'Language:', 'edublink' ),
                            'desc'     => __( 'Default Value: Language:', 'edublink' ),
                            'required' => array( 
                                array( 'lp_course_details_sidebar_status', 'equals', true ),
                                array( 'lp_course_language', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'lp_course_certificate',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Certificate', 'edublink' ),
                            'default' => true,
                            'required' => array( 'lp_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'lp_course_certificate_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Certificate', 'edublink' ),
                            'default'  => __( 'Certifications:', 'edublink' ),
                            'desc'     => __( 'Default Value: Certifications:', 'edublink' ),
                            'required' => array( 
                                array( 'lp_course_details_sidebar_status', 'equals', true ),
                                array( 'lp_course_certificate', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'lp_course_sidebar_button',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Sidebar Button', 'edublink' ),
                            'default' => true,
                            'required' => array( 'lp_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'    => 'eb_lp_external_link_text',
                            'type'  => 'text',
                            'title' => __( 'External Button Text', 'edublink' ),
                            'desc'  => __( 'Default Text: More Info', 'edublink' ),
                            'required' => array( 
                                array( 'lp_course_details_sidebar_status', 'equals', true ),
                                array( 'lp_course_sidebar_button', 'equals', true )    
                            )
                        ),
                        array(
                            'id'    => 'eb_lp_purchase_button_text',
                            'type'  => 'text',
                            'title' => __( 'Purchase Button Text', 'edublink' ),
                            'desc'  => __( 'Default Text: Buy Now', 'edublink' ),
                            'required' => array( 
                                array( 'lp_course_details_sidebar_status', 'equals', true ),
                                array( 'lp_course_sidebar_button', 'equals', true )    
                            )
                        ),
                        array(
                            'id'    => 'eb_lp_enroll_button_text',
                            'type'  => 'text',
                            'title' => __( 'Enroll Button Text', 'edublink' ),
                            'desc'  => __( 'Default Text: Start Now', 'edublink' ),
                            'required' => array( 
                                array( 'lp_course_details_sidebar_status', 'equals', true ),
                                array( 'lp_course_sidebar_button', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'lp_course_sidebar_social_share',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Social Share', 'edublink' ),
                            'default' => true,
                            'required' => array( 'lp_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'    => 'lp_course_sidebar_social_share_heading',
                            'type'  => 'text',
                            'title' => __( 'Social Share Heading', 'edublink' ),
                            'desc'  => __( 'Default Text: Share On:', 'edublink' ),
                            'default'  => __( 'Share On:', 'edublink' ),
                            'required' => array( 
                                array( 'lp_course_details_sidebar_status', 'equals', true ),
                                array( 'lp_course_sidebar_social_share', 'equals', true )    
                            )
                        )
                    )
                );
            endif;

            if ( edublink_is_learndash_activated() ) :
                $this->sections[] = array(
                    'subsection' => true,
                    'title'      => __( 'Courses Archive(LearnDash)', 'edublink' ),
                    'fields'     => array(
                        array(
                            'id'        => 'ld_course_style',
                            'type'      => 'select',
                            'title'     => __( 'Course Style', 'edublink' ),
                            'default'   => 1,
                            'options'   => array(
                                '1'     => __( 'One', 'edublink' ),
                                '2'     => __( 'Two', 'edublink' ),
                                '3'     => __( 'Three', 'edublink' ),
                                '4'     => __( 'Four', 'edublink' ),
                                '5'     => __( 'Five', 'edublink' ),
                                '6'     => __( 'Six', 'edublink' ),
                                '7'     => __( 'Seven', 'edublink' ),
                                '8'     => __( 'Eight', 'edublink' ),
                                '9'     => __( 'Nine', 'edublink' ),
                                '10'    => __( 'Ten', 'edublink' ),
                                '11'    => __( 'Eleven', 'edublink' ),
                                '12'    => __( 'Twelve', 'edublink' ),
                                '13'    => __( 'Thirteen', 'edublink' ),
                                '14'    => __( 'Fourteen', 'edublink' ),
                                '15'    => __( 'Fifteen', 'edublink' ),
                                '16'    => __( 'Sixteen', 'edublink' ),
                                '17'    => __( 'Seventeen', 'edublink' ),
                                'quran' => __( 'Quran', 'edublink' )
                            )
                        ),
                        array(
                            'id'        => 'ld_course_masonry_layout',
                            'type'      => 'switch',
                            'on'        => __( 'Enable', 'edublink' ),
                            'off'       => __( 'Disable', 'edublink' ),
                            'title'     => __( 'Masonry Layout', 'edublink' ),
                            'default'   => true
                        ),
                        array(
                            'id'        => 'ld_course_archive_page_items',
                            'type'      => 'slider',
                            'title'     => __( 'Number of Courses Per Page', 'edublink' ),
                            'default'   => 9,
                            'min'       => -1,
                            'step'      => 1,
                            'max'       => 250
                        ),
                        array(
                            'id'        => 'ld_course_excerpt_length',
                            'type'      => 'slider',
                            'title'     => __( 'Excerpt Length', 'edublink' ),
                            'default'   => 12,
                            'min'       => 1,
                            'step'      => 1,
                            'max'       => 250
                        ),
                        array(
                            'id'       => 'ld_course_button_text',
                            'type'     => 'text',
                            'title'    => __( 'Button Text', 'edublink' ),
                            'default'  => __( 'Enroll Now', 'edublink' ),
                            'desc'     => __( 'Default Text: Enroll Now', 'edublink' )
                        ),
                        array(
                            'id'       => 'ld_course_image_size',
                            'type'     => 'select',
                            'title'    => __( 'Course image size', 'edublink' ),
                            'options'  => edublink_available_thumb_size(),
                            'default'  => 'edublink-post-thumb'
                        ),
                        array(
                            'id'      => 'ld_course_rating_system',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Course Rating System', 'edublink' ),
                            'default' => true
                        ),
                        array(
                            'id'      => 'ld_course_wishlist_system',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Course Wishlist System', 'edublink' ),
                            'default' => true
                        )
                    )
                );

                // LearnDash Single Course settings
                $this->sections[] = array(
                    'subsection' => true,
                    'title'      => __( 'Course Single(LearnDash)', 'edublink' ),
                    'fields'     => array(
                        array(
                            'id'          => 'ld_course_details_style',
                            'type'        => 'select',
                            'title'       => __( 'Course Details Style', 'edublink' ),
                            'default'     => 1,
                            'options'     => array(
                                '1'       => 'Style 1',
                                '2'       => 'Style 2',
                                '3'       => 'Style 3',
                                '4'       => 'Style 4',
                                '5'       => 'Style 5',
                                '6'       => 'Style 6'
                            )
                        ),
                        array(
                            'id'       => 'ld_course_breadcrumb_image',
                            'type'     => 'media',
                            'title'    => __( 'Header Background', 'edublink' ),
                            'subtitle' => __( 'Upload a .jpg or .png image that will be your breadcrumbs. <strong>Only applicable for Course Details Style > Style 4.</strong>', 'edublink' ),
                            'default'  => array(
                                'url'  => get_template_directory_uri() . '/assets/images/edublink-breadcrumb-bg.webp'
                            )
                        ),
                        array(
                            'id'      => 'ld_course_preview_thumb',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Course Preview Thumb', 'edublink' ),
                            'default' => true,
                            'required' => array( 'ld_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'      => 'ld_course_preview_video_popup',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Course Preview Video PopUp', 'edublink' ),
                            'default' => true,
                            'required' => array( 'ld_course_preview_thumb', 'equals', true )
                        ),
                        array(
                            'id'       => 'ld_related_course_options',
                            'type'     => 'section',
                            'title'    => __( 'Related Course', 'edublink' ),
                            'indent'   => true
                        ),
                        array(
                            'id'      => 'ld_related_courses',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Related Courses', 'edublink' ),
                            'default' => true
                        ),
                        array(
                            'id'          => 'ld_related_course_style',
                            'type'        => 'select',
                            'title'       => __( 'Related Course Style', 'edublink' ),
                            'default'     => 'default',
                            'options'     => array(
                                'default' => 'Default',
                                '1'     => __( 'One', 'edublink' ),
                                '2'     => __( 'Two', 'edublink' ),
                                '3'     => __( 'Three', 'edublink' ),
                                '4'     => __( 'Four', 'edublink' ),
                                '5'     => __( 'Five', 'edublink' ),
                                '6'     => __( 'Six', 'edublink' ),
                                '7'     => __( 'Seven', 'edublink' ),
                                '8'     => __( 'Eight', 'edublink' ),
                                '9'     => __( 'Nine', 'edublink' ),
                                '10'    => __( 'Ten', 'edublink' ),
                                '11'    => __( 'Eleven', 'edublink' ),
                                '12'    => __( 'Twelve', 'edublink' ),
                                '13'    => __( 'Thirteen', 'edublink' ),
                                '14'    => __( 'Fourteen', 'edublink' ),
                                '15'    => __( 'Fifteen', 'edublink' ),
                                '16'    => __( 'Sixteen', 'edublink' ),
                                '17'    => __( 'Seventeen', 'edublink' ),
                                'quran' => __( 'Quran', 'edublink' )
                            ),
                            'required' => array( 'ld_related_courses', 'equals', true )
                        ),
                        array(
                            'id'       => 'ld_related_course_title',
                            'type'     => 'text',
                            'title'    => __( 'Related Courses Title', 'edublink' ),
                            'default'  => __( 'Courses You May Like', 'edublink' ),
                            'required' => array( 'ld_related_courses', 'equals', true )
                        ),
                        array(
                            'id'       => 'ld_course_sidebar_options',
                            'type'     => 'section',
                            'title'    => __( 'Course Sidebar Options', 'edublink' ),
                            'indent'   => true
                        ),
                        array(
                            'id'      => 'ld_course_details_sidebar_status',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Course Details Sidebar', 'edublink' ),
                            'default' => true
                        ),
                        array(
                            'id'      => 'ld_course_details_sidebar_sticky',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Course Details Sidebar Sticky', 'edublink' ),
                            'default' => false,
                            'desc'    => __( 'By enabling this option, the sidebar will get sticky until the parallal side content is finished while scrolling. Please note that, the sticky will only work at Style 3 & 4.', 'edublink' ),
                            'required' => array( 'ld_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'      => 'ld_course_sidebar_heading_status',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Heading', 'edublink' ),
                            'default' => true,
                            'required' => array( 'ld_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'ld_course_sidebar_heading_text',
                            'type'     => 'text',
                            'title'    => __( 'Heading Text', 'edublink' ),
                            'desc'     => __( 'Value of Course Sidebar Heading', 'edublink' ),
                            'default'  => __( 'Course Includes:', 'edublink' ),
                            'required' => array( 
                                array( 'ld_course_details_sidebar_status', 'equals', true ),
                                array( 'ld_course_sidebar_heading_status', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'ld_course_sidebar_price_status',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Price', 'edublink' ),
                            'default' => true,
                            'required' => array( 'ld_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'ld_course_sidebar_price_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Price', 'edublink' ),
                            'default'  => __( 'Price:', 'edublink' ),
                            'desc'     => __( 'Default Value: Price:', 'edublink' ),
                            'required' => array( 
                                array( 'ld_course_details_sidebar_status', 'equals', true ),
                                array( 'ld_course_sidebar_price_status', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'ld_course_instructor',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Instructor', 'edublink' ),
                            'default' => true,
                            'required' => array( 'ld_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'ld_course_instructor_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Instructor', 'edublink' ),
                            'default'  => __( 'Instructor:', 'edublink' ),
                            'desc'     => __( 'Default Value: Instructor:', 'edublink' ),
                            'required' => array( 
                                array( 'ld_course_details_sidebar_status', 'equals', true ),
                                array( 'ld_course_instructor', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'ld_course_duration',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Duration', 'edublink' ),
                            'default' => true,
                            'required' => array( 'ld_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'ld_course_duration_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Duration', 'edublink' ),
                            'default'  => __( 'Duration:', 'edublink' ),
                            'desc'     => __( 'Default Value: Duration:', 'edublink' ),
                            'required' => array( 
                                array( 'ld_course_details_sidebar_status', 'equals', true ),
                                array( 'ld_course_duration', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'ld_course_lessons',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Lessons', 'edublink' ),
                            'default' => true,
                            'required' => array( 'ld_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'ld_course_lessons_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Lessons', 'edublink' ),
                            'default'  => __( 'Lessons:', 'edublink' ),
                            'desc'     => __( 'Default Value: Lessons:', 'edublink' ),
                            'required' => array( 
                                array( 'ld_course_details_sidebar_status', 'equals', true ),
                                array( 'ld_course_lessons', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'ld_course_students',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Students', 'edublink' ),
                            'default' => true,
                            'required' => array( 'ld_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'ld_course_students_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Students', 'edublink' ),
                            'default'  => __( 'Students:', 'edublink' ),
                            'desc'     => __( 'Default Value: Students:', 'edublink' ),
                            'required' => array( 
                                array( 'ld_course_details_sidebar_status', 'equals', true ),
                                array( 'ld_course_students', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'ld_course_language',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Language', 'edublink' ),
                            'default' => true,
                            'required' => array( 'ld_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'ld_course_language_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Language', 'edublink' ),
                            'default'  => __( 'Language:', 'edublink' ),
                            'desc'     => __( 'Default Value: Language:', 'edublink' ),
                            'required' => array( 
                                array( 'ld_course_details_sidebar_status', 'equals', true ),
                                array( 'ld_course_language', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'ld_course_certificate',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Certificate', 'edublink' ),
                            'default' => true,
                            'required' => array( 'ld_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'ld_course_certificate_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Certificate', 'edublink' ),
                            'default'  => __( 'Certifications:', 'edublink' ),
                            'desc'     => __( 'Default Value: Certifications:', 'edublink' ),
                            'required' => array( 
                                array( 'ld_course_details_sidebar_status', 'equals', true ),
                                array( 'ld_course_certificate', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'ld_course_sidebar_button',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Sidebar Button', 'edublink' ),
                            'default' => true,
                            'required' => array( 'ld_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'    => 'ld_external_button_text',
                            'type'  => 'text',
                            'title' => __( 'External Button Text', 'edublink' ),
                            'default' => __( 'More Info', 'edublink' ),
                            'required' => array( 
                                array( 'ld_course_details_sidebar_status', 'equals', true ),
                                array( 'ld_course_sidebar_button', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'ld_external_button_open_tab',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Button Open in New Tab?', 'edublink' ),
                            'default' => true,
                            'desc'    => __( 'By enabling it, while visitor will click on the button, it will redirect the user in a new tab rather then the same tab.', 'edublink' ),
                            'required' => array( 
                                array( 'ld_course_details_sidebar_status', 'equals', true ),
                                array( 'ld_course_sidebar_button', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'ld_course_sidebar_social_share',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Social Share', 'edublink' ),
                            'default' => true,
                            'required' => array( 'ld_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'    => 'ld_course_sidebar_social_share_heading',
                            'type'  => 'text',
                            'title' => __( 'Social Share Heading', 'edublink' ),
                            'desc'  => __( 'Default Text: Share On:', 'edublink' ),
                            'default'  => __( 'Share On:', 'edublink' ),
                            'required' => array( 
                                array( 'ld_course_details_sidebar_status', 'equals', true ),
                                array( 'ld_course_sidebar_social_share', 'equals', true )    
                            )
                        )
                    )
                );
            endif;

            if ( edublink_is_tutor_lms_activated() ) :
                // Tutor LMS Course Archive settings
                $this->sections[] = array(
                    'subsection' => true,
                    'title'      => __( 'Courses Archive(Tutor LMS)', 'edublink' ),
                    'fields'     => array(
                        array(
                            'id'       => 'tutor_course_style',
                            'type'     => 'select',
                            'title'    => __( 'Course Style', 'edublink' ),
                            'default'  => 1,
                            'options'  => array(
                                '1'     => __( 'One', 'edublink' ),
                                '2'     => __( 'Two', 'edublink' ),
                                '3'     => __( 'Three', 'edublink' ),
                                '4'     => __( 'Four', 'edublink' ),
                                '5'     => __( 'Five', 'edublink' ),
                                '6'     => __( 'Six', 'edublink' ),
                                '7'     => __( 'Seven', 'edublink' ),
                                '8'     => __( 'Eight', 'edublink' ),
                                '9'     => __( 'Nine', 'edublink' ),
                                '10'    => __( 'Ten', 'edublink' ),
                                '11'    => __( 'Eleven', 'edublink' ),
                                '12'    => __( 'Twelve', 'edublink' ),
                                '13'    => __( 'Thirteen', 'edublink' ),
                                '14'    => __( 'Fourteen', 'edublink' ),
                                '15'    => __( 'Fifteen', 'edublink' ),
                                '16'    => __( 'Sixteen', 'edublink' ),
                                '17'    => __( 'Seventeen', 'edublink' ),
                                'quran' => __( 'Quran', 'edublink' )
                            )
                        ),
                        array(
                            'id'        => 'tl_course_masonry_layout',
                            'type'      => 'switch',
                            'on'        => __( 'Enable', 'edublink' ),
                            'off'       => __( 'Disable', 'edublink' ),
                            'title'     => __( 'Masonry Layout', 'edublink' ),
                            'default'   => true
                        ),
                        // array(
                        //     'id'      => 'tl_course_archive_top_bar',
                        //     'type'    => 'switch',
                        //     'on'      => __( 'Enable', 'edublink' ),
                        //     'off'     => __( 'Disable', 'edublink' ),
                        //     'title'   => __( 'Enable Top Bar on Course Archive Page.', 'edublink' ),
                        //     'default' => true
                        // ),
                        // array(
                        //     'id'       => 'tl_course_index',
                        //     'type'     => 'switch',
                        //     'on'       => __( 'Enable', 'edublink' ),
                        //     'off'      => __( 'Disable', 'edublink' ),
                        //     'title'    => __( 'Total Number of Courses', 'edublink' ),
                        //     'default'  => true,
                        //     'required' => array( 'tl_course_archive_top_bar', 'equals', true )
                        // ),
                        // array(
                        //     'id'       => 'tl_course_search_bar',
                        //     'type'     => 'switch',
                        //     'on'       => __( 'Enable', 'edublink' ),
                        //     'off'      => __( 'Disable', 'edublink' ),
                        //     'title'    => __( 'Course Search Bar', 'edublink' ),
                        //     'default'  => true,
                        //     'required' => array( 'tl_course_archive_top_bar', 'equals', true )
                        // ),
                        // array(
                        //     'id'      => 'tl_course_white_bg',
                        //     'type'    => 'switch',
                        //     'on'      => __( 'Enable', 'edublink' ),
                        //     'off'     => __( 'Disable', 'edublink' ),
                        //     'title'   => __( 'Enable White Background', 'edublink' ),
                        //     'default' => false
                        // ),
                        array(
                            'id'       => 'tl_course_image_size',
                            'type'     => 'select',
                            'title'    => __( 'Course image size', 'edublink' ),
                            'options'  => edublink_available_thumb_size(),
                            'default'  => 'edublink-post-thumb'
                        ),
                        array(
                            'id'        => 'tl_course_excerpt_length',
                            'type'      => 'slider',
                            'title'     => __( 'Excerpt Length', 'edublink' ),
                            'default'   => 25,
                            'min'       => 1,
                            'step'      => 1,
                            'max'       => 250
                        ),
                        array(
                            'id'       => 'tl_course_archive_breadcrumb_heading',
                            'type'     => 'text',
                            'title'    => __( 'Page Title at Breadcrumb', 'edublink' ),
                            'desc'     => __( 'This field will override the default page title at the Breadcrumb section of course archive page.', 'edublink' )
                        ),
                        array(
                            'id'       => 'tl_course_button_text',
                            'type'     => 'text',
                            'title'    => __( 'Button Text', 'edublink' ),
                            'default'  => __( 'Enroll Now', 'edublink' ),
                            'desc'     => __( 'Default Text: Enroll Now', 'edublink' )
                        ),
                        array(
                            'id'       => 'header_top_bar_for_lp',
                            'type'     => 'section',
                            'title'    => __( 'Header Top Bar Specific Conditions for LearnPress', 'edublink' ),
                            'indent'   => true
                        ),
                        array(
                            'id'      => 'tl_header_top_username_show',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Show Username instead of "Logout" at Header Top after logged in.', 'edublink' ),
                            'desc'   => __( 'Show Username which redirects to the profile page while clicking on it instead of "Logout" at Header Top after logged in.', 'edublink' ),
                            'default' => false
                        )
                    )
                );

                // Tutor LMS Single Course settings
                $this->sections[] = array(
                    'subsection' => true,
                    'title'      => __( 'Course Single(Tutor LMS)', 'edublink' ),
                    'fields'     => array(
                        array(
                            'id'          => 'tl_course_details_style',
                            'type'        => 'select',
                            'title'       => __( 'Course Details Style', 'edublink' ),
                            'default'     => 1,
                            'options'     => array(
                                '1'       => 'Style 1',
                                '2'       => 'Style 2',
                                '3'       => 'Style 3',
                                '4'       => 'Style 4',
                                '5'       => 'Style 5',
                                '6'       => 'Style 6'
                            )
                        ),
                        array(
                            'id'       => 'tl_course_breadcrumb_image',
                            'type'     => 'media',
                            'title'    => __( 'Breadcrumb Background', 'edublink' ),
                            'subtitle' => __( 'Upload a .jpg or .png image that will be your breadcrumbs. <strong>Only applicable for Course Details Style > Style 4.</strong>', 'edublink' ),
                            'default'  => array(
                                'url'  => get_template_directory_uri() . '/assets/images/edublink-breadcrumb-bg.webp'
                            )
                        ),
                        array(
                            'id'      => 'tl_course_preview',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Course Preview Thumb', 'edublink' ),
                            'default' => true
                        ),
                        array(
                            'id'       => 'tl_related_course_options',
                            'type'     => 'section',
                            'title'    => __( 'Related Course', 'edublink' ),
                            'indent'   => true
                        ),
                        array(
                            'id'      => 'tl_related_courses',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Related Courses', 'edublink' ),
                            'default' => true
                        ),
                        array(
                            'id'          => 'tl_related_course_style',
                            'type'        => 'select',
                            'title'       => __( 'Related Course Style', 'edublink' ),
                            'default'     => 'default',
                            'options'     => array(
                                'default' => 'Default',
                                '1'     => __( 'One', 'edublink' ),
                                '2'     => __( 'Two', 'edublink' ),
                                '3'     => __( 'Three', 'edublink' ),
                                '4'     => __( 'Four', 'edublink' ),
                                '5'     => __( 'Five', 'edublink' ),
                                '6'     => __( 'Six', 'edublink' ),
                                '7'     => __( 'Seven', 'edublink' ),
                                '8'     => __( 'Eight', 'edublink' ),
                                '9'     => __( 'Nine', 'edublink' ),
                                '10'    => __( 'Ten', 'edublink' ),
                                '11'    => __( 'Eleven', 'edublink' ),
                                '12'    => __( 'Twelve', 'edublink' ),
                                '13'    => __( 'Thirteen', 'edublink' ),
                                '14'    => __( 'Fourteen', 'edublink' ),
                                '15'    => __( 'Fifteen', 'edublink' ),
                                '16'    => __( 'Sixteen', 'edublink' ),
                                '17'    => __( 'Seventeen', 'edublink' ),
                                'quran' => __( 'Quran', 'edublink' )
                            ),
                            'required' => array( 'tl_related_courses', 'equals', true )
                        ),
                        array(
                            'id'       => 'tl_related_course_title',
                            'type'     => 'text',
                            'title'    => __( 'Related Courses Title', 'edublink' ),
                            'default'  => __( 'Courses You May Like', 'edublink' ),
                            'required' => array( 'tl_related_courses', 'equals', true )
                        ),
                        array(
                            'id'       => 'tl_course_tab_options',
                            'type'     => 'section',
                            'title'    => __( 'Course Tab Options', 'edublink' ),
                            'indent'   => true
                        ),
                        array(
                            'id'       => 'tl_course_info_tab_title',
                            'type'     => 'text',
                            'title'    => __( 'Course Info Tab Title', 'edublink' ),
                            'desc'    => __( 'Default Value: Course Info', 'edublink' ),
                        ),
                        array(
                            'id'       => 'tl_course_reviews_tab_title',
                            'type'     => 'text',
                            'title'    => __( 'Reviews Tab Title', 'edublink' ),
                            'desc'    => __( 'Default Value: Reviews', 'edublink' ),
                        ),
                        array(
                            'id'       => 'tl_course_q_and_a_tab_title',
                            'type'     => 'text',
                            'title'    => __( 'Q&A Tab Title', 'edublink' ),
                            'desc'    => __( 'Default Value: Q&A', 'edublink' ),
                        ),
                        array(
                            'id'       => 'tl_course_announcements_tab_title',
                            'type'     => 'text',
                            'title'    => __( 'Announcements Tab Title', 'edublink' ),
                            'desc'    => __( 'Default Value: Announcements', 'edublink' ),
                        ),
                        array(
                            'id'      => 'tl_course_instructor_tab_status',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Instructor Tab?', 'edublink' ),
                            'default' => true
                        ),
                        array(
                            'id'       => 'tl_course_instructor_tab_title',
                            'type'     => 'text',
                            'title'    => __( 'Announcements Tab Title', 'edublink' ),
                            'desc'    => __( 'Default Value: Instructor', 'edublink' ),
                            'required' => array( 'tl_course_instructor_tab_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'tl_course_sidebar_options',
                            'type'     => 'section',
                            'title'    => __( 'Course Sidebar Options', 'edublink' ),
                            'indent'   => true
                        ),
                        array(
                            'id'      => 'tl_course_details_sidebar_status',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Course Details Sidebar', 'edublink' ),
                            'default' => true
                        ),
                        array(
                            'id'      => 'tl_course_details_sidebar_sticky',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Course Details Sidebar Sticky', 'edublink' ),
                            'default' => false,
                            'desc'    => __( 'By enabling this option, the sidebar will get sticky until the parallal side content is finished while scrolling. Please note that, the sticky will only work at Style 3 & 4.', 'edublink' ),
                            'required' => array( 'tl_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'      => 'tl_course_sidebar_heading_status',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Heading', 'edublink' ),
                            'default' => true,
                            'required' => array( 'tl_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'tl_course_sidebar_heading_text',
                            'type'     => 'text',
                            'title'    => __( 'Heading Text', 'edublink' ),
                            'desc'     => __( 'Value of Course Sidebar Heading', 'edublink' ),
                            'default'  => __( 'Course Includes:', 'edublink' ),
                            'required' => array( 
                                array( 'tl_course_details_sidebar_status', 'equals', true ),
                                array( 'tl_course_sidebar_heading_status', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'tl_course_sidebar_price_status',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Price', 'edublink' ),
                            'default' => true,
                            'required' => array( 'tl_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'tl_course_sidebar_price_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Price', 'edublink' ),
                            'default'  => __( 'Price:', 'edublink' ),
                            'desc'     => __( 'Default Value: Price:', 'edublink' ),
                            'required' => array( 
                                array( 'tl_course_details_sidebar_status', 'equals', true ),
                                array( 'tl_course_sidebar_price_status', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'tl_course_instructor',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Instructor', 'edublink' ),
                            'default' => true,
                            'required' => array( 'tl_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'tl_course_instructor_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Instructor', 'edublink' ),
                            'default'  => __( 'Instructor:', 'edublink' ),
                            'desc'     => __( 'Default Value: Instructor:', 'edublink' ),
                            'required' => array( 
                                array( 'tl_course_details_sidebar_status', 'equals', true ),
                                array( 'tl_course_instructor', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'tl_course_duration',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Duration', 'edublink' ),
                            'default' => true,
                            'required' => array( 'tl_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'tl_course_duration_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Duration', 'edublink' ),
                            'default'  => __( 'Duration:', 'edublink' ),
                            'desc'     => __( 'Default Value: Duration:', 'edublink' ),
                            'required' => array( 
                                array( 'tl_course_details_sidebar_status', 'equals', true ),
                                array( 'tl_course_duration', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'tl_course_lessons',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Lessons', 'edublink' ),
                            'default' => true,
                            'required' => array( 'tl_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'tl_course_lessons_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Lessons', 'edublink' ),
                            'default'  => __( 'Lessons:', 'edublink' ),
                            'desc'     => __( 'Default Value: Lessons:', 'edublink' ),
                            'required' => array( 
                                array( 'tl_course_details_sidebar_status', 'equals', true ),
                                array( 'tl_course_lessons', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'tl_course_students',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Students', 'edublink' ),
                            'default' => true,
                            'required' => array( 'tl_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'tl_course_students_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Students', 'edublink' ),
                            'default'  => __( 'Students:', 'edublink' ),
                            'desc'     => __( 'Default Value: Students:', 'edublink' ),
                            'required' => array( 
                                array( 'tl_course_details_sidebar_status', 'equals', true ),
                                array( 'tl_course_students', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'tl_course_language',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Language', 'edublink' ),
                            'default' => true,
                            'required' => array( 'tl_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'tl_course_language_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Language', 'edublink' ),
                            'default'  => __( 'Language:', 'edublink' ),
                            'desc'     => __( 'Default Value: Language:', 'edublink' ),
                            'required' => array( 
                                array( 'tl_course_details_sidebar_status', 'equals', true ),
                                array( 'tl_course_language', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'tl_course_level',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Level', 'edublink' ),
                            'default' => true,
                            'required' => array( 'tl_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'tl_course_level_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Level', 'edublink' ),
                            'default'  => __( 'Level:', 'edublink' ),
                            'desc'     => __( 'Default Value: Level:', 'edublink' ),
                            'required' => array( 
                                array( 'tl_course_details_sidebar_status', 'equals', true ),
                                array( 'tl_course_level', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'tl_course_last_updated',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Last Updated', 'edublink' ),
                            'default' => false,
                            'required' => array( 'tl_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'tl_course_last_updated_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Last Updated', 'edublink' ),
                            'default'  => __( 'Updated:', 'edublink' ),
                            'desc'     => __( 'Default Value: Last Updated:', 'edublink' ),
                            'required' => array( 
                                array( 'tl_course_details_sidebar_status', 'equals', true ),
                                array( 'tl_course_last_updated', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'tl_course_certificate',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Certificate', 'edublink' ),
                            'default' => true,
                            'required' => array( 'tl_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'tl_course_certificate_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Certificate', 'edublink' ),
                            'default'  => __( 'Certifications:', 'edublink' ),
                            'desc'     => __( 'Default Value: Certifications:', 'edublink' ),
                            'required' => array( 
                                array( 'tl_course_details_sidebar_status', 'equals', true ),
                                array( 'tl_course_certificate', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'tl_course_sidebar_button',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Sidebar Button', 'edublink' ),
                            'default' => true,
                            'required' => array( 'tl_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'    => 'eb_tl_retake_button_text',
                            'type'  => 'text',
                            'title' => __( 'Retake Button Text', 'edublink' ),
                            'desc'  => __( 'Default Text: Retake This Course', 'edublink' ),
                            'required' => array( 'tl_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'    => 'eb_tl_start_learning_button_text',
                            'type'  => 'text',
                            'title' => __( 'Start Learning Button Text', 'edublink' ),
                            'desc'  => __( 'Default Text: Start Learning', 'edublink' ),
                            'required' => array( 'tl_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'    => 'eb_tl_continue_learning_button_text',
                            'type'  => 'text',
                            'title' => __( 'Continue Learning Button Text', 'edublink' ),
                            'desc'  => __( 'Default Text: Continue Learning', 'edublink' ),
                            'required' => array( 'tl_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'    => 'eb_tl_review_progress_button_text',
                            'type'  => 'text',
                            'title' => __( 'Review Progress Button Text', 'edublink' ),
                            'desc'  => __( 'Default Text: Review Progress', 'edublink' ),
                            'required' => array( 'tl_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'    => 'eb_tl_complete_course_button_text',
                            'type'  => 'text',
                            'title' => __( 'Complete Course Button Text', 'edublink' ),
                            'desc'  => __( 'Default Text: Complete Course', 'edublink' ),
                            'required' => array( 'tl_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'eb_tl_enroll_now_button_text',
                            'type'     => 'text',
                            'title'    => __( 'Enroll Now Button Text', 'edublink' ),
                            'desc'     => __( 'Default Text: Enroll Now', 'edublink' ),
                            'required' => array( 'tl_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'      => 'tl_show_course_progress',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Course Progress', 'edublink' ),
                            'desc'    => __( 'Course progress is visible only for logged in users and who already started the course.', 'edublink' ),
                            'default' => true,
                            'required' => array( 'tl_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'      => 'tl_course_wishlist_button',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Social Share', 'edublink' ),
                            'default' => true,
                            'required' => array( 'tl_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'    => 'tl_course_wishlist_button_text',
                            'type'  => 'text',
                            'title' => __( 'Wishlist Button Text', 'edublink' ),
                            'desc'  => __( 'Default Text: Wishlist', 'edublink' ),
                            'required' => array( 
                                array( 'tl_course_details_sidebar_status', 'equals', true ),
                                array( 'tl_course_wishlist_button', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'tl_course_sidebar_social_share',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Social Share', 'edublink' ),
                            'default' => true,
                            'required' => array( 'tl_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'    => 'tl_course_sidebar_social_share_heading',
                            'type'  => 'text',
                            'title' => __( 'Social Share Heading', 'edublink' ),
                            'desc'  => __( 'Default Text: Share On:', 'edublink' ),
                            'default'  => __( 'Share On:', 'edublink' ),
                            'required' => array( 
                                array( 'tl_course_details_sidebar_status', 'equals', true ),
                                array( 'tl_course_sidebar_social_share', 'equals', true )    
                            )
                        )
                    )
                );
            endif;

            if ( edublink_is_lifter_lms_activated() ) :
                $this->sections[] = array(
                    'subsection' => true,
                    'title'      => __( 'Courses Archive(Lifter LMS)', 'edublink' ),
                    'fields'     => array(
                        array(
                            'id'        => 'll_course_style',
                            'type'      => 'select',
                            'title'     => __( 'Course Style', 'edublink' ),
                            'default'   => 1,
                            'options'   => array(
                                '1'     => __( 'One', 'edublink' ),
                                '2'     => __( 'Two', 'edublink' ),
                                '3'     => __( 'Three', 'edublink' ),
                                '4'     => __( 'Four', 'edublink' ),
                                '5'     => __( 'Five', 'edublink' ),
                                '6'     => __( 'Six', 'edublink' ),
                                '7'     => __( 'Seven', 'edublink' ),
                                '8'     => __( 'Eight', 'edublink' ),
                                '9'     => __( 'Nine', 'edublink' ),
                                '10'    => __( 'Ten', 'edublink' ),
                                '11'    => __( 'Eleven', 'edublink' ),
                                '12'    => __( 'Twelve', 'edublink' ),
                                '13'    => __( 'Thirteen', 'edublink' ),
                                '14'    => __( 'Fourteen', 'edublink' ),
                                '15'    => __( 'Fifteen', 'edublink' ),
                                '16'    => __( 'Sixteen', 'edublink' ),
                                '17'    => __( 'Seventeen', 'edublink' ),
                                'quran' => __( 'Quran', 'edublink' )
                            )
                        ),
                        array(
                            'id'        => 'll_course_masonry_layout',
                            'type'      => 'switch',
                            'on'        => __( 'Enable', 'edublink' ),
                            'off'       => __( 'Disable', 'edublink' ),
                            'title'     => __( 'Masonry Layout', 'edublink' ),
                            'default'   => true
                        ),
                        array(
                            'id'        => 'll_course_excerpt_length',
                            'type'      => 'slider',
                            'title'     => __( 'Excerpt Length', 'edublink' ),
                            'default'   => 12,
                            'min'       => 1,
                            'step'      => 1,
                            'max'       => 250
                        ),
                        array(
                            'id'       => 'll_course_button_text',
                            'type'     => 'text',
                            'title'    => __( 'Button Text', 'edublink' ),
                            'default'  => __( 'Enroll Now', 'edublink' ),
                            'desc'     => __( 'Default Text: Enroll Now', 'edublink' )
                        ),
                        array(
                            'id'       => 'll_course_image_size',
                            'type'     => 'select',
                            'title'    => __( 'Course image size', 'edublink' ),
                            'options'  => edublink_available_thumb_size(),
                            'default'  => 'edublink-post-thumb'
                        ),
                        array(
                            'id'      => 'll_course_wishlist_system',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Course Wishlist System', 'edublink' ),
                            'default' => true
                        ),
                        array(
                            'id'      => 'll_header_top_username_show',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Show Username instead of "Logout" at Header Top after logged in.', 'edublink' ),
                            'desc'   => __( 'Show Username which redirects to the profile page while clicking on it instead of "Logout" at Header Top after logged in.', 'edublink' ),
                            'default' => false
                        )
                    )
                );

                // Lifter LMS Single Course settings
                $this->sections[] = array(
                    'subsection' => true,
                    'title'      => __( 'Course Single(Lifter LMS)', 'edublink' ),
                    'fields'     => array(
                        array(
                            'id'          => 'll_course_details_style',
                            'type'        => 'select',
                            'title'       => __( 'Course Details Style', 'edublink' ),
                            'default'     => 1,
                            'options'     => array(
                                '1'       => 'Style 1',
                                '2'       => 'Style 2',
                                '3'       => 'Style 3',
                                '4'       => 'Style 4',
                                '5'       => 'Style 5',
                                '6'       => 'Style 6'
                            )
                        ),
                        array(
                            'id'       => 'll_course_breadcrumb_image',
                            'type'     => 'media',
                            'title'    => __( 'Header Background', 'edublink' ),
                            'subtitle' => __( 'Upload a .jpg or .png image that will be your breadcrumbs. <strong>Only applicable for Course Details Style > Style 4.</strong>', 'edublink' ),
                            'default'  => array(
                                'url'  => get_template_directory_uri() . '/assets/images/edublink-breadcrumb-bg.webp'
                            )
                        ),
                        array(
                            'id'      => 'll_course_preview_thumb',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Course Preview Thumb', 'edublink' ),
                            'default' => true,
                            'required' => array( 'll_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'      => 'll_course_preview_video_popup',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Course Preview Video PopUp', 'edublink' ),
                            'default' => true,
                            'required' => array( 'll_course_preview_thumb', 'equals', true )
                        ),
                        array(
                            'id'      => 'll_course_author_box',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Author Box', 'edublink' ),
                            'default' => true
                        ),
                        array(
                            'id'       => 'll_related_course_options',
                            'type'     => 'section',
                            'title'    => __( 'Related Course', 'edublink' ),
                            'indent'   => true
                        ),
                        array(
                            'id'      => 'll_related_courses',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Related Courses', 'edublink' ),
                            'default' => true
                        ),
                        array(
                            'id'          => 'll_related_course_style',
                            'type'        => 'select',
                            'title'       => __( 'Related Course Style', 'edublink' ),
                            'default'     => 'default',
                            'options'     => array(
                                'default' => 'Default',
                                '1'     => __( 'One', 'edublink' ),
                                '2'     => __( 'Two', 'edublink' ),
                                '3'     => __( 'Three', 'edublink' ),
                                '4'     => __( 'Four', 'edublink' ),
                                '5'     => __( 'Five', 'edublink' ),
                                '6'     => __( 'Six', 'edublink' ),
                                '7'     => __( 'Seven', 'edublink' ),
                                '8'     => __( 'Eight', 'edublink' ),
                                '9'     => __( 'Nine', 'edublink' ),
                                '10'    => __( 'Ten', 'edublink' ),
                                '11'    => __( 'Eleven', 'edublink' ),
                                '12'    => __( 'Twelve', 'edublink' ),
                                '13'    => __( 'Thirteen', 'edublink' ),
                                '14'    => __( 'Fourteen', 'edublink' ),
                                '15'    => __( 'Fifteen', 'edublink' ),
                                '16'    => __( 'Sixteen', 'edublink' ),
                                '17'    => __( 'Seventeen', 'edublink' ),
                                'quran' => __( 'Quran', 'edublink' )
                            ),
                            'required' => array( 'll_related_courses', 'equals', true )
                        ),
                        array(
                            'id'       => 'll_related_course_title',
                            'type'     => 'text',
                            'title'    => __( 'Related Courses Title', 'edublink' ),
                            'default'  => __( 'Courses You May Like', 'edublink' ),
                            'required' => array( 'll_related_courses', 'equals', true )
                        ),
                        array(
                            'id'       => 'll_course_sidebar_options',
                            'type'     => 'section',
                            'title'    => __( 'Course Sidebar Options', 'edublink' ),
                            'indent'   => true
                        ),
                        array(
                            'id'      => 'll_course_details_sidebar_status',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Course Details Sidebar', 'edublink' ),
                            'default' => true
                        ),
                        array(
                            'id'      => 'll_course_details_sidebar_sticky',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Course Details Sidebar Sticky', 'edublink' ),
                            'default' => false,
                            'desc'    => __( 'By enabling this option, the sidebar will get sticky until the parallal side content is finished while scrolling. Please note that, the sticky will only work at Style 3 & 4.', 'edublink' ),
                            'required' => array( 'll_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'      => 'll_course_sidebar_heading_status',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Heading', 'edublink' ),
                            'default' => true,
                            'required' => array( 'll_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'll_course_sidebar_heading_text',
                            'type'     => 'text',
                            'title'    => __( 'Heading Text', 'edublink' ),
                            'desc'     => __( 'Value of Course Sidebar Heading', 'edublink' ),
                            'default'  => __( 'Course Includes:', 'edublink' ),
                            'required' => array( 
                                array( 'll_course_details_sidebar_status', 'equals', true ),
                                array( 'll_course_sidebar_heading_status', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'll_course_sidebar_price_status',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Price', 'edublink' ),
                            'default' => true,
                            'required' => array( 'll_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'll_course_sidebar_price_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Price', 'edublink' ),
                            'default'  => __( 'Price:', 'edublink' ),
                            'desc'     => __( 'Default Value: Price:', 'edublink' ),
                            'required' => array( 
                                array( 'll_course_details_sidebar_status', 'equals', true ),
                                array( 'll_course_sidebar_price_status', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'll_course_instructor',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Instructor', 'edublink' ),
                            'default' => true,
                            'required' => array( 'll_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'll_course_instructor_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Instructor', 'edublink' ),
                            'default'  => __( 'Instructor:', 'edublink' ),
                            'desc'     => __( 'Default Value: Instructor:', 'edublink' ),
                            'required' => array( 
                                array( 'll_course_details_sidebar_status', 'equals', true ),
                                array( 'll_course_instructor', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'll_course_duration',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Duration', 'edublink' ),
                            'default' => true,
                            'required' => array( 'll_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'll_course_duration_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Duration', 'edublink' ),
                            'default'  => __( 'Duration:', 'edublink' ),
                            'desc'     => __( 'Default Value: Duration:', 'edublink' ),
                            'required' => array( 
                                array( 'll_course_details_sidebar_status', 'equals', true ),
                                array( 'll_course_duration', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'll_course_lessons',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Lessons', 'edublink' ),
                            'default' => true,
                            'required' => array( 'll_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'll_course_lessons_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Lessons', 'edublink' ),
                            'default'  => __( 'Lessons:', 'edublink' ),
                            'desc'     => __( 'Default Value: Lessons:', 'edublink' ),
                            'required' => array( 
                                array( 'll_course_details_sidebar_status', 'equals', true ),
                                array( 'll_course_lessons', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'll_course_students',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Students', 'edublink' ),
                            'default' => true,
                            'required' => array( 'll_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'll_course_students_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Students', 'edublink' ),
                            'default'  => __( 'Students:', 'edublink' ),
                            'desc'     => __( 'Default Value: Students:', 'edublink' ),
                            'required' => array( 
                                array( 'll_course_details_sidebar_status', 'equals', true ),
                                array( 'll_course_students', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'll_course_language',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Language', 'edublink' ),
                            'default' => true,
                            'required' => array( 'll_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'll_course_language_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Language', 'edublink' ),
                            'default'  => __( 'Language:', 'edublink' ),
                            'desc'     => __( 'Default Value: Language:', 'edublink' ),
                            'required' => array( 
                                array( 'll_course_details_sidebar_status', 'equals', true ),
                                array( 'll_course_language', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'll_course_certificate',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Certificate', 'edublink' ),
                            'default' => true,
                            'required' => array( 'll_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'll_course_certificate_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Certificate', 'edublink' ),
                            'default'  => __( 'Certifications:', 'edublink' ),
                            'desc'     => __( 'Default Value: Certifications:', 'edublink' ),
                            'required' => array( 
                                array( 'll_course_details_sidebar_status', 'equals', true ),
                                array( 'll_course_certificate', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'll_course_sidebar_social_share',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Social Share', 'edublink' ),
                            'default' => true,
                            'required' => array( 'll_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'    => 'll_course_sidebar_social_share_heading',
                            'type'  => 'text',
                            'title' => __( 'Social Share Heading', 'edublink' ),
                            'desc'  => __( 'Default Text: Share On:', 'edublink' ),
                            'default'  => __( 'Share On:', 'edublink' ),
                            'required' => array( 
                                array( 'll_course_details_sidebar_status', 'equals', true ),
                                array( 'll_course_sidebar_social_share', 'equals', true )    
                            )
                        )
                    )
                );
            endif;

            if ( edublink_is_masterstudy_lms_activated() ) :
                $this->sections[] = array(
                    'subsection' => true,
                    'title'      => __( 'Courses Archive(MasterStudy)', 'edublink' ),
                    'fields'     => array(
                        array(
                            'id'      => 'ms_header_top_username_show',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Show Username instead of "Logout" at Header Top after logged in.', 'edublink' ),
                            'desc'    => __( 'Show Username which redirects to the profile page while clicking on it instead of "Logout" at Header Top after logged in.', 'edublink' ),
                            'default' => false
                        ),
                        array(
                            'id'       => 'ms_header_top_username_profile_page',
                            'type'     => 'select',
                            'title'    => __( 'Profile Page', 'edublink' ),
                            'default'  => 'user-account',
                            'options'  => array(
                                'user-account'        => 'User Account',
                                'user-public-account' => 'User Public Account'
                            ),
                            'required' => array( 'ms_header_top_username_show', 'equals', true )
                        ),
                        array(
                            'id'      => 'ms_instructor_linking',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Enable Instructor Linking', 'edublink' ),
                            'default' => true
                        ),
                    )
                );

                // Master LMS Single Course settings
                $this->sections[] = array(
                    'subsection' => true,
                    'title'      => __( 'Course Single(Master LMS)', 'edublink' ),
                    'fields'     => array(
                        array(
                            'id'          => 'ms_course_details_style',
                            'type'        => 'select',
                            'title'       => __( 'Course Details Style', 'edublink' ),
                            'default'     => 1,
                            'options'     => array(
                                '1'       => 'Style 1',
                                '2'       => 'Style 2',
                                '3'       => 'Style 3',
                                '4'       => 'Style 4',
                                '5'       => 'Style 5',
                                '6'       => 'Style 6'
                            )
                        ),
                        array(
                            'id'       => 'ms_course_breadcrumb_image',
                            'type'     => 'media',
                            'title'    => __( 'Header Background', 'edublink' ),
                            'subtitle' => __( 'Upload a .jpg or .png image that will be your breadcrumbs. <strong>Only applicable for Course Details Style > Style 4.</strong>', 'edublink' ),
                            'default'  => array(
                                'url'  => get_template_directory_uri() . '/assets/images/edublink-breadcrumb-bg.webp'
                            ),
                        ),
                        array(
                            'id'      => 'ms_course_preview_thumb',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Course Preview Thumb', 'edublink' ),
                            'default' => true,
                            'required' => array( 'ms_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'      => 'ms_course_preview_video_popup',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Course Preview Video PopUp', 'edublink' ),
                            'default' => true,
                            'required' => array( 'ms_course_preview_thumb', 'equals', true )
                        ),
                        array(
                            'id'      => 'ms_course_author_box',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Author Box', 'edublink' ),
                            'default' => true
                        ),
                        array(
                            'id'       => 'ms_related_course_options',
                            'type'     => 'section',
                            'title'    => __( 'Related Course', 'edublink' ),
                            'indent'   => true
                        ),
                        array(
                            'id'      => 'ms_related_courses',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Related Courses', 'edublink' ),
                            'default' => true
                        ),
                        array(
                            'id'          => 'ms_related_course_style',
                            'type'        => 'select',
                            'title'       => __( 'Related Course Style', 'edublink' ),
                            'default'     => 'default',
                            'options'     => array(
                                'default' => 'Default',
                                '1'       => __( 'One', 'edublink' ),
                                '2'       => __( 'Two', 'edublink' ),
                                '3'       => __( 'Three', 'edublink' ),
                                '4'       => __( 'Four', 'edublink' ),
                                '5'       => __( 'Five', 'edublink' ),
                                '6'       => __( 'Six', 'edublink' ),
                                '7'       => __( 'Seven', 'edublink' ),
                                '8'       => __( 'Eight', 'edublink' ),
                                '9'       => __( 'Nine', 'edublink' ),
                                '10'      => __( 'Ten', 'edublink' ),
                                '11'      => __( 'Eleven', 'edublink' ),
                                '12'      => __( 'Twelve', 'edublink' ),
                                '13'      => __( 'Thirteen', 'edublink' ),
                                '14'      => __( 'Fourteen', 'edublink' ),
                                '15'      => __( 'Fifteen', 'edublink' ),
                                '16'      => __( 'Sixteen', 'edublink' ),
                                '17'      => __( 'Seventeen', 'edublink' ),
                                'quran'   => __( 'Quran', 'edublink' )
                            ),
                            'required' => array( 'ms_related_courses', 'equals', true )
                        ),
                        array(
                            'id'       => 'ms_related_course_title',
                            'type'     => 'text',
                            'title'    => __( 'Related Courses Title', 'edublink' ),
                            'default'  => __( 'Courses You May Like', 'edublink' ),
                            'required' => array( 'ms_related_courses', 'equals', true )
                        ),
                        array(
                            'id'       => 'ms_course_sidebar_options',
                            'type'     => 'section',
                            'title'    => __( 'Course Sidebar Options', 'edublink' ),
                            'indent'   => true
                        ),
                        array(
                            'id'      => 'ms_course_details_sidebar_status',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Course Details Sidebar', 'edublink' ),
                            'default' => true
                        ),
                        array(
                            'id'      => 'ms_course_details_sidebar_sticky',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Course Details Sidebar Sticky', 'edublink' ),
                            'default' => false,
                            'desc'    => __( 'By enabling this option, the sidebar will get sticky until the parallal side content is finished while scrolling. Please note that, the sticky will only work at Style 3 & 4.', 'edublink' ),
                            'required' => array( 'ms_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'      => 'ms_course_sidebar_heading_status',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Heading', 'edublink' ),
                            'default' => true,
                            'required' => array( 'ms_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'ms_course_sidebar_heading_text',
                            'type'     => 'text',
                            'title'    => __( 'Heading Text', 'edublink' ),
                            'desc'     => __( 'Value of Course Sidebar Heading', 'edublink' ),
                            'default'  => __( 'Course Includes:', 'edublink' ),
                            'required' => array( 
                                array( 'ms_course_details_sidebar_status', 'equals', true ),
                                array( 'ms_course_sidebar_heading_status', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'ms_course_sidebar_price_status',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Price', 'edublink' ),
                            'default' => true,
                            'required' => array( 'ms_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'ms_course_sidebar_price_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Price', 'edublink' ),
                            'default'  => __( 'Price:', 'edublink' ),
                            'desc'     => __( 'Default Value: Price:', 'edublink' ),
                            'required' => array( 
                                array( 'ms_course_details_sidebar_status', 'equals', true ),
                                array( 'ms_course_sidebar_price_status', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'ms_course_instructor',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Instructor', 'edublink' ),
                            'default' => true,
                            'required' => array( 'ms_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'ms_course_instructor_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Instructor', 'edublink' ),
                            'default'  => __( 'Instructor:', 'edublink' ),
                            'desc'     => __( 'Default Value: Instructor:', 'edublink' ),
                            'required' => array( 
                                array( 'ms_course_details_sidebar_status', 'equals', true ),
                                array( 'ms_course_instructor', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'ms_course_duration',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Duration', 'edublink' ),
                            'default' => true,
                            'required' => array( 'ms_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'ms_course_duration_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Duration', 'edublink' ),
                            'default'  => __( 'Duration:', 'edublink' ),
                            'desc'     => __( 'Default Value: Duration:', 'edublink' ),
                            'required' => array( 
                                array( 'ms_course_details_sidebar_status', 'equals', true ),
                                array( 'ms_course_duration', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'ms_course_lessons',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Lessons', 'edublink' ),
                            'default' => true,
                            'required' => array( 'ms_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'ms_course_lessons_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Lessons', 'edublink' ),
                            'default'  => __( 'Lessons:', 'edublink' ),
                            'desc'     => __( 'Default Value: Lessons:', 'edublink' ),
                            'required' => array( 
                                array( 'ms_course_details_sidebar_status', 'equals', true ),
                                array( 'ms_course_lessons', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'ms_course_students',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Students', 'edublink' ),
                            'default' => true,
                            'required' => array( 'ms_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'ms_course_students_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Students', 'edublink' ),
                            'default'  => __( 'Students:', 'edublink' ),
                            'desc'     => __( 'Default Value: Students:', 'edublink' ),
                            'required' => array( 
                                array( 'ms_course_details_sidebar_status', 'equals', true ),
                                array( 'ms_course_students', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'ms_course_language',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Language', 'edublink' ),
                            'default' => true,
                            'required' => array( 'ms_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'ms_course_language_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Language', 'edublink' ),
                            'default'  => __( 'Language:', 'edublink' ),
                            'desc'     => __( 'Default Value: Language:', 'edublink' ),
                            'required' => array( 
                                array( 'ms_course_details_sidebar_status', 'equals', true ),
                                array( 'ms_course_language', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'ms_course_certificate',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Certificate', 'edublink' ),
                            'default' => true,
                            'required' => array( 'ms_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'       => 'ms_course_certificate_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Certificate', 'edublink' ),
                            'default'  => __( 'Certifications:', 'edublink' ),
                            'desc'     => __( 'Default Value: Certifications:', 'edublink' ),
                            'required' => array( 
                                array( 'ms_course_details_sidebar_status', 'equals', true ),
                                array( 'ms_course_certificate', 'equals', true )    
                            )
                        ),
                        array(
                            'id'      => 'ms_course_sidebar_social_share',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Social Share', 'edublink' ),
                            'default' => true,
                            'required' => array( 'ms_course_details_sidebar_status', 'equals', true )
                        ),
                        array(
                            'id'    => 'ms_course_sidebar_social_share_heading',
                            'type'  => 'text',
                            'title' => __( 'Social Share Heading', 'edublink' ),
                            'desc'  => __( 'Default Text: Share On:', 'edublink' ),
                            'default'  => __( 'Share On:', 'edublink' ),
                            'required' => array( 
                                array( 'ms_course_details_sidebar_status', 'equals', true ),
                                array( 'ms_course_sidebar_social_share', 'equals', true )    
                            )
                        )
                    )
                );
            endif;

            if ( edublink_is_sensei_lms_activated() ) :
                $this->sections[] = array(
                    'subsection' => true,
                    'title'      => __( 'Courses Archive(Sensei)', 'edublink' ),
                    'fields'     => array(
                        array(
                            'id'        => 'ss_course_style',
                            'type'      => 'select',
                            'title'     => __( 'Course Style', 'edublink' ),
                            'default'   => 1,
                            'options'   => array(
                                '1'     => __( 'One', 'edublink' ),
                                '2'     => __( 'Two', 'edublink' ),
                                '3'     => __( 'Three', 'edublink' ),
                                '4'     => __( 'Four', 'edublink' ),
                                '5'     => __( 'Five', 'edublink' ),
                                '6'     => __( 'Six', 'edublink' ),
                                '7'     => __( 'Seven', 'edublink' ),
                                '8'     => __( 'Eight', 'edublink' ),
                                '9'     => __( 'Nine', 'edublink' ),
                                '10'    => __( 'Ten', 'edublink' ),
                                '11'    => __( 'Eleven', 'edublink' ),
                                '12'    => __( 'Twelve', 'edublink' ),
                                '13'    => __( 'Thirteen', 'edublink' ),
                                '14'    => __( 'Fourteen', 'edublink' ),
                                '15'    => __( 'Fifteen', 'edublink' ),
                                '16'    => __( 'Sixteen', 'edublink' ),
                                '17'    => __( 'Seventeen', 'edublink' ),
                                'quran' => __( 'Quran', 'edublink' )
                            )
                        ),
                        // array(
                        //     'id'        => 'ss_course_masonry_layout',
                        //     'type'      => 'switch',
                        //     'on'        => __( 'Enable', 'edublink' ),
                        //     'off'       => __( 'Disable', 'edublink' ),
                        //     'title'     => __( 'Masonry Layout', 'edublink' ),
                        //     'default'   => true
                        // ),
                        // array(
                        //     'id'        => 'ss_course_archive_page_items',
                        //     'type'      => 'slider',
                        //     'title'     => __( 'Number of Courses Per Page', 'edublink' ),
                        //     'default'   => 9,
                        //     'min'       => -1,
                        //     'step'      => 1,
                        //     'max'       => 250
                        // ),
                        array(
                            'id'        => 'ss_course_excerpt_length',
                            'type'      => 'slider',
                            'title'     => __( 'Excerpt Length', 'edublink' ),
                            'default'   => 12,
                            'min'       => 1,
                            'step'      => 1,
                            'max'       => 250
                        ),
                        array(
                            'id'       => 'ss_course_button_text',
                            'type'     => 'text',
                            'title'    => __( 'Button Text', 'edublink' ),
                            'default'  => __( 'Enroll Now', 'edublink' ),
                            'desc'     => __( 'Default Text: Enroll Now', 'edublink' )
                        ),
                        array(
                            'id'       => 'ss_course_image_size',
                            'type'     => 'select',
                            'title'    => __( 'Course image size', 'edublink' ),
                            'options'  => edublink_available_thumb_size(),
                            'default'  => 'edublink-post-thumb'
                        ),
                        array(
                            'id'      => 'ss_course_rating_system',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Course Rating System', 'edublink' ),
                            'default' => true
                        ),
                        // array(
                        //     'id'      => 'ss_course_wishlist_system',
                        //     'type'    => 'switch',
                        //     'on'      => __( 'Enable', 'edublink' ),
                        //     'off'     => __( 'Disable', 'edublink' ),
                        //     'title'   => __( 'Course Wishlist System', 'edublink' ),
                        //     'default' => true
                        // )
                    )
                );

                // Sensei Single Course settings
                $this->sections[] = array(
                    'subsection' => true,
                    'title'      => __( 'Course Single(Sensei)', 'edublink' ),
                    'fields'     => array(
                        array(
                            'id'          => 'ss_course_details_style',
                            'type'        => 'select',
                            'title'       => __( 'Course Details Style', 'edublink' ),
                            'default'     => 1,
                            'options'     => array(
                                '1'       => 'Style 1',
                                '2'       => 'Style 2',
                                '3'       => 'Style 3',
                                '4'       => 'Style 4',
                                '5'       => 'Style 5',
                                '6'       => 'Style 6'
                            )
                        ),
                        // array(
                        //     'id'       => 'ld_course_breadcrumb_image',
                        //     'type'     => 'media',
                        //     'title'    => __( 'Header Background', 'edublink' ),
                        //     'subtitle' => __( 'Upload a .jpg or .png image that will be your breadcrumbs. <strong>Only applicable for Course Details Style > Style 4.</strong>', 'edublink' ),
                        //     'default'  => array(
                        //         'url'  => get_template_directory_uri() . '/assets/images/edublink-breadcrumb-bg.webp'
                        //     )
                        // ),
                        // array(
                        //     'id'      => 'ld_course_preview_thumb',
                        //     'type'    => 'switch',
                        //     'on'      => __( 'Enable', 'edublink' ),
                        //     'off'     => __( 'Disable', 'edublink' ),
                        //     'title'   => __( 'Course Preview Thumb', 'edublink' ),
                        //     'default' => true,
                        //     'required' => array( 'ld_course_details_sidebar_status', 'equals', true )
                        // ),
                        // array(
                        //     'id'      => 'ld_course_preview_video_popup',
                        //     'type'    => 'switch',
                        //     'on'      => __( 'Enable', 'edublink' ),
                        //     'off'     => __( 'Disable', 'edublink' ),
                        //     'title'   => __( 'Course Preview Video PopUp', 'edublink' ),
                        //     'default' => true,
                        //     'required' => array( 'ld_course_preview_thumb', 'equals', true )
                        // ),
                        // array(
                        //     'id'       => 'ld_related_course_options',
                        //     'type'     => 'section',
                        //     'title'    => __( 'Related Course', 'edublink' ),
                        //     'indent'   => true
                        // ),
                        // array(
                        //     'id'      => 'ld_related_courses',
                        //     'type'    => 'switch',
                        //     'on'      => __( 'Enable', 'edublink' ),
                        //     'off'     => __( 'Disable', 'edublink' ),
                        //     'title'   => __( 'Related Courses', 'edublink' ),
                        //     'default' => true
                        // ),
                        // array(
                        //     'id'          => 'ld_related_course_style',
                        //     'type'        => 'select',
                        //     'title'       => __( 'Related Course Style', 'edublink' ),
                        //     'default'     => 'default',
                        //     'options'     => array(
                        //         'default' => 'Default',
                        //         '1'     => __( 'One', 'edublink' ),
                        //         '2'     => __( 'Two', 'edublink' ),
                        //         '3'     => __( 'Three', 'edublink' ),
                        //         '4'     => __( 'Four', 'edublink' ),
                        //         '5'     => __( 'Five', 'edublink' ),
                        //         '6'     => __( 'Six', 'edublink' ),
                        //         '7'     => __( 'Seven', 'edublink' ),
                        //         '8'     => __( 'Eight', 'edublink' ),
                        //         '9'     => __( 'Nine', 'edublink' ),
                        //         '10'    => __( 'Ten', 'edublink' ),
                        //         '11'    => __( 'Eleven', 'edublink' ),
                        //         '12'    => __( 'Twelve', 'edublink' ),
                        //         '13'    => __( 'Thirteen', 'edublink' ),
                        //         '14'    => __( 'Fourteen', 'edublink' ),
                        //         '15'    => __( 'Fifteen', 'edublink' ),
                        //         '16'    => __( 'Sixteen', 'edublink' ),
                        //         '17'    => __( 'Seventeen', 'edublink' ),
                        //         'quran' => __( 'Quran', 'edublink' )
                        //     ),
                        //     'required' => array( 'ld_related_courses', 'equals', true )
                        // ),
                        // array(
                        //     'id'       => 'ld_related_course_title',
                        //     'type'     => 'text',
                        //     'title'    => __( 'Related Courses Title', 'edublink' ),
                        //     'default'  => __( 'Courses You May Like', 'edublink' ),
                        //     'required' => array( 'ld_related_courses', 'equals', true )
                        // ),
                        // array(
                        //     'id'       => 'ld_course_sidebar_options',
                        //     'type'     => 'section',
                        //     'title'    => __( 'Course Sidebar Options', 'edublink' ),
                        //     'indent'   => true
                        // ),
                        // array(
                        //     'id'      => 'ld_course_details_sidebar_status',
                        //     'type'    => 'switch',
                        //     'on'      => __( 'Enable', 'edublink' ),
                        //     'off'     => __( 'Disable', 'edublink' ),
                        //     'title'   => __( 'Course Details Sidebar', 'edublink' ),
                        //     'default' => true
                        // ),
                        // array(
                        //     'id'      => 'ld_course_details_sidebar_sticky',
                        //     'type'    => 'switch',
                        //     'on'      => __( 'Enable', 'edublink' ),
                        //     'off'     => __( 'Disable', 'edublink' ),
                        //     'title'   => __( 'Course Details Sidebar Sticky', 'edublink' ),
                        //     'default' => false,
                        //     'desc'    => __( 'By enabling this option, the sidebar will get sticky until the parallal side content is finished while scrolling. Please note that, the sticky will only work at Style 3 & 4.', 'edublink' ),
                        //     'required' => array( 'ld_course_details_sidebar_status', 'equals', true )
                        // ),
                        // array(
                        //     'id'      => 'ld_course_sidebar_heading_status',
                        //     'type'    => 'switch',
                        //     'on'      => __( 'Enable', 'edublink' ),
                        //     'off'     => __( 'Disable', 'edublink' ),
                        //     'title'   => __( 'Heading', 'edublink' ),
                        //     'default' => true,
                        //     'required' => array( 'ld_course_details_sidebar_status', 'equals', true )
                        // ),
                        // array(
                        //     'id'       => 'ld_course_sidebar_heading_text',
                        //     'type'     => 'text',
                        //     'title'    => __( 'Heading Text', 'edublink' ),
                        //     'desc'     => __( 'Value of Course Sidebar Heading', 'edublink' ),
                        //     'default'  => __( 'Course Includes:', 'edublink' ),
                        //     'required' => array( 
                        //         array( 'ld_course_details_sidebar_status', 'equals', true ),
                        //         array( 'ld_course_sidebar_heading_status', 'equals', true )    
                        //     )
                        // ),
                        // array(
                        //     'id'      => 'ld_course_sidebar_price_status',
                        //     'type'    => 'switch',
                        //     'on'      => __( 'Enable', 'edublink' ),
                        //     'off'     => __( 'Disable', 'edublink' ),
                        //     'title'   => __( 'Price', 'edublink' ),
                        //     'default' => true,
                        //     'required' => array( 'ld_course_details_sidebar_status', 'equals', true )
                        // ),
                        // array(
                        //     'id'       => 'ld_course_sidebar_price_label',
                        //     'type'     => 'text',
                        //     'title'    => __( 'Label for Price', 'edublink' ),
                        //     'default'  => __( 'Price:', 'edublink' ),
                        //     'desc'     => __( 'Default Value: Price:', 'edublink' ),
                        //     'required' => array( 
                        //         array( 'ld_course_details_sidebar_status', 'equals', true ),
                        //         array( 'ld_course_sidebar_price_status', 'equals', true )    
                        //     )
                        // ),
                        // array(
                        //     'id'      => 'ld_course_instructor',
                        //     'type'    => 'switch',
                        //     'on'      => __( 'Enable', 'edublink' ),
                        //     'off'     => __( 'Disable', 'edublink' ),
                        //     'title'   => __( 'Instructor', 'edublink' ),
                        //     'default' => true,
                        //     'required' => array( 'ld_course_details_sidebar_status', 'equals', true )
                        // ),
                        // array(
                        //     'id'       => 'ld_course_instructor_label',
                        //     'type'     => 'text',
                        //     'title'    => __( 'Label for Instructor', 'edublink' ),
                        //     'default'  => __( 'Instructor:', 'edublink' ),
                        //     'desc'     => __( 'Default Value: Instructor:', 'edublink' ),
                        //     'required' => array( 
                        //         array( 'ld_course_details_sidebar_status', 'equals', true ),
                        //         array( 'ld_course_instructor', 'equals', true )    
                        //     )
                        // ),
                        // array(
                        //     'id'      => 'ld_course_duration',
                        //     'type'    => 'switch',
                        //     'on'      => __( 'Enable', 'edublink' ),
                        //     'off'     => __( 'Disable', 'edublink' ),
                        //     'title'   => __( 'Duration', 'edublink' ),
                        //     'default' => true,
                        //     'required' => array( 'ld_course_details_sidebar_status', 'equals', true )
                        // ),
                        // array(
                        //     'id'       => 'ld_course_duration_label',
                        //     'type'     => 'text',
                        //     'title'    => __( 'Label for Duration', 'edublink' ),
                        //     'default'  => __( 'Duration:', 'edublink' ),
                        //     'desc'     => __( 'Default Value: Duration:', 'edublink' ),
                        //     'required' => array( 
                        //         array( 'ld_course_details_sidebar_status', 'equals', true ),
                        //         array( 'ld_course_duration', 'equals', true )    
                        //     )
                        // ),
                        // array(
                        //     'id'      => 'ld_course_lessons',
                        //     'type'    => 'switch',
                        //     'on'      => __( 'Enable', 'edublink' ),
                        //     'off'     => __( 'Disable', 'edublink' ),
                        //     'title'   => __( 'Lessons', 'edublink' ),
                        //     'default' => true,
                        //     'required' => array( 'ld_course_details_sidebar_status', 'equals', true )
                        // ),
                        // array(
                        //     'id'       => 'ld_course_lessons_label',
                        //     'type'     => 'text',
                        //     'title'    => __( 'Label for Lessons', 'edublink' ),
                        //     'default'  => __( 'Lessons:', 'edublink' ),
                        //     'desc'     => __( 'Default Value: Lessons:', 'edublink' ),
                        //     'required' => array( 
                        //         array( 'ld_course_details_sidebar_status', 'equals', true ),
                        //         array( 'ld_course_lessons', 'equals', true )    
                        //     )
                        // ),
                        // array(
                        //     'id'      => 'ld_course_students',
                        //     'type'    => 'switch',
                        //     'on'      => __( 'Enable', 'edublink' ),
                        //     'off'     => __( 'Disable', 'edublink' ),
                        //     'title'   => __( 'Students', 'edublink' ),
                        //     'default' => true,
                        //     'required' => array( 'ld_course_details_sidebar_status', 'equals', true )
                        // ),
                        // array(
                        //     'id'       => 'ld_course_students_label',
                        //     'type'     => 'text',
                        //     'title'    => __( 'Label for Students', 'edublink' ),
                        //     'default'  => __( 'Students:', 'edublink' ),
                        //     'desc'     => __( 'Default Value: Students:', 'edublink' ),
                        //     'required' => array( 
                        //         array( 'ld_course_details_sidebar_status', 'equals', true ),
                        //         array( 'ld_course_students', 'equals', true )    
                        //     )
                        // ),
                        // array(
                        //     'id'      => 'ld_course_language',
                        //     'type'    => 'switch',
                        //     'on'      => __( 'Enable', 'edublink' ),
                        //     'off'     => __( 'Disable', 'edublink' ),
                        //     'title'   => __( 'Language', 'edublink' ),
                        //     'default' => true,
                        //     'required' => array( 'ld_course_details_sidebar_status', 'equals', true )
                        // ),
                        // array(
                        //     'id'       => 'ld_course_language_label',
                        //     'type'     => 'text',
                        //     'title'    => __( 'Label for Language', 'edublink' ),
                        //     'default'  => __( 'Language:', 'edublink' ),
                        //     'desc'     => __( 'Default Value: Language:', 'edublink' ),
                        //     'required' => array( 
                        //         array( 'ld_course_details_sidebar_status', 'equals', true ),
                        //         array( 'ld_course_language', 'equals', true )    
                        //     )
                        // ),
                        // array(
                        //     'id'      => 'ld_course_certificate',
                        //     'type'    => 'switch',
                        //     'on'      => __( 'Enable', 'edublink' ),
                        //     'off'     => __( 'Disable', 'edublink' ),
                        //     'title'   => __( 'Certificate', 'edublink' ),
                        //     'default' => true,
                        //     'required' => array( 'ld_course_details_sidebar_status', 'equals', true )
                        // ),
                        // array(
                        //     'id'       => 'ld_course_certificate_label',
                        //     'type'     => 'text',
                        //     'title'    => __( 'Label for Certificate', 'edublink' ),
                        //     'default'  => __( 'Certifications:', 'edublink' ),
                        //     'desc'     => __( 'Default Value: Certifications:', 'edublink' ),
                        //     'required' => array( 
                        //         array( 'ld_course_details_sidebar_status', 'equals', true ),
                        //         array( 'ld_course_certificate', 'equals', true )    
                        //     )
                        // ),
                        // array(
                        //     'id'      => 'ld_course_sidebar_button',
                        //     'type'    => 'switch',
                        //     'on'      => __( 'Enable', 'edublink' ),
                        //     'off'     => __( 'Disable', 'edublink' ),
                        //     'title'   => __( 'Sidebar Button', 'edublink' ),
                        //     'default' => true,
                        //     'required' => array( 'ld_course_details_sidebar_status', 'equals', true )
                        // ),
                        // array(
                        //     'id'    => 'ld_external_button_text',
                        //     'type'  => 'text',
                        //     'title' => __( 'External Button Text', 'edublink' ),
                        //     'default' => __( 'More Info', 'edublink' ),
                        //     'required' => array( 
                        //         array( 'ld_course_details_sidebar_status', 'equals', true ),
                        //         array( 'ld_course_sidebar_button', 'equals', true )    
                        //     )
                        // ),
                        // array(
                        //     'id'      => 'ld_external_button_open_tab',
                        //     'type'    => 'switch',
                        //     'on'      => __( 'Enable', 'edublink' ),
                        //     'off'     => __( 'Disable', 'edublink' ),
                        //     'title'   => __( 'Button Open in New Tab?', 'edublink' ),
                        //     'default' => true,
                        //     'desc'    => __( 'By enabling it, while visitor will click on the button, it will redirect the user in a new tab rather then the same tab.', 'edublink' ),
                        //     'required' => array( 
                        //         array( 'ld_course_details_sidebar_status', 'equals', true ),
                        //         array( 'ld_course_sidebar_button', 'equals', true )    
                        //     )
                        // ),
                        // array(
                        //     'id'      => 'ld_course_sidebar_social_share',
                        //     'type'    => 'switch',
                        //     'on'      => __( 'Enable', 'edublink' ),
                        //     'off'     => __( 'Disable', 'edublink' ),
                        //     'title'   => __( 'Social Share', 'edublink' ),
                        //     'default' => true,
                        //     'required' => array( 'ld_course_details_sidebar_status', 'equals', true )
                        // ),
                        // array(
                        //     'id'    => 'ld_course_sidebar_social_share_heading',
                        //     'type'  => 'text',
                        //     'title' => __( 'Social Share Heading', 'edublink' ),
                        //     'desc'  => __( 'Default Text: Share On:', 'edublink' ),
                        //     'default'  => __( 'Share On:', 'edublink' ),
                        //     'required' => array( 
                        //         array( 'ld_course_details_sidebar_status', 'equals', true ),
                        //         array( 'ld_course_sidebar_social_share', 'equals', true )    
                        //     )
                        // )
                    )
                );
            endif;

            // Events settings for WP Events Manager
            if ( edublink_is_wp_events_manager_activated() ) :
                $this->sections[] = array(
                    'icon'   => 'el el-pencil',
                    'title'  => __( 'Events( WP Events Manager )', 'edublink' ),
                    'fields' => array(
                        array(
                            'id'      => 'tp_event_show_breadcrumb',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Breadcrumbs', 'edublink' ),
                            'default' => true
                        ),
                        array(
                            'id'      => 'tp_event_show_default_breadcrumb',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Show Default Breadcrumb Background', 'edublink' ),
                            'default' => true,
                            'required' => array( 'tp_event_show_breadcrumb', 'equals', true )
                        ),
                        array (
                            'id'          => 'tp_event_breadcrumb_color',
                            'title'       => __( 'Breadcrumbs Background Color', 'edublink' ),
                            'subtitle'    => '<em>' . __( 'The breadcrumbs background color of the site. If there is no background image available only then this background color will be visible.', 'edublink' ) . '</em>',
                            'type'        => 'color',
                            'required'    => array( 
                                array( 'show_page_breadcrumb', 'equals', true ),
                                array( 'tp_event_show_default_breadcrumb', '!=', true )    
                            )
                        ),
                        array(
                            'id'       => 'tp_event_breadcrumb_image',
                            'type'     => 'media',
                            'title'    => __( 'Breadcrumbs Background', 'edublink' ),
                            'subtitle' => __( 'Upload a .jpg or .png image that will be your breadcrumbs. <strong>The background image will only visible for "Style 1" which is located at Header Settings > Global Breadcrumb Style > Style 1.</strong>', 'edublink' ),
                            'default'  => array(
                                'url' => get_template_directory_uri() . '/assets/images/edublink-breadcrumb-bg.webp'
                            ),
                            'required'    => array( 
                                array( 'show_page_breadcrumb', 'equals', true ),
                                array( 'tp_event_show_default_breadcrumb', '!=', true )    
                            )
                        )
                    )
                );

                $this->sections[] = array(
                    'subsection' => true,
                    'title'      => __( 'Event Archive', 'edublink' ),
                    'fields'     => array(
                        array(
                            'id'        => 'tp_event_archive_page_items',
                            'type'      => 'slider',
                            'title'     => __( 'Number of Events Per Page', 'edublink' ),
                            'default'   => 6,
                            'min'       => -1,
                            'step'      => 1,
                            'max'       => 250
                        ),
                        array(
                            'id'       => 'tp_event_button_text',
                            'type'     => 'text',
                            'title'    => __( 'Button Text', 'edublink' ),
                            'default'  => __( 'Learn More', 'edublink' )
                        )
                    )
                );

                $this->sections[] = array(
                    'subsection' => true,
                    'title'      => __( 'Event Single', 'edublink' ),
                    'fields'     => array(
                        array(
                            'id'       => 'tp_single_event_google_map',
                            'type'     => 'switch',
                            'on'       => __( 'Enable', 'edublink' ),
                            'off'      => __( 'Disable', 'edublink' ),
                            'title'    => __( 'Google Map', 'edublink' ),
                            'default'  => false
                        ),
                        array(
                            'id'       => 'tp_single_event_google_map_api_key',
                            'type'     => 'text',
                            'title'    => __( 'Google Map API Key', 'edublink' )
                        ),
                        array(
                            'id'      => 'tp_single_event_comment_form',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Comment Form', 'edublink' ),
                            'default' => false
                        ),
                        array(
                            'id'      => 'tp_single_event_speaker',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Speaker', 'edublink' ),
                            'default' => true
                        ),
                        array(
                            'id'       => 'tp_single_event_speaker_heading',
                            'type'     => 'text',
                            'title'    => __( 'Heading', 'edublink' ),
                            'default'  => __( 'Event Speakers', 'edublink' ),
                            'required' => array( 'tp_single_event_speaker', 'equals', true )
                        ),
                        array(
                            'id'       => 'tp_single_event_sidebar_section',
                            'type'     => 'section',
                            'title'    => __( 'Sidebar', 'edublink' ),
                            'indent'   => true,
                        ),
                        array(
                            'id'       => 'tp_single_event_sidebar',
                            'type'     => 'switch',
                            'on'       => __( 'Enable', 'edublink' ),
                            'off'      => __( 'Disable', 'edublink' ),
                            'title'    => __( 'Sidebar', 'edublink' ),
                            'default'  => true
                        ),
                        array(
                            'id'      => 'tp_single_event_sidebar_meta_cost',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Cost', 'edublink' ),
                            'default' => true,
                            'required' => array( 'tp_single_event_sidebar', 'equals', true )
                        ),
                        array(
                            'id'      => 'tp_single_event_sidebar_meta_total_slot',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Total Slot', 'edublink' ),
                            'default' => true,
                            'required' => array( 'tp_single_event_sidebar', 'equals', true )
                        ),
                        array(
                            'id'      => 'tp_single_event_sidebar_meta_booked_slot',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Booked Slot', 'edublink' ),
                            'default' => true,
                            'required' => array( 'tp_single_event_sidebar', 'equals', true )
                        ),
                        array(
                            'id'      => 'tp_single_event_sidebar_meta_countdown',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'CountDown', 'edublink' ),
                            'default' => true,
                            'required' => array( 'tp_single_event_sidebar', 'equals', true )
                        ),
                        array(
                            'id'      => 'tp_single_event_sidebar_button',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Button', 'edublink' ),
                            'default' => true,
                            'required' => array( 'tp_single_event_sidebar', 'equals', true )
                        ),
                        array(
                            'id'       => 'tp_single_event_sidebar_button_type',
                            'type'     => 'button_set',
                            'title'    => __( 'Button Type', 'edublink' ),
                            'default'  => 'default',
                            'options'  => array(
                                'default' => __( 'Default Button', 'edublink' ),
                                'custom'  => __( 'Custom Button', 'edublink' ),
                            ),
                            'required' => array( 
                                array( 'tp_single_event_sidebar', 'equals', true ),
                                array( 'tp_single_event_sidebar_button', 'equals', true )    
                            )
                        ),
                        array(
                            'id'       => 'tp_single_event_sidebar_heading',
                            'type'     => 'text',
                            'title'    => __( 'Heading', 'edublink' ),
                            'default'  => __( 'Event Info', 'edublink' ),
                            'required' => array( 'tp_single_event_sidebar', 'equals', true )
                        ),
                        array(
                            'id'       => 'tp_single_event_sidebar_cost_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Cost', 'edublink' ),
                            'default'  => __( 'Cost:', 'edublink' ),
                            'required' => array( 
                                array( 'tp_single_event_sidebar', 'equals', true ),
                                array( 'tp_single_event_sidebar_meta_cost', 'equals', true )    
                            )
                        ),
                        array(
                            'id'       => 'tp_single_event_sidebar_total_slot_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Total Slot', 'edublink' ),
                            'default'  => __( 'Total Slot:', 'edublink' ),
                            'required' => array( 
                                array( 'tp_single_event_sidebar', 'equals', true ),
                                array( 'tp_single_event_sidebar_meta_total_slot', 'equals', true )    
                            )
                        ),
                        array(
                            'id'       => 'tp_single_event_sidebar_booked_slot_label',
                            'type'     => 'text',
                            'title'    => __( 'Label for Booked Slot', 'edublink' ),
                            'default'  => __( 'Booked Slot:', 'edublink' ),
                            'required' => array( 
                                array( 'tp_single_event_sidebar', 'equals', true ),
                                array( 'tp_single_event_sidebar_meta_booked_slot', 'equals', true )    
                            )
                        ),
                        array(
                            'id'       => 'tp_single_event_sidebar_register_button_text',
                            'type'     => 'text',
                            'title'    => __( 'Button Text', 'edublink' ),
                            'default'  => __( 'Book Now', 'edublink' ),
                            'required' => array( 
                                array( 'tp_single_event_sidebar', 'equals', true ),
                                array( 'tp_single_event_sidebar_button', 'equals', true )    
                            )
                        )
                    )
                );
            endif;

            if ( edublink_is_woocommerce_activated() ) :
                // WooCommerce  settings
                $this->sections[] = array(
                    'icon'   => 'el el-pencil',
                    'title'  => __( 'Shop Settings', 'edublink' ),
                    'fields' => array(
                        array(
                            'id'      => 'show_shop_breadcrumb',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Breadcrumbs', 'edublink' ),
                            'default' => true,
                            'desc'     => sprintf( 'If you set <strong>"Global Breadcrumb Background"</strong> to <strong>"Disbale"</strong> then you can\'t enable it here.', 'edublink' )
                        ),
                        array(
                            'id'      => 'default_breadcrumb_at_shop',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Default Breadcrumb Settings', 'edublink' ),
                            'default' => true,
                            'required' => array( 'show_shop_breadcrumb', 'equals', true )
                        ),
                        array(
                            'id'       => 'shop_breadcrumb_image',
                            'type'     => 'media',
                            'title'    => __( 'Breadcrumbs Background', 'edublink' ),
                            'subtitle' => __( 'Upload a .jpg or .png image that will be your breadcrumbs. <strong>The background image will only visible for "Style 1" which is located at Header Settings > Global Breadcrumb Style > Style 1.</strong>', 'edublink' ),
                            'default'  => array(
                                'url' => get_template_directory_uri() . '/assets/images/edublink-breadcrumb-bg.webp'
                            ),
                            'required'    => array( 
                                array( 'show_shop_breadcrumb', 'equals', true ),
                                array( 'default_breadcrumb_at_shop', '!=', true )    
                            )
                        ),
                        array (
                            'id'          => 'shop_breadcrumb_color',
                            'title'       => __( 'Breadcrumbs Background Color', 'edublink' ),
                            'subtitle'    => '<em>' . __( 'If you uploaded an image at <strong>Global Breadcrumb Background</strong> then this field option won\'t work.', 'edublink' ) . '</em>',
                            'type'        => 'color',
                            'required'    => array( 
                                array( 'show_shop_breadcrumb', 'equals', true ),
                                array( 'default_breadcrumb_at_shop', '!=', true )    
                            )
                        )
                    )
                );

                $this->sections[] = array(
                    'subsection' => true,
                    'title'      => __( 'Product Archive', 'edublink' ),
                    'fields'     => array(
                        array(
                            'id'        => 'woo_number_of_products',
                            'type'      => 'slider',
                            'title'     => __( 'Number of Products Per Page', 'edublink' ),
                            'default'   => 12,
                            'min'       => -1,
                            'step'      => 1,
                            'max'       => 100
                        ),
                        array(
                            'id'       => 'woo_product_columns',
                            'type'     => 'select',
                            'title'    => __( 'Product Columns', 'edublink' ),
                            'options'  => $columns,
                            'default'  => 4
                        ),
                        // array(
                        //     'id'       => 'woo_product_archive_breadcrumb_heading',
                        //     'type'     => 'text',
                        //     'title'    => __( 'Page Title at Breadcrumb', 'edublink' ),
                        //     'desc'     => __( 'This field will override the default page title at the Breadcrumb section of course archive page.', 'edublink' )
                        // )
                    )
                );

                $this->sections[] = array(
                    'subsection' => true,
                    'title'      => __( 'Shop Single', 'edublink' ),
                    'fields'     => array(
                        array(
                            'id'      => 'woo_related_products',
                            'type'    => 'switch',
                            'on'      => __( 'Enable', 'edublink' ),
                            'off'     => __( 'Disable', 'edublink' ),
                            'title'   => __( 'Related Products', 'edublink' ),
                            'default' => false
                        ),
                        array(
                            'id'       => 'woo_related_products_subtitle',
                            'type'     => 'text',
                            'title'    => __( 'Related Products Sub Title', 'edublink' ),
                            'default'  => __( 'SIMILAR ITEMS', 'edublink' ),
                            'required' => array( 'woo_related_products', 'equals', true )
                        ),
                        array(
                            'id'       => 'woo_related_products_title',
                            'type'     => 'text',
                            'title'    => __( 'Related Products Title', 'edublink' ),
                            'default'  => __( 'Related Products', 'edublink' ),
                            'required' => array( 'woo_related_products', 'equals', true )
                        )
                    )
                );

            endif;

            // 404 page
            $this->sections[] = array(
                'title'  => __( '404 Page', 'edublink' ),
                'fields' => array(
                    array(
                        'id'      => 'error_page_title',
                        'type'    => 'text',
                        'title'   => __( 'Title', 'edublink' ),
                        'default' => __( '404 - Page Not Found', 'edublink' )
                    ),
                    array(
                        'id'      => 'error_page_description',
                        'type'    => 'editor',
                        'title'   => __( 'Description', 'edublink' ),
                        'default' => __( 'The page you are looking for does not exist.', 'edublink' )
                    )
                )
            );

            // Social Media
            $this->sections[] = array(
                'icon'   => 'el el-file',
                'title'  => __( 'Social Media', 'edublink' ),
                'desc'   => __( 'This options will be applied at Event Details and Post Details page.', 'edublink' ),
                'fields' => array(
                    array(
                        'id'      => 'facebook_share',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'edublink' ),
                        'off'     => __( 'Disable', 'edublink' ),
                        'title'   => __( 'Facebook', 'edublink' ),
                        'default' => true
                    ),
                    array(
                        'id'      => 'twitter_share',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'edublink' ),
                        'off'     => __( 'Disable', 'edublink' ),
                        'title'   => __( 'Twitter', 'edublink' ),
                        'default' => true
                    ),
                    array(
                        'id'      => 'linkedin_share',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'edublink' ),
                        'off'     => __( 'Disable', 'edublink' ),
                        'title'   => __( 'Linkedin', 'edublink' ),
                        'default' => true
                    ),
                    array(
                        'id'      => 'whatsapp_share',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'edublink' ),
                        'off'     => __( 'Disable', 'edublink' ),
                        'title'   => __( 'WhatsApp', 'edublink' ),
                        'default' => false
                    ),
                    array(
                        'id'      => 'pinterest_share',
                        'type'    => 'switch',
                        'on'      => __( 'Enable', 'edublink' ),
                        'off'     => __( 'Disable', 'edublink' ),
                        'title'   => __( 'Pinterest', 'edublink' ),
                        'default' => false
                    )
                )
            );

            // Custom Code
            $this->sections[] = array(
                'title'           => __( 'Import / Export', 'edublink' ),
                'desc'            => __( 'Import and Export your Redux Framework settings from file, text or URL.', 'edublink' ),
                'icon'            => 'el-icon-refresh',
                'fields'          => array(
                    array(
                        'id'         => 'opt-import-export',
                        'type'       => 'import_export',
                        'title'      => 'Import Export',
                        'subtitle'   => 'Save and restore your Redux options',
                        'full_width' => false
                    ),
                ),
            );
        }

        /**
         * All the possible arguments for Redux.
         * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
         * */
        public function setArguments() {
        	$theme = wp_get_theme(); // For use with some settings. Not necessary.
        	$this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'                    => apply_filters( 'edublink_theme_option_name', 'edublink_theme_options' ),
                // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'                => $theme->get( 'Name' ),
                // Name that appears at the top of your panel
                'display_version'             => $theme->get( 'Version' ),
                // Version that appears at the top of your panel
                'menu_type'                   => 'submenu',
                //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'              => true,
                // Show the sections below the admin menu item or not
                'menu_title'                  => __( 'Theme Options', 'edublink' ),
                'page_title'                  => __( 'Theme Options', 'edublink' ),
                
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key'              => '',
                // Set it you want google fonts to update weekly. A google_api_key value is required.
                'google_update_weekly'        => false,
                // Must be defined to add google fonts to the typography module
                'async_typography'            => true,
                // Use a asynchronous font on the front end or font string
                //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                'admin_bar'                   => true,
                // Show the panel pages on the admin bar
                'admin_bar_icon'              => 'dashicons-portfolio',
                // Choose an icon for the admin bar menu
                'admin_bar_priority'          => 50,
                // Choose an priority for the admin bar menu
                'global_variable'             => 'edublink_options',
                // Set a different name for your global variable other than the opt_name
                'dev_mode'                    => false,
                // Show the time the page took to load, etc
                'update_notice'               => false,
                // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                'customizer'                  => true,
                // Enable basic customizer support
                //'open_expanded'             => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn'         => true,                    // Disable the save warning when a user changes a field
                
                // OPTIONAL -> Give you extra features
                'page_priority'               => null,
                // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'                 => 'themes.php',
                // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'            => 'manage_options',
                // Permissions needed to access the options panel.
                'menu_icon'                   => '',
                // Specify a custom URL to an icon
                'last_tab'                    => '',
                // Force your panel to always open to a specific tab (by id)
                'page_icon'                   => 'icon-themes',
                // Icon displayed in the admin panel next to your menu_title
                'page_slug'                   => 'edublink_options',
                // Page slug used to denote the panel
                'save_defaults'               => true,
                // On load save the defaults to DB before user clicks save or not
                'default_show'                => false,
                // If true, shows the default value next to each field that is not the default value.
                'default_mark'                => '',
                // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export'          => true,
                // Shows the Import/Export panel when not used as a field.
                
                // CAREFUL -> These options are for advanced use only
                'transient_time'              => 60 * MINUTE_IN_SECONDS,
                'output'                      => true,
                // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'                  => true,
                // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'            => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
                
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'                    => '',
                // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'                 => false,
                // REMOVE
                'use_cdn'                     => true
            );
            return $this->args;
        }
    }
    global $reduxConfig;
    $reduxConfig = new EduBlink_Redux_Framework_Config();
endif;