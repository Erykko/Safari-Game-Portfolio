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

require_once SAFARI_PORTFOLIO_PATH . 'inc/theme-setup.php';
require_once SAFARI_PORTFOLIO_PATH . 'inc/enqueue.php';
require_once SAFARI_PORTFOLIO_PATH . 'inc/block-registration.php';
require_once SAFARI_PORTFOLIO_PATH . 'inc/game-data.php';
