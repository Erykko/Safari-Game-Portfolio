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

function safari_portfolio_get_game_data() {
	$skills   = safari_portfolio_format_skills();
	$projects = safari_portfolio_format_projects();
	$config   = array();
	if ( function_exists( 'get_field' ) ) {
		$config['restUrl'] = rest_url( 'wp/v2/' );
		$config['nonce']   = wp_create_nonce( 'wp_rest' );
	}
	return array(
		'skills'   => $skills,
		'projects' => $projects,
		'config'   => $config,
	);
}

function safari_portfolio_format_skills() {
	$query = new WP_Query( array(
		'post_type'      => 'safari_skill',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'post_status'    => 'publish',
	) );
	$out = array();
	foreach ( $query->posts as $post ) {
		$icon = '';
		$level = 0;
		if ( function_exists( 'get_field' ) ) {
			$icon  = get_field( 'skill_icon_emoji', $post->ID ) ?: '';
			$level = (int) get_field( 'skill_proficiency', $post->ID );
		}
		$out[] = array(
			'icon'  => $icon,
			'name'  => $post->post_title,
			'desc'  => $post->post_excerpt ?: '',
			'level' => $level . '%',
		);
	}
	return $out;
}

function safari_portfolio_format_projects() {
	$query = new WP_Query( array(
		'post_type'      => 'safari_project',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'post_status'    => 'publish',
	) );
	$out = array();
	foreach ( $query->posts as $post ) {
		$animal   = '';
		$url      = '';
		$featured = false;
		$tools_str = '';
		if ( function_exists( 'get_field' ) ) {
			$animal   = get_field( 'project_animal_emoji', $post->ID ) ?: '';
			$url      = get_field( 'project_live_url', $post->ID ) ?: '';
			$featured = (bool) get_field( 'project_featured', $post->ID );
			$tools_str = get_field( 'project_tools_display', $post->ID ) ?: '';
		}
		$tools = array_filter( array_map( 'trim', explode( ',', $tools_str ) ) );
		$out[] = array(
			'animal'   => $animal,
			'name'     => $post->post_title,
			'desc'     => $post->post_excerpt ?: '',
			'tools'    => $tools,
			'url'      => $url,
			'featured' => $featured,
		);
	}
	return $out;
}
