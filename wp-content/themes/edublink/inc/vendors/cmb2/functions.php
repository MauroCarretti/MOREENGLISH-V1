<?php

/**
 * MetaBoxes for EduBlink Theme
 *
 * @since 1.0.0
 */
namespace EduBlink;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * Metaboxes Class
 *
 * @since 1.0.0
 */ 
class Metaboxes {

	public static function init() {
		add_filter( 'cmb2_admin_init', array( __CLASS__, 'page_metabox' ) );
		add_filter( 'cmb2_admin_init', array( __CLASS__, 'course_features' ) );
		if ( edublink_is_wp_events_manager_activated() ) :
			add_filter( 'cmb2_admin_init', array( __CLASS__, 'tp_event_speaker_meta' ) );
			add_filter( 'cmb2_admin_init', array( __CLASS__, 'tp_event_metabox' ) );
		endif;
		if ( edublink_is_learnpress_activated() ) :
			add_filter( 'cmb2_admin_init', array( __CLASS__, 'lp_course_side_meta' ) );
		endif;
		if ( edublink_is_tutor_lms_activated() ) :
			add_filter( 'cmb2_admin_init', array( __CLASS__, 'tl_course_side_meta' ) );
		endif;
		if ( edublink_is_learndash_activated() ) :
			add_filter( 'cmb2_admin_init', array( __CLASS__, 'ld_course_side_meta' ) );
		endif;
		if ( edublink_is_sensei_lms_activated() ) :
			add_filter( 'cmb2_admin_init', array( __CLASS__, 'ss_course_side_meta' ) );
		endif;
		if ( edublink_is_lifter_lms_activated() ) :
			add_filter( 'cmb2_admin_init', array( __CLASS__, 'll_course_side_meta' ) );
		endif;
		// if ( edublink_is_masterstudy_lms_activated() ) :
			add_filter( 'cmb2_admin_init', array( __CLASS__, 'ms_course_side_meta' ) );
		// endif;
		add_filter( 'cmb2_admin_init', array( __CLASS__, 'zoom_sidebar_metabox' ) );
	}

	public static function page_metabox() {
		global $wp_registered_sidebars;
        $sidebars = array();
        if ( ! empty( $wp_registered_sidebars ) ) :
            foreach ( $wp_registered_sidebars as $sidebar ) :
                $sidebars[$sidebar['id']] = $sidebar['name'];
            endforeach;
        endif;

		$headers = array_merge( array( 'global' => __( 'Global Settings', 'edublink' ) ), edublink_fetch_header_layouts(), array( 'none' => __( 'None', 'edublink' ) ) );
		$footers = array_merge( array( 'global' => __( 'Global Settings', 'edublink' ) ), edublink_get_footer_layouts(), array( 'none' => __( 'None', 'edublink' ) ) );
		$prefix = 'edublink_page_';

		$page_meta = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Display Settings', 'edublink' ),
			'object_types' => array( 'page' ), // Post type
			'context'      => 'normal', //  'normal', 'advanced', or 'side'
			'priority'     => 'high',  //  'high', 'core', 'default' or 'low'
			'show_names'   => true // Show field names on the left
		) );

		$page_meta->add_field( array(
			'id'      => $prefix . 'header_top_bar_status',
			'name'    => 'Header Top Bar Status',
			'type'    => 'radio_inline',
			'default' => 'default',
			'options' => array(
				'default' => __( 'Global Settings', 'edublink' ),
				'enable'  => __( 'Enable', 'edublink' ),
				'disable' => __( 'Disable', 'edublink' ),
			),
			'description' => __( 'Global Settings means it will get the value which is selected from Theme Options > Header Settings > Header Top Bar Status.', 'edublink' )
		) );

		$page_meta->add_field( array(
			'id'          => $prefix . 'header_top_bar_type',
			'type'        => 'select',
			'name'        => __( 'Header Top Bar Type', 'edublink' ),
			'default'     => 'global',
			'options'     => array(
				'global'  => __( 'Global Settings', 'edublink' ),
				'1'       => 'Top Bar 1',
				'2'       => 'Top Bar 2'
			),
			'description' => __( 'Global Settings means it will get the value which is selected from Theme Options > Header Settings > Header Top Bar Type.', 'edublink' )
		) );

		$page_meta->add_field( array(
			'id'          => $prefix . 'header_type',
			'type'        => 'select',
			'name'        => __( 'Header Layout Type', 'edublink' ),
			'description' => __( 'Choose a header for your website.', 'edublink' ),
			'options'     => $headers,
			'default'     => 'global',
			'description' => __( 'Global Settings means it will get the value which is selected from Theme Options > Header Settings > Header Layout Type.', 'edublink' )
		) );

		$page_meta->add_field( array(
			'id'      => $prefix . 'header_sticky',
			'name'    => 'Header Sticky Status',
			'type'    => 'radio_inline',
			'default' => 'default',
			'options' => array(
				'default' => __( 'Global Settings', 'edublink' ),
				'enable'  => __( 'Enable', 'edublink' )
			),
			'description' => __( 'Global Settings means it will get the value which is selected from Theme Options > Header Settings > Sticky Header.', 'edublink' )
		) );

		$page_meta->add_field( array(
			'id'      => $prefix . 'header_transparent',
			'name'    => 'Header Transparent',
			'type'    => 'radio_inline',
			'default' => 'disable',
			'options' => array(
				'enable'  => __( 'Enable', 'edublink' ),
				'disable' => __( 'Disable', 'edublink' )
			)
		) );

		$page_meta->add_field( array(
			'id'      => $prefix . 'header_white_logo_status',
			'name'    => 'Header White Logo',
			'type'    => 'radio_inline',
			'default' => 'disable',
			'options' => array(
				'enable'  => __( 'Enable', 'edublink' ),
				'disable' => __( 'Disable', 'edublink' )
			),
			'description' => __( 'This option will only work if you Enable the value of <strong>Header Transparent</strong>', 'edublink' )
		) );

		$page_meta->add_field( array(
			'id'      => $prefix . 'header_color_white',
			'name'    => 'Header Color White',
			'type'    => 'radio_inline',
			'default' => 'disable',
			'options' => array(
				'enable'  => __( 'Enable', 'edublink' ),
				'disable' => __( 'Disable', 'edublink' )
			),
			'description' => __( 'This option will only work if you Enable the value of <strong>Header Transparent</strong>', 'edublink' )
		) );

		$page_meta->add_field( array(
			'id'          => $prefix . 'footer_type',
			'type'        => 'select',
			'name'        => __( 'Footer Layout Type', 'edublink' ),
			'description' => __( 'Choose a footer for your website.', 'edublink' ),
			'options'     => $footers,
			'default'     => 'global',
			'description' => __( 'Global Settings means it will get the value which is selected from Theme Options > Footer Settings > Footer Layout Type.', 'edublink' )
		) );

		$page_meta->add_field( array(
			'id'          => $prefix . 'layout_type',
			'type'        => 'select',
			'name'        => __( 'Page Layout Type', 'edublink' ),
			'default'     => 'boxed',
			'options'     => array(
				'boxed'      => __( 'Boxed', 'edublink' ),
				'full-width' => __( 'Full Width', 'edublink' )
			)
		) );

		$page_meta->add_field( array(
			'id'          => $prefix . 'content_type',
			'type'        => 'select',
			'name'        => __( 'Content Type', 'edublink' ),
			'default'     => 'full-width',
			'options'     => array(
				'no-sidebar'    => __( 'Only Content( No Sidebar )', 'edublink' ),
				'left-sidebar'  => __( 'Left Sidebar', 'edublink' ),
				'right-sidebar' => __( 'Right Sidebar', 'edublink' )
			),
			'description' => __( 'If you select <b>Full Width</b> Layout Type then this option won\'t work.', 'edublink' )
		) );

		$page_meta->add_field( array(
			'id'          => $prefix . 'sidebar_name',
			'type'        => 'select',
			'name'        => __( 'Sidebar', 'edublink' ),
			'options'     => $sidebars,
			'description' => __( 'If you select <b>Full Width</b> from Layout Type or <b>Only Content( No Sidebar )</b> from Content Type then this selected sidebar won\'t display.', 'edublink' )
		) );

		$page_meta->add_field( array(
			'id'          => $prefix . 'title_at_breadcrumb',
			'type'        => 'text',
			'name'        => __( 'Page Title at Breadcrumb', 'edublink' ),
			'description' => __( 'This field will override the default page title at the Breadcrumb section heading.', 'edublink' )
        ) );

		$page_meta->add_field( array(
			'id'          => $prefix . 'sub_title_at_breadcrumb',
			'type'        => 'text',
			'name'        => __( 'Page Sub-title at Breadcrumb', 'edublink' ),
			'description' => __( 'This field will override the default page title at the Breadcrumb section.', 'edublink' )
        ) );

		$page_meta->add_field( array(
			'id'          => $prefix . 'breadcrumb',
			'type'        => 'select',
			'name'        => __( 'Breadcrumb', 'edublink' ),
			'default'     => 'default',
			'options'     => array(
				'default' => __( 'Default', 'edublink' ),
				'enable'  => __( 'Enable', 'edublink' ),
				'disable' => __( 'Disable', 'edublink' )
			),
			'description' => __( 'This option won\'t work at the Front Page.', 'edublink' )
		) );

		$page_meta->add_field( array(
			'id'          => $prefix . 'breadcrumb_style',
			'type'        => 'select',
			'name'        => __( 'Breadcrumb Style', 'edublink' ),
			'default'     => 'global',
			'options'     => array(
				'global'  => __( 'Global Settings', 'edublink' ),
				'default' => __( 'Default', 'edublink' ),
				'1'       => 'Style 1',
				'2'       => 'Style 2'
			),
			'description' => __( 'Global Settings means it will get the value which is selected from Theme Options > Header Settings > Global Breadcrumb Style. This option won\'t work at the Front Page.', 'edublink' )
		) );

		$page_meta->add_field( array(
			'id'   => $prefix . 'breadcrumb_color',
			'type' => 'colorpicker',
			'name' => __( 'Breadcrumb Background Color', 'edublink' )
		) );

		$page_meta->add_field( array(
			'id'   => $prefix . 'breadcrumb_image',
			'type' => 'file',
			'name' => __( 'Breadcrumb Background Image', 'edublink' )
        ) );

		$page_meta->add_field( array(
			'id'          => $prefix . 'extra_class',
			'type'        => 'text',
			'name'        => __( 'Extra Class', 'edublink' ),
			'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'edublink' )
        ) );
	}

	public static function woo_product_metabox( array $metaboxes ) {
		$prefix = 'edublink_woo_product_';
		
		$metaboxes[ $prefix . 'info' ] = array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Author Details', 'edublink' ),
			'object_types' => array( 'product' ),
			'context'      => 'side',
			'priority'     => 'low',
			'show_names'   => true,
			'fields'       => self::woo_product_metaboxes()
		);
		
		return $metaboxes;
	}

	public static function course_features() {
		$prefix = 'edublink_course_';

		$lp_course = new_cmb2_box( array(
			'id'           => $prefix . 'features',
			'title'        => __( 'Course Features', 'edublink' ),
			'object_types' => array( 'lp_course', 'courses', 'sfwd-courses', 'stm-courses', 'course' ),
			'context'      => 'normal',
			'priority'     => 'high', 
			'show_names'   => true
		) );

		$group_field_id = $lp_course->add_field( array(
			'id'           => $prefix . 'top_features',
			'type'         => 'group',
			'name'         => __( 'Features', 'edublink' ),
			'description'  => __( 'This features will be shown only on Course Style 14.', 'edublink' ),
			'options'      => array(
				'group_title'      => __( 'Feature {#}', 'edublink' ),
				'add_button'       => __( 'Add Another Feature', 'edublink' ),
				'remove_button'    => __( 'Remove Feature', 'edublink' ),
				'sortable'         => true
			),
			'fields'       => array(
	            array(
	                'name' => __( 'Feature', 'edublink' ),
	                'id'   => 'name',
	                'type' => 'text'
	            )
	        )
		) );
	}

	public static function lp_course_side_meta() {
		$prefix = 'edublink_lp_course_';

		$course_meta = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Course Meta', 'edublink' ),
			'object_types' => array( 'lp_course' ),
			'context'      => 'normal',
			'priority'     => 'high', 
			'show_names'   => true
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Preview Image', 'edublink' ),
			'id'      => $prefix . 'preview_image',
			'type'    => 'file',
			'options' => array(
				'url' => false
			),
			'text'    => array(
				'add_upload_file_text' => __( 'Add Image', 'edublink' )
			),
			'description'  => __( 'This image will be shown at the course preview video background.', 'edublink' )
		) );

		$course_meta->add_field( array(
			'name'        => __( 'Preview Video Link', 'edublink' ),
			'id'          => $prefix . 'preview_video_link',
			'type'        => 'text',
			'desc' => __( 'https://www.youtube.com/watch?v=m2m5Xx5T4No', 'edublink' )
		) );
		
		$course_meta->add_field( array(
			'name'    => __( 'Language', 'edublink' ),
			'id'      => $prefix . 'language',
			'type' => 'text',
			'default' => __( 'English', 'edublink' )
		) );
		
		$course_meta->add_field( array(
			'name' => __( 'Certificate', 'edublink' ),
			'id'   => $prefix . 'certificate',
			'desc' => __( 'Set course certificate', 'edublink' ),
			'std'  => 'yes',
			'type'    => 'checkbox'
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Class Type', 'edublink' ),
			'id'      => $prefix . 'class_type',
			'type'    => 'text',
			'default' => __( 'Online Only', 'edublink' )
		) );

		$course_meta->add_field( array(
			'id'           => $prefix . 'extra_meta_fields',
			'type'         => 'group',
			'name'         => __( 'Course Sidebar Extra Meta Informations', 'edublink' ),
			'options'      => array(
				'group_title'      => __( 'Meta Information{#}', 'edublink' ),
				'add_button'       => __( 'Add Another Meta Information', 'edublink' ),
				'remove_button'    => __( 'Remove Meta', 'edublink' ),
				'sortable'         => true
			),
			'fields'       => array(
	            array(
	                'name' => __( 'Meta Label', 'edublink' ),
	                'id'   => 'label',
	                'type' => 'text'
				),
				array(
	                'name' => __( 'Meta Value', 'edublink' ),
	                'id'   => 'value',
	                'type' => 'text'
	            ),
				array(
	                'name' => __( 'Meta Icon Class', 'edublink' ),
	                'id'   => 'icon_class',
	                'type' => 'text',
					'description' => __( 'You need to put the icon class name here. Example: <b>ri-user-line</b>. You can find all the default icons by clicking <a href="https://remixicon.com/" target="_blank">here</a>.', 'edublink' )
	            ),
				array(
	                'name' => __( 'Meta Wrapper Class', 'edublink' ),
	                'id'   => 'wrapper_class',
	                'type' => 'text'
	            )
	        )
		) );
	}

	public static function tl_course_side_meta() {
		$prefix = 'edublink_tl_course_';

		$course_meta = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Course Meta', 'edublink' ),
			'object_types' => array( 'courses' ),
			'context'      => 'normal',
			'priority'     => 'high', 
			'show_names'   => true
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Deadline', 'edublink' ),
			'id'      => $prefix . 'deadline',
			'type'    => 'text'
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Class Type', 'edublink' ),
			'id'      => $prefix . 'class_type',
			'type'    => 'text'
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Language', 'edublink' ),
			'id'      => $prefix . 'language',
			'type'    => 'text'
		) );

		$course_meta->add_field( array(
			'name' => __( 'Certificate', 'edublink' ),
			'id'   => $prefix . 'certificate',
			'desc' => __( 'Set course certificate', 'edublink' ),
			'std'  => 'yes',
			'type'    => 'checkbox'
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Class Type', 'edublink' ),
			'id'      => $prefix . 'class_type',
			'type'    => 'text',
			'default' => __( 'Online Only', 'edublink' )
		) );

		$course_meta->add_field( array(
			'id'           => $prefix . 'extra_meta_fields',
			'type'         => 'group',
			'name'         => __( 'Course Sidebar Extra Meta Informations', 'edublink' ),
			'options'      => array(
				'group_title'      => __( 'Meta Information{#}', 'edublink' ),
				'add_button'       => __( 'Add Another Meta Information', 'edublink' ),
				'remove_button'    => __( 'Remove Meta', 'edublink' ),
				'sortable'         => true
			),
			'fields'       => array(
	            array(
	                'name' => __( 'Meta Label', 'edublink' ),
	                'id'   => 'label',
	                'type' => 'text'
				),
				array(
	                'name' => __( 'Meta Value', 'edublink' ),
	                'id'   => 'value',
	                'type' => 'text'
	            ),
				array(
	                'name' => __( 'Meta Icon Class', 'edublink' ),
	                'id'   => 'icon_class',
	                'type' => 'text',
					'description' => __( 'You need to put the icon class name here. Example: <b>ri-user-line</b>. You can find all the default icons by clicking <a href="https://remixicon.com/" target="_blank">here</a>.', 'edublink' )
	            ),
				array(
	                'name' => __( 'Meta Wrapper Class', 'edublink' ),
	                'id'   => 'wrapper_class',
	                'type' => 'text'
	            )
	        )
		) );
	}

	public static function ld_course_side_meta() {
		$prefix = 'edublink_ld_course_';

		$course_meta = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Course Meta', 'edublink' ),
			'object_types' => array( 'sfwd-courses' ),
			'context'      => 'normal',
			'priority'     => 'high', 
			'show_names'   => true
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Preview Image', 'edublink' ),
			'id'      => $prefix . 'preview_image',
			'type'    => 'file',
			'options' => array(
				'url' => false
			),
			'text'    => array(
				'add_upload_file_text' => __( 'Add Image', 'edublink' )
			),
			'description'  => __( 'This image will be shown at the course preview video background.', 'edublink' )
		) );

		$course_meta->add_field( array(
			'name'        => __( 'Preview Video Link', 'edublink' ),
			'id'          => $prefix . 'preview_video_link',
			'type'        => 'text',
			'desc' => __( 'https://www.youtube.com/watch?v=m2m5Xx5T4No', 'edublink' )
		) );

		$course_meta->add_field( array(
			'name' => __( 'Estimated Duration', 'edublink' ),
			'id'   => $prefix . 'duration',
			'type' => 'text'
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Course Level', 'edublink' ),
			'id'      => $prefix . 'level',
			'type'    => 'text'
		) );
		
		$course_meta->add_field( array(
			'name'    => __( 'Language', 'edublink' ),
			'id'      => $prefix . 'language',
			'type' => 'text',
			'default' => __( 'English', 'edublink' )
		) );
		
		$course_meta->add_field( array(
			'name' => __( 'Certificate', 'edublink' ),
			'id'   => $prefix . 'certificate',
			'desc' => __( 'Set course certificate', 'edublink' ),
			'std'  => 'yes',
			'type'    => 'checkbox'
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Number of Enrolled Students', 'edublink' ),
			'id'      => $prefix . 'students',
			'type'    => 'text'
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Class Type', 'edublink' ),
			'id'      => $prefix . 'class_type',
			'type'    => 'text',
			'default' => __( 'Online Only', 'edublink' )
		) );

		$course_meta->add_field( array(
			'name'    => __( 'External Button URL', 'edublink' ),
			'id'      => $prefix . 'button_url',
			'type' => 'text',
			'default' => __( '#', 'edublink' )
		) );

		$course_meta->add_field( array(
			'id'           => $prefix . 'extra_meta_fields',
			'type'         => 'group',
			'name'         => __( 'Course Sidebar Extra Meta Informations', 'edublink' ),
			'options'      => array(
				'group_title'      => __( 'Meta Information{#}', 'edublink' ),
				'add_button'       => __( 'Add Another Meta Information', 'edublink' ),
				'remove_button'    => __( 'Remove Meta', 'edublink' ),
				'sortable'         => true
			),
			'fields'       => array(
	            array(
	                'name' => __( 'Meta Label', 'edublink' ),
	                'id'   => 'label',
	                'type' => 'text'
				),
				array(
	                'name' => __( 'Meta Value', 'edublink' ),
	                'id'   => 'value',
	                'type' => 'text'
	            ),
				array(
	                'name' => __( 'Meta Icon Class', 'edublink' ),
	                'id'   => 'icon_class',
	                'type' => 'text',
					'description' => __( 'You need to put the icon class name here. Example: <b>ri-user-line</b>. You can find all the default icons by clicking <a href="https://remixicon.com/" target="_blank">here</a>.', 'edublink' )
	            ),
				array(
	                'name' => __( 'Meta Wrapper Class', 'edublink' ),
	                'id'   => 'wrapper_class',
	                'type' => 'text'
	            )
	        )
		) );
	}

	public static function ss_course_side_meta() {
		$prefix = 'edublink_ss_course_';

		$course_meta = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Course Meta', 'edublink' ),
			'object_types' => array( 'course' ),
			'context'      => 'normal',
			'priority'     => 'high', 
			'show_names'   => true
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Course Language', 'edublink' ),
			'id'      => $prefix . 'language',
			'type'    => 'text',
			'desc' => __( 'The instructor used this language while conducting the course.', 'edublink' ),
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Deadline', 'edublink' ),
			'id'      => $prefix . 'deadline',
			'type'    => 'text',
			'default' => __( '25 Dec, 2024', 'edublink' )
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Class Type', 'edublink' ),
			'id'      => $prefix . 'class_type',
			'type'    => 'text',
			'default' => __( 'Online Only', 'edublink' )
		) );

		$course_meta->add_field( array(
			'name' => __( 'Access', 'edublink' ),
			'id'   => $prefix . 'access',
			'type' => 'text',
			'std'  => __( 'Lifetime', 'edublink' )
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Number of Enrolled Students', 'edublink' ),
			'id'      => $prefix . 'students',
			'type'    => 'text'
		) );

		$course_meta->add_field( array(
			'name' => __( 'Estimated Duration', 'edublink' ),
			'id'   => $prefix . 'duration',
			'type' => 'text'
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Course Level', 'edublink' ),
			'id'      => $prefix . 'level',
			'type'    => 'text'
		) );

		$course_meta->add_field( array(
			'name' => __( 'Certificate', 'edublink' ),
			'id'   => $prefix . 'certificate',
			'desc' => __( 'Set course certificate', 'edublink' ),
			'std'  => 'yes',
			'type'    => 'checkbox'
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Class Type', 'edublink' ),
			'id'      => $prefix . 'class_type',
			'type'    => 'text',
			'default' => __( 'Online Only', 'edublink' )
		) );

	}

	public static function ll_course_side_meta() {
		$prefix = 'edublink_ll_course_';

		$course_meta = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Course Meta', 'edublink' ),
			'object_types' => array( 'course' ),
			'context'      => 'normal',
			'priority'     => 'high', 
			'show_names'   => true
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Preview Image', 'edublink' ),
			'id'      => $prefix . 'preview_image',
			'type'    => 'file',
			'options' => array(
				'url' => false
			),
			'text'    => array(
				'add_upload_file_text' => __( 'Add Image', 'edublink' )
			),
			'description'  => __( 'This image will be shown at the course preview video background.', 'edublink' )
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Course Language', 'edublink' ),
			'id'      => $prefix . 'language',
			'type'    => 'text',
			'desc' => __( 'The instructor used this language while conducting the course.', 'edublink' ),
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Deadline', 'edublink' ),
			'id'      => $prefix . 'deadline',
			'type'    => 'text',
			'default' => __( '25 Dec, 2024', 'edublink' )
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Class Type', 'edublink' ),
			'id'      => $prefix . 'class_type',
			'type'    => 'text',
			'default' => __( 'Online Only', 'edublink' )
		) );

		$course_meta->add_field( array(
			'name' => __( 'Access', 'edublink' ),
			'id'   => $prefix . 'access',
			'type' => 'text',
			'std'  => __( 'Lifetime', 'edublink' )
		) );

		$course_meta->add_field( array(
			'name'        => __( 'Preview Video Link', 'edublink' ),
			'id'          => $prefix . 'preview_video_link',
			'type'        => 'text',
			'desc' => __( 'https://www.youtube.com/watch?v=m2m5Xx5T4No', 'edublink' )
		) );

		$course_meta->add_field( array(
			'name' => __( 'Certificate', 'edublink' ),
			'id'   => $prefix . 'certificate',
			'desc' => __( 'Set course certificate', 'edublink' ),
			'std'  => 'yes',
			'type'    => 'checkbox'
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Class Type', 'edublink' ),
			'id'      => $prefix . 'class_type',
			'type'    => 'text',
			'default' => __( 'Online Only', 'edublink' )
		) );

		$course_meta->add_field( array(
			'id'           => $prefix . 'extra_meta_fields',
			'type'         => 'group',
			'name'         => __( 'Course Sidebar Extra Meta Informations', 'edublink' ),
			'options'      => array(
				'group_title'      => __( 'Meta Information{#}', 'edublink' ),
				'add_button'       => __( 'Add Another Meta Information', 'edublink' ),
				'remove_button'    => __( 'Remove Meta', 'edublink' ),
				'sortable'         => true
			),
			'fields'       => array(
	            array(
	                'name' => __( 'Meta Label', 'edublink' ),
	                'id'   => 'label',
	                'type' => 'text'
				),
				array(
	                'name' => __( 'Meta Value', 'edublink' ),
	                'id'   => 'value',
	                'type' => 'text'
	            ),
				array(
	                'name' => __( 'Meta Icon Class', 'edublink' ),
	                'id'   => 'icon_class',
	                'type' => 'text',
					'description' => __( 'You need to put the icon class name here. Example: <b>ri-user-line</b>. You can find all the default icons by clicking <a href="https://remixicon.com/" target="_blank">here</a>.', 'edublink' )
	            ),
				array(
	                'name' => __( 'Meta Wrapper Class', 'edublink' ),
	                'id'   => 'wrapper_class',
	                'type' => 'text'
	            )
	        )
		) );

		$course_meta->add_field( array(
			'id'           => $prefix . 'buttons',
			'type'         => 'group',
			'name'         => __( 'Course Sidebar Buttons', 'edublink' ),
			'options'      => array(
				'group_title'      => __( 'Button{#}', 'edublink' ),
				'add_button'       => __( 'Add Another Button', 'edublink' ),
				'remove_button'    => __( 'Remove Button', 'edublink' ),
				'sortable'         => true
			),
			'fields'       => array(
	            array(
	                'name' => __( 'Button Text', 'edublink' ),
	                'id'   => 'button_text',
	                'type' => 'text'
				),
				array(
	                'name' => __( 'Button URL', 'edublink' ),
	                'id'   => 'button_url',
	                'type' => 'text'
	            ),
				array(
	                'name' => __( 'Button Class', 'edublink' ),
	                'id'   => 'button_class',
	                'type' => 'text'
	            ),
				array(
	                'name' => __( 'Open In New Tab', 'edublink' ),
	                'id'   => 'button_tab_type',
	                'type' => 'checkbox'
	            )
	        )
		) );
	}

	public static function ms_course_side_meta() {
		$prefix = 'edublink_ms_course_';

		$course_meta = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Course Meta', 'edublink' ),
			'object_types' => array( 'stm-courses' ),
			'context'      => 'normal',
			'priority'     => 'high', 
			'show_names'   => true
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Preview Image', 'edublink' ),
			'id'      => $prefix . 'preview_image',
			'type'    => 'file',
			'options' => array(
				'url' => false
			),
			'text'    => array(
				'add_upload_file_text' => __( 'Add Image', 'edublink' )
			),
			'description'  => __( 'This image will be shown at the course preview video background.', 'edublink' )
		) );

		$course_meta->add_field( array(
			'name'        => __( 'Preview Video Link', 'edublink' ),
			'id'          => $prefix . 'preview_video_link',
			'type'        => 'text',
			'desc' => __( 'https://www.youtube.com/watch?v=m2m5Xx5T4No', 'edublink' )
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Course Language', 'edublink' ),
			'id'      => $prefix . 'language',
			'type'    => 'text',
			'desc' => __( 'The instructor used this language while conducting the course.', 'edublink' ),
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Deadline', 'edublink' ),
			'id'      => $prefix . 'deadline',
			'type'    => 'text',
			'default' => __( '25 Dec, 2024', 'edublink' )
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Class Type', 'edublink' ),
			'id'      => $prefix . 'class_type',
			'type'    => 'text',
			'default' => __( 'Online Only', 'edublink' )
		) );

		$course_meta->add_field( array(
			'name' => __( 'Access', 'edublink' ),
			'id'   => $prefix . 'access',
			'type' => 'text',
			'std'  => __( 'Lifetime', 'edublink' )
		) );

		$course_meta->add_field( array(
			'name' => __( 'Certificate', 'edublink' ),
			'id'   => $prefix . 'certificate',
			'desc' => __( 'Set course certificate', 'edublink' ),
			'std'  => 'yes',
			'type'    => 'checkbox'
		) );

		$course_meta->add_field( array(
			'name'    => __( 'Class Type', 'edublink' ),
			'id'      => $prefix . 'class_type',
			'type'    => 'text',
			'default' => __( 'Online Only', 'edublink' )
		) );

		$course_meta->add_field( array(
			'id'           => $prefix . 'extra_meta_fields',
			'type'         => 'group',
			'name'         => __( 'Course Sidebar Extra Meta Informations', 'edublink' ),
			'options'      => array(
				'group_title'      => __( 'Meta Information{#}', 'edublink' ),
				'add_button'       => __( 'Add Another Meta Information', 'edublink' ),
				'remove_button'    => __( 'Remove Meta', 'edublink' ),
				'sortable'         => true
			),
			'fields'       => array(
	            array(
	                'name' => __( 'Meta Label', 'edublink' ),
	                'id'   => 'label',
	                'type' => 'text'
				),
				array(
	                'name' => __( 'Meta Value', 'edublink' ),
	                'id'   => 'value',
	                'type' => 'text'
	            ),
				array(
	                'name' => __( 'Meta Icon Class', 'edublink' ),
	                'id'   => 'icon_class',
	                'type' => 'text',
					'description' => __( 'You need to put the icon class name here. Example: <b>ri-user-line</b>. You can find all the default icons by clicking <a href="https://remixicon.com/" target="_blank">here</a>.', 'edublink' )
	            ),
				array(
	                'name' => __( 'Meta Wrapper Class', 'edublink' ),
	                'id'   => 'wrapper_class',
	                'type' => 'text'
	            )
	        )
		) );

		$course_meta->add_field( array(
			'id'           => $prefix . 'buttons',
			'type'         => 'group',
			'name'         => __( 'Course Sidebar Buttons', 'edublink' ),
			'options'      => array(
				'group_title'      => __( 'Button{#}', 'edublink' ),
				'add_button'       => __( 'Add Another Button', 'edublink' ),
				'remove_button'    => __( 'Remove Button', 'edublink' ),
				'sortable'         => true
			),
			'fields'       => array(
	            array(
	                'name' => __( 'Button Text', 'edublink' ),
	                'id'   => 'button_text',
	                'type' => 'text'
				),
				array(
	                'name' => __( 'Button URL', 'edublink' ),
	                'id'   => 'button_url',
	                'type' => 'text'
	            ),
				array(
	                'name' => __( 'Button Class', 'edublink' ),
	                'id'   => 'button_class',
	                'type' => 'text'
	            ),
				array(
	                'name' => __( 'Open In New Tab', 'edublink' ),
	                'id'   => 'button_tab_type',
	                'type' => 'checkbox'
	            )
	        )
		) );
	}

	public static function tp_event_speaker_meta() {
		$prefix = 'edublink_tp_event_speaker_';

		$tp_event_meta = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Speaker Meta', 'edublink' ),
			'object_types' => array( 'term' ),
			'taxonomies'   => array( 'tp_event_speaker' ),
			'context'      => 'normal',
			'priority'     => 'low', 
			'show_names'   => true
		) );

		$tp_event_meta->add_field( array(
			'name'    => __( 'Designation', 'edublink' ),
			'id'      => $prefix . 'designation',
			'type' => 'text'
		) );

		$tp_event_meta->add_field( array(
			'name'    => __( 'Speaker Image', 'edublink' ),
			'id'      => $prefix . 'image',
			'type'    => 'file',
			'text'    => array(
				'add_upload_file_text' => __( 'Add Speaker Image', 'edublink' )
			)
		) );

		$tp_event_meta->add_field( array(
			'name'    => __( 'Facebook Profile', 'edublink' ),
			'id'      => $prefix . 'fb_profile',
			'type'    => 'text',
			'default' => '#'
		) );

		$tp_event_meta->add_field( array(
			'name'    => __( 'Twitter Profile', 'edublink' ),
			'id'      => $prefix . 'tw_profile',
			'type'    => 'text',
			'default' => '#'
		) );

		$tp_event_meta->add_field( array(
			'name'    => __( 'Linkedin Profile', 'edublink' ),
			'id'      => $prefix . 'lk_profile',
			'type'    => 'text',
			'default' => '#'
		) );
	}

	public static function tp_event_metabox() {
		$prefix = 'edublink_tp_event_';

		$tp_event_meta = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Event Meta', 'edublink' ),
			'object_types' => array( 'tp_event' ),
			'context'      => 'advanced',
			'priority'     => 'default', 
			'show_names'   => true
		) );

		$tp_event_meta->add_field( array(
			'name' => __( 'Latitude for Google Map', 'edublink' ),
			'id'   => $prefix . 'latitude',
			'type' => 'text'
		) );

		$tp_event_meta->add_field( array(
			'name' => __( 'Longitude for Google Map', 'edublink' ),
			'id'   => $prefix . 'longitude',
			'type' => 'text'
		) );

		$tp_event_meta->add_field( array(
			'name' => __( 'Custom Button Link', 'edublink' ),
			'id'   => $prefix . 'custom_link',
			'type' => 'text'
		) );

		$tp_event_meta->add_field( array(
			'id'           => $prefix . 'extra_meta_fields',
			'type'         => 'group',
			'name'         => __( 'Event Sidebar Extra Meta Informations', 'edublink' ),
			'options'      => array(
				'group_title'      => __( 'Meta Information{#}', 'edublink' ),
				'add_button'       => __( 'Add Another Meta Information', 'edublink' ),
				'remove_button'    => __( 'Remove Meta', 'edublink' ),
				'sortable'         => true
			),
			'fields'       => array(
	            array(
	                'name' => __( 'Meta Label', 'edublink' ),
	                'id'   => 'label',
	                'type' => 'text'
				),
				array(
	                'name' => __( 'Meta Value', 'edublink' ),
	                'id'   => 'value',
	                'type' => 'text'
	            ),
				array(
	                'name' => __( 'Meta Icon Class', 'edublink' ),
	                'id'   => 'icon_class',
	                'type' => 'text',
					'description' => __( 'You need to put the icon class name here. Example: <b>ri-user-line</b>. You can find all the default icons by clicking <a href="https://remixicon.com/" target="_blank">here</a>.', 'edublink' )
	            ),
				array(
	                'name' => __( 'Meta Wrapper Class', 'edublink' ),
	                'id'   => 'wrapper_class',
	                'type' => 'text'
	            )
	        )
		) );
	}

	public static function zoom_sidebar_metabox() {
		$prefix = 'edublink_zoom_';

		$zoom_meta = new_cmb2_box( array(
			'id'           => $prefix . 'metabox',
			'title'        => __( 'Zoom Meta', 'edublink' ),
			'object_types' => array( 'zoom-meetings' ),
			'context'      => 'advanced',
			'priority'     => 'default', 
			'show_names'   => true
		) );

		$zoom_meta->add_field( array(
			'id'           => $prefix . 'extra_meta_fields',
			'type'         => 'group',
			'name'         => __( 'Zoom Sidebar Extra Meta Informations', 'edublink' ),
			'options'      => array(
				'group_title'      => __( 'Meta Information{#}', 'edublink' ),
				'add_button'       => __( 'Add Another Meta Information', 'edublink' ),
				'remove_button'    => __( 'Remove Meta', 'edublink' ),
				'sortable'         => true
			),
			'fields'       => array(
	            array(
	                'name' => __( 'Meta Label', 'edublink' ),
	                'id'   => 'label',
	                'type' => 'text'
				),
				array(
	                'name' => __( 'Meta Value', 'edublink' ),
	                'id'   => 'value',
	                'type' => 'text'
	            ),
				array(
	                'name' => __( 'Meta Wrapper Class', 'edublink' ),
	                'id'   => 'wrapper_class',
	                'type' => 'text'
	            )
	        )
		) );
	}
}

Metaboxes::init();