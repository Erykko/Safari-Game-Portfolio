<?php
/**
 * ACF field group: Field Medals — Achievements (safari_achievement).
 *
 * Badge-style unlocks displayed as toast notifications and in a collectable panel.
 * The game.js achievement system reads these via SafariData to know which
 * achievements exist, their triggers, and XP rewards.
 *
 * @package Safari_Portfolio_Core
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

acf_add_local_field_group( array(
	'key'    => 'group_safari_achievement',
	'title'  => __( 'Achievement Details', 'safari-portfolio-core' ),
	'fields' => array(
		array(
			'key'          => 'field_achievement_icon',
			'label'        => __( 'Badge icon', 'safari-portfolio-core' ),
			'name'         => 'achievement_icon',
			'type'         => 'text',
			'instructions' => __( 'Emoji shown in the toast and badge panel (e.g. 📸, 🏆, 🗺️).', 'safari-portfolio-core' ),
			'placeholder'  => '🏆',
		),
		array(
			'key'          => 'field_achievement_trigger_id',
			'label'        => __( 'Trigger ID', 'safari-portfolio-core' ),
			'name'         => 'achievement_trigger_id',
			'type'         => 'text',
			'instructions' => __( 'Unique JS identifier used in game.js to unlock this achievement (e.g. "first_shot", "big_nine", "campfire_story"). Must be lowercase with underscores.', 'safari-portfolio-core' ),
			'placeholder'  => 'first_shot',
		),
		array(
			'key'          => 'field_achievement_description',
			'label'        => __( 'Description', 'safari-portfolio-core' ),
			'name'         => 'achievement_description',
			'type'         => 'textarea',
			'instructions' => __( 'Shown in the toast notification when unlocked.', 'safari-portfolio-core' ),
			'rows'         => 2,
		),
		array(
			'key'           => 'field_achievement_xp_reward',
			'label'         => __( 'XP reward', 'safari-portfolio-core' ),
			'name'          => 'achievement_xp_reward',
			'type'          => 'number',
			'instructions'  => __( 'How much XP is awarded when this achievement unlocks.', 'safari-portfolio-core' ),
			'min'           => 0,
			'default_value' => 100,
		),
		array(
			'key'          => 'field_achievement_rarity',
			'label'        => __( 'Rarity', 'safari-portfolio-core' ),
			'name'         => 'achievement_rarity',
			'type'         => 'select',
			'instructions' => __( 'Affects badge colour and perceived value.', 'safari-portfolio-core' ),
			'choices'      => array(
				'common'    => __( 'Common', 'safari-portfolio-core' ),
				'rare'      => __( 'Rare', 'safari-portfolio-core' ),
				'epic'      => __( 'Epic', 'safari-portfolio-core' ),
				'legendary' => __( 'Legendary', 'safari-portfolio-core' ),
			),
			'default_value' => 'common',
		),
	),
	'location' => array(
		array(
			array(
				'param'    => 'post_type',
				'operator' => '==',
				'value'    => 'safari_achievement',
			),
		),
	),
	'style'    => 'default',
	'position' => 'normal',
) );
