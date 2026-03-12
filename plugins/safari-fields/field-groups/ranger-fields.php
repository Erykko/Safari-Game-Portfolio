<?php
/**
 * ACF field group: Ranger Profile (safari_ranger).
 *
 * @package Safari_Fields
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

acf_add_local_field_group( array(
	'key'                   => 'group_safari_ranger',
	'title'                 => __( 'Ranger Profile', 'safari-fields' ),
	'fields'                => array(
		array(
			'key'   => 'field_ranger_avatar_emoji',
			'label' => __( 'Avatar emoji', 'safari-fields' ),
			'name'  => 'ranger_avatar_emoji',
			'type'  => 'text',
			'placeholder' => '🦒',
		),
		array(
			'key'   => 'field_ranger_stats',
			'label' => __( 'Stats', 'safari-fields' ),
			'name'  => 'ranger_stats',
			'type'  => 'repeater',
			'sub_fields' => array(
				array(
					'key'   => 'field_ranger_stat_value',
					'label' => __( 'Value', 'safari-fields' ),
					'name'  => 'stat_value',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_ranger_stat_label',
					'label' => __( 'Label', 'safari-fields' ),
					'name'  => 'stat_label',
					'type'  => 'text',
				),
			),
		),
		array(
			'key'   => 'field_ranger_bio_intro',
			'label' => __( 'Bio intro', 'safari-fields' ),
			'name'  => 'ranger_bio_intro',
			'type'  => 'textarea',
		),
		array(
			'key'   => 'field_ranger_bio_paragraphs',
			'label' => __( 'Bio paragraphs', 'safari-fields' ),
			'name'  => 'ranger_bio_paragraphs',
			'type'  => 'repeater',
			'sub_fields' => array(
				array(
					'key'   => 'field_ranger_bio_paragraph',
					'label' => __( 'Paragraph', 'safari-fields' ),
					'name'  => 'paragraph',
					'type'  => 'wysiwyg',
				),
			),
		),
		array(
			'key'   => 'field_ranger_specialties',
			'label' => __( 'Specialties', 'safari-fields' ),
			'name'  => 'ranger_specialties',
			'type'  => 'repeater',
			'sub_fields' => array(
				array(
					'key'   => 'field_ranger_specialty_text',
					'label' => __( 'Specialty', 'safari-fields' ),
					'name'  => 'specialty_text',
					'type'  => 'text',
				),
			),
		),
		array(
			'key'   => 'field_ranger_location',
			'label' => __( 'Location', 'safari-fields' ),
			'name'  => 'ranger_location',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_ranger_website',
			'label' => __( 'Website', 'safari-fields' ),
			'name'  => 'ranger_website',
			'type'  => 'url',
		),
		array(
			'key'   => 'field_ranger_availability',
			'label' => __( 'Availability', 'safari-fields' ),
			'name'  => 'ranger_availability',
			'type'  => 'text',
		),
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
) );
