<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package EduBlink
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'edublink-single-post edu-blog' ); ?>>
	<?php
	/**
	* edublink_single_post_thumbnail_before hook
	*
	* @hooked edublink_single_post_thumbnail_before_content - 10
	*/
	do_action( 'edublink_single_post_thumbnail_before' );
	
	edublink_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		if ( is_single() ) :
			/**
			 * edublink_single_post_before hook
			 *
			 */
			do_action( 'edublink_single_post_before' );

			the_content( sprintf(
				/* translators: %s: Name of current post. Only visible to screen readers */
				wp_kses( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'edublink' ), array( 'span' => array( 'class' => array() ) ) ),
				get_the_title()
			) );

			if ( function_exists( 'edublink_link_pages' ) ) :
				edublink_link_pages( array(
					'before' => '<nav class="edublink-theme-page-links">' . __( 'Pages:', 'edublink' ) . '<ul class="pager">',
					'after'  => '</ul></nav>',
				) );
			else :
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'edublink' ),
					'after'  => '</div>',
				) );
			endif;
			
			/**
			 * edublink_single_post_after hook
			 *
			 * @hooked edublink_single_post_after_cats_social_share - 10
			 * @hooked edublink_single_post_after_author_bio - 15
			 * @hooked edublink_post_nav_prev_next - 20
			 */
			do_action( 'edublink_single_post_after' );
		else :
			the_excerpt();
		endif;
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php edublink_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
