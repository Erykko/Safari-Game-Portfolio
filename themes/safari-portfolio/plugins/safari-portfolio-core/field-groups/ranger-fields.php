<?php
/**
 * ACF field group: Ranger Profile (safari_ranger).
 * Uses only ACF-free field types (no repeaters).
 *
 * @package Safari_Portfolio_Core
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

$stat_fields = array();
for ( $i = 1; $i <= 6; $i++ ) {
	$stat_fields[] = array(
		'key'         => "field_ranger_stat_{$i}_value",
		'label'       => sprintf( __( 'Stat %d — value', 'safari-portfolio-core' ), $i ),
		'name'        => "ranger_stat_{$i}_value",
		'type'        => 'text',
		'placeholder' => $i === 1 ? '9+' : '',
		'wrapper'     => array( 'width' => '50' ),
	);
	$stat_fields[] = array(
		'key'         => "field_ranger_stat_{$i}_label",
		'label'       => sprintf( __( 'Stat %d — label', 'safari-portfolio-core' ), $i ),
		'name'        => "ranger_stat_{$i}_label",
		'type'        => 'text',
		'placeholder' => $i === 1 ? 'Projects' : '',
		'wrapper'     => array( 'width' => '50' ),
	);
}

$specialty_fields = array();
for ( $i = 1; $i <= 10; $i++ ) {
	$specialty_fields[] = array(
		'key'   => "field_ranger_specialty_{$i}",
		'label' => sprintf( __( 'Specialty %d', 'safari-portfolio-core' ), $i ),
		'name'  => "ranger_specialty_{$i}",
		'type'  => 'text',
	);
}

acf_add_local_field_group( array(
	'key'    => 'group_safari_ranger',
	'title'  => __( 'Ranger Profile', 'safari-portfolio-core' ),
	'fields' => array_merge(
		array(
			array(
				'key'          => 'field_ranger_avatar_emoji',
				'label'        => __( 'Avatar emoji', 'safari-portfolio-core' ),
				'name'         => 'ranger_avatar_emoji',
				'type'         => 'text',
				'placeholder'  => '🦒',
				'instructions' => __( 'Single emoji shown as the ranger portrait.', 'safari-portfolio-core' ),
			),
			array(
				'key'   => 'field_ranger_stats_tab',
				'label' => __( 'Stats (up to 6)', 'safari-portfolio-core' ),
				'name'  => '',
				'type'  => 'tab',
			),
		),
		$stat_fields,
		array(
			array(
				'key'   => 'field_ranger_bio_tab',
				'label' => __( 'Bio', 'safari-portfolio-core' ),
				'name'  => '',
				'type'  => 'tab',
			),
			array(
				'key'          => 'field_ranger_bio',
				'label'        => __( 'Bio (full)', 'safari-portfolio-core' ),
				'name'         => 'ranger_bio',
				'type'         => 'wysiwyg',
				'instructions' => __( 'Full bio. Use paragraphs as needed. Rendered in the Ranger section.', 'safari-portfolio-core' ),
				'tabs'         => 'all',
				'toolbar'      => 'full',
				'media_upload' => 0,
			),
			array(
				'key'   => 'field_ranger_specialties_tab',
				'label' => __( 'Specialties (up to 10)', 'safari-portfolio-core' ),
				'name'  => '',
				'type'  => 'tab',
			),
		),
		$specialty_fields,
		array(
			array(
				'key'   => 'field_ranger_contact_tab',
				'label' => __( 'Contact', 'safari-portfolio-core' ),
				'name'  => '',
				'type'  => 'tab',
			),
			array(
				'key'         => 'field_ranger_location',
				'label'       => __( 'Location', 'safari-portfolio-core' ),
				'name'        => 'ranger_location',
				'type'        => 'text',
				'placeholder' => 'Nairobi, Kenya',
			),
			array(
				'key'         => 'field_ranger_website',
				'label'       => __( 'Website', 'safari-portfolio-core' ),
				'name'        => 'ranger_website',
				'type'        => 'url',
				'placeholder' => 'https://designnairobi.agency',
			),
			array(
				'key'         => 'field_ranger_availability',
				'label'       => __( 'Availability', 'safari-portfolio-core' ),
				'name'        => 'ranger_availability',
				'type'        => 'text',
				'placeholder' => 'Available for remote & local projects',
			),
		)
	),
	'location' => array(
		array(
			array(
				'param'    => 'post_type',
				'operator' => '==',
				'value'    => 'safari_ranger',
			),
		),
	),
	'style'    => 'default',
	'position' => 'normal',
) );
