<?php

namespace EduBlinkCore\TL\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Course_Search extends \EduBlinkCore\Widgets\Course_Search {

	public function get_name() {
		return 'edublink-tl-course-search';
	}

	public function get_title() {
		return __( 'Course Live Search(Ajax)( Tutor LMS )', 'edublink-core' );
	}

	public function get_keywords() {
		return [ 'edublink', 'course', 'search', 'form', 'course search', 'tutor', 'lms', 'tutor lms' ];
	}

    protected $post_type = 'courses';
}