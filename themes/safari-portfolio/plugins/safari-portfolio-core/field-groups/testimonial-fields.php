<?php
/**
 * ACF field group: Animal Tracks — Testimonials (safari_testimonial).
 *
 * Displayed on the front page as embossed "tracks in the mud" near the Ranger section.
 * Each testimonial shows a client quote with an animal paw-print icon.
 *
 * @package Safari_Portfolio_Core
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

acf_add_local_field_group( array(
	'key'    => 'group_safari_testimonial',
	'title'  => __( 'Testimonial Details', 'safari-portfolio-core' ),
	'fields' => array(
		array(
			'key'          => 'field_testimonial_animal_icon',
			'label'        => __( 'Animal track icon', 'safari-portfolio-core' ),
			'name'         => 'testimonial_animal_icon',
			'type'         => 'text',
			'instructions' => __( 'Emoji used as the paw-print avatar (e.g. 🐾, 🦁, 🐘).', 'safari-portfolio-core' ),
			'placeholder'  => '🐾',
		),
		array(
			'key'          => 'field_testimonial_author_name',
			'label'        => __( 'Author name', 'safari-portfolio-core' ),
			'name'         => 'testimonial_author_name',
			'type'         => 'text',
			'instructions' => __( 'Client or colleague name.', 'safari-portfolio-core' ),
			'placeholder'  => 'Jane Doe',
		),
		array(
			'key'          => 'field_testimonial_author_title',
			'label'        => __( 'Author title / company', 'safari-portfolio-core' ),
			'name'         => 'testimonial_author_title',
			'type'         => 'text',
			'placeholder'  => 'CEO, Acme Corp',
		),
		array(
			'key'           => 'field_testimonial_rating',
			'label'         => __( 'Rating', 'safari-portfolio-core' ),
			'name'          => 'testimonial_rating',
			'type'          => 'number',
			'instructions'  => __( '1–5 star rating (optional).', 'safari-portfolio-core' ),
			'min'           => 1,
			'max'           => 5,
			'default_value' => 5,
		),
		array(
			'key'          => 'field_testimonial_quote',
			'label'        => __( 'Quote', 'safari-portfolio-core' ),
			'name'         => 'testimonial_quote',
			'type'         => 'textarea',
			'instructions' => __( 'The testimonial text. The post title is used as a short label; this field holds the full quote.', 'safari-portfolio-core' ),
			'rows'         => 4,
		),
		array(
			'key'           => 'field_testimonial_featured',
			'label'         => __( 'Featured', 'safari-portfolio-core' ),
			'name'          => 'testimonial_featured',
			'type'          => 'true_false',
			'instructions'  => __( 'Featured testimonials appear first.', 'safari-portfolio-core' ),
			'default_value' => 0,
		),
	),
	'location' => array(
		array(
			array(
				'param'    => 'post_type',
				'operator' => '==',
				'value'    => 'safari_testimonial',
			),
		),
	),
	'style'    => 'default',
	'position' => 'normal',
) );
