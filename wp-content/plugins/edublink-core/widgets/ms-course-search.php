<?php

namespace EduBlinkCore\MS\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Course_Search extends \EduBlinkCore\Widgets\Course_Search {

	public function get_name() {
		return 'edublink-ms-course-search';
	}

	public function get_title() {
		return __( 'Course Live Search(Ajax)( MasterStudy LMS )', 'edublink-core' );
	}

	public function get_keywords() {
		return [ 'edublink', 'course', 'search', 'form', 'course search', 'master study lms', 'lms', 'masterstudy lms' ];
	}

    protected $post_type = 'stm-courses';
}