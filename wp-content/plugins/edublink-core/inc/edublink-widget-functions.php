<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Admin Menu Page
 * 
 * @since 1.0.0
 */
add_action( 'admin_menu', 'edublink_add_admin_menu' );

if ( ! function_exists( 'edublink_add_admin_menu' ) ) :
    function edublink_add_admin_menu() {
        
        add_menu_page( 'EduBlink',  __( 'EduBlink', 'edublink-core' ), 'manage_options', 'edublink_settings', 'edublink_admin_welcome_text', plugins_url( 'edublink-core/assets/images/dashboard-icon.png' ), 5 );

        add_submenu_page( 'edublink_settings', __( 'Welcome', 'edublink-core' ), __( 'Welcome', 'edublink-core' ), 'manage_options', 'edublink_settings' );

        add_submenu_page( 'edublink_settings', __( 'Headers', 'edublink-core' ), __( 'Headers', 'edublink-core' ), 'manage_options', 'edit.php?post_type=edublink_header' );
        
        add_submenu_page( 'edublink_settings', __( 'Footers', 'edublink-core' ), __( 'Footers', 'edublink-core' ), 'manage_options', 'edit.php?post_type=edublink_footer' );

        add_submenu_page( 'edublink_settings', __( 'Mega Menu', 'edublink-core' ), __( 'Mega Menus', 'edublink-core' ), 'manage_options', 'edit.php?post_type=edublink_megamenu' );

        if ( class_exists( 'OCDI_Plugin' ) ) :
            add_submenu_page( 'edublink_settings', __( 'Import Demo Data', 'edublink-core' ), __( 'Import Demo Data', 'edublink-core' ), 'manage_options', 'themes.php?page=one-click-demo-import' );
        endif;
        
        if ( class_exists( 'Redux_Framework_Plugin' ) ) :
            add_submenu_page( 'edublink_settings', __( 'Theme Options', 'edublink-core' ), __( 'Theme Options', 'edublink-core' ), 'manage_options', 'admin.php?page=edublink_options' );
        endif;
    }
endif;

if ( ! function_exists( 'edublink_admin_welcome_text' ) ) :
    function edublink_admin_welcome_text(){
        echo '<h2>'. __( 'Welcome to EduBlink', 'edublink-core' ) . '</h2>';
        echo '<p>' . __( 'EduBlink is a complete WordPress LMS( Learning Management System ) theme developed by DevsBlink. DevsBlink is a very young team of developers and designers. Our goal is ensuring product quality and customer satisfaction, so we\'ve gathered people who are driven by the passion to create an excellent product and be a helpful hand to their customers. Please let us know if you\'ve any query. Our support Engineer will reply to you within 10 minutes to 8 hours( maximum ). If you need any development related task then please feel free to let us know. We\'re ready to get hired and would love to help you out. If you are interested in Premium WordPress Theme, React and HTML Template then one of our products may please you. We love what we do and your review would be a great inspiration for our product development and enriching feature for you. Thanks...', 'edublink-core' ) . '</p>';
    }
endif;


/**
 * Author additional fields
 */
if ( ! function_exists( 'edublink_additional_user_fields' ) ) :
    function edublink_additional_user_fields( $contactmethods ) {
        $contactmethods['edublink_job']   = __( 'Instructor Job', 'edublink-core' );
        $contactmethods['edublink_facebook']  = __( 'Facebook', 'edublink-core' );
        $contactmethods['edublink_twitter']   = __( 'Twitter', 'edublink-core' );
        $contactmethods['edublink_youtube']  = __( 'YoutTube', 'edublink-core' );
        $contactmethods['edublink_linkedin']   = __( 'LinkedIn', 'edublink-core' );
    
        return $contactmethods;
    }
endif;
add_filter( 'user_contactmethods', 'edublink_additional_user_fields', 10, 1 );
