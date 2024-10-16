<?php

namespace EduBlinkCore\HF\Shortcode;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/**
 * Shortcode for Copyright
 *
 * @since 1.0.0
 */
class Copyright {

	public function __construct() {
		add_shortcode( 'edublink_core_running_year', [ $this, 'year' ] );
		add_shortcode( 'edublink_core_site_title', [ $this, 'title' ] );
	}

	public function year() {
		$year = gmdate( 'Y' );
		$year = do_shortcode( shortcode_unautop( $year ) );
		if ( ! empty( $year ) ) :
			return $year;
        endif;
	}

	public function title() {
		$title = get_bloginfo( 'name' );
		if ( ! empty( $title ) ) :
			return $title;
        endif;
	}

}

new Copyright();
