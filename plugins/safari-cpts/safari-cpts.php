<?php
/**
 * Plugin Name: Safari CPTs
 * Description: Registers Custom Post Types for the Safari Portfolio Game (projects, skills, ranger, testimonial, achievement, dispatch, easter egg).
 * Version: 1.0.0
 * Author: Eric Mutema
 * Text Domain: safari-cpts
 * Requires at least: 5.8
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SAFARI_CPTS_VERSION', '1.0.0' );
define( 'SAFARI_CPTS_PATH', plugin_dir_path( __FILE__ ) );
define( 'SAFARI_CPTS_URL', plugin_dir_url( __FILE__ ) );

require_once SAFARI_CPTS_PATH . 'includes/class-safari-register-cpts.php';
require_once SAFARI_CPTS_PATH . 'includes/class-safari-seed.php';

add_action( 'init', array( 'Safari_Register_CPTs', 'register_all' ), 0 );

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require_once SAFARI_CPTS_PATH . 'includes/class-safari-wpcli.php';
	WP_CLI::add_command( 'safari', 'Safari_WPCLI_Commands' );
}

add_action( 'admin_init', array( 'Safari_Seed', 'register_ajax_seed' ) );
add_action( 'admin_menu', array( 'Safari_Seed', 'add_tools_page' ), 20 );
