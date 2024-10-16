<?php

namespace EduBlinkCore\LD\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Course_Categories extends \EduBlinkCore\Widgets\Course_Categories { 

    public function get_name() {
        return 'edublink-ld-course-category';
    }

    public function get_title() {
        return __( 'LearnDash Course Category', 'edublink-core' );
    }

    public function get_keywords() {
        return [ 'edublink', 'category', 'learndash', 'lms', 'taxonomy', 'categories' ];
    }

    protected $taxomy_name = 'ld_course_category';
}