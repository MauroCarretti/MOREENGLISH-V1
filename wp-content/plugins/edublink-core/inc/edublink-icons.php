<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// ENQUEUE // Enqueueing Frontend stylesheet and scripts.
add_action( 'elementor/editor/after_enqueue_scripts', 'edublink_elementor_icons_css' );
// FRONTEND // After Elementor registers all styles.
add_action( 'elementor/frontend/after_register_styles', 'edublink_elementor_icons_css' );
// EDITOR // Before the editor scripts enqueuing.
add_action( 'elementor/editor/before_enqueue_scripts', 'edublink_elementor_icons_css' );
	
/**
 * Enqueueing icons
 */
if ( ! function_exists( 'edublink_elementor_icons_css' ) ) :
	function edublink_elementor_icons_css() {
		$box_icon_enable = false;
		wp_enqueue_style( 'edublink-custom-icons' );
   		wp_enqueue_style( 'remixicon' );
		if ( $box_icon_enable ) :
			wp_enqueue_style( 'boxicons' );
		endif;
	}
endif;


add_filter( 'elementor/icons_manager/additional_tabs', 'edublink_elementor_custom_icons_tab' );
if ( ! function_exists( 'edublink_elementor_custom_icons_tab' ) ) :
	function edublink_elementor_custom_icons_tab( $tabs = array() ) {

		/*
		 * EduBlink Custom Icons
		 */
		$edublink_custom_icons   = [];
		$custom_icons_pack = include EDUBLINK_PLUGIN_DIR . '/icons/edublink-custom-icons/edublink-custom-icons.php';

		foreach ( $custom_icons_pack as $education_icon ) :
		    $edublink_custom_icons[] = $education_icon;
		endforeach;

		$tabs['edublink-custom-icons'] = array(
			'name'          => 'edublink-custom-icons',
			'label'         => __( 'EduBlink Icons', 'edublink-core' ),
			'labelIcon'     => 'edublink icon-34',
			'prefix'        => 'icon-',
			'displayPrefix' => 'edublink',
			'url'           => get_template_directory_uri() . '/assets/css/edublink-custom-icons.css',
			'icons'         => $edublink_custom_icons,
			'ver'           => '1.0.0'
		);

		/*
		 * Remix Icons
		 */
		$rm_icons   = [];
		$remix_icons = include EDUBLINK_PLUGIN_DIR . '/icons/remix-icons/remix-icons.php';

		foreach ( $remix_icons as $remix_icon ) :
		    $rm_icons[] = $remix_icon;
		endforeach;

		$tabs['remix-icons'] = array(
			'name'          => 'remix-icons',
			'label'         => __( 'Remix Icons', 'edublink-core' ),
			'labelIcon'     => 'ri-remixicon-line',
			'prefix'        => 'ri-',
			'displayPrefix' => 'ri',
			'url'           => get_template_directory_uri() . '/assets/css/remixicon.css',
			'icons'         => $rm_icons,
			'ver'           => '1.0.0'
		);

		/*
		 * Box Icons
		 */
		$box_icon_enable = false;
		if ( $box_icon_enable ) :
			$bx_icons  = [];
			$box_icons = include EDUBLINK_PLUGIN_DIR . '/icons/box-icons/box-icons.php';
			
			foreach ( $box_icons as $box_icon ) :
				$bx_icons[] = $box_icon;
			endforeach;

			$tabs['box-icons'] = array(
				'name'          => 'box-icons',
				'label'         => __( 'Box Icons', 'elementor-icons' ),
				'labelIcon'     => 'bx bxl-bootstrap',
				'prefix'        => '',
				'displayPrefix' => 'bx',
				'url'           => get_template_directory_uri() . '/assets/css/boxicons.min.css',
				'icons'         => $bx_icons,
				'ver'           => '1.0.0'
			);
		endif;

		/*
		 * Tutor Icons
		 */
		if ( edublink_is_tutor_lms_activated() ) :
			$tl_icons  = [];
			$tutor_lms_icons = include EDUBLINK_PLUGIN_DIR . '/icons/tutor-lms-icons/tutor-lms-icons.php';

			foreach ( $tutor_lms_icons as $tutor_icon ) :
			    $tl_icons[] = $tutor_icon;
			endforeach;

			$tabs['tutor-icon'] = array(
				'name'          => 'tutor-icon',
				'label'         => __( 'Tutor LMS Icons', 'edublink-core' ),
				'labelIcon'     => 'tutor-icon-file-artboard',
				'prefix'        => 'tutor-icon-',
				'displayPrefix' => 'tutor',
				'url'           => tutor()->url.'assets/css/tutor-icon.min.css',
				'icons'         => $tl_icons,
				'ver'           => '1.0.0'
			);
		endif;

		return $tabs;
	}
endif;