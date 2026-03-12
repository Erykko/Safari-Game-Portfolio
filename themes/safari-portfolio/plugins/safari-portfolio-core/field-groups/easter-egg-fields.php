<?php
/**
 * ACF field group: Hidden Encounters — Easter Eggs (safari_easter_egg).
 *
 * Secret interactions scattered across the site. Each defines a trigger type,
 * the achievement it unlocks, and XP reward. game.js reads these via SafariData
 * to register available easter eggs dynamically.
 *
 * @package Safari_Portfolio_Core
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

acf_add_local_field_group( array(
	'key'    => 'group_safari_easter_egg',
	'title'  => __( 'Hidden Encounter Details', 'safari-portfolio-core' ),
	'fields' => array(
		array(
			'key'          => 'field_egg_icon',
			'label'        => __( 'Icon', 'safari-portfolio-core' ),
			'name'         => 'egg_icon',
			'type'         => 'text',
			'instructions' => __( 'Emoji for this encounter (e.g. 🎮, 🌙, 🔑).', 'safari-portfolio-core' ),
			'placeholder'  => '🥚',
		),
		array(
			'key'          => 'field_egg_trigger_type',
			'label'        => __( 'Trigger type', 'safari-portfolio-core' ),
			'name'         => 'egg_trigger_type',
			'type'         => 'select',
			'instructions' => __( 'How the visitor activates this encounter.', 'safari-portfolio-core' ),
			'choices'      => array(
				'konami'     => __( 'Konami code (key sequence)', 'safari-portfolio-core' ),
				'click'      => __( 'Click / tap a hidden element', 'safari-portfolio-core' ),
				'long_press' => __( 'Long-press (3 s)', 'safari-portfolio-core' ),
				'scroll'     => __( 'Scroll pattern (e.g. scroll past then back)', 'safari-portfolio-core' ),
				'idle'       => __( 'Idle for N seconds', 'safari-portfolio-core' ),
				'custom'     => __( 'Custom JS trigger', 'safari-portfolio-core' ),
			),
			'default_value' => 'click',
		),
		array(
			'key'          => 'field_egg_trigger_detail',
			'label'        => __( 'Trigger detail', 'safari-portfolio-core' ),
			'name'         => 'egg_trigger_detail',
			'type'         => 'text',
			'instructions' => __( 'CSS selector, key sequence, or JS event name that fires this egg.', 'safari-portfolio-core' ),
			'placeholder'  => '#site-logo',
		),
		array(
			'key'          => 'field_egg_reward_text',
			'label'        => __( 'Reward message', 'safari-portfolio-core' ),
			'name'         => 'egg_reward_text',
			'type'         => 'textarea',
			'instructions' => __( 'Message shown to the visitor when they find this encounter.', 'safari-portfolio-core' ),
			'rows'         => 2,
		),
		array(
			'key'          => 'field_egg_achievement_id',
			'label'        => __( 'Achievement to unlock', 'safari-portfolio-core' ),
			'name'         => 'egg_achievement_id',
			'type'         => 'text',
			'instructions' => __( 'Trigger ID of the Field Medal (achievement) to unlock (e.g. "campfire_story"). Must match a Field Medal\'s Trigger ID.', 'safari-portfolio-core' ),
			'placeholder'  => 'campfire_story',
		),
		array(
			'key'           => 'field_egg_xp_reward',
			'label'         => __( 'XP reward', 'safari-portfolio-core' ),
			'name'          => 'egg_xp_reward',
			'type'          => 'number',
			'instructions'  => __( 'Bonus XP awarded on discovery.', 'safari-portfolio-core' ),
			'min'           => 0,
			'default_value' => 250,
		),
		array(
			'key'           => 'field_egg_active',
			'label'         => __( 'Active', 'safari-portfolio-core' ),
			'name'          => 'egg_active',
			'type'          => 'true_false',
			'instructions'  => __( 'Only active encounters are loaded into the game engine.', 'safari-portfolio-core' ),
			'default_value' => 1,
		),
	),
	'location' => array(
		array(
			array(
				'param'    => 'post_type',
				'operator' => '==',
				'value'    => 'safari_easter_egg',
			),
		),
	),
	'style'    => 'default',
	'position' => 'normal',
) );
