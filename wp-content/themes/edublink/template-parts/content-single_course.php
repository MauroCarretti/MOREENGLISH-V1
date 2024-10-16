<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package EduBlink
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'edublink-single-lp-course-item' ); ?>>
	<?php
		the_content();
	?>
</article><!-- #post-## -->