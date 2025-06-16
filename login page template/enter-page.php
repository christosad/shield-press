<?php
/**
 * Template Name: Enter Page (Shield Press)
 */

session_start();
get_header();

$error = isset( $_SESSION['pwg_error'] ) ? $_SESSION['pwg_error'] : '';
unset( $_SESSION['pwg_error'] );
?>

<div style="max-width: 400px; margin: 100px auto; text-align: center;">
	<h2>Enter Password to Access</h2>
	<?php if ( $error ) : ?>
		<p style="color: red;"><?php echo esc_html( $error ); ?></p>
	<?php endif; ?>
	<form method="post">
		<input type="password" name="pwg_password" required style="padding:10px;width:100%;margin:10px 0;">
		<button type="submit" style="padding:10px 20px;">Enter</button>
	</form>
</div>

<?php get_footer(); ?>