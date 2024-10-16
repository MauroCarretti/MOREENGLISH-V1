<?php

namespace EduBlinkCore\LL\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Course_Categories extends \EduBlinkCore\Widgets\Course_Categories { 

    public function get_name() {
        return 'edublink-ll-course-category';
    }

    public function get_title() {
        return __( 'Lifter LMS Course Category', 'edublink-core' );
    }

    public function get_keywords() {
        return [ 'edublink', 'category', 'lifterlms', 'lifter lms', 'lms', 'taxonomy', 'categories' ];
    }

    protected $taxomy_name = 'course_cat';
}