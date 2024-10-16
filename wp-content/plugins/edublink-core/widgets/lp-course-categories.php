<?php

namespace EduBlinkCore\LP\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Course_Categories extends \EduBlinkCore\Widgets\Course_Categories {

	public function get_name() {
		return 'edublink-lp-course-category';
	}

    public function get_title() {
        return __( 'LearnPress Course Category', 'edublink-core' );
    }

    public function get_keywords() {
        return [ 'edublink', 'category', 'learnpress', 'lms', 'taxonomy', 'categories' ];
    }
}