<?php
defined( 'ABSPATH' ) || exit;

// return if it's not an admin page.
if ( ! is_admin() ) :
	return;
endif;

/**
 * Enqueue Admin scripts and styles.
 */
function edublink_admin_scripts() {
	wp_enqueue_style( 'edublink-admin', get_template_directory_uri() . '/assets/css/admin-main.css', array(), EDUBLINK_THEME_VERSION );

	wp_add_inline_style( 'edublink-admin', html_entity_decode( edublink_root_css_variables(), ENT_QUOTES ) );
}

add_action( 'admin_enqueue_scripts', 'edublink_admin_scripts' );

function edublink_admin_classes( $classes ) {
    $classes .= ' edublink-admin-wrapper ';
    return $classes;
}

add_filter( 'admin_body_class', 'edublink_admin_classes' );