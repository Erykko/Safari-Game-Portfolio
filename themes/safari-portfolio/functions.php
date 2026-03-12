<?php
/**
 * Safari Portfolio theme — loader.
 *
 * @package Safari_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SAFARI_PORTFOLIO_PATH', get_template_directory() . '/' );
define( 'SAFARI_PORTFOLIO_URL', get_template_directory_uri() . '/' );

// Load bundled plugin (CPTs, ACF fields, seed tools).
$safari_core = SAFARI_PORTFOLIO_PATH . 'plugins/safari-portfolio-core/safari-portfolio-core.php';
if ( is_readable( $safari_core ) ) {
	require_once $safari_core;
}

require_once SAFARI_PORTFOLIO_PATH . 'inc/theme-setup.php';
require_once SAFARI_PORTFOLIO_PATH . 'inc/enqueue.php';
require_once SAFARI_PORTFOLIO_PATH . 'inc/block-registration.php';
require_once SAFARI_PORTFOLIO_PATH . 'inc/game-data.php';
require_once SAFARI_PORTFOLIO_PATH . 'inc/contact-form-detect.php';
require_once SAFARI_PORTFOLIO_PATH . 'inc/contact-handler.php';
