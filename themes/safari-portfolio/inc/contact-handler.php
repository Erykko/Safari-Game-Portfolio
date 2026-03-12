<?php
/**
 * AJAX contact form handler — sends email via wp_mail().
 *
 * @package Safari_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_ajax_safari_contact', 'safari_portfolio_handle_contact' );
add_action( 'wp_ajax_nopriv_safari_contact', 'safari_portfolio_handle_contact' );

function safari_portfolio_handle_contact() {
	if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'safari_contact_nonce' ) ) {
		wp_send_json_error( array( 'message' => __( 'Security check failed. Please reload and try again.', 'safari-portfolio' ) ), 403 );
	}

	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	if ( ! $name || ! $email || ! $message ) {
		wp_send_json_error( array( 'message' => __( 'Please fill in all fields.', 'safari-portfolio' ) ), 400 );
	}

	if ( ! is_email( $email ) ) {
		wp_send_json_error( array( 'message' => __( 'Please enter a valid email address.', 'safari-portfolio' ) ), 400 );
	}

	$to      = apply_filters( 'safari_contact_recipient', 'emutema.mutema@gmail.com' );
	$subject = sprintf( '[Safari Portfolio] New message from %s', $name );
	$body    = sprintf(
		"Name: %s\nEmail: %s\n\nMessage:\n%s",
		$name,
		$email,
		$message
	);
	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		sprintf( 'Reply-To: %s <%s>', $name, $email ),
	);

	$sent = wp_mail( $to, $subject, $body, $headers );

	if ( $sent ) {
		wp_send_json_success( array( 'message' => __( 'Dispatch sent successfully!', 'safari-portfolio' ) ) );
	} else {
		wp_send_json_error( array( 'message' => __( 'Failed to send. Please try again later.', 'safari-portfolio' ) ), 500 );
	}
}
