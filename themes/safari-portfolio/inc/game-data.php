<?php
/**
 * Build game data for wp_localize_script (SafariData).
 * Format matches static game.js SafariTools / SafariProjects so the engine can use them.
 *
 * @package Safari_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Read a custom field from post meta. Uses ACF get_field when available, falls back to get_post_meta.
 */
function safari_read_field( $key, $post_id ) {
	if ( function_exists( 'get_field' ) ) {
		return get_field( $key, $post_id );
	}
	return get_post_meta( $post_id, $key, true );
}

function safari_portfolio_get_game_data() {
	$skills       = safari_portfolio_format_skills();
	$projects     = safari_portfolio_format_projects();
	$achievements = safari_portfolio_format_achievements();
	$easter_eggs  = safari_portfolio_format_easter_eggs();
	$config       = array(
		'restUrl' => rest_url( 'wp/v2/' ),
		'nonce'   => wp_create_nonce( 'wp_rest' ),
	);
	return array(
		'skills'       => $skills,
		'projects'     => $projects,
		'achievements' => $achievements,
		'easterEggs'   => $easter_eggs,
		'config'       => $config,
	);
}

function safari_portfolio_format_skills() {
	if ( ! post_type_exists( 'safari_skill' ) ) {
		return array();
	}
	$query = new WP_Query( array(
		'post_type'      => 'safari_skill',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'post_status'    => 'publish',
	) );
	$out = array();
	foreach ( $query->posts as $post ) {
		$icon  = safari_read_field( 'skill_icon_emoji', $post->ID );
		$level = (int) safari_read_field( 'skill_proficiency', $post->ID );
		$out[] = array(
			'icon'  => is_string( $icon ) ? sanitize_text_field( $icon ) : '',
			'name'  => sanitize_text_field( $post->post_title ),
			'desc'  => sanitize_textarea_field( $post->post_excerpt ? $post->post_excerpt : '' ),
			'level' => max( 0, min( 100, $level ) ) . '%',
		);
	}
	return $out;
}

function safari_portfolio_format_projects() {
	if ( ! post_type_exists( 'safari_project' ) ) {
		return array();
	}
	$query = new WP_Query( array(
		'post_type'      => 'safari_project',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'post_status'    => 'publish',
	) );
	$out = array();
	foreach ( $query->posts as $post ) {
		$animal    = safari_read_field( 'project_animal_emoji', $post->ID );
		$url       = safari_read_field( 'project_live_url', $post->ID );
		$featured  = (bool) safari_read_field( 'project_featured', $post->ID );
		$tools_str = safari_read_field( 'project_tools_display', $post->ID );
		$tools_str = is_string( $tools_str ) ? $tools_str : '';
		$tools     = array_filter( array_map( 'sanitize_text_field', array_map( 'trim', explode( ',', $tools_str ) ) ) );
		$out[]     = array(
			'animal'   => is_string( $animal ) ? sanitize_text_field( $animal ) : '',
			'name'     => sanitize_text_field( $post->post_title ),
			'desc'     => sanitize_textarea_field( $post->post_excerpt ? $post->post_excerpt : '' ),
			'tools'    => array_values( $tools ),
			'url'      => is_string( $url ) ? esc_url_raw( $url ) : '',
			'featured' => $featured,
		);
	}
	return $out;
}

function safari_portfolio_format_achievements() {
	if ( ! post_type_exists( 'safari_achievement' ) ) {
		return array();
	}
	$query = new WP_Query( array(
		'post_type'      => 'safari_achievement',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	) );
	$out = array();
	foreach ( $query->posts as $post ) {
		$icon    = safari_read_field( 'achievement_icon', $post->ID );
		$trigger = safari_read_field( 'achievement_trigger_id', $post->ID );
		$desc    = safari_read_field( 'achievement_description', $post->ID );
		$xp      = (int) safari_read_field( 'achievement_xp_reward', $post->ID );
		$rarity  = safari_read_field( 'achievement_rarity', $post->ID );
		$out[] = array(
			'id'      => is_string( $trigger ) ? sanitize_text_field( $trigger ) : '',
			'name'    => sanitize_text_field( $post->post_title ),
			'icon'    => is_string( $icon ) ? sanitize_text_field( $icon ) : '🏆',
			'desc'    => is_string( $desc ) ? sanitize_textarea_field( $desc ) : '',
			'xp'      => max( 0, $xp ),
			'rarity'  => is_string( $rarity ) ? sanitize_text_field( $rarity ) : 'common',
		);
	}
	return $out;
}

function safari_portfolio_format_easter_eggs() {
	if ( ! post_type_exists( 'safari_easter_egg' ) ) {
		return array();
	}
	$query = new WP_Query( array(
		'post_type'      => 'safari_easter_egg',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	) );
	$out = array();
	foreach ( $query->posts as $post ) {
		$trigger_type   = safari_read_field( 'egg_trigger_type', $post->ID );
		$trigger_detail = safari_read_field( 'egg_trigger_detail', $post->ID );
		$reward_text    = safari_read_field( 'egg_reward_text', $post->ID );
		$achievement_id = safari_read_field( 'egg_achievement_id', $post->ID );
		$xp             = (int) safari_read_field( 'egg_xp_reward', $post->ID );
		$active         = safari_read_field( 'egg_active', $post->ID );
		if ( '' !== $active && ! $active ) {
			continue;
		}
		$out[] = array(
			'name'          => sanitize_text_field( $post->post_title ),
			'triggerType'   => is_string( $trigger_type ) ? sanitize_text_field( $trigger_type ) : 'click',
			'triggerDetail' => is_string( $trigger_detail ) ? sanitize_text_field( $trigger_detail ) : '',
			'rewardText'    => is_string( $reward_text ) ? sanitize_textarea_field( $reward_text ) : '',
			'achievementId' => is_string( $achievement_id ) ? sanitize_text_field( $achievement_id ) : '',
			'xp'            => max( 0, $xp ),
		);
	}
	return $out;
}
