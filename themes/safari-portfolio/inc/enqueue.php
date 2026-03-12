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

	wp_enqueue_style(
		'safari-game-css',
		$theme_url . 'assets/css/game.css',
		array(),
		file_exists( $theme_path . 'assets/css/game.css' ) ? filemtime( $theme_path . 'assets/css/game.css' ) : '1.0'
	);

	wp_enqueue_script(
		'safari-game-engine',
		$theme_url . 'assets/js/game.js',
		array(),
		file_exists( $theme_path . 'assets/js/game.js' ) ? filemtime( $theme_path . 'assets/js/game.js' ) : '1.0',
		true
	);

	if ( is_front_page() ) {
		$safari_data = safari_portfolio_get_game_data();
		wp_localize_script( 'safari-game-engine', 'SafariData', $safari_data );
	}
}
