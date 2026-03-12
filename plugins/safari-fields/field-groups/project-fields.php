<?php
/**
 * ACF field group: Project / Wildlife (safari_project) — minimal set for seed and front-page.
 *
 * @package Safari_Fields
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

acf_add_local_field_group( array(
	'key'                   => 'group_safari_project',
	'title'                 => __( 'Project / Wildlife Data', 'safari-fields' ),
	'fields'                => array(
		array(
			'key'   => 'field_project_animal_emoji',
			'label' => __( 'Animal emoji', 'safari-fields' ),
			'name'  => 'project_animal_emoji',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_project_live_url',
			'label' => __( 'Live URL', 'safari-fields' ),
			'name'  => 'project_live_url',
			'type'  => 'url',
		),
		array(
			'key'   => 'field_project_featured',
			'label' => __( 'Featured', 'safari-fields' ),
			'name'  => 'project_featured',
			'type'  => 'true_false',
		),
		array(
			'key'   => 'field_project_tools_display',
			'label' => __( 'Tools (comma-separated for display)', 'safari-fields' ),
			'name'  => 'project_tools_display',
			'type'  => 'text',
		),
	),
	'location' => array(
		array(
			array(
				'param'    => 'post_type',
				'operator' => '==',
				'value'    => 'safari_project',
			),
		),
	),
) );
