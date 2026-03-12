<?php
/**
 * ACF field group: Field Dispatches — Blog posts (safari_dispatch).
 *
 * Blog-style posts published at /dispatches/. They drive SEO via long-tail
 * technical content. Each dispatch can optionally link to a related project.
 *
 * @package Safari_Portfolio_Core
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

acf_add_local_field_group( array(
	'key'    => 'group_safari_dispatch',
	'title'  => __( 'Dispatch Details', 'safari-portfolio-core' ),
	'fields' => array(
		array(
			'key'          => 'field_dispatch_icon',
			'label'        => __( 'Icon', 'safari-portfolio-core' ),
			'name'         => 'dispatch_icon',
			'type'         => 'text',
			'instructions' => __( 'Emoji shown in lists and cards (e.g. 📝, 🔧, 🐛).', 'safari-portfolio-core' ),
			'placeholder'  => '📝',
		),
		array(
			'key'          => 'field_dispatch_read_time',
			'label'        => __( 'Read time', 'safari-portfolio-core' ),
			'name'         => 'dispatch_read_time',
			'type'         => 'text',
			'instructions' => __( 'Estimated reading time (e.g. "4 min read").', 'safari-portfolio-core' ),
			'placeholder'  => '4 min read',
		),
		array(
			'key'          => 'field_dispatch_topic',
			'label'        => __( 'Topic / tag', 'safari-portfolio-core' ),
			'name'         => 'dispatch_topic',
			'type'         => 'text',
			'instructions' => __( 'Short topic label (e.g. "WordPress", "Laravel", "Performance").', 'safari-portfolio-core' ),
			'placeholder'  => 'WordPress',
		),
		array(
			'key'          => 'field_dispatch_related_project',
			'label'        => __( 'Related project', 'safari-portfolio-core' ),
			'name'         => 'dispatch_related_project',
			'type'         => 'post_object',
			'instructions' => __( 'Optionally link to a Wildlife Sighting (project) this dispatch relates to.', 'safari-portfolio-core' ),
			'post_type'    => array( 'safari_project' ),
			'return_format' => 'id',
			'allow_null'   => 1,
		),
		array(
			'key'           => 'field_dispatch_featured',
			'label'         => __( 'Featured', 'safari-portfolio-core' ),
			'name'          => 'dispatch_featured',
			'type'          => 'true_false',
			'instructions'  => __( 'Featured dispatches appear prominently.', 'safari-portfolio-core' ),
			'default_value' => 0,
		),
	),
	'location' => array(
		array(
			array(
				'param'    => 'post_type',
				'operator' => '==',
				'value'    => 'safari_dispatch',
			),
		),
	),
	'style'    => 'default',
	'position' => 'normal',
) );
