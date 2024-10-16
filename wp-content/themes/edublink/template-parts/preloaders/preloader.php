<?php

$preloader_type = edublink_set_value( 'preloader_type', '1' );
echo '<div id="edublink-preloader" class="edublink-preloader-wrapper edublink-preloader-' . esc_attr( $preloader_type ) . '-wrapper">';
	echo '<div class="edublink-preloader-inner">';
		get_template_part( 'template-parts/preloaders/preloader', $preloader_type );

		echo '<div class="edublink-preloader-close-btn-wraper">';
			echo '<span class="edublink-preloader-close-btn">';
				_e( 'Cancel Preloader', 'edublink' );
			echo '</span>';
		echo '</div>';
	echo '</div>';
echo '</div>';