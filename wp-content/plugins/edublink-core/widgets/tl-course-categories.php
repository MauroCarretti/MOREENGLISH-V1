<?php

namespace EduBlinkCore\TL\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Course_Categories extends \EduBlinkCore\Widgets\Course_Categories { 

    public function get_name() {
        return 'edublink-tl-course-category';
    }

    public function get_title() {
        return __( 'Course Category(Tutor LMS)', 'edublink-core' );
    }

    public function get_keywords() {
        return [ 'edublink', 'category', 'tutorlms', 'tutor lms', 'lms', 'taxonomy', 'categories' ];
    }

    protected $taxomy_name = 'course-category';
}