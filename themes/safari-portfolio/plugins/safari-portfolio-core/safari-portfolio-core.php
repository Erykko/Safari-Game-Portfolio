<?php
/**
 * Plugin Name: Safari Portfolio Core
 * Description: CPTs, ACF field groups, seed tools, and settings for Safari Portfolio theme. Works with ACF free (no Pro required).
 * Version: 1.0.0
 * Author: Eric Mutema
 * Text Domain: safari-portfolio-core
 * Requires at least: 5.8
 * Requires PHP: 7.4
 *
 * Bundled with Safari Portfolio theme. Loaded automatically when the theme is active.
 *
 * @package Safari_Portfolio_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SAFARI_CORE_VERSION', '1.0.0' );
define( 'SAFARI_CORE_PATH', dirname( __FILE__ ) . '/' );
define( 'SAFARI_CPTS_PATH', SAFARI_CORE_PATH );
define( 'SAFARI_FIELDS_PATH', SAFARI_CORE_PATH );

// Core includes.
require_once SAFARI_CORE_PATH . 'includes/class-safari-register-cpts.php';
require_once SAFARI_CORE_PATH . 'includes/class-safari-seed.php';
require_once SAFARI_CORE_PATH . 'includes/class-safari-settings.php';

add_action( 'init', array( 'Safari_Register_CPTs', 'register_all' ), 0 );

Safari_Settings::register();

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require_once SAFARI_CORE_PATH . 'includes/class-safari-wpcli.php';
	WP_CLI::add_command( 'safari', 'Safari_WPCLI_Commands' );
}

add_action( 'admin_init', array( 'Safari_Seed', 'register_ajax_seed' ) );

// ACF field groups (works with free ACF — no Pro required).
add_action( 'acf/init', 'safari_core_load_fields', 8 );

function safari_core_load_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}
	require_once SAFARI_CORE_PATH . 'field-groups/skill-fields.php';
	require_once SAFARI_CORE_PATH . 'field-groups/project-fields.php';
	require_once SAFARI_CORE_PATH . 'field-groups/ranger-fields.php';
	require_once SAFARI_CORE_PATH . 'field-groups/testimonial-fields.php';
	require_once SAFARI_CORE_PATH . 'field-groups/achievement-fields.php';
	require_once SAFARI_CORE_PATH . 'field-groups/dispatch-fields.php';
	require_once SAFARI_CORE_PATH . 'field-groups/easter-egg-fields.php';
}

// Admin menu — Safari top-level + Global Settings + Seed Content.
add_action( 'admin_menu', 'safari_core_admin_menu', 5 );
add_action( 'admin_menu', 'safari_core_add_subpages', 10 );

function safari_core_admin_menu() {
	add_menu_page(
		__( 'Safari Portfolio', 'safari-portfolio-core' ),
		__( 'Safari', 'safari-portfolio-core' ),
		'manage_options',
		'safari-settings',
		array( 'Safari_Settings', 'render_page' ),
		'dashicons-palmtree',
		30
	);
}

function safari_core_add_subpages() {
	add_submenu_page(
		'safari-settings',
		__( 'Global Settings', 'safari-portfolio-core' ),
		__( 'Global Settings', 'safari-portfolio-core' ),
		'manage_options',
		'safari-settings'
	);

	add_submenu_page(
		'safari-settings',
		__( 'Seed Content', 'safari-portfolio-core' ),
		__( 'Seed Content', 'safari-portfolio-core' ),
		'manage_options',
		'safari-seed-content',
		array( 'Safari_Seed', 'render_tools_page' )
	);
}
