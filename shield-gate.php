<?php
/**
 * Plugin Name: ShieldPress
 * Description: Password-protected landing page for entire site access (admin configurable).
 * Version: 1.0
 * Author: chad
 */

if ( ! defined( 'ABSPATH' ) )
	exit;

// ==============================
// 1. Start PHP session
// ==============================
add_action( 'init', function () {
	if ( ! session_id() ) {
		session_start();
	}
} );

// ==============================
// 2. Admin Settings Page
// ==============================
add_action( 'admin_menu', function () {
	add_submenu_page(
		'tools.php',
		'Shield Press Settings',
		'Shield Press',
		'manage_options',
		'shield-press',
		'pwg_settings_page'
	);
} );

function pwg_settings_page() {
	if ( ! current_user_can( 'manage_options' ) )
		return;

	$message = '';

	if ( isset( $_POST['pwg_new_password'] ) && check_admin_referer( 'pwg_save_password' ) ) {
		$new_password = sanitize_text_field( $_POST['pwg_new_password'] );
		if ( ! empty( $new_password ) ) {
			$hash = password_hash( $new_password, PASSWORD_DEFAULT );
			update_option( 'pwg_password_hash', $hash );
			update_option( 'pwg_password_version', wp_generate_password( 12, false ) ); // generate a new version key

			update_option( 'pwg_password_plain', $new_password ); // ✅ Add this line

			$message = 'Password updated successfully.';
		} else {
			$message = 'Password cannot be empty.';
		}
	}

	?>
	<div class="wrap">
		<h1>Shield Press Settings</h1>
		<?php if ( $message ) : ?>
			<div class="notice notice-success">
				<p><?php echo esc_html( $message ); ?></p>
			</div>
		<?php endif; ?>
		<form method="post">
			<?php wp_nonce_field( 'pwg_save_password' ); ?>
			<table class="form-table">
				<tr>
					<th scope="row"><label for="pwg_new_password">New Access Password</label></th>
					<td>
						<?php $existing_password = get_option( 'pwg_password_plain', '' ); ?>
						<input type="password" name="pwg_new_password" id="pwg_new_password" class="regular-text"
							value="<?php echo esc_attr( $existing_password ); ?>" />
						<button type="button" id="pwg_toggle_password" style="margin-left: 5px;">👁️</button>
						<p class="description">Enter a new password to protect the site.</p>
					</td>
				</tr>
			</table>
			<?php submit_button( 'Save Password' ); ?>
		</form>
		<script>
			document.addEventListener("DOMContentLoaded", function () {
				const input = document.getElementById("pwg_new_password");
				const toggle = document.getElementById("pwg_toggle_password");

				if (input && toggle) {
					toggle.addEventListener("click", function () {
						const isHidden = input.getAttribute("type") === "password";
						input.setAttribute("type", isHidden ? "text" : "password");
						toggle.textContent = isHidden ? "🙈" : "👁️";
					});
				}
			});
		</script>
	</div>
	<?php
}

// ==============================
// 3. Password Verification & Redirect Logic
// ==============================
add_action( 'template_redirect', function () {
	if ( is_admin() || wp_doing_ajax() )
		return;

	if ( is_user_logged_in() && current_user_can( 'manage_options' ) ) {
		return;
	}

	$allowed_slug = 'enter';
	$stored_hash = get_option( 'pwg_password_hash' );
	$stored_version = get_option( 'pwg_password_version' );

	if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['pwg_password'] ) ) {
		if ( $stored_hash && password_verify( $_POST['pwg_password'], $stored_hash ) ) {
			$_SESSION['pwg_authenticated'] = true;
			$_SESSION['pwg_version'] = $stored_version;
			wp_redirect( home_url() );
			exit;
		} else {
			$_SESSION['pwg_error'] = 'Invalid password';
			wp_redirect( home_url( '/' . $allowed_slug . '/' ) );
			exit;
		}
	}

	if (
		empty( $_SESSION['pwg_authenticated'] ) ||
		! isset( $_SESSION['pwg_version'] ) ||
		$_SESSION['pwg_version'] !== $stored_version
	) {
		$_SESSION['pwg_authenticated'] = false;
		unset( $_SESSION['pwg_version'] );
		if ( ! is_page( $allowed_slug ) ) {
			wp_redirect( home_url( '/' . $allowed_slug . '/' ) );
			exit;
		}
	}
} );

// ==============================
// 5. Logout Link (optional)
// ==============================
add_action( 'init', function () {
	if ( isset( $_GET['pwg_logout'] ) ) {
		session_start();
		unset( $_SESSION['pwg_authenticated'] );
		wp_redirect( home_url( '/access-gate/' ) );
		exit;
	}
} );