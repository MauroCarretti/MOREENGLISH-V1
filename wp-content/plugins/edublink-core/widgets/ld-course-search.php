<?php

namespace EduBlinkCore\LD\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Course_Search extends \EduBlinkCore\Widgets\Course_Search {

	public function get_name() {
		return 'edublink-ld-course-search';
	}

	public function get_title() {
		return __( 'Course Live Search(Ajax)( LearnDash )', 'edublink-core' );
	}

	public function get_keywords() {
		return [ 'edublink', 'course', 'search', 'form', 'course search', 'LearnDash', 'lms', 'LearnDash lms' ];
	}

    protected $post_type = 'sfwd-courses';
}