<?php
/**
 * Register Safari section blocks (server-side render + editor inserter).
 *
 * @package Safari_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once SAFARI_PORTFOLIO_PATH . 'inc/blocks/safari-hero.php';
require_once SAFARI_PORTFOLIO_PATH . 'inc/blocks/safari-toolkit.php';
require_once SAFARI_PORTFOLIO_PATH . 'inc/blocks/safari-sightings.php';
require_once SAFARI_PORTFOLIO_PATH . 'inc/blocks/safari-ranger.php';
require_once SAFARI_PORTFOLIO_PATH . 'inc/blocks/safari-contact.php';
require_once SAFARI_PORTFOLIO_PATH . 'inc/blocks/safari-hud.php';
require_once SAFARI_PORTFOLIO_PATH . 'inc/blocks/safari-progress-bar.php';
require_once SAFARI_PORTFOLIO_PATH . 'inc/blocks/safari-divider.php';
require_once SAFARI_PORTFOLIO_PATH . 'inc/blocks/safari-boot-screen.php';
require_once SAFARI_PORTFOLIO_PATH . 'inc/blocks/safari-testimonials.php';
require_once SAFARI_PORTFOLIO_PATH . 'inc/blocks/safari-achievements.php';
require_once SAFARI_PORTFOLIO_PATH . 'inc/blocks/safari-dispatches.php';

add_filter( 'block_categories_all', 'safari_portfolio_block_category', 10, 2 );

function safari_portfolio_block_category( $categories, $context ) {
	return array_merge(
		array(
			array(
				'slug'  => 'safari',
				'title' => __( 'Safari Portfolio', 'safari-portfolio' ),
				'icon'  => 'palmtree',
			),
		),
		$categories
	);
}

add_action( 'init', 'safari_portfolio_register_blocks' );

function safari_portfolio_register_blocks() {
	$editor_js = SAFARI_PORTFOLIO_PATH . 'assets/js/safari-blocks-editor.js';
	wp_register_script(
		'safari-blocks-editor',
		SAFARI_PORTFOLIO_URL . 'assets/js/safari-blocks-editor.js',
		array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-server-side-render' ),
		file_exists( $editor_js ) ? (string) filemtime( $editor_js ) : '1.0',
		true
	);

	$blocks = array(
		array(
			'name'       => 'safari/hero',
			'title'      => __( 'Safari Hero (Base Camp)', 'safari-portfolio' ),
			'render'     => 'safari_block_render_hero',
			'attributes' => array(
				'badge'        => array( 'type' => 'string' ),
				'tag'          => array( 'type' => 'string' ),
				'name'         => array( 'type' => 'string' ),
				'title'        => array( 'type' => 'string' ),
				'desc'         => array( 'type' => 'string' ),
				'missionTitle' => array( 'type' => 'string' ),
				'missionSub'   => array( 'type' => 'string' ),
				'confirmLabel' => array( 'type' => 'string' ),
				'miniLog'      => array( 'type' => 'string' ),
				'scrollHint'   => array( 'type' => 'string' ),
				'location'     => array( 'type' => 'string' ),
				'hudLabel'     => array( 'type' => 'string' ),
			),
		),
		array(
			'name'       => 'safari/toolkit',
			'title'      => __( 'Safari Toolkit', 'safari-portfolio' ),
			'render'     => 'safari_block_render_toolkit',
			'attributes' => array(
				'sectionLabel' => array( 'type' => 'string' ),
				'sectionTitle' => array( 'type' => 'string' ),
				'sectionSub'   => array( 'type' => 'string' ),
			),
		),
		array(
			'name'       => 'safari/sightings',
			'title'      => __( 'Safari Sightings', 'safari-portfolio' ),
			'render'     => 'safari_block_render_sightings',
			'attributes' => array(
				'sectionLabel' => array( 'type' => 'string' ),
				'sectionTitle' => array( 'type' => 'string' ),
				'sectionSub'   => array( 'type' => 'string' ),
				'logCountLabel' => array( 'type' => 'string' ),
			),
		),
		array(
			'name'       => 'safari/ranger',
			'title'      => __( 'Safari Ranger', 'safari-portfolio' ),
			'render'     => 'safari_block_render_ranger',
			'attributes' => array(
				'sectionLabel' => array( 'type' => 'string' ),
				'sectionTitle' => array( 'type' => 'string' ),
			),
		),
		array(
			'name'       => 'safari/contact',
			'title'      => __( 'Safari Contact (Field Notes)', 'safari-portfolio' ),
			'render'     => 'safari_block_render_contact',
			'attributes' => array(
				'sectionLabel' => array( 'type' => 'string' ),
				'sectionTitle' => array( 'type' => 'string' ),
				'quote'        => array( 'type' => 'string' ),
				'location'     => array( 'type' => 'string' ),
				'website'      => array( 'type' => 'string' ),
				'availability' => array( 'type' => 'string' ),
			),
		),
		array(
			'name'       => 'safari/hud',
			'title'      => __( 'Safari HUD', 'safari-portfolio' ),
			'render'     => 'safari_block_render_hud',
			'attributes' => array(
				'logo'   => array( 'type' => 'string' ),
				'mission' => array( 'type' => 'string' ),
			),
		),
		array(
			'name'       => 'safari/progress-bar',
			'title'      => __( 'Safari Progress Bar', 'safari-portfolio' ),
			'render'     => 'safari_block_render_progress_bar',
			'attributes' => array(),
		),
		array(
			'name'       => 'safari/divider',
			'title'      => __( 'Safari Divider', 'safari-portfolio' ),
			'render'     => 'safari_block_render_divider',
			'attributes' => array(
				'variant' => array( 'type' => 'string', 'default' => 'default' ),
			),
		),
		array(
			'name'       => 'safari/boot-screen',
			'title'      => __( 'Safari Boot Screen', 'safari-portfolio' ),
			'render'     => 'safari_block_render_boot_screen',
			'attributes' => array(
				'kicker'   => array( 'type' => 'string' ),
				'title'   => array( 'type' => 'string' ),
				'subtitle' => array( 'type' => 'string' ),
			),
		),
		array(
			'name'       => 'safari/testimonials',
			'title'      => __( 'Safari Testimonials (Animal Tracks)', 'safari-portfolio' ),
			'render'     => 'safari_block_render_testimonials',
			'attributes' => array(
				'sectionLabel' => array( 'type' => 'string' ),
				'sectionTitle' => array( 'type' => 'string' ),
				'count'        => array( 'type' => 'number', 'default' => 6 ),
			),
		),
		array(
			'name'       => 'safari/achievements',
			'title'      => __( 'Safari Achievements (Field Medals)', 'safari-portfolio' ),
			'render'     => 'safari_block_render_achievements',
			'attributes' => array(
				'sectionLabel' => array( 'type' => 'string' ),
				'sectionTitle' => array( 'type' => 'string' ),
			),
		),
		array(
			'name'       => 'safari/dispatches',
			'title'      => __( 'Safari Dispatches (Field Dispatches)', 'safari-portfolio' ),
			'render'     => 'safari_block_render_dispatches',
			'attributes' => array(
				'sectionLabel' => array( 'type' => 'string' ),
				'sectionTitle' => array( 'type' => 'string' ),
				'count'        => array( 'type' => 'number', 'default' => 3 ),
			),
		),
	);

	foreach ( $blocks as $block ) {
		register_block_type( $block['name'], array(
			'editor_script'   => 'safari-blocks-editor',
			'render_callback' => $block['render'],
			'attributes'      => $block['attributes'],
		) );
	}
}
