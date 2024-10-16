<?php

namespace EduBlinkCore\MS\Widgets;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Course_Categories extends \EduBlinkCore\Widgets\Course_Categories { 

    public function get_name() {
        return 'edublink-ms-course-category';
    }

    public function get_title() {
        return __( 'MasterStudy LMS Course Category', 'edublink-core' );
    }

    public function get_keywords() {
        return [ 'edublink', 'category', 'masterstudylms', 'master study lms', 'lms', 'taxonomy', 'categories' ];
    }

    protected $taxomy_name = 'stm_lms_course_taxonomy';
}