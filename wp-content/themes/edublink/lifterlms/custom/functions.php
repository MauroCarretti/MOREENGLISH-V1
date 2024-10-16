<?php

require_once get_template_directory() . '/lifterlms/custom/helper-class.php';

remove_action( 'lifterlms_single_course_after_summary', 'lifterlms_template_single_meta_wrapper_start', 5 );
remove_action( 'lifterlms_single_course_after_summary', 'lifterlms_template_single_meta_wrapper_end', 50 );

remove_action( 'lifterlms_single_course_after_summary', 'lifterlms_template_single_length', 10 );
remove_action( 'lifterlms_single_course_after_summary', 'lifterlms_template_single_difficulty', 20 );
remove_action( 'lifterlms_single_course_after_summary', 'lifterlms_template_single_course_categories', 30 );
remove_action( 'lifterlms_single_course_after_summary', 'lifterlms_template_single_course_tags', 35 );
remove_action( 'lifterlms_single_course_after_summary', 'lifterlms_template_course_author', 40 );

remove_action( 'lifterlms_sidebar', 'lifterlms_get_sidebar', 10 );

add_action( 'lifterlms_single_course_after_summary', 'edublink_ll_course_author', 100 );

add_filter( 'lifterlms_show_page_title', '__return_false' );

/**
 * Course Search Post Type
 */
add_filter( 'edublink_course_search_post_type', 'edublink_ll_course_search_post_type' );
if ( ! function_exists( 'edublink_ll_course_search_post_type' ) ) :
	function edublink_ll_course_search_post_type() {
		return 'course';
	}
endif;

/**
 * Header Course Category Slug
 */
add_filter( 'edublink_header_course_lms_cat_slug', 'edublink_header_course_ll_cat_slug' );
if ( ! function_exists( 'edublink_header_course_ll_cat_slug' ) ) :
	function edublink_header_course_ll_cat_slug() {
		return 'course_cat';
	}
endif;

/**
 * Lifter LMS specific scripts & stylesheets.
 *
 * @return void
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'edublink_ll_scripts' ) ) :
	function edublink_ll_scripts() {
		wp_enqueue_style( 'edublink-ll-style', get_template_directory_uri() . '/assets/css/lifter.css', array(), EDUBLINK_THEME_VERSION );
		if ( is_singular( 'course' ) ) :
			wp_enqueue_style( 'jquery-fancybox' );
			wp_enqueue_script( 'jquery-fancybox' );
		endif;
	}
endif;
add_action( 'wp_enqueue_scripts', 'edublink_ll_scripts' );


/**
 * post_class extends for Lifter LMS courses
 * 
 * @since 1.0.0
 */
if ( ! function_exists( 'edublink_lifter_course_class' ) ) :
    function edublink_lifter_course_class( $default = array() ) {
		$terms      = get_the_terms( get_the_ID(), 'course_cat' );
		$terms_html = array();
		if ( $terms ) :
			foreach ( $terms as $term ) :
				$terms_html[] = $term->slug;
			endforeach;
		endif;
		$all_classes = array_merge( $terms_html, $default );
		$classes     = apply_filters( 'edublink_lifter_course_class', $all_classes );
        post_class( $classes );
    }
endif;

/**
 * Add html span tag to wrap decimal separator.
 */
add_filter( 'llms_price', 'edublink_ll_course_price_decimal_separator' );
if ( ! function_exists( 'edublink_ll_course_price_decimal_separator' ) ) :
	function edublink_ll_course_price_decimal_separator( $origin_price ) {
		$decimal_number    = get_lifterlms_decimals();
		$decimal_separator = get_lifterlms_decimal_separator();

		if ( $decimal_number > 0 && ! empty( $decimal_separator ) ) :
			$decimal_position = strpos( $origin_price, $decimal_separator );
			$decimal_part = substr( $origin_price, $decimal_position, $decimal_number + 1 );
			$decimal_html = '<span class="decimal-separator">' . $decimal_part . '</span>';
			$origin_price = str_replace( $decimal_part, $decimal_html, $origin_price );
		endif;
		return $origin_price;
	}
endif;

/**
 * Right Side Course Preview
 */
if ( ! function_exists( 'edublink_ll_course_preview' ) ) :
	function edublink_ll_course_preview() {
		$preview_video = get_post_meta( get_the_ID(), 'edublink_ll_course_preview_video_link', true );
		$preview_image = get_post_meta( get_the_ID(), 'edublink_ll_course_preview_image', true );
		$video_status = edublink_set_value( 'll_course_preview_video_popup', true );

		if ( empty( $preview_image ) ) :
			$preview_image = apply_filters( 'edublink_ll_course_default_preview_image', esc_url( get_template_directory_uri() . '/assets/images/course-preview.jpg' ) );
		endif;
		echo '<div class="edublink-course-details-card-preview" style="background-image: url(' . esc_url( $preview_image ) . ')">';
			if ( $video_status ) :
				echo '<div class="edublink-course-video-preview-area">';
					if ( ! empty( $preview_video ) ) :
						echo '<a data-fancybox href="' . esc_url( $preview_video ) . '" class="edublink-course-video-popup">';
							echo '<i class="icon-18"></i>';
						echo '</a>';
					endif;
				echo '</div>';
			endif;
		echo '</div>';
	}
endif;

/**
 * Lifter LMS Course Details Header
 *
 */
if( ! function_exists( 'edublink_ll_course_details_header' ) ) :
	function edublink_ll_course_details_header( $style ) {
		switch ( $style ):
			case 1:
				edublink_ll_course_details_header_default_style();
				break;
			case 2:
				edublink_ll_course_details_header_default_style( 'dark-version' );
				break;
			case 3:
				edublink_ll_course_details_header_default_style();
				break;
			case 4:
				edublink_ll_course_details_header_style_2();
				break;
			case 5:
				edublink_ll_course_details_header_default_style( 'style-5' );
				break;
			case 6:
				edublink_ll_course_details_header_default_style( 'style-6' );
				break;
			default:
			edublink_ll_course_details_header_default_style();
		endswitch;
	}
endif;

/**
 * Lifter LMS Course Details Header Default Style
 *
 */
if( ! function_exists( 'edublink_ll_course_details_header_default_style' ) ) :
	function edublink_ll_course_details_header_default_style( $style = null ) {
		$style = $style ? ' ' . esc_attr( $style ) : '';
		echo '<div class="edublink-course-page-header' . esc_attr( $style ) . '">';
			echo '<div class="eb-course-header-breadcrumb">';
				echo '<div class="' . esc_attr( apply_filters( 'edublink_breadcrumb_container_class', 'edublink-container' ) ) . '">';
					do_action( 'edublink_breadcrumb' );
				echo '</div>';
			echo '</div>';

			echo '<div class="eb-course-header-breadcrumb-content">';
				echo '<div class="' . esc_attr( apply_filters( 'edublink_breadcrumb_container_class', 'edublink-container' ) ) . '">';
					echo '<div class="edublink-course-breadcrumb-inner">';
						echo '<div class="edublink-course-title">';
							echo '<h1 class="entry-title">';
								the_title(); 
							echo '</h1>';
						echo '</div>';
						
						echo '<div class="edublink-course-header-meta">';
							edublink_breadcrumb_ll_course_meta();
						echo '</div>';
					echo '</div>';
				echo '</div>';
				if ( ' style-6' === $style  ) :
					edublink_course_breadcrumb_header_6_shapes();
				endif;
			echo '</div>';
			
			if ( ' style-6' !== $style ) :
				edublink_breadcrumb_shapes();
			endif;
		echo '</div>';
	}
endif;

/**
 * Lifter LMS Course Details Header Style 2
 *
 */
if( ! function_exists( 'edublink_ll_course_details_header_style_2' ) ) :
	function edublink_ll_course_details_header_style_2() {
		$has_bg_image = '';
		$breadcrumb_img   = edublink_set_value( 'll_course_breadcrumb_image' );
		$title = get_the_title();
		$style = array();
		
		if ( isset( $breadcrumb_img['url'] ) && ! empty( $breadcrumb_img['url'] ) ) :
			$style[] = 'background-image:url(\'' . esc_url( $breadcrumb_img['url'] ) . '\' )';
			$has_bg_image = 'edublink-breadcrumb-has-bg course-header-4';
		else :
			$has_bg_image = 'edublink-breadcrumb-empty-bg course-header-4';
		endif;

		$extra_style = ! empty( $style ) ? ' style="' . implode( "; ", $style ) . '"' : "";

		edublink_breadcrumb_style_1( $title, $has_bg_image, $extra_style );
	}
endif;

/**
 * Lifter LMS Course Breaecrumb Meta
 *
 */
if( ! function_exists( 'edublink_breadcrumb_ll_course_meta' ) ) :
	function edublink_breadcrumb_ll_course_meta() {
		global $post;
		$author_id = $post->post_author;
		$category = edublink_category_by_id( get_the_ID(), 'course_cat' );
		echo '<ul class="eb-course-header-meta-items">';
			echo '<li class="instructor">';
				echo '<i class="icon-58"></i>';
				_e( 'By', 'edublink' );
				echo ' ';
				echo get_the_author_meta( 'display_name', $author_id );
			echo '</li>';

			if ( $category ) :
				echo '<li class="category"><i class="icon-59"></i>' . wp_kses_post( $category ) . '</li>';
			endif;
		echo '</ul>';
	}
endif;

/**
 * Lifter LMS Course Details 
 * Header Style 6 Shapes
 */
if( ! function_exists( 'edublink_course_breadcrumb_header_6_shapes' ) ) :
	function edublink_course_breadcrumb_header_6_shapes() {
		$status = apply_filters( 'edublink_breadcrumb_shape', true );

		if ( $status ) :
			echo '<div class="shape-dot-wrapper shape-wrapper edublink-d-xl-block edublink-d-none">';
				echo '<div class="shape-image eb-mouse-animation shape-a">';
					echo '<span data-depth="2">';
						echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/shapes/breadcrumb-shape-1.png' ) . '" alt="Breadcrumb Abstract Shape">';
					echo '</span>';
				echo '</div>';

				echo '<div class="shape-image shape-b">';
					echo '<span>';
						echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/shapes/breadcrumb-shape-4.png' ) . '" alt="Breadcrumb Abstract Shape">';
					echo '</span>';
				echo '</div>';

				echo '<div class="shape-image eb-mouse-animation shape-c">';
					echo '<span data-depth="2">';
						echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/shapes/breadcrumb-shape-5.png' ) . '" alt="Breadcrumb Abstract Shape">';
					echo '</span>';
				echo '</div>';

				echo '<div class="shape-image eb-mouse-animation shape-d">';
					echo '<span data-depth="-2">';
						echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/shapes/breadcrumb-shape-6.png' ) . '" alt="Breadcrumb Abstract Shape">';
					echo '</span>';
				echo '</div>';
			echo '</div>';
		endif;
	}
endif;

/**
 * Right Side Content
 */
if ( ! function_exists( 'edublink_ll_course_content_sidebar' ) ) :
	function edublink_ll_course_content_sidebar() {
		$style = edublink_set_value( 'll_course_details_style', '1' );
		$preview_thumb = edublink_set_value( 'll_course_preview_thumb', true );
		$heading_status = edublink_set_value( 'll_course_sidebar_heading_status', true );
		$social_share_status = edublink_set_value( 'll_course_sidebar_social_share', true );
		$heading = edublink_set_value( 'll_course_sidebar_heading_text', __( 'Course Includes:', 'edublink' ) );
		$extra_class = $preview_thumb ? 'enable' : 'disable';

		if ( isset( $_GET['course_details'] ) ) :
			$style = in_array( $_GET['course_details'], array( 1, 2, 3, 4, 5, 6 ) ) ? $_GET['course_details'] : 1;
		endif;

		echo '<div class="edublink-course-details-sidebar eb-ld-course-sidebar eb-course-single-' . esc_attr( $style ) . ' sidebar-' . esc_attr( $extra_class ) . '">';
			echo '<div class="edublink-course-details-sidebar-inner">';
				if ( $preview_thumb && '4' != $style ) :
					edublink_ll_course_preview();
				endif;

				echo '<div class="edublink-course-details-sidebar-content">';
					if ( $heading_status && $heading ) :
						echo '<h4 class="widget-title">' . esc_html( $heading ). '</h4>';
					endif;

					do_action( 'edublink_ll_course_sidebar_before_meta' );

					edublink_ll_course_meta_data();

					do_action( 'edublink_ll_course_sidebar_after_meta' );

					if ( $social_share_status ) :
						$social_heading = edublink_set_value( 'll_course_sidebar_social_share_heading', __( 'Share On:', 'edublink' ) );
						echo '<div class="edublink-single-event-social-share">';
							echo '<h4 class="share-title">' . esc_html( $social_heading ) . '</h4>';
							get_template_part( 'template-parts/social', 'share' );
						echo '</div>';
					endif;

					do_action( 'edublink_ll_course_sidebar_after_social_share' );
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
endif;


/**
 * Right Side Meta Data
 */
if ( ! function_exists( 'edublink_ll_course_meta_data' ) ) :
	function edublink_ll_course_meta_data() {
		global $post;
		$course = new \LLMS_Course( $post );
		$enrolled  = $course->get_student_count();
		$duration  = $course->get( 'length' );
		$language  = get_post_meta( get_the_ID(), 'edublink_ll_course_language', true );
		$lessons   = $course->get_lessons_count();
		$extra_meta = get_post_meta( get_the_ID(), 'edublink_ll_course_extra_meta_fields', true ); 
		$buttons = get_post_meta( get_the_ID(), 'edublink_ll_course_buttons', true ); 
		$certificate   = 'on' === get_post_meta( get_the_ID(), 'edublink_ll_course_certificate', true ) ? __( 'Yes', 'edublink' ) : __( 'No', 'edublink' );	

		echo '<ul class="edublink-course-meta-informations">';
			do_action( 'edublink_ll_course_meta_before' );

			if ( edublink_set_value( 'll_course_sidebar_price_status', true ) ) :
				$price_label = edublink_set_value( 'll_course_sidebar_price_label' ) ? edublink_set_value( 'll_course_sidebar_price_label' ) : __( 'Price:', 'edublink' );
				echo '<li class="edublink-course-details-features-item course-price">';
					echo '<span class="edublink-course-feature-item-label">';
						echo '<i class="icon-60"></i>';
						echo esc_html( $price_label );
					echo '</span>';

					echo '<span class="edublink-course-feature-item-value">';
						echo wp_kses_post( EduBlink_Ll_Helper::course_price() );
					echo '</span>';
				echo '</li>';
			endif;

			if ( edublink_set_value( 'll_course_instructor', true ) ) :
				$instructor_label = edublink_set_value( 'll_course_instructor_label' ) ? edublink_set_value( 'll_course_instructor_label' ) : __( 'Instructor:', 'edublink' );
				echo '<li class="edublink-course-details-features-item course-instructor">';
					echo '<span class="edublink-course-feature-item-label">';
						echo '<i class="icon-62"></i>';
						echo esc_html( $instructor_label );
					echo '</span>';

					echo '<span class="edublink-course-feature-item-value">';
						echo wp_kses_post( get_the_author() );
					echo '</span>';
				echo '</li>';
			endif;

			if ( ! empty( $duration ) && edublink_set_value( 'll_course_duration', true ) ) :
				$duration_label = edublink_set_value( 'll_course_duration_label' ) ? edublink_set_value( 'll_course_duration_label' ) : __( 'Duration:', 'edublink' );
				echo '<li class="edublink-course-details-features-item course-duration">';
					echo '<span class="edublink-course-feature-item-label">';
						echo '<i class="icon-61"></i>';
						echo esc_html( $duration_label );
					echo '</span>';

					echo '<span class="edublink-course-feature-item-value">';
						echo esc_html( $duration );
					echo '</span>';
				echo '</li>';
			endif;

			if ( edublink_set_value( 'll_course_lessons', true ) ) :
				$lessons_label = edublink_set_value( 'll_course_lessons_label' ) ? edublink_set_value( 'll_course_lessons_label' ) : __( 'Lessons:', 'edublink' );
				echo '<li class="edublink-course-details-features-item course-lesson">';
					echo '<span class="edublink-course-feature-item-label">';
						echo '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/icons/books.svg' ) . '" class="edublink-course-sidebar-img-icon">';
						echo esc_html( $lessons_label );
					echo '</span>';

					echo '<span class="edublink-course-feature-item-value">';
						echo esc_html( $lessons );
					echo '</span>';
				echo '</li>';
			endif;

			if ( edublink_set_value( 'll_course_students', true ) && $enrolled ) :
				$students_label = edublink_set_value( 'll_course_students_label' ) ? edublink_set_value( 'll_course_students_label' ) : __( 'Students:', 'edublink' );
				echo '<li class="edublink-course-details-features-item course-student">';
					echo '<span class="edublink-course-feature-item-label">';
						echo '<i class="icon-63"></i>';
						echo esc_html( $students_label );
					echo '</span>';

					echo '<span class="edublink-course-feature-item-value">';
						echo esc_html( $enrolled );
					echo '</span>';
				echo '</li>';
			endif;

			if ( ! empty( $language ) && edublink_set_value( 'll_course_language', true ) ) :
				$language_label = edublink_set_value( 'll_course_language_label' ) ? edublink_set_value( 'll_course_language_label' ) : __( 'Language:', 'edublink' );
				echo '<li class="edublink-course-details-features-item course-language">';
					echo '<span class="edublink-course-feature-item-label">';
						echo '<i class="icon-59"></i>';
						echo esc_html( $language_label );
					echo '</span>';

					echo '<span class="edublink-course-feature-item-value">';
						echo esc_html( $language );
					echo '</span>';
				echo '</li>';
			endif;

			if ( ! empty( $certificate ) && edublink_set_value( 'll_course_certificate', true ) ) :
				$certificate_label = edublink_set_value( 'll_course_certificate_label' ) ? edublink_set_value( 'll_course_certificate_label' ) : __( 'Certifications:', 'edublink' );
				echo '<li class="edublink-course-details-features-item course-certificate">';
					echo '<span class="edublink-course-feature-item-label">';
						echo '<i class="icon-64"></i>';
						echo esc_html( $certificate_label );
					echo '</span>';

					echo '<span class="edublink-course-feature-item-value">';
						echo esc_html( $certificate );
					echo '</span>';
				echo '</li>';
			endif;

			if ( isset( $extra_meta ) && is_array( $extra_meta ) ) :
				foreach ( $extra_meta as $key => $meta ) :
					if ( $meta['label'] ) :
						$wrapper_class = '';
						if ( isset( $meta['wrapper_class'] ) && ! empty( $meta['wrapper_class'] ) ) :
							$wrapper_class = ' ' . $meta['wrapper_class'];
						endif;
						echo '<li class="edublink-course-details-features-item' . esc_attr( $wrapper_class ) . '">';
							echo '<span class="edublink-course-feature-item-label">';
								if ( isset( $meta['icon_class'] ) ) :
									echo '<i class="' . esc_attr( $meta['icon_class'] ) . '"></i>';
								else :
									echo '<i class="ri-check-fill"></i>';
								endif;
								echo esc_html( $meta['label'] );
							echo '</span>';

							if ( ! empty( $meta['value'] ) ) :
								echo '<span class="edublink-course-feature-item-value">' . esc_html( $meta['value'] ) . '</span>';
							endif;
						echo '</li>';
					endif;
				endforeach;
			endif;

			if ( isset( $buttons ) && is_array( $buttons ) ) :
				echo '<div class="edublink-course-details-sidebar-buttons">';
					foreach ( $buttons as $key => $button ) :
						$button_class = '';
						$href = '#';
						$target = '_self';
						if ( isset( $button['button_class'] ) && ! empty( $button['button_class'] ) ) :
							$button_class = ' ' . $button['button_class'];
						endif;
						if ( isset( $button['button_url'] ) ) :
							$href = $button['button_url'];
						endif;
						
						if ( isset( $button['button_tab_type'] ) && 'on' === $button['button_tab_type'] ) :
							$target = '_blank';
						endif;

						if ( $button['button_text'] ) :
							echo '<a class="course-sidebar-btn' . esc_attr( $button_class ) . '" href="' . esc_url( $href ) . '" target="' . esc_attr( $target ) . '">';
								echo esc_html( $button['button_text'] );
							echo '</a>';
						endif;
					endforeach;
				echo '</div>';
			endif;

			do_action( 'edublink_ll_course_meta_after' );
		echo '</ul>';
	}
endif;

/**
 * Related Courses
 */
if ( ! function_exists( 'edublink_ll_related_courses' ) ) :
	function edublink_ll_related_courses() {
		$related_courses = edublink_set_value( 'll_related_courses', true );
		if ( isset( $_GET['disable_related_courses'] ) ) :
			$related_courses = false;
		endif;

		if ( $related_courses ) :
			llms_get_template( 'custom/courses-related.php' );
		endif;
	}
endif;

/**
 * Course Author
 */
if ( ! function_exists( 'edublink_ll_course_author' ) ) :
	function edublink_ll_course_author() {
		$user_id = get_the_author_meta( 'ID' );
		$job  = get_the_author_meta( 'edublink_job', $user_id );
		if ( edublink_set_value( 'll_course_author_box', true ) ) :
			echo '<div class="eb-course-author-box eb-ll-course-author-box edublink-course-author-wrapper">';
				echo '<div class="edublink-course-author-thumb">';
					echo get_avatar( get_the_author_meta( 'ID' ), 350 );
				echo '</div>';

				echo '<div class="edublink-course-author-details">';
					echo '<div class="edublink-author-bio-name">';
						echo '<h5>' . esc_html( get_the_author_meta( 'display_name', $user_id ) ) . '</h5>';
						// echo '<h5>' . esc_html( get_the_author() ) . '</h5>';
					echo '</div>';

					if( $job ) :
						echo '<div class="edublink-author-bio-designation">';
							echo '<span>' . wp_kses_post( $job ) . '</span>';
						echo '</div>';
					endif;

					echo '<div class="edublink-author-bio-details">';
						echo wpautop( wp_kses_post( get_the_author_meta( 'description' ) ) );
					echo '</div>';
					
					echo '<div class="edublink-author-social-info">';
						edublink_user_social_icons( get_the_author_meta( 'ID' ) );
					echo '</div>';
				echo '</div>';
			echo '</div>';
		endif;
	}
endif;