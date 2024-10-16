<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package EduBlink
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'edublink-single-page' ); ?>>

	<?php edublink_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		the_content();
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
		?>
	</div><!-- .entry-content -->

	<?php 
	$page_edit = apply_filters( 'edublink_page_edit_permission_for_logged_users', false );
	
	if ( get_edit_post_link() && $page_edit ) : ?>
		<footer class="entry-footer<?php do_action( 'edublink_page_footer_wrapper_class' ); ?>">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'edublink' ),
						array(
							'span' => array(
								'class' => array()
							)
						)
					),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
