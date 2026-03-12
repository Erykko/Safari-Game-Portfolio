<?php
/**
 * Enqueue scripts and styles.
 *
 * @package Safari_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', 'safari_portfolio_enqueue', 20 );

function safari_portfolio_enqueue() {
	$theme_url = SAFARI_PORTFOLIO_URL;
	$theme_path = SAFARI_PORTFOLIO_PATH;

	$game_css_path = $theme_path . 'assets/css/game.css';
	$game_js_path  = $theme_path . 'assets/js/game.js';
	wp_enqueue_style(
		'safari-game-css',
		esc_url( $theme_url . 'assets/css/game.css' ),
		array(),
		file_exists( $game_css_path ) ? (string) filemtime( $game_css_path ) : '1.0'
	);

	wp_enqueue_script(
		'safari-game-engine',
		esc_url( $theme_url . 'assets/js/game.js' ),
		array(),
		file_exists( $game_js_path ) ? (string) filemtime( $game_js_path ) : '1.0',
		true
	);

	$is_safari_page = is_front_page();
	if ( ! $is_safari_page && is_page() ) {
		$is_safari_page = ( 'page-safari-portfolio.php' === get_page_template_slug() );
	}
	if ( $is_safari_page ) {
		$safari_data = safari_portfolio_get_game_data();
		wp_localize_script( 'safari-game-engine', 'SafariData', $safari_data );
	}

	wp_localize_script( 'safari-game-engine', 'SafariAjax', array(
		'url'   => admin_url( 'admin-ajax.php' ),
		'nonce' => wp_create_nonce( 'safari_contact_nonce' ),
	) );
}
