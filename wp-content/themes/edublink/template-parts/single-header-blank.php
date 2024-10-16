<?php
/**
 * The template for displaying single post with Header & Footer blank
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package EduBlink
 */

get_header( 'blank' );
	echo '<div id="page" class="site">';
		echo '<a class="skip-link screen-reader-text" href="#content">' . __( 'Skip to content', 'edublink' ) . '</a>';
		echo '<div id="content" class="site-content">';
			while ( have_posts() ) : the_post();
				the_content();
			endwhile;
		echo '</div>';
	echo '</div>';
get_footer( 'blank' );