<?php $full_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' ); ?>

<ul class="edublink-social-share-icons-wrapper">
	<?php do_action( 'edublink_social_share_items_before' ); ?>
	
	<?php if ( edublink_set_value( 'facebook_share', true ) ) : ?>
		<li class="edublink-social-share-each-icon facebook">
			<a class="edublink-social-share-link" href="https://www.facebook.com/sharer.php?s=100&u=<?php the_permalink(); ?>&i=<?php echo urlencode($full_image ? $full_image[0] : ''); ?>" target="_blank" title="<?php esc_attr_e( 'Share on facebook', 'edublink' ); ?>">
				<i class="icon-facebook"></i>
			</a>
	 	</li>
	<?php endif; ?>

	<?php if ( edublink_set_value( 'twitter_share', true ) ) : ?>
 		<li class="edublink-social-share-each-icon twitter">
			<a class="edublink-social-share-link" href="https://twitter.com/intent/tweet?url=<?php the_permalink(); ?>" target="_blank" title="<?php esc_attr_e( 'Share on Twitter', 'edublink' ); ?>">
				<i class="ri-twitter-x-fill"></i>
			</a>
 		</li>
	<?php endif; ?>

	<?php if ( edublink_set_value( 'linkedin_share', true ) ) : ?>
 		<li class="edublink-social-share-each-icon linkedin">
			<a class="edublink-social-share-link" href="https://linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title(); ?>" target="_blank" title="<?php esc_attr_e( 'Share on LinkedIn', 'edublink' ); ?>">
				<i class="icon-linkedin2"></i>
			</a>
 		</li>
	<?php endif; ?>

	<?php if ( edublink_set_value( 'pinterest_share', false ) ) : ?>
 		<li class="edublink-social-share-each-icon pinterest">
			<a class="edublink-social-share-link" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&amp;description=<?php echo urlencode($post->post_title); ?>&amp;media=<?php echo urlencode( $full_image ? $full_image[0] : '' ); ?>" target="_blank" title="<?php esc_attr_e( 'Share on Pinterest', 'edublink' ); ?>">
				<i class="icon-pinterest"></i>
			</a>
 		</li>
	<?php endif; ?>

	<?php if ( edublink_set_value( 'whatsapp_share', false ) ) : ?>
 		<li class="edublink-social-share-each-icon whatsapp">
			<a class="edublink-social-share-link" href="whatsapp://send?text=<?php the_title(); ?> <?php the_permalink(); ?>" data-action="share/whatsapp/share" title="<?php esc_attr_e( 'Share on WhatsApp', 'edublink' ); ?>">
				<i class="ri-whatsapp-line"></i>
			</a>
 		</li>
	<?php endif; ?>

	<?php do_action( 'edublink_social_share_items_after' ); ?>
</ul>