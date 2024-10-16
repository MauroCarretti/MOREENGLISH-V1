<?php
namespace EduBlink;

if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

/*
 * EduBlink Course Filter Class
 */ 
class Filter {

	/**
     * Search Field
     * @since 1.0.0
     */
    public static function search( $search_value, $placeholder = '', $filter = '' ) {
        echo '<div class="filter-widget widget widget-' . esc_attr( $filter ) . '">';
            echo '<div class="filter-search-widget">';
                echo '<input type="text" value="' . esc_attr( $search_value ) . '" name="course_search" placeholder="' . esc_attr( $placeholder ) . '" class="input-search" autocomplete="off" />'; 
            echo '</div>';
        echo '</div>';
    }

	/**
     * Taxonomy Field
     *
     * @since 1.0.0
     */
    public static function taxonomy( $filter = array(), $slug = 'course_category', $handler = 'course_cats', $label_text = '', $number = null ) {
        $number = $number ? $number : 0;
        $terms = get_terms( array(
            'taxonomy'   => $slug,
            'hide_empty' => true,
            'parent'     => 0,
            'number'     => $number
        ) );

        echo '<div class="filter-widget widget widget-' . esc_attr( $slug ) . '">';
            echo $label_text ? '<h5 class="widget-title">' . esc_html( $label_text ). '</h5>' : '';
            echo '<div class="eb-filter-content">';
                foreach ( $terms as $term ) :
                    $id = $term->term_id;
                    $checked = in_array( $id, $filter ) ? 'checked' : '';
                    echo '<label for="category-' . esc_attr( $id ) . '">';
                        echo '<input type="checkbox" name="' . esc_attr( $handler ) . '[]" id="category-' . esc_attr( $id ) . '" value="' . esc_attr( $id ) . '" ' . esc_attr( $checked ) . '>';
                        echo '<span class="filter-cat-name">' . esc_html( $term->name ) . '</span>';
                        echo '<span class="filter-count">' . esc_html( '(' . $term->count . ')' ) . '</span>';
                    echo '</label>';
                endforeach;
            echo '</div>';
        echo '</div>';
    }

	/**
     * query
     * @return array
     *
     * @since 1.0.0
     */
    public static function query( $filtered_category, $filtered_tags, $settings ) {
        $args = array(
            'post_type'      => $settings['course_cpt'],
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'tax_query'      => array(
                'relation'   => 'AND'
            )
        );

        if ( in_array( 'category', $settings['filter_options'] ) ) :
            $args['tax_query'][] = [
                'taxonomy' => $settings['course_category'],
                'field'    => 'term_id',
                'terms'    => $filtered_category,
                'operator' => ! empty( $filtered_category ) ? 'IN' : 'NOT IN'
            ];
        endif;

        if ( in_array( 'tags', $settings['filter_options'] ) ) :
            $args['tax_query'][] = [
                'taxonomy' => $settings['course_tag'],
                'field'    => 'term_id',
                'terms'    => $filtered_tags,
                'operator' => ! empty( $filtered_tags ) ? 'IN' : 'NOT IN'
            ];
        endif;

        if ( isset( $_GET['course_search'] ) && ! isset( $_GET['reset'] ) && in_array( 'search', $settings['filter_options'] ) ) :
            $args['s'] = sanitize_text_field( $_REQUEST['course_search'] );
        endif;

        if ( isset( $settings['filtered_instructor'] ) && ! empty( $settings['filtered_instructor'] ) ) :
            $args['author__in'] = $settings['filtered_instructor'];
        endif;

        if ( 'yes' === $settings['enable_ordering'] ) :
            switch ( $settings['course_ordering'] ) :
                case 'newest_first':
                    $args['orderby'] = 'date';
                    $args['order'] = 'desc';
                    break;
                case 'oldest_first':
                    $args['orderby'] = 'date';
                    $args['order'] = 'asc';
                    break;
                case 'course_title_az':
                    $args['orderby'] = 'post_title';
                    $args['order'] = 'asc';
                    break;
                case 'course_title_za':
                    $args['orderby'] = 'post_title';
                    $args['order'] = 'desc';
                    break;
                case 'lp_popular':
                    $args['meta_key'] = '_lp_students';
                    $args['orderby'] = 'meta_value_num';
                    break;
                case 'lp_featured':
                    $args['meta_key'] = '_lp_featured';
                    $args['meta_value'] = 'yes';
                    break;
                default:
                    $args['orderby'] = 'date';
                    $args['order'] = 'desc';
                    break;
            endswitch;
        endif;

        return $args;
    }

    /**
     * filter sidebar
     * @since 1.0.0
     */
    public static function filter( $settings  ) {
        foreach ( $settings['filter_options'] as $filter ) :
            switch ( $filter ) :
                case 'category':
                    Filter::taxonomy( $settings['filtered_category'], $settings['course_category'], $settings['course_cats'], $settings['category_label_text'], $settings['category_number'] );
                    break;

                case 'tags':
                    Filter::taxonomy( $settings['filtered_tags'], $settings['course_tag'], $settings['course_tags'], $settings['tags_label_text'] );
                    break;

                case 'search':
                    Filter::search( $settings['search_value'], $settings['search_placeholder_text'], $filter );
                    break;
                    
                case 'instructor':
                    Filter::instructor( $settings['filtered_instructor'], $settings['instructor_label_text'], $filter, $settings['course_cpt'] );
                    break;

                case 'lp_price':
                    self::lp_price( $settings['price_label_text'], $filter );
                    break;
                    
                case 'lp_level':
                    Filter::lp_level( $settings['filtered_level'], $settings['level_label_text'], $filter );
                    break;
                    
                case 'tl_level':
                    Filter::tl_level( $settings['filtered_level'], $settings['level_label_text'], $filter );
                    break;
                    
                case 'tl_price':
                    self::tl_price( $settings['price_label_text'], $filter );
                    break;

                case 'll_level':
                    Filter::taxonomy( $settings['filtered_difficulties'], $settings['course_difficulty'], $settings['course_difficulties'], $settings['difficulties_label_text'] );
                    break;

                case 'ms_status':
                    Filter::ms_status( $settings['filtered_status'], $settings['status_label_text'], $filter );
                    break;

                case 'ms_price':
                    self::ms_price( $settings['price_label_text'], $filter );
                    break;

                case 'ms_rating':
                    Filter::ms_rating( $settings['rating_label_text'], $filter );
                    break;
                    
                case 'ms_level':
                    Filter::ms_level( $settings['filtered_level'], $settings['level_label_text'], $filter );
                    break;
            endswitch;
        endforeach;
    }

	/**
     * Form Submit & Reset Button
     * @since 1.0.0
     */
    public static function form_button( $apply_filter, $reset_filter = null ) {
        $remove_url_args = array( 'course_search', 'course_cats', 'course_tags', 'course_price', 'course_level' );
        $reset_url = remove_query_arg( $remove_url_args, get_pagenum_link() );
        $reset_button_type = apply_filters( 'edublink_course_reset_button_type', 'default' );
        $apply_filter = $apply_filter ? $apply_filter : __( 'Filter', 'edublink' );
        $reset_filter = $reset_filter ? $reset_filter : __( 'Reset', 'edublink' );
        echo '<div class="edublink-course-filter-buttons">';
            echo '<button type="submit" class="edu-btn btn-medium">' . esc_html( $apply_filter ) . '</button>';

            if ( 'default' === $reset_button_type ) :
                echo '<a href="' . esc_url( parse_url( $_SERVER["REQUEST_URI"], PHP_URL_PATH ) ) . '" class="edu-btn btn-border btn-medium edublink-filter-clear">';
                    echo esc_html( $reset_filter );
                echo '</a></div>';
            else :
                echo '<button type="submit" name="reset" value="true" class="edublink-filter-reset edu-btn btn-border btn-medium" id="reset-button">' . esc_html( $reset_filter ) . '</button></div>';
            ?>
                <script>
                    ;( function( $ ) {
                        'use strict';
                        document.addEventListener( 'DOMContentLoaded', function () {
                            let resetButton = document.getElementById( 'reset-button' );
                            resetButton.addEventListener( 'click', function () {
                                let currentURL = window.location.href;
                                let updatedURL = removeURLParameter( currentURL, 'reset' );
                                window.location.href = updatedURL;
                            });

                            function removeURLParameter( url, parameter ) {
                                let urlSearchParams = new URLSearchParams( url );
                                urlSearchParams.delete( parameter );
                                return '?' + urlSearchParams.toString();
                            }
                        } );

                    } )( jQuery );
                </script>
            <?php
        endif;
    }

    /**
     * LearnPress Price Filter Options
     *
     * @since 1.0.0
     */
    public static function lp_price( $label_text, $slug ) {
        $cp_checked = '';
        if ( isset( $_GET['course_price'] ) ) :
            $cp_checked = wp_unslash( $_GET['course_price'] );
        endif;

        // Handle the reset button for price
        if ( isset( $_GET['reset'] ) ) :
            $cp_checked = '';
        endif;

        echo '<div class="filter-widget widget widget-' . esc_attr( $slug ) . '">';
            echo $label_text ? '<h5 class="widget-title">' . esc_html( $label_text ). '</h5>' : '';

            $query_args = array(
                'post_type'      => LP_COURSE_CPT,
                'posts_per_page' => 1,
                'fields'         => 'ids'
            );

            $loop = new \WP_Query( $query_args );
            $courses_count = $loop->found_posts;

            echo '<div class="eb-filter-content">';
                // all
                echo '<div class="edublink-radio-filter">';
                    echo '<input type="radio" id="all" name="course_price" value=""';
                        if ( ! ( $cp_checked === 'free' || $cp_checked === 'paid' ) ) : ?>
                            checked="checked"
                        <?php endif;
                    echo '>';

                    echo '<label for="all">' . __( 'All', 'edublink' ) . '<span class="filter-count">(' . esc_html( $courses_count ) . ')</span></label>';
                echo '</div>';

                // free
                $meta_query = array(array(
                    'relation'    => 'OR',
                    array(
                        'key'     => '_lp_price',
                        'value'   => '0',
                        'compare' => '='
                    ),
                    array(
                        'key'     => '_lp_price',
                        'value'   => '',
                        'compare' => '='
                    ),
                    array(
                        'key'     => '_lp_price',
                        'compare' => 'NOT EXISTS'
                    )
                ) );

                $query_args = array(
                    'post_type'      => LP_COURSE_CPT,
                    'posts_per_page' => 1,
                    'meta_query'     => $meta_query,
                    'fields'         => 'ids'
                );

                $loop = new \WP_Query( $query_args );
                $courses_count = $loop->found_posts;

                echo '<div class="edublink-radio-filter">';
                    echo' <input type="radio" id="free" name="course_price" value="free"';
                        if ( $cp_checked === 'free' ) : ?>
                            checked="checked"
                        <?php endif;
                    echo '>';
                    echo '<label for="free">' . __( 'Free', 'edublink' ) . '<span class="filter-count">(' . esc_html( $courses_count ) . ')</span></label>';
                echo '</div>';

                // paid 
                $meta_query = array( array(
                    'key'     => '_lp_price',
                    'value'   => '0',
                    'compare' => '>'
                ) );

                $query_args = array(
                    'post_type'      => LP_COURSE_CPT,
                    'posts_per_page' => 1,
                    'meta_query'     => $meta_query,
                    'fields'         => 'ids'
                );
                
                $loop = new \WP_Query( $query_args );
                $courses_count = $loop->found_posts;

                echo '<div class="edublink-radio-filter">';
                    echo' <input type="radio" id="paid" name="course_price" value="paid"';
                        if ( $cp_checked === 'paid' ) : ?>
                            checked="checked"
                        <?php endif;
                    echo '>';

                    echo '<label for="paid">' . __( 'Paid', 'edublink' ) . '<span class="filter-count">(' . esc_html( $courses_count ) . ')</span></label>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }

    /**
     * LearnPress Level Filter Options
     *
     * @since 1.0.0
     */
    public static function lp_level( $filtered_level, $label_text, $slug ) {
        // Handle the reset button for level
        if ( isset( $_GET['reset'] ) ) :
            $filtered_level = array();
        endif;

        $course_levels = lp_course_level();
        echo '<div class="filter-widget widget widget-' . esc_attr( $slug ) . '">';
            echo $label_text ? '<h5 class="widget-title">' . esc_html( $label_text ). '</h5>' : '';
            echo '<div class="eb-filter-content">';
                foreach ( $course_levels as $key => $course_level ) :
                    $meta_query = array(
                        array(
                            'key'     => '_lp_level',
                            'value'   => $key,
                            'compare' => '='
                        )
                    );
                    
                    $query_args = array(
                        'post_type'      => LP_COURSE_CPT,
                        'posts_per_page' => 1,
                        'meta_query'     => $meta_query,
                        'fields'         => 'ids'
                    );

                    $loop = new \WP_Query( $query_args );
                    $courses_count = $loop->found_posts;

                    $course_level = self::lp_level_text( $key );

                    if ( $key == '' ) :
                        $key = 'all_levels';

                        echo '<label for="' . esc_attr( $key ) . '">';
                            echo '<input
                                type="checkbox"
                                name="course_level[]"
                                value=""
                                id="' . esc_attr( $key ) . '"';
                                echo in_array( '', $filtered_level ) ? 'checked="checked"' : '';
                            echo '>';

                            echo '<span class="eb-filter-multicheck"></span>';
                            echo esc_html( $course_level );
                            echo '<span class="filter-count">(' . esc_html( $courses_count ) . ')</span>';
                        echo '</label>';
                        continue;
                    endif;

                    echo '<label for="' . esc_attr( $key ) . '">';
                        echo '<input
                            type="checkbox"
                            name="course_level[]"
                            value="' . esc_attr( $key ) . '"
                            id="' . esc_attr( $key ) . '"';
                            echo in_array( $key, $filtered_level ) ? 'checked="checked"' : '';
                        echo '>';
                        
                        echo '<span class="eb-filter-multicheck"></span>';
                        echo esc_html( $course_level );
                        echo '<span class="filter-count">(' . esc_html( $courses_count ) . ')</span>';
                    echo '</label>';
                endforeach;
            echo '</div>';
        echo '</div>';
    }

    /**
     * LearnPress Level Filter Options
     *
     * @since 1.0.0
     */
    public static function lp_level_text( $label_key ) {
        if ( 'beginner' === $label_key ) :
            $course_level = __( 'Beginner', 'edublink' );
        elseif( 'intermediate' === $label_key ) :
            $course_level = __( 'Intermediate', 'edublink' );
        elseif( 'expert' === $label_key ) :
            $course_level = __( 'Expert', 'edublink' );
        else :
            $course_level = __( 'All Levels', 'edublink' );
        endif;
        return apply_filters( 'edublink_lp_course_level_text', $course_level );
    }

    /**
     * Tutor LMS Level Filter Options
     *
     * @since 1.0.0
     */
    public static function tl_level( $filtered_level, $label_text, $slug ) {
        // Handle the reset button for level
        if ( isset( $_GET['reset'] ) ) :
            $filtered_level = array();
        endif;

        $course_levels = tutor_utils()->course_levels();
        echo '<div class="filter-widget widget widget-' . esc_attr( $slug ) . '">';
            echo $label_text ? '<h5 class="widget-title">' . esc_html( $label_text ). '</h5>' : '';
            echo '<div class="eb-filter-content">';
                foreach ( $course_levels as $key => $course_level ) :
                    $meta_query = array(
                        array(
                            'key'     => '_tutor_course_level',
                            'value'   => $key,
                            'compare' => '='
                        )
                    );
                    
                    $query_args = array(
                        'post_type'      => 'courses',
                        'posts_per_page' => 1,
                        'meta_query'     => $meta_query,
                        'fields'         => 'ids'
                    );

                    $loop = new \WP_Query( $query_args );
                    $courses_count = $loop->found_posts;

                    if ( $key == '' ) :
                        $key = 'all_levels';

                        echo '<label for="' . esc_attr( $key ) . '">';
                            echo '<input
                                type="checkbox"
                                name="course_level[]"
                                value=""
                                id="' . esc_attr( $key ) . '"';
                                echo in_array( '', $filtered_level ) ? 'checked="checked"' : '';
                            echo '>';

                            echo '<span class="eb-filter-multicheck"></span>';
                            echo esc_html( $course_level );
                            echo '<span class="filter-count">(' . esc_html( $courses_count ) . ')</span>';
                        echo '</label>';
                        continue;
                    endif;

                    echo '<label for="' . esc_attr( $key ) . '">';
                        echo '<input
                            type="checkbox"
                            name="course_level[]"
                            value="' . esc_attr( $key ) . '"
                            id="' . esc_attr( $key ) . '"';
                            echo in_array( $key, $filtered_level ) ? 'checked="checked"' : '';
                        echo '>';
                        
                        echo '<span class="eb-filter-multicheck"></span>';
                        echo esc_html( $course_level );
                        echo '<span class="filter-count">(' . esc_html( $courses_count ) . ')</span>';
                    echo '</label>';
                endforeach;
            echo '</div>';
        echo '</div>';
    }

    /**
     * Tutor LMS Price Filter Options
     *
     * @since 1.0.0
     */
    public static function tl_price( $label_text, $slug ) {
        $cp_checked = '';
        if ( isset( $_GET['course_price'] ) ) :
            $cp_checked = wp_unslash( $_GET['course_price'] );
        endif;

        // Handle the reset button for price
        if ( isset( $_GET['reset'] ) ) :
            $cp_checked = '';
        endif;

        $query_args = array(
            'post_type'      => 'courses',
            'posts_per_page' => 1,
            'fields'         => 'ids'
        );

        $loop = new \WP_Query( $query_args );
        $courses_count = $loop->found_posts;
        
        echo '<div class="filter-widget widget widget-' . esc_attr( $slug ) . '">';
            echo $label_text ? '<h5 class="widget-title">' . esc_html( $label_text ). '</h5>' : '';
            echo '<div class="eb-filter-content">';
                echo '<div class="edublink-radio-filter">';
                    echo '<input type="radio" id="all" name="course_price" value=""';
                        if ( ! ( $cp_checked === 'free' || $cp_checked === 'paid' ) ) : ?>
                            checked="checked"
                        <?php endif;
                    echo '>';

                    echo '<label for="all">' . __( 'All', 'edublink' ) . '<span class="filter-count">(' . esc_html( $courses_count ) . ')</span></label>';
                echo '</div>';

                $meta_query = array( array(
                    'key'     => '_tutor_course_product_id',
                    'compare' => 'NOT EXISTS',
                ) );

                $query_args = array(
                    'post_type'      => 'courses',
                    'posts_per_page' => 1,
                    'meta_query'     => $meta_query,
                    'fields'         => 'ids'
                );

                $loop = new \WP_Query( $query_args );
                $courses_count = $loop->found_posts;

                echo '<div class="edublink-radio-filter">';
                    echo' <input type="radio" id="free" name="course_price" value="free"';
                        if ( $cp_checked === 'free' ) : ?>
                            checked="checked"
                        <?php endif;
                    echo '>';
                    echo '<label for="free">' . __( 'Free', 'edublink' ) . '<span class="filter-count">(' . esc_html( $courses_count ) . ')</span></label>';
                echo '</div>';

                $meta_query = array( array(
                    'key'     => '_tutor_course_product_id',
                    'compare' => 'EXISTS',
                ) );

                $query_args = array(
                    'post_type'      => 'courses',
                    'posts_per_page' => 1,
                    'meta_query'     => $meta_query,
                    'fields'         => 'ids'
                );

                $loop = new \WP_Query( $query_args );
                $courses_count = $loop->found_posts;

                echo '<div class="edublink-radio-filter">';
                    echo' <input type="radio" id="paid" name="course_price" value="paid"';
                        if ( $cp_checked === 'paid' ) : ?>
                            checked="checked"
                        <?php endif;
                    echo '>';

                    echo '<label for="paid">' . __( 'Paid', 'edublink' ) . '<span class="filter-count">(' . esc_html( $courses_count ) . ')</span></label>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }

    /**
     * MasterStudy Status Filter Options
     *
     * @since 1.0.0
     */
    public static function ms_status( $filtered_status, $label_text, $slug ) {
        // Handle the reset button for level
        if ( isset( $_GET['reset'] ) ) :
            $filtered_status = array();
        endif;
        $course_statuses = \STM_LMS_Course::get_all_statuses();
        echo '<div class="filter-widget widget widget-' . esc_attr( $slug ) . '">';
            echo $label_text ? '<h5 class="widget-title">' . esc_html( $label_text ). '</h5>' : '';
            echo '<div class="eb-filter-content">';
                foreach ( $course_statuses as $key => $course_status ) :
                    $meta_query = array(
                        array(
                            'key'     => 'status',
                            'value'   => $key,
                            'compare' => '='
                        )
                    );
                    
                    $query_args = array(
                        'post_type'      => 'stm-courses',
                        'posts_per_page' => 1,
                        'meta_query'     => $meta_query,
                        'fields'         => 'ids'
                    );

                    $loop = new \WP_Query( $query_args );
                    $courses_count = $loop->found_posts;

                    echo '<label for="' . esc_attr( $key ) . '">';
                        echo '<input
                            type="checkbox"
                            name="course_status[]"
                            value="' . esc_attr( $key ) . '"
                            id="' . esc_attr( $key ) . '"';
                            echo in_array( $key, $filtered_status ) ? 'checked="checked"' : '';
                        echo '>';
                        
                        echo '<span class="eb-filter-multicheck"></span>';
                        echo esc_html( $course_status );
                        echo '<span class="filter-count">(' . esc_html( $courses_count ) . ')</span>';
                    echo '</label>';
                endforeach;
            echo '</div>';
        echo '</div>';
    }

    /**
     * MasterStudy Price Filter Options
     *
     * @since 1.0.0
     */
    public static function ms_price( $label_text, $slug ) {
        $cp_checked = '';
        if ( isset( $_GET['course_price'] ) ) :
            $cp_checked = wp_unslash( $_GET['course_price'] );
        endif;

        // Handle the reset button for price
        if ( isset( $_GET['reset'] ) ) :
            $cp_checked = '';
        endif;

        echo '<div class="filter-widget widget widget-' . esc_attr( $slug ) . '">';
            echo $label_text ? '<h5 class="widget-title">' . esc_html( $label_text ). '</h5>' : '';

            $query_args = array(
                'post_type'      => 'stm-courses',
                'posts_per_page' => 1,
                'fields'         => 'ids'
            );

            $loop = new \WP_Query( $query_args );
            $courses_count = $loop->found_posts;

            echo '<div class="eb-filter-content">';
                // all
                echo '<div class="edublink-radio-filter">';
                    echo '<input type="radio" id="all" name="course_price" value=""';
                        if ( ! ( $cp_checked === 'free' || $cp_checked === 'paid' || $cp_checked === 'subscription' ) ) : ?>
                            checked="checked"
                        <?php endif;
                    echo '>';

                    echo '<label for="all">' . __( 'All', 'edublink' ) . '<span class="filter-count">(' . esc_html( $courses_count ) . ')</span></label>';
                echo '</div>';

                // free
                $meta_query = array(array(
                    'relation' => 'AND',
                    array(
                        'relation' => 'OR',
                        array(
                            'key'     => 'price',
                            'value'   => array( 0, '' ),
                            'compare' => 'in'
                        ),
                        array(
                            'key'     => 'price',
                            'compare' => 'NOT EXISTS'
                        )
                    ),
                    array(
                        'relation' => 'OR',
                        array(
                            'key'     => 'not_single_sale',
                            'value'   => 'on',
                            'compare' => '!='
                        ),
                        array(
                            'key'     => 'not_single_sale',
                            'compare' => 'NOT EXISTS'
                        )
                    )
                ) );

                $query_args = array(
                    'post_type'      => 'stm-courses',
                    'posts_per_page' => 1,
                    'meta_query'     => $meta_query,
                    'fields'         => 'ids'
                );

                $loop = new \WP_Query( $query_args );
                $courses_count = $loop->found_posts;

                echo '<div class="edublink-radio-filter">';
                    echo' <input type="radio" id="free" name="course_price" value="free"';
                        if ( $cp_checked === 'free' ) : ?>
                            checked="checked"
                        <?php endif;
                    echo '>';
                    echo '<label for="free">' . __( 'Free', 'edublink' ) . '<span class="filter-count">(' . esc_html( $courses_count ) . ')</span></label>';
                echo '</div>';

                // paid
                $meta_query = array(array(
                    'relation' => 'AND',
                    array(
                        'key'     => 'price',
                        'value'   => 0,
                        'compare' => '>'
                    ),
                    array(
                        'relation' => 'OR',
                        array(
                            'key'     => 'not_single_sale',
                            'value'   => 'on',
                            'compare' => '!='
                        ),
                        array(
                            'key'     => 'not_single_sale',
                            'compare' => 'NOT EXISTS'
                        )
                    )
                ) );

                $query_args = array(
                    'post_type'      => 'stm-courses',
                    'posts_per_page' => 1,
                    'meta_query'     => $meta_query,
                    'fields'         => 'ids'
                );

                $loop = new \WP_Query( $query_args );
                $courses_count = $loop->found_posts;
                
                echo '<div class="edublink-radio-filter">';
                    echo' <input type="radio" id="paid" name="course_price" value="paid"';
                        if ( $cp_checked === 'paid' ) : ?>
                            checked="checked"
                        <?php endif;
                    echo '>';
                    echo '<label for="paid">' . __( 'Paid', 'edublink' ) . '<span class="filter-count">(' . esc_html( $courses_count ) . ')</span></label>';
                echo '</div>';
                            
                // subscription
                $meta_query = array(array(
                    'relation' => 'AND',
                    array(
                        'key'     => 'not_single_sale',
                        'value'   => 'on',
                        'compare' => '='
                    )
                ) );

                $query_args = array(
                    'post_type'      => 'stm-courses',
                    'posts_per_page' => 1,
                    'meta_query'     => $meta_query,
                    'fields'         => 'ids'
                );

                $loop = new \WP_Query( $query_args );
                $courses_count = $loop->found_posts;

                echo '<div class="edublink-radio-filter">';
                    echo' <input type="radio" id="subscription" name="course_price" value="subscription"';
                        if ( $cp_checked === 'subscription' ) : ?>
                            checked="checked"
                        <?php endif;
                    echo '>';

                    echo '<label for="subscription">' . __( 'Subscription', 'edublink' ) . '<span class="filter-count">(' . esc_html( $courses_count ) . ')</span></label>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }

    /**
     * MasterStudy Rating Filter Options
     *
     * @since 1.0.0
     */
    public static function ms_rating( $label_text, $slug ) {
        $cp_checked = '';
        if ( isset( $_GET['rate'] ) ) :
            $cp_checked = wp_unslash( $_GET['rate'] );
        endif;

        // Handle the reset button for price
        if ( isset( $_GET['reset'] ) ) :
            $cp_checked = '';
        endif;

        $query_args = array(
            'post_type'      => 'stm-courses',
            'posts_per_page' => 1,
            'fields'         => 'ids'
        );

        $loop = new \WP_Query( $query_args );
        $courses_count = $loop->found_posts;

        echo '<div class="filter-widget widget widget-' . esc_attr( $slug ) . '">';
            echo $label_text ? '<h5 class="widget-title">' . esc_html( $label_text ). '</h5>' : '';

            echo '<div class="eb-filter-content">';
                // 4.5-star & above
                echo '<div class="edublink-radio-filter">';
                    echo' <input type="radio" id="four-half-above" name="rate" value="4.5"';
                        if ( $cp_checked === '4.5' ) : ?>
                            checked="checked"
                        <?php endif;
                    echo '>';
                    $label_text = __( '4.5 & Up', 'edublink' );
                    echo '<label for="four-half-above">' . self::rating( 90, $label_text ) . '</label>';
                echo '</div>';

                // 4.0-star & above
                echo '<div class="edublink-radio-filter">';
                    echo' <input type="radio" id="four-above" name="rate" value="4"';
                        if ( $cp_checked === '4' ) : ?>
                            checked="checked"
                        <?php endif;
                    echo '>';
                    $label_text = __( '4.0 & Up', 'edublink' );
                    echo '<label for="four-above">' . self::rating( 80, $label_text ) . '</label>';
                echo '</div>';

                // 3.5-star & above
                echo '<div class="edublink-radio-filter">';
                    echo' <input type="radio" id="three-half-above" name="rate" value="3.5"';
                        if ( $cp_checked === '3.5' ) : ?>
                            checked="checked"
                        <?php endif;
                    echo '>';
                    $label_text = __( '3.5 & Up', 'edublink' );
                    echo '<label for="three-half-above">' . self::rating( 70, $label_text ) . '</label>';
                echo '</div>';

                // 3.0-star & above
                echo '<div class="edublink-radio-filter">';
                    echo' <input type="radio" id="three-above" name="rate" value="3"';
                        if ( $cp_checked === '3' ) : ?>
                            checked="checked"
                        <?php endif;
                    echo '>';
                    $label_text = __( '3.0 & Up', 'edublink' );
                    echo '<label for="three-above">' . self::rating( 60, $label_text ) . '</label>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    }

    /**
     * MasterStudy Level Filter Options
     *
     * @since 1.0.0
     */
    public static function ms_level( $filtered_level, $label_text, $slug ) {
        // Handle the reset button for level
        if ( isset( $_GET['reset'] ) ) :
            $filtered_level = array();
        endif;

        $course_levels = \STM_LMS_Helpers::get_course_levels();
        echo '<div class="filter-widget widget widget-' . esc_attr( $slug ) . '">';
            echo $label_text ? '<h5 class="widget-title">' . esc_html( $label_text ). '</h5>' : '';
            echo '<div class="eb-filter-content">';
                foreach ( $course_levels as $key => $course_level ) :
                    $meta_query = array(
                        array(
                            'key'     => 'level',
                            'value'   => $key,
                            'compare' => '='
                        )
                    );
                    
                    $query_args = array(
                        'post_type'      => 'stm-courses',
                        'posts_per_page' => 1,
                        'meta_query'     => $meta_query,
                        'fields'         => 'ids'
                    );

                    $loop = new \WP_Query( $query_args );
                    $courses_count = $loop->found_posts;

                    echo '<label for="' . esc_attr( $key ) . '">';
                        echo '<input
                            type="checkbox"
                            name="course_level[]"
                            value="' . esc_attr( $key ) . '"
                            id="' . esc_attr( $key ) . '"';
                            echo in_array( $key, $filtered_level ) ? 'checked="checked"' : '';
                        echo '>';
                        
                        echo '<span class="eb-filter-multicheck"></span>';
                        echo esc_html( $course_level );
                        echo '<span class="filter-count">(' . esc_html( $courses_count ) . ')</span>';
                    echo '</label>';
                endforeach;
            echo '</div>';
        echo '</div>';
    }

    /**
     * Instructor
     *
     * @since 1.0.0
     */
    public static function instructor( $filtered_instructor, $label_text, $slug, $course_cpt = 'post' ) {
        // Handle the reset button for instructor
        if ( isset( $_GET['reset'] ) ) :
            $filtered_instructor = array();
        endif;

        $required_role = apply_filters( 'edublink_instructor_filter_user_role', array( 'administrator' ) );
        $instructor_role = array( 'role__in' => $required_role );
        $course_instructor = get_users( $instructor_role );
        echo '<div class="filter-widget widget widget-' . esc_attr( $slug ) . '">';
            echo $label_text ? '<h5 class="widget-title">' . esc_html( $label_text ). '</h5>' : '';
            echo '<div class="eb-filter-content">';
                if ( is_array( $course_instructor ) ) :
                    foreach ( $course_instructor as $user ) :
                        $count = self::user_post_count_by_post_type( $user->ID, $course_cpt );
                        if ( $count ) :
                            echo '<label for="' . esc_attr( $user->ID ) . '">';
                                echo '<input
                                    type="checkbox"
                                    name="course_instructor[]"
                                    value="' . esc_attr( $user->ID ) . '"
                                    id="' . esc_attr( $user->ID ) . '"';
                                    echo in_array( $user->ID, $filtered_instructor ) ? 'checked="checked"' : '';
                                echo '>';
                                
                                echo '<span class="eb-filter-multicheck"></span>';
                                echo esc_html( $user->display_name );
                                echo '<span class="filter-count">(' . esc_html( $count ) . ')</span>';
                            echo '</label>';
                        endif;
                    endforeach;
                endif;
            echo '</div>';
        echo '</div>';
    }

    /**
     * Post Order Filter Options
     *
     * @since 1.0.0
     */
    public static function orderby( $orderby, $course_ordering ) {
        if ( empty( $orderby ) ) :
            $orderby = apply_filters( 'edublink_courses_orderby', array(
                'newest_first'    => __( 'Newest', 'edublink' ),
                'oldest_first'    => __( 'Oldest', 'edublink' ),
                'course_title_az' => __( 'Course Title (a-z)', 'edublink' ),
                'course_title_za' => __( 'Course Title (z-a)', 'edublink' )
            ) );
        endif;

        foreach ( $orderby as $id => $name ) :
            echo '<option 
                value="' . esc_attr( $id ) . '"';
                selected( $course_ordering, $id );
                echo '>';
                echo esc_html( $name );
            echo '</option>';
        endforeach;
    }

    /**
     * print top filter
     *
     * @since 1.0.0
     *
     */
    public static function top_filter( $settings, $query ) {
        if ( 'yes' === $settings['enable_found_text'] || 'grid-list' === $settings['content_type'] || $settings['enable_ordering'] ) :
            echo '<div class="edu-top-sorting-area">';
                if ( 'yes' === $settings['enable_found_text'] ) :
                    echo '<div class="edu-top-sorting-left">';
                        echo '<h6 class="course-found">';
                            if ( 'default' === $settings['found_text_type'] ) :
                                $count_course = sprintf( _n( '%s course', '%s courses', $query->found_posts, 'edublink' ), '<span class="count">' . number_format_i18n( $query->found_posts ) . '</span>' );
                                $found_text = sprintf(
                                    wp_kses(
                                        __( 'We found %s available for you', 'edublink' ),
                                        array( 'span' => [ 'class' => [] ] )
                                    ),
                                    $count_course
                                );
                                $found_text = apply_filters( 'edublink_course_found_text', $found_text, $query );

                                echo wp_kses_post( $found_text );
                            elseif ( 'secondary' === $settings['found_text_type'] ) :
                                self::top_text_secondary( $query );
                            else :
                                self::top_text_alter( $query, $settings );
                            endif;
                        echo '</h6>';
                    echo '</div>';
                endif;

                echo '<div class="edu-top-sorting-right">';
                    if ( 'grid-list' === $settings['content_type'] ) :
                        $active = $settings['default_layout'];
                        $grid_active = 'grid' === $active  ? ' active' : '';
                        $list_active = 'list' === $active ? ' active' : '';

                        echo '<div class="layout-switcher">';
                            echo '<label class="eb-filter-type-text eb-grid-filter-text' . esc_attr( $grid_active ) . '">' . esc_html( $settings['grid_filter_text'] ) . '</label>';
                            echo '<label class="eb-filter-type-text eb-list-filter-text' . esc_attr( $list_active ) . '">' . esc_html( $settings['list_filter_text'] ) . '</label>';
                            echo '<ul class="switcher-btn">';
                                echo '<li><a href="javascript:void(0)" class="eb-filter-layout-trigger eb-grid-filter-trigger' . esc_attr( $grid_active ) . '"><i class="icon-53"></i></a></li>';
                                echo '<li><a hhref="javascript:void(0)" class="eb-filter-layout-trigger eb-list-filter-trigger' . esc_attr( $list_active ) . '"><i class="icon-54"></i></a></li>';
                            echo '</ul>';
                        echo '</div>';
                    endif;

                    if ( 'yes' === $settings['enable_ordering'] ) :
                        echo '<form class="course-top-filter" method="get">';
                            echo '<div class="edu-course-sorting">';
                                echo '<div class="icon"><i class="icon-55"></i></div>';
                                echo '<select class="course-orderby" name="course_serialize">';
                                    if ( ! empty( $settings['order_default_text'] ) ) :
                                        echo '<option value="" class="default-order">' . esc_html( $settings['order_default_text'] ) . '</option>';
                                    endif;
                                    self::orderby( $settings['orderby_types'], $settings['course_ordering'] );  
                                echo '</select>';
                            echo '</div>';
                        echo '</form>';
                    endif;
                echo '</div>';
            echo '</div>';
        endif;
    }  

    /**
     * Course Found Text Alter Example
     *
     * @since 1.0.0
     *
     */
    public static function top_text_alter( $query, $settings ) {
        $total = $query->found_posts;
        if ( 0 === $total ) :
            $result = __( 'There are no available courses!', 'edublink' );	
        elseif ( 1 === $total ) :
            $result = __( 'Showing only one result.', 'edublink' );
        else :
            $courses_per_page = $settings['per_page']['size'] ? $settings['per_page']['size'] : -1;
            $paged = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;

            $from = 1 + ( $paged - 1 ) * $courses_per_page;
            $to   = ( $paged * $courses_per_page > $total ) ? $total : $paged * $courses_per_page;

            if ( $from == $to ) :
                $result = sprintf( __( 'Showing Last Course Of %s Courses', 'edublink' ), $total );
            else :
                $result = sprintf( __( 'Showing %s-%s Of %s Courses', 'edublink' ), '<span class="course-count count-from">' . esc_html( $from ), esc_html( $to ) . '</span>', '<span class="course-count count-total">' . esc_html( $total ) . '</span>' );
            endif;
        endif;
        echo wp_kses_post( $result );
    }

    /**
     * Course Found Text Secondary Example
     *
     * @since 1.0.0
     *
     */
    public static function top_text_secondary( $query ) {
        $count = 0;
        $show = $count + $query->post_count;
        $total = $count + $query->found_posts;
        echo __( 'Showing', 'edublink' ) . ' ' . esc_html( $show ) . ' ' . __( 'out of', 'edublink' ) . ' ' . esc_attr( $total ) . ' ' . __( 'courses', 'edublink' );
    }

    /**
     * print pagination
     *
     * @since 1.0.0
     *
     */
    public static function pagination( $query, $settings ) {
        if ( 'yes' === $settings['pagination'] ) :
            echo '<nav class="edublink-pagination-wrapper eb-custom-pagination">';
                echo '<div class="page-number">';
                    echo paginate_links( array(
                        'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                        'total'        => $query->max_num_pages,
                        'current'      => max( 1, get_query_var( 'paged' ) ),
                        'format'       => '?paged=%#%',
                        'show_all'     => $settings['pagination_show_all'] ? true : false,
                        'end_size'     => $settings['pagination_end_size'] ? $settings['pagination_end_size'] : 1,
                        'mid_size'     => $settings['pagination_mid_size'] ? $settings['pagination_mid_size'] : 2,
                        'prev_text' => '<i class="edublink-pagination-icon icon-west" aria-hidden="true"></i>',
                        'next_text' => '<i class="edublink-pagination-icon icon-east" aria-hidden="true"></i>'
                    ) );
                echo '</div>';
            echo '</nav>';
        endif;
    }  

    /**
     * return grid column
     *
     * @since 1.0.0
     *
     */
    public static function column( $settings ) {
        $grid_large_desktop_column = 12/$settings['large_desktop_grid_columns'];
        $grid_desktop_column = 12/$settings['desktop_grid_columns'];
        $grid_tablet_column  = 12/$settings['tablet_grid_columns'];
        $grid_mobile_column  = 12/$settings['mobile_grid_columns'];
        $grid = 'edublink-col-xl-' . esc_attr( $grid_large_desktop_column ) . ' edublink-col-lg-' . esc_attr( $grid_desktop_column ) . ' edublink-col-md-' . esc_attr( $grid_tablet_column ) . ' edublink-col-sm-' . esc_attr( $grid_mobile_column );
        return $grid;
    }  

    /**
     * return course grid layouts
     *
     * @since 1.0.0
     *
     */
    public static function grid_layout( ) {
        $layout = apply_filters( 'edublink_course_grid_layout', [
            '1'     => __( 'One', 'edublink' ),
            '2'     => __( 'Two', 'edublink' ),
            '3'     => __( 'Three', 'edublink' ),
            '4'     => __( 'Four', 'edublink' ),
            '5'     => __( 'Five', 'edublink' ),
            '6'     => __( 'Six', 'edublink' ),
            '7'     => __( 'Seven', 'edublink' ),
            '8'     => __( 'Eight', 'edublink' ),
            '9'     => __( 'Nine', 'edublink' ),
            '10'    => __( 'Ten', 'edublink' ),
            '11'    => __( 'Eleven', 'edublink' ),
            '12'    => __( 'Twelve', 'edublink' ),
            '13'    => __( 'Thirteen', 'edublink' ),
            '14'    => __( 'Fourteen', 'edublink' ),
            '15'    => __( 'Fifteen', 'edublink' ),
            '16'    => __( 'Sixteen', 'edublink' ),
            '17'    => __( 'Seventeen', 'edublink' ),
            'quran' => __( 'Quran', 'edublink' )
        ] );
        return $layout;
    }  

    /**
     * return array of grid layout keys only
     *
     * @since 1.0.0
     *
     */
    public static function grid_layout_keys() {
        return in_array( wp_unslash( $_GET['course_preset'] ), array_keys( self::grid_layout() ) ) ? wp_unslash( $_GET['course_preset'] ) : 1;
    }

    /**
     * return course list layouts
     *
     * @since 1.0.0
     *
     */
    public static function list_layout( ) {
        $layout = [
            '18' => __( 'List 1', 'edublink' ),
            '19' => __( 'List 2', 'edublink' ),
        ];
        return $layout;
    }  

    /**
     * return course featured image
     *
     * @since 1.0.0
     *
     */
    public static function render_image( $image_id, $settings ) {
        $image_size = $settings['thumb_size_size'];
        if ( 'custom' === $image_size ) :
            $image_src = Group_Control_Image_Size::get_attachment_image_src( $image_id, 'thumb_size', $settings );
        else :
            $image_src = wp_get_attachment_image_src( $image_id, $image_size );
            $image_src = $image_src[0];
        endif;
        return $image_src;
    }

    /**
     * return number of posts created by a user 
     * from a specific post type
     *
     * @since 1.0.0
     *
     */
    public static function user_post_count_by_post_type( $id, $post_type = 'post' ) {
        global $wpdb;
        $where = get_posts_by_author_sql( $post_type, true, $id );
        $count = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts $where" );
        return $count;
    }

    /**
     * Filter Sidebar
     *
     * @since 1.0.0
     *
     */
    public static function sidebar( $settings ) {
        echo '<aside id="secondary" class="widget-area course-filter filter-sidebar-column edublink-col-lg-3">';
            if ( 'yes' === $settings['filter_resposnive_status'] ) :
                echo '<div class="eb-course-filter-toggle">';
                    echo '<span class="eb-course-filter-icon"><i class="ri-side-bar-line"></i></span>';
                    echo $settings['filter_resposnive_toggle_text'] ? esc_html( $settings['filter_resposnive_toggle_text'] ) : __( 'Filter Sidebar', 'edublink' );
                echo '</div>';
            endif;

            echo '<div class="widget-area-wrapper course-filter-form-wrapper">';
                echo '<div class="edublink-filter-close-trigger">';
                    echo '<a href="javascript:void(0);"><i aria-hidden="true" class="icon-73"></i></a>';
                echo '</div>';
                
                echo '<form action="" method="get" class="edublink-course-filtering">';
                    do_action( 'edublink_course_filter_options_before' );
                    self::filter( $settings );
                    do_action( 'edublink_course_filter_options_after' );
                    self::form_button( $settings['apply_filter_button'], $settings['reset_filter_button'] );
                echo '</form>';
            echo '</div>';
        echo '</aside>';
    }

    /**
     * rating filter display
     *
     * @since 1.0.0
     *
     */
    public static function rating( $percent = 80, $text ) {
        return '<div class="eb-course-rating-content">
            <div class="eb-course-review-wrapper">
                <ul class="eb-course-review">
                    <li><span class="icon-23"></span></li>
                    <li><span class="icon-23"></span></li>
                    <li><span class="icon-23"></span></li>
                    <li><span class="icon-23"></span></li>
                    <li><span class="icon-23"></span></li>
                </ul>

                <ul class="eb-course-review eb-review-filled" style="width:' . esc_attr( $percent ) . '%">
                    <li><span class="icon-23"></span></li>
                    <li><span class="icon-23"></span></li>
                    <li><span class="icon-23"></span></li>
                    <li><span class="icon-23"></span></li>
                    <li><span class="icon-23"></span></li>
                </ul>
            </div>
            <span class="eb-rating-text">(' . esc_html( $text ) . ')</span>
        </div>';
    }

    /**
     * return array of LP Course Info
     *
     * @since 1.0.0
     *
     */
    public static function LP_Data() {
        $thumb_size = edublink_set_value( 'lp_course_image_size', 'edublink-post-thumb' ) ? edublink_set_value( 'lp_course_image_size', 'edublink-post-thumb' ) : 'edublink-post-thumb';
        if ( isset( $_GET['thumb_size'] ) ) :
            $thumb_size = wp_unslash( $_GET['thumb_size'] );
        endif;

        $thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $thumb_size );
        if ( isset( $thumb_src ) && ! empty( $thumb_src ) ) :
            $thumb_url = $thumb_src[0];
        else :
            $thumb_url = LP()->image( 'no-image.png' );
        endif;

        if ( ! isset( $style ) ) :
            $style = edublink_set_value( 'lp_course_style', 1 );
        endif;

        if ( isset( $_GET['course_preset'] ) ) :
            $style = self::grid_layout_keys();
        endif;

        $excerpt_length = edublink_set_value( 'lp_course_excerpt_length', 22 );
        if ( isset( $_GET['excerpt_length'] ) ) :
            $excerpt_length = wp_unslash( $_GET['excerpt_length'] );
        endif;

        $button_text = edublink_set_value( 'lp_course_button_text' ) ? edublink_set_value( 'lp_course_button_text' ) : __( 'Enroll Now', 'edublink' );
        if ( isset( $_GET['button_text'] ) ) :
            $button_text = wp_unslash( $_GET['button_text'] );
        endif;

        $course      = \LP_Global::course();
        $course_rate = $ratings = $percent = $featured = '';
        $is_featured = get_post_meta( get_the_ID(), '_lp_featured', true );

        if ( 'yes' === $is_featured ) :
            $featured = __( 'Featured', 'edublink' );
        endif;

        if ( class_exists( 'LP_Addon_Course_Review_Preload' ) ) :
            $course_rate    = learn_press_get_course_rate( get_the_ID() );
            $ratings        = learn_press_get_course_rate_total( get_the_ID() );
            $percent        = ( ! $course_rate ) ? 0 : min( 100, ( round( $course_rate * 2 ) / 2 ) * 20 );
        endif;

        $class_type     = get_post_meta( get_the_ID(), 'edublink_lp_course_class_type', true );
        $features       = get_post_meta( get_the_ID(), 'edublink_course_top_features', true );
        $extra_meta     = get_post_meta( get_the_ID(), 'edublink_lp_course_extra_meta_fields', true ); 
        $duration_main  = get_post_meta( get_the_ID(), '_lp_duration', true );
        $duration       = edublink_lp_course_duration_customize( $duration_main );
        $level          = get_post_meta( get_the_ID(), '_lp_level', true);
        $certificate    =  'on' === get_post_meta( get_the_ID(), 'edublink_lp_course_certificate', true ) ? __( 'Yes', 'edublink' ) : __( 'No', 'edublink' );
        // $discount_price = $course->get_origin_price() != $course->get_price() ? true : false;

        $level = self::lp_level_text( $level );
        
        $data = [
            'thumb_url'      => $thumb_url,
            'style'          => $style,
            'course'         => $course,
            'enrolled'       => $course->get_users_enrolled(),
            'lessons'        => $course->get_curriculum_items( 'lp_lesson' ) ? count( $course->get_curriculum_items( 'lp_lesson' ) ) : 0,
            'level'          => $level,
            'certificate'    => $certificate,
            'cat_item'       => edublink_category_by_id( get_the_ID(), 'course_category' ),
            'language'       => get_post_meta( get_the_ID(), 'edublink_lp_course_language', true ),
            'duration'       => $duration,
            'enable_excerpt' => apply_filters( 'edublink_lp_enable_course_excerpt', true ),
            'excerpt_length' => $excerpt_length,
            'excerpt_end'    => apply_filters( 'edublink_lp_course_excerpt', '...' ),
            // 'discount'       => $discount_price,
            'rate'           => $course_rate,
            'ratings'        => $ratings,
            'percent'        => $percent,
            'extra_meta'     => $extra_meta,
            'features'       => $features,
            'featured'		 => $featured,
            'uniqid'		 => uniqid(),
            'button_text'    => $button_text,
            'class_type'     => $class_type
        ];

        return $data;
    }

    /**
     * return array of LearnDash Course Info
     *
     * @since 1.0.0
     *
     */
    public static function LD_Data() {
        $thumb_size = edublink_set_value( 'ld_course_image_size', 'edublink-post-thumb' ) ? edublink_set_value( 'ld_course_image_size', 'edublink-post-thumb' ) : 'edublink-post-thumb';
        if ( isset( $_GET['thumb_size'] ) ) :
            $thumb_size = wp_unslash( $_GET['thumb_size'] );
        endif;

        $thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $thumb_size );
        if ( isset( $thumb_src ) && ! empty( $thumb_src ) ) :
            $thumb_url = $thumb_src[0];
        else :
            $thumb_url = get_template_directory_uri() . '/assets/images/no-image-found.png';
        endif;

        if ( ! isset( $style ) ) :
            $style = edublink_set_value( 'ld_course_style', 1 );
        endif;

        if ( isset( $_GET['course_preset'] ) ) :
            $style = self::grid_layout_keys();
        endif;

        if ( get_query_var( 'author_name' ) ) :
            $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
            $author_id = $author->ID;
        else :
            $author    = '';
            $author_id = get_the_author_meta( 'ID' );
        endif;
        
        $author_email  = get_the_author_meta( 'email', $author_id );
        $meta_data     = get_post_meta( get_the_ID(), '_ld_custom_meta', true );
        $is_wc_product = defined( 'WC_PLUGIN_FILE' ) && defined( 'LEARNDASH_WOOCOMMERCE_FILE' ) && ! empty( $meta_data['related_product'] );
        
        $lessons = learndash_get_course_steps( get_the_ID(), array( 'sfwd-lessons' ) );
        $topics  = learndash_get_course_steps( get_the_ID(), array( 'sfwd-topic' ) );
        
        $quiz_args = new \wp_Query( array(
            'post_type'  => 'sfwd-quiz',							
            'meta_query' => array(
                array( 
                    'key'   => 'course_id', 
                    'value' => get_the_ID()
                ) 
            )						
        ) );
        
        $excerpt_length = edublink_set_value( 'ld_course_excerpt_length', 12 ) ? edublink_set_value( 'ld_course_excerpt_length', 12 ) : 12;
        if ( isset( $_GET['excerpt_length'] ) ) :
            $excerpt_length = wp_unslash( $_GET['excerpt_length'] );
        endif;
        
        $button_text = edublink_set_value( 'ld_course_button_text' ) ? edublink_set_value( 'ld_course_button_text' ) : __( 'Enroll Now', 'edublink' );
        if ( isset( $_GET['button_text'] ) ) :
            $button_text = wp_unslash( $_GET['button_text'] );
        endif;

        $data = [
            'thumb_url'       => $thumb_url,
            'style'           => $style,
            'author'          => $author,
            'cat_item'        => edublink_category_by_id( get_the_ID(), 'ld_course_category' ),
            'enrolled'        => get_post_meta( get_the_ID(), 'edublink_ld_course_students', true ) ? get_post_meta( get_the_ID(), 'edublink_ld_course_students', true ) : 0,
            'level'           => get_post_meta( get_the_ID(), 'edublink_ld_course_level', true ),
            'duration'        => get_post_meta( get_the_ID(), 'edublink_ld_course_duration', true ),
            'class_type'      => get_post_meta( get_the_ID(), 'edublink_ld_course_class_type', true ),
            'lessons'         => count( $lessons ),
            'topics'          => count( $topics ),
            'quizzes'         => $quiz_args->post_count,
            'course_options'  => get_post_meta( get_the_ID(), '_sfwd-courses', true ),
            'meta_data'       => $meta_data,
            'author_email'    => get_the_author_meta( 'email', $author_id ),
            'is_wc_product'   => $is_wc_product,
            'features'        => get_post_meta( get_the_ID(), 'edublink_course_top_features', true ),
            'button_text'     => $button_text,
            'enable_excerpt'  => true,
            'excerpt_length'  => $excerpt_length,
            'rating'		  => \EduBlink_LD_Course_Review::get_average_ratings( get_the_ID() ),
            'total_rating'    => \EduBlink_LD_Course_Review::get_all_reviews( get_the_ID() ),
            'uniqid'		  => uniqid(),
            'excerpt_end'     => apply_filters( 'edublink_ld_course_excerpt_end', '...' )
        ];
        
        return $data;
    }

    /**
     * return array of Tutor LMS Course Info
     *
     * @since 1.0.0
     *
     */
    public static function TL_Data() {
        global $post, $authordata;
        $thumb_size = edublink_set_value( 'tl_course_image_size' ) ? edublink_set_value( 'tl_course_image_size' ) : 'edublink-post-thumb';
        if ( isset( $_GET['thumb_size'] ) ) :
            $thumb_size = wp_unslash( $_GET['thumb_size'] );
        endif;

        $thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $thumb_size );
        if ( isset( $thumb_src ) && ! empty( $thumb_src ) ) :
            $thumb_url = $thumb_src[0];
        else :
            $thumb_url = get_template_directory_uri() . '/assets/images/no-image-found.png';
        endif;

        if ( ! isset( $style ) ) :
            $style = edublink_set_value( 'tl_course_style', 1 );
        endif;

        if ( isset( $_GET['course_preset'] ) ) :
            $style = self::grid_layout_keys();
        endif;
        
        $excerpt_length = edublink_set_value( 'tl_course_excerpt_length', 12 ) ? edublink_set_value( 'tl_course_excerpt_length', 12 ) : 12;
        if ( isset( $_GET['excerpt_length'] ) ) :
            $excerpt_length = wp_unslash( $_GET['excerpt_length'] );
        endif;
        
        $button_text = edublink_set_value( 'tl_course_button_text' ) ? edublink_set_value( 'tl_course_button_text' ) : __( 'Enroll Now', 'edublink' );
        if ( isset( $_GET['button_text'] ) ) :
            $button_text = wp_unslash( $_GET['button_text'] );
        endif;

        $is_purchasable = tutor_utils()->is_course_purchasable();
        $price          = apply_filters( 'get_tutor_course_price', null, get_the_ID() );
        if ( $is_purchasable && $price ) :
            $price = $price;
        else :
            $price = __( 'Free', 'edublink' );
        endif;

        $course_rating   = tutor_utils()->get_course_rating();
        $ratings_average = $course_rating->rating_avg;
        $total_ratings   = $course_rating->rating_count;
        $percent         = ( ! $ratings_average ) ? 0 : min( 100, ( round( $ratings_average * 2 ) / 2 ) * 20 );
        $features        = get_post_meta( get_the_ID(), 'edublink_course_top_features', true );
        $class_type      = get_post_meta( get_the_ID(), 'edublink_tl_course_class_type', true );
        $language        = get_post_meta( get_the_ID(), 'edublink_tl_course_language', true );
		$extra_meta      = get_post_meta( get_the_ID(), 'edublink_tl_course_extra_meta_fields', true ); 
        $certificate     =  'on' === get_post_meta( get_the_ID(), 'edublink_tl_course_certificate', true ) ? __( 'Yes', 'edublink' ) : __( 'No', 'edublink' );

        $data = [
            'thumb_url'        => $thumb_url,
            'style'            => $style,
            'instructors'      => tutor_utils()->get_instructors_by_course(),
            'lessons'          => tutor_utils()->get_lesson_count_by_course( get_the_ID() ),
            'duration'         => get_tutor_course_duration_context(),
            'disable_enrolled' => get_tutor_option( 'disable_course_total_enrolled' ),
            'enrolled'         => tutor_utils()->count_enrolled_users_by_course(),
            'last_updated'     => get_the_modified_date( get_option( 'date_format' ) ),
            'cat_item'         => edublink_category_by_id( get_the_ID(), 'course-category' ),
            'review_status'    => get_tutor_option( 'enable_course_review' ),
            'price'            => $price,
            'ratings_average'  => $ratings_average,
            'total_ratings'	   => $total_ratings,
            'percent'		   => $percent,
            'level'  		   => get_tutor_course_level(),
            'author'		   => $post->post_author,
            'author_name'	   => $authordata->display_name,
            'author_url'       => tutor_utils()->profile_url( $authordata->ID ),
            'features'         => $features,
            'button_text'      => $button_text,
            'class_type'       => $class_type,
            'language'         => $language,
            'enable_excerpt'   => true,
            'excerpt_length'   => $excerpt_length,
            'certificate'      => $certificate,
            'extra_meta'       => $extra_meta,
            'uniqid'		   => uniqid(),
            'excerpt_end'      => apply_filters( 'edublink_tl_course_excerpt_end', '...' )
        ];
        
        return $data;
    }

    /**
     * return array of Lifter LMS Course Info
     *
     * @since 1.0.0
     *
     */
    public static function LL_Data() {
        global $post;
        $thumb_size = edublink_set_value( 'll_course_image_size', 'edublink-post-thumb' ) ? edublink_set_value( 'll_course_image_size', 'edublink-post-thumb' ) : 'edublink-post-thumb';
        if ( isset( $_GET['thumb_size'] ) ) :
            $thumb_size = $_GET['thumb_size'];
        endif;

        $thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $thumb_size );
        if ( isset( $thumb_src ) && ! empty( $thumb_src ) ) :
            $thumb_url = $thumb_src[0];
        else :
            $thumb_url = get_template_directory_uri() . '/assets/images/no-image-found.png';
        endif;

        if ( ! isset( $style ) ) :
            $style = edublink_set_value( 'll_course_style', 1 );
        endif;

        if ( isset( $_GET['course_preset'] ) ) :
            $style = self::grid_layout_keys();
        endif;

        if ( get_query_var( 'author_name' ) ) :
            $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
            $author_id = $author->ID;
        else :
            $author    = '';
            $author_id = get_the_author_meta( 'ID' );
        endif;

        $author_email  = get_the_author_meta( 'email', $author_id );

        $excerpt_length = edublink_set_value( 'll_course_excerpt_length', 12 ) ? edublink_set_value( 'll_course_excerpt_length', 12 ) : 12;
        if ( isset( $_GET['excerpt_length'] ) ) :
            $excerpt_length = (int)$_GET['excerpt_length'];
        endif;

        $button_text = edublink_set_value( 'll_course_button_text' ) ? edublink_set_value( 'll_course_button_text' ) : __( 'Enroll Now', 'edublink' );
        if ( isset( $_GET['button_text'] ) ) :
            $button_text = $_GET['button_text'];
        endif;

        $course = new \LLMS_Course( $post );
        $data = [
            'thumb_url'      => $thumb_url,
            'style'          => $style,
            'author'         => $author,
            'cat_item'       => edublink_category_by_id( get_the_ID(), 'course_cat' ),
            'enrolled'       => $course->get_student_count(),
            'level'          => $course->get_difficulty(),
            'duration'       => $course->get( 'length' ),
            'lessons'        => $course->get_lessons_count(),
            'class_type'     => get_post_meta( get_the_ID(), 'edublink_ll_course_class_type', true ),
            'author_email'   => get_the_author_meta( 'email', $author_id ),
            'features'       => get_post_meta( get_the_ID(), 'edublink_course_top_features', true ),
            'button_text'    => $button_text,
            'enable_excerpt' => true,
            'excerpt_length' => $excerpt_length,
            'uniqid'		 => uniqid(),
            'excerpt_end'    => '...'
        ];

        return $data;
    }

    /**
     * return array of MasterStudy LMS Course Info
     *
     * @since 1.0.0
     *
     */
    public static function MS_Data() {
        global $post;

        $thumb_size = edublink_set_value( 'ms_course_image_size', 'edublink-post-thumb' ) ? edublink_set_value( 'ms_course_image_size', 'edublink-post-thumb' ) : 'edublink-post-thumb';
        if ( isset( $_GET['thumb_size'] ) ) :
            $thumb_size = $_GET['thumb_size'];
        endif;

        $thumb_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), $thumb_size );
        if ( isset( $thumb_src ) && ! empty( $thumb_src ) ) :
            $thumb_url = $thumb_src[0];
        else :
            $thumb_url = get_template_directory_uri() . '/assets/images/no-image-found.png';
        endif;

        if ( ! isset( $style ) ) :
            $style = edublink_set_value( 'ms_course_style', 1 );
        endif;

        if ( isset( $_GET['course_preset'] ) ) :
            $style = Filter::grid_layout_keys();
        endif;

        if ( get_query_var( 'author_name' ) ) :
            $author = get_user_by( 'slug', get_query_var( 'author_name' ) );
            $author_id = $author->ID;
        else :
            $author    = '';
            $author_id = get_the_author_meta( 'ID' );
        endif;

        $author_email  = get_the_author_meta( 'email', $author_id );

        $excerpt_length = edublink_set_value( 'ms_course_excerpt_length', 12 ) ? edublink_set_value( 'ms_course_excerpt_length', 12 ) : 12;
        if ( isset( $_GET['excerpt_length'] ) ) :
            $excerpt_length = (int)$_GET['excerpt_length'];
        endif;

        $button_text = edublink_set_value( 'ms_course_button_text' ) ? edublink_set_value( 'ms_course_button_text' ) : __( 'Enroll Now', 'edublink' );
        if ( isset( $_GET['button_text'] ) ) :
            $button_text = $_GET['button_text'];
        endif;

        $meta = \STM_LMS_Helpers::parse_meta_field( get_the_ID() );
        $curriculum_info = \STM_LMS_Course::curriculum_info( get_the_ID() );
        $rating  = get_post_meta( get_the_ID(), 'course_marks', true );
        $rates   = \STM_LMS_Course::course_average_rate( $rating );
        $extra_meta  = get_post_meta( get_the_ID(), 'edublink_ms_course_extra_meta_fields', true ); 
        $buttons  = get_post_meta( get_the_ID(), 'edublink_ms_course_buttons', true ); 
        $certificate =  'on' === get_post_meta( get_the_ID(), 'edublink_ms_course_certificate', true ) ? __( 'Yes', 'edublink' ) : __( 'No', 'edublink' );

        $data = [
            'thumb_url'      => $thumb_url,
            'style'          => $style,
            'author'         => $author,
            'cat_item'       => edublink_category_by_id( get_the_ID(), 'stm_lms_course_taxonomy' ),
            'language'       => get_post_meta( get_the_ID(), 'edublink_ms_course_language', true ),
            'meta_info'      => $meta,
            'enrolled'       => $meta['current_students'],
            'views'          => $meta['views'],
            'level'          => $meta['level'],
            'certificate'    => $certificate,
            'duration'       => $meta['duration_info'],
            'video_duration' => $meta['video_duration'],
            'class_type'     => get_post_meta( get_the_ID(), 'edublink_ms_course_class_type', true ),
            'lessons'        => $curriculum_info['lessons'],
            'author_email'   => get_the_author_meta( 'email', $author_id ),
            'features'       => get_post_meta( get_the_ID(), 'edublink_course_top_features', true ),
            'button_text'    => $button_text,
            'enable_excerpt' => true,
            'excerpt_length' => $excerpt_length,
            'extra_meta'     => $extra_meta,
            'buttons'        => $buttons,
            'uniqid'		 => uniqid(),
            'average'        => $rates['average'],
            'percent'        => $rates['percent'],
            'excerpt_end'    => '...'
        ];

        return $data;
    }
}