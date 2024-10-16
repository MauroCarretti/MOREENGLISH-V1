<?php

namespace EduBlinkCore\SS\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Course_Categories extends \EduBlinkCore\Widgets\Course_Categories { 

    public function get_name() {
        return 'edublink-ss-course-category';
    }

    public function get_title() {
        return __( 'Sensei LMS Course Category', 'edublink-core' );
    }

    public function get_keywords() {
        return [ 'edublink', 'category', 'senseilms', 'sensei lms', 'lms', 'taxonomy', 'categories' ];
    }

    protected $taxomy_name = 'course-category';
}