<?php
/**
 * ACF field group: Skill / Equipment (safari_skill) — minimal set for seed and front-page.
 *
 * @package Safari_Fields
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

acf_add_local_field_group( array(
	'key'                   => 'group_safari_skill',
	'title'                 => __( 'Skill / Equipment Data', 'safari-portfolio-core' ),
	'fields'                => array(
		array(
			'key'   => 'field_skill_icon_emoji',
			'label' => __( 'Icon emoji', 'safari-portfolio-core' ),
			'name'  => 'skill_icon_emoji',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_skill_proficiency',
			'label' => __( 'Proficiency (0–100)', 'safari-portfolio-core' ),
			'name'  => 'skill_proficiency',
			'type'  => 'number',
			'min'   => 0,
			'max'   => 100,
		),
	),
	'location' => array(
		array(
			array(
				'param'    => 'post_type',
				'operator' => '==',
				'value'    => 'safari_skill',
			),
		),
	),
) );
