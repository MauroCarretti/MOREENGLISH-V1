<?php

namespace EduBlinkCore\LP\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Course_Search extends \EduBlinkCore\Widgets\Course_Search {

	public function get_name() {
		return 'edublink-lp-course-search';
	}

	public function get_title() {
		return __( 'Course Live Search(Ajax)', 'edublink-core' );
	}

	public function get_keywords() {
		return [ 'edublink', 'course', 'search', 'learnpress', 'form', 'course search' ];
	}
}