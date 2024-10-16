<?php

/**
 * Remove One Click demo importer branding
 */
add_filter( 'pt-ocdi/disable_pt_branding', '__return_false' );

function edublink_import_theme_demo_files() {
    $demos = array();
    $demos[] = array(
        'import_file_name'           => __( 'EduBlink LearnPress Demo(Recommended)', 'edublink' ),
        'categories'                 => array( 'LearnPress' ),
        'import_file_url'            => 'https://docs.devsblink.com/edublink-demo-import/learnpress/demo-content.xml',
        'import_widget_file_url'     => 'https://docs.devsblink.com/edublink-demo-import/widgets.wie',
        'import_customizer_file_url' => 'https://docs.devsblink.com/edublink-demo-import/customizer.dat',
        'import_redux'               => array(
            array(
                'file_url'           => 'https://docs.devsblink.com/edublink-demo-import/learnpress/redux_options.json',
                'option_name'        => 'edublink_theme_options'
            )
        ),
        'import_preview_image_url'   => trailingslashit( get_template_directory_uri() ) . 'lib/demo-data/edublink_demo.png',
        'import_notice'              => __( 'The import process usually takes 5-10 minutes, though occasionally it may extend to 30 minutes based on your internet speed & hosting configuration. If you\'re facing any issues please <a href="https://devsblink.ticksy.com/" target="_blank">support</a>.', 'edublink' ),
        'preview_url'                => 'https://demo.edublink.co'
    );

    $demos[] = array(
        'import_file_name'           => __( 'EduBlink Tutor LMS Demo', 'edublink' ),
        'categories'                 => array( 'Tutor LMS' ),
        'import_file_url'            => 'https://docs.devsblink.com/edublink-demo-import/tutor/demo-content.xml',
        'import_widget_file_url'     => 'https://docs.devsblink.com/edublink-demo-import/widgets.wie',
        'import_customizer_file_url' => 'https://docs.devsblink.com/edublink-demo-import/customizer.dat',
        'import_redux'               => array(
            array(
                'file_url'           => 'https://docs.devsblink.com/edublink-demo-import/tutor/redux_options.json',
                'option_name'        => 'edublink_theme_options'
            )
        ),
        'import_preview_image_url'   => trailingslashit( get_template_directory_uri() ) . 'lib/demo-data/edublink_demo.png',
        'import_notice'              => __( 'The import process usually takes 5-10 minutes, though occasionally it may extend to 30 minutes based on your internet speed & hosting configuration. If you\'re facing any issues please <a href="https://devsblink.ticksy.com/" target="_blank">support</a>.', 'edublink' ),
        'preview_url'                => 'https://tutor.edublink.co'
    );

    $demos[] = array(
        'import_file_name'           => __( 'EduBlink MasterStudy Demo', 'edublink' ),
        'categories'                 => array( 'MasterStudy' ),
        'import_file_url'            => 'https://docs.devsblink.com/edublink-demo-import/masterstudy/demo-content.xml',
        'import_widget_file_url'     => 'https://docs.devsblink.com/edublink-demo-import/widgets.wie',
        'import_customizer_file_url' => 'https://docs.devsblink.com/edublink-demo-import/customizer.dat',
        'import_redux'               => array(
            array(
                'file_url'           => 'https://docs.devsblink.com/edublink-demo-import/masterstudy/redux_options.json',
                'option_name'        => 'edublink_theme_options'
            )
        ),
        'import_preview_image_url'   => trailingslashit( get_template_directory_uri() ) . 'lib/demo-data/edublink_demo.png',
        'import_notice'              => __( 'The import process usually takes 5-10 minutes, though occasionally it may extend to 30 minutes based on your internet speed & hosting configuration. If you\'re facing any issues please <a href="https://devsblink.ticksy.com/" target="_blank">support</a>.', 'edublink' ),
        'preview_url'                => 'https://masterstudy.edublink.co'
    );

    $demos[] = array(
        'import_file_name'           => __( 'EduBlink LearnDash Demo', 'edublink' ),
        'categories'                 => array( 'LearnDash' ),
        'import_file_url'            => 'https://docs.devsblink.com/edublink-demo-import/learndash/demo-content.xml',
        'import_widget_file_url'     => 'https://docs.devsblink.com/edublink-demo-import/widgets.wie',
        'import_customizer_file_url' => 'https://docs.devsblink.com/edublink-demo-import/customizer.dat',
        'import_redux'               => array(
            array(
                'file_url'           => 'https://docs.devsblink.com/edublink-demo-import/learndash/redux_options.json',
                'option_name'        => 'edublink_theme_options'
            )
        ),
        'import_preview_image_url'   => trailingslashit( get_template_directory_uri() ) . 'lib/demo-data/edublink_demo.png',
        'import_notice'              => __( 'The import process usually takes 5-10 minutes, though occasionally it may extend to 30 minutes based on your internet speed & hosting configuration. If you\'re facing any issues please <a href="https://devsblink.ticksy.com/" target="_blank">support</a>.', 'edublink' ),
        'preview_url'                => 'https://learndash.edublink.co'
    );

    $demos[] = array(
        'import_file_name'           => __( 'EduBlink Lifter LMS Demo', 'edublink' ),
        'categories'                 => array( 'Lifter LMS' ),
        'import_file_url'            => 'https://docs.devsblink.com/edublink-demo-import/lifter/demo-content.xml',
        'import_widget_file_url'     => 'https://docs.devsblink.com/edublink-demo-import/widgets.wie',
        'import_customizer_file_url' => 'https://docs.devsblink.com/edublink-demo-import/customizer.dat',
        'import_redux'               => array(
            array(
                'file_url'           => 'https://docs.devsblink.com/edublink-demo-import/lifter/redux_options.json',
                'option_name'        => 'edublink_theme_options'
            )
        ),
        'import_preview_image_url'   => trailingslashit( get_template_directory_uri() ) . 'lib/demo-data/edublink_demo.png',
        'import_notice'              => __( 'The import process usually takes 5-10 minutes, though occasionally it may extend to 30 minutes based on your internet speed & hosting configuration. If you\'re facing any issues please <a href="https://devsblink.ticksy.com/" target="_blank">support</a>.', 'edublink' ),
        'preview_url'                => 'https://lifter.edublink.co'
    );

    $demos[] = array(
        'import_file_name'           => __( 'EduBlink Dark Demo(LearnPress)', 'edublink' ),
        'categories'                 => array( 'LearnPress', 'Dark' ),
        'import_file_url'            => 'https://docs.devsblink.com/edublink-demo-import/dark-lp/demo-content.xml',
        'import_widget_file_url'     => 'https://docs.devsblink.com/edublink-demo-import/widgets.wie',
        'import_customizer_file_url' => 'https://docs.devsblink.com/edublink-demo-import/customizer.dat',
        'import_redux'               => array(
            array(
                'file_url'           => 'https://docs.devsblink.com/edublink-demo-import/dark-lp/redux_options.json',
                'option_name'        => 'edublink_theme_options'
            )
        ),
        'import_preview_image_url'   => trailingslashit( get_template_directory_uri() ) . 'lib/demo-data/edublink_demo.png',
        'import_notice'              => __( 'The import process usually takes 5-10 minutes, though occasionally it may extend to 30 minutes based on your internet speed & hosting configuration. If you\'re facing any issues please <a href="https://devsblink.ticksy.com/" target="_blank">support</a>.', 'edublink' ),
        'preview_url'                => 'https://dark.edublink.co'
    );

    $demos[] = array(
        'import_file_name'           => __( 'EduBlink RTL Demo(Tutor LMS)', 'edublink' ),
        'categories'                 => array( 'Tutor LMS', 'RTL' ),
        'import_file_url'            => 'https://docs.devsblink.com/edublink-demo-import/rtl-tutor/demo-content.xml',
        'import_widget_file_url'     => 'https://docs.devsblink.com/edublink-demo-import/widgets.wie',
        'import_customizer_file_url' => 'https://docs.devsblink.com/edublink-demo-import/customizer.dat',
        'import_redux'               => array(
            array(
                'file_url'           => 'https://docs.devsblink.com/edublink-demo-import/rtl-tutor/redux_options.json',
                'option_name'        => 'edublink_theme_options'
            )
        ),
        'import_preview_image_url'   => trailingslashit( get_template_directory_uri() ) . 'lib/demo-data/edublink_demo.png',
        'import_notice'              => __( 'The import process usually takes 5-10 minutes, though occasionally it may extend to 30 minutes based on your internet speed & hosting configuration. If you\'re facing any issues please <a href="https://devsblink.ticksy.com/" target="_blank">support</a>.', 'edublink' ),
        'preview_url'                => 'https://rtl.edublink.co'
    );

    // $demos[] = array(
    //     'import_file_name'             => __( 'EduBlink Sensei LMS Demo', 'edublink' ),
    //     'categories'                   => array( 'Sensei LMS' ),
    //     'import_file_url'              => 'https://docs.devsblink.com/edublink-demo-import/sensei/demo-content.xml',
    //     'import_widget_file_url'       => 'https://docs.devsblink.com/edublink-demo-import/widgets.wie',
    //     'import_customizer_file_url'   => 'https://docs.devsblink.com/edublink-demo-import/customizer.dat',
    //     'import_redux'                 => array(
    //         array(
    //             'file_url'             => 'https://docs.devsblink.com/edublink-demo-import/sensei/redux_options.json',
    //             'option_name'          => 'edublink_theme_options'
    //         )
    //     ),
    //     'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'lib/demo-data/edublink_demo.png',
    //     'import_notice'                => __( 'The import process usually takes 5-10 minutes, though occasionally it may extend to 30 minutes based on your internet speed & hosting configuration. If you\'re facing any issues please <a href="https://devsblink.ticksy.com/" target="_blank">support</a>.', 'edublink' ),
    //     'preview_url'                  => 'https://sensei.edublink.co'
    // );

    // $demos[] = array(
    //     'import_file_name'             => __( 'EduBlink Masteriyo LMS Demo', 'edublink' ),
    //     'categories'                   => array( 'Masteriyo LMS' ),
    //     'import_file_url'              => 'https://docs.devsblink.com/edublink-demo-import/masteriyo/demo-content.xml',
    //     'import_widget_file_url'       => 'https://docs.devsblink.com/edublink-demo-import/widgets.wie',
    //     'import_customizer_file_url'   => 'https://docs.devsblink.com/edublink-demo-import/customizer.dat',
    //     'import_redux'                 => array(
    //         array(
    //             'file_url'             => 'https://docs.devsblink.com/edublink-demo-import/masteriyo/redux_options.json',
    //             'option_name'          => 'edublink_theme_options'
    //         )
    //     ),
    //     'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'lib/demo-data/edublink_demo.png',
    //     'import_notice'                => __( 'The import process usually takes 5-10 minutes, though occasionally it may extend to 30 minutes based on your internet speed & hosting configuration. If you\'re facing any issues please <a href="https://devsblink.ticksy.com/" target="_blank">support</a>.', 'edublink' ),
    //     'preview_url'                  => 'https://masteriyo.edublink.co'
    // );

    return apply_filters( 'edublink_ocdi_demo_files_args', $demos );
}
add_filter( 'pt-ocdi/import_files', 'edublink_import_theme_demo_files' );


function edublink_ocdi_after_import( $imported_demo ) {
    $main_menu       = get_term_by( 'name', 'Main Menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id
        )
    );

    $front_page_id    = get_page_by_title( 'Home Main' );
    $blog_page_id     = get_page_by_title( 'Blog' );
    $shop_page_id     = get_page_by_title( 'Shop' );
    $cart_page_id     = get_page_by_title( 'Cart' );
    $checkout_page_id = get_page_by_title( 'Checkout' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );
    update_option( 'woocommerce_shop_page_id', $shop_page_id->ID );
    update_option( 'woocommerce_cart_page_id', $cart_page_id->ID );
    update_option( 'woocommerce_checkout_page_id', $checkout_page_id->ID );
    update_option( 'woocommerce_enable_myaccount_registration', 'yes' );

    update_option( 'elementor_global_image_lightbox', 0 );
    update_option( 'elementor_disable_color_schemes', 'yes' );
    update_option( 'elementor_disable_typography_schemes', 'yes' );
    update_option( 'elementor_container_width', 1200 );

    $file = trailingslashit( get_template_directory() ) . 'inc/vendors/one-click-demo-import/settings.json';
    if ( file_exists( $file ) ) :
        edublink_ocdi_import_settings($file);
    endif;
}

add_action( 'pt-ocdi/after_import', 'edublink_ocdi_after_import' );

function edublink_ocdi_import_settings( $file ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
    require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';
    $file_obj = new WP_Filesystem_Direct( array() );
    $datas = $file_obj->get_contents($file);
    $datas = json_decode( $datas, true );

    if ( count( array_filter( $datas ) ) < 1 ) :
        return;
    endif;

    if ( ! empty( $datas['page_options'] ) ) :
        edublink_ocdi_import_page_options( $datas['page_options'] );
    endif;
}

function edublink_ocdi_import_page_options( $datas ) {
    if ( $datas ) :
        foreach ( $datas as $option_name => $page_id ) :
            update_option( $option_name, $page_id );
        endforeach;
    endif;
}


function edublink_ocdi_plugins_to_install( $plugins ) {
    $lms_plugins = [];
    // Check if user is on the theme recommeneded plugins step and a demo was selected.
    if ( isset( $_GET['step'] ) && $_GET['step'] === 'import' && isset( $_GET['import'] ) ) :
 
        if ( $_GET['import'] === '0' || $_GET['import'] === '5' ) :
            $lms_plugins = [
                [
                    'name'     => 'LearnPress LMS',
                    'slug'     => 'learnpress',
                    'required' => true
                ],
                [
                    'name'     => 'LearnPress - Course Review',
                    'slug'     => 'learnpress-course-review',
                    'required' => true
                ],
                [
                    'name'     => 'LearnPress – Course Wishlist',
                    'slug'     => 'learnpress-wishlist',
                    'required' => true
                ],
            ];
        endif;
 
        if ( $_GET['import'] === '1' || $_GET['import'] === '6' ) :
            $lms_plugins = [
                [
                    'name'     => 'Tutor LMS',
                    'slug'     => 'tutor',
                    'required' => true
                ],
            ];
        endif;
 
        if ( $_GET['import'] === '2' ) :
            $lms_plugins = [
                [
                    'name'     => 'MasterStudy LMS WordPress Plugin',
                    'slug'     => 'masterstudy-lms-learning-management-system',
                    'required' => true
                ],
            ];
        endif;
 
        if ( $_GET['import'] === '4' ) :
            $lms_plugins = [
                [
                    'name'     => 'LifterLMS – WordPress LMS Plugin for eLearning',
                    'slug'     => 'lifterlms',
                    'required' => true
                ],
            ];
        endif;
 
        // if ( $_GET['import'] === '5' ) :
        //     $lms_plugins = [
        //         [
        //             'name'     => 'Sensei LMS – Online Courses, Quizzes, & Learning',
        //             'slug'     => 'sensei-lms',
        //             'required' => true
        //         ],
        //     ];
        // endif;
 
        // if ( $_GET['import'] === '6' ) :
        //     $lms_plugins = [
        //         [
        //             'name'     => 'Masteriyo LMS – eLearning and Online Course Builder for WordPress',
        //             'slug'     => 'learning-management-system',
        //             'required' => true
        //         ],
        //     ];
        // endif;
    endif;
 
    return array_merge( $plugins, $lms_plugins );
}
add_filter( 'ocdi/register_plugins', 'edublink_ocdi_plugins_to_install' );