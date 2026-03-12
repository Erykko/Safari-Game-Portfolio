<?php
/**
 * Plugin Name: Safari Fields
 * Description: ACF field group definitions for Safari Portfolio (Ranger, Global Settings, and CPT meta). Requires ACF Pro.
 * Version: 1.0.0
 * Author: Eric Mutema
 * Text Domain: safari-fields
 * Requires at least: 5.8
 * Requires PHP: 7.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SAFARI_FIELDS_VERSION', '1.0.0' );
define( 'SAFARI_FIELDS_PATH', plugin_dir_path( __FILE__ ) );

add_action( 'acf/init', 'safari_fields_load' );

function safari_fields_load() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		add_action( 'admin_notices', function () {
			echo '<div class="notice notice-warning"><p>' . esc_html__( 'Safari Fields requires ACF Pro. Please install and activate Advanced Custom Fields Pro.', 'safari-fields' ) . '</p></div>';
		} );
		return;
	}
	require_once SAFARI_FIELDS_PATH . 'field-groups/skill-fields.php';
	require_once SAFARI_FIELDS_PATH . 'field-groups/project-fields.php';
	require_once SAFARI_FIELDS_PATH . 'field-groups/ranger-fields.php';
	require_once SAFARI_FIELDS_PATH . 'field-groups/global-settings.php';
}

add_action( 'acf/init', 'safari_fields_options_pages', 9 );

function safari_fields_options_pages() {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}
	acf_add_options_page( array(
		'page_title' => __( 'Game Config', 'safari-fields' ),
		'menu_title' => __( 'Game Config', 'safari-fields' ),
		'menu_slug'  => 'safari-game-config',
		'parent_slug' => 'edit.php?post_type=safari_project',
		'capability' => 'manage_options',
	) );
	acf_add_options_page( array(
		'page_title' => __( 'Global Settings', 'safari-fields' ),
		'menu_title' => __( 'Global Settings', 'safari-fields' ),
		'menu_slug'  => 'safari-global-settings',
		'parent_slug' => 'edit.php?post_type=safari_project',
		'capability' => 'manage_options',
	) );
}
