<?php
/**
 * Registers all Safari Custom Post Types.
 *
 * @package Safari_CPTs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Safari_Register_CPTs {

	public static function register_all() {
		self::register_safari_project();
		self::register_safari_skill();
		self::register_safari_ranger();
		self::register_safari_testimonial();
		self::register_safari_achievement();
		self::register_safari_dispatch();
		self::register_safari_easter_egg();
	}

	private static function register_safari_project() {
		register_post_type(
			'safari_project',
			array(
				'labels'              => array(
					'name'               => __( 'Wildlife Sightings', 'safari-cpts' ),
					'singular_name'      => __( 'Sighting', 'safari-cpts' ),
					'menu_name'          => __( 'Wildlife Sightings', 'safari-cpts' ),
					'add_new'            => __( 'Add Sighting', 'safari-cpts' ),
					'add_new_item'       => __( 'Add New Sighting', 'safari-cpts' ),
					'edit_item'          => __( 'Edit Sighting', 'safari-cpts' ),
					'new_item'           => __( 'New Sighting', 'safari-cpts' ),
					'view_item'          => __( 'View Sighting', 'safari-cpts' ),
					'search_items'       => __( 'Search Sightings', 'safari-cpts' ),
					'not_found'          => __( 'No sightings found.', 'safari-cpts' ),
					'not_found_in_trash' => __( 'No sightings found in Trash.', 'safari-cpts' ),
				),
				'public'              => true,
				'has_archive'         => false,
				'menu_icon'           => 'dashicons-camera',
				'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
				'show_in_rest'        => true,
				'rest_base'           => 'projects',
				'capability_type'     => 'post',
			)
		);
	}

	private static function register_safari_skill() {
		register_post_type(
			'safari_skill',
			array(
				'labels'              => array(
					'name'               => __( 'Field Equipment', 'safari-cpts' ),
					'singular_name'      => __( 'Skill', 'safari-cpts' ),
					'menu_name'          => __( 'Field Equipment', 'safari-cpts' ),
					'add_new'            => __( 'Add Skill', 'safari-cpts' ),
					'add_new_item'       => __( 'Add New Skill', 'safari-cpts' ),
					'edit_item'          => __( 'Edit Skill', 'safari-cpts' ),
					'new_item'           => __( 'New Skill', 'safari-cpts' ),
					'view_item'          => __( 'View Skill', 'safari-cpts' ),
					'search_items'       => __( 'Search Skills', 'safari-cpts' ),
					'not_found'          => __( 'No skills found.', 'safari-cpts' ),
					'not_found_in_trash' => __( 'No skills found in Trash.', 'safari-cpts' ),
				),
				'public'              => true,
				'has_archive'         => false,
				'menu_icon'           => 'dashicons-hammer',
				'supports'            => array( 'title', 'editor', 'excerpt', 'page-attributes' ),
				'show_in_rest'        => true,
				'rest_base'           => 'skills',
				'capability_type'     => 'post',
			)
		);
	}

	private static function register_safari_ranger() {
		register_post_type(
			'safari_ranger',
			array(
				'labels'              => array(
					'name'               => __( 'The Ranger', 'safari-cpts' ),
					'singular_name'      => __( 'Ranger Profile', 'safari-cpts' ),
					'menu_name'          => __( 'The Ranger', 'safari-cpts' ),
					'add_new'            => __( 'Add Ranger', 'safari-cpts' ),
					'add_new_item'       => __( 'Add Ranger Profile', 'safari-cpts' ),
					'edit_item'          => __( 'Edit Ranger', 'safari-cpts' ),
					'new_item'           => __( 'New Ranger', 'safari-cpts' ),
					'view_item'          => __( 'View Ranger', 'safari-cpts' ),
					'search_items'       => __( 'Search Rangers', 'safari-cpts' ),
					'not_found'          => __( 'No ranger profile found.', 'safari-cpts' ),
					'not_found_in_trash' => __( 'No ranger profiles found in Trash.', 'safari-cpts' ),
				),
				'public'              => true,
				'has_archive'         => false,
				'menu_icon'           => 'dashicons-admin-users',
				'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
				'show_in_rest'        => true,
				'rest_base'           => 'ranger',
				'capability_type'     => 'post',
			)
		);
	}

	private static function register_safari_testimonial() {
		register_post_type(
			'safari_testimonial',
			array(
				'labels'              => array(
					'name'               => __( 'Animal Tracks', 'safari-cpts' ),
					'singular_name'      => __( 'Testimonial', 'safari-cpts' ),
					'menu_name'          => __( 'Animal Tracks', 'safari-cpts' ),
					'add_new'            => __( 'Add Testimonial', 'safari-cpts' ),
					'add_new_item'       => __( 'Add New Testimonial', 'safari-cpts' ),
					'edit_item'          => __( 'Edit Testimonial', 'safari-cpts' ),
					'not_found'          => __( 'No testimonials found.', 'safari-cpts' ),
				),
				'description'         => __( 'Client testimonials displayed as "tracks in the mud" near the Ranger section. Each has a quote, author, animal paw-print icon, and optional rating.', 'safari-cpts' ),
				'public'              => true,
				'has_archive'         => false,
				'menu_icon'           => 'dashicons-format-quote',
				'supports'            => array( 'title', 'editor', 'thumbnail' ),
				'show_in_rest'        => true,
				'rest_base'           => 'testimonials',
				'capability_type'     => 'post',
			)
		);
	}

	private static function register_safari_achievement() {
		register_post_type(
			'safari_achievement',
			array(
				'labels'              => array(
					'name'               => __( 'Field Medals', 'safari-cpts' ),
					'singular_name'      => __( 'Achievement', 'safari-cpts' ),
					'menu_name'          => __( 'Field Medals', 'safari-cpts' ),
					'add_new'            => __( 'Add Achievement', 'safari-cpts' ),
					'add_new_item'       => __( 'Add New Achievement', 'safari-cpts' ),
					'edit_item'          => __( 'Edit Achievement', 'safari-cpts' ),
					'not_found'          => __( 'No achievements found.', 'safari-cpts' ),
				),
				'description'         => __( 'Badge-style achievements unlocked by visitor actions. Each has a trigger ID, rarity, XP reward, and icon. game.js shows a toast notification when unlocked. Shareable as auto-generated images.', 'safari-cpts' ),
				'public'              => true,
				'has_archive'         => false,
				'menu_icon'           => 'dashicons-awards',
				'supports'            => array( 'title', 'excerpt', 'thumbnail' ),
				'show_in_rest'        => true,
				'rest_base'           => 'achievements',
				'capability_type'     => 'post',
			)
		);
	}

	private static function register_safari_dispatch() {
		register_post_type(
			'safari_dispatch',
			array(
				'labels'              => array(
					'name'               => __( 'Field Dispatches', 'safari-cpts' ),
					'singular_name'      => __( 'Dispatch', 'safari-cpts' ),
					'menu_name'          => __( 'Field Dispatches', 'safari-cpts' ),
					'add_new'            => __( 'Write Dispatch', 'safari-cpts' ),
					'add_new_item'       => __( 'Write New Dispatch', 'safari-cpts' ),
					'edit_item'          => __( 'Edit Dispatch', 'safari-cpts' ),
					'not_found'          => __( 'No dispatches found.', 'safari-cpts' ),
				),
				'description'         => __( 'Blog posts published at /dispatches/. Short technical articles about problems solved, WordPress tips, or client work. Drives SEO via long-tail content. Each has a topic, read time, and optional link to a related project.', 'safari-cpts' ),
				'public'              => true,
				'has_archive'         => true,
				'rewrite'             => array( 'slug' => 'dispatches' ),
				'menu_icon'           => 'dashicons-book-alt',
				'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'author', 'comments' ),
				'show_in_rest'        => true,
				'capability_type'     => 'post',
			)
		);
	}

	private static function register_safari_easter_egg() {
		register_post_type(
			'safari_easter_egg',
			array(
				'labels'              => array(
					'name'               => __( 'Hidden Encounters', 'safari-cpts' ),
					'singular_name'      => __( 'Easter Egg', 'safari-cpts' ),
					'menu_name'          => __( 'Hidden Encounters', 'safari-cpts' ),
					'add_new'            => __( 'Add Encounter', 'safari-cpts' ),
					'add_new_item'       => __( 'Add Hidden Encounter', 'safari-cpts' ),
					'edit_item'          => __( 'Edit Hidden Encounter', 'safari-cpts' ),
					'not_found'          => __( 'No hidden encounters found.', 'safari-cpts' ),
				),
				'description'         => __( 'Secret interactions (easter eggs) scattered across the site. Each defines a trigger (Konami code, hidden click target, long-press, etc.), the achievement it unlocks, and XP reward. Not publicly visible — only loaded into the game engine.', 'safari-cpts' ),
				'public'              => false,
				'publicly_queryable'  => false,
				'show_ui'             => true,
				'has_archive'         => false,
				'menu_icon'           => 'dashicons-hidden',
				'supports'            => array( 'title', 'editor' ),
				'show_in_rest'        => true,
				'capability_type'     => 'post',
			)
		);
	}
}
