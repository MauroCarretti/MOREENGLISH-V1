<?php
/**
 * Template for displaying main user profile page.
 *
 * @author   ThimPress
 * @package  Learnpress/Templates
 * @version  4.0.2
 */

defined( 'ABSPATH' ) || exit();

if ( ! isset( $profile ) ) {
	return;
}

$eb_lp_form_column = '';
if ( $profile->get_user()->is_guest() ) :
	if ( 'yes' === LP()->settings()->get( 'enable_login_profile' ) || 'yes' === LP()->settings()->get( 'enable_register_profile') ) :

		$eb_lp_form_column = ' edublink-lp-login-register-form-wrapper edublink-lp-col-1';
		if ( 'yes' === LP()->settings()->get( 'enable_login_profile' ) && 'yes' === LP()->settings()->get( 'enable_register_profile') ) :
			$eb_lp_form_column = ' edublink-lp-login-register-form-wrapper edublink-lp-col-2';
		endif;
	endif;
endif;
?>
	<div id="learn-press-profile" <?php $profile->main_class(); ?>>
		<div class="lp-content-area<?php echo esc_attr( $eb_lp_form_column ); ?>">
			<?php do_action( 'learn-press/user-profile', $profile ); ?>
		</div>
	</div>
<?php
