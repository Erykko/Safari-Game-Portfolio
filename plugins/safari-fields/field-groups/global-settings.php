<?php
/**
 * ACF field group: Global Settings (options page).
 *
 * @package Safari_Fields
 */

if ( ! defined( 'ABSPATH' ) || ! function_exists( 'acf_add_local_field_group' ) ) {
	return;
}

acf_add_local_field_group( array(
	'key'                   => 'group_safari_global_settings',
	'title'                 => __( 'Global Settings', 'safari-fields' ),
	'fields'                => array(
		// —— Module toggles ———
		array(
			'key'   => 'field_global_modules_tab',
			'label' => __( 'Global modules', 'safari-fields' ),
			'name'  => '',
			'type'  => 'tab',
		),
		array(
			'key'   => 'field_show_hero',
			'label' => __( 'Show Hero (Base Camp)', 'safari-fields' ),
			'name'  => 'show_hero',
			'type'  => 'true_false',
			'default_value' => 1,
		),
		array(
			'key'   => 'field_show_toolkit',
			'label' => __( 'Show Toolkit', 'safari-fields' ),
			'name'  => 'show_toolkit',
			'type'  => 'true_false',
			'default_value' => 1,
		),
		array(
			'key'   => 'field_show_sightings',
			'label' => __( 'Show Sightings', 'safari-fields' ),
			'name'  => 'show_sightings',
			'type'  => 'true_false',
			'default_value' => 1,
		),
		array(
			'key'   => 'field_show_ranger',
			'label' => __( 'Show Ranger', 'safari-fields' ),
			'name'  => 'show_ranger',
			'type'  => 'true_false',
			'default_value' => 1,
		),
		array(
			'key'   => 'field_show_contact',
			'label' => __( 'Show Contact (Field Notes)', 'safari-fields' ),
			'name'  => 'show_contact',
			'type'  => 'true_false',
			'default_value' => 1,
		),
		array(
			'key'   => 'field_show_hud',
			'label' => __( 'Show HUD', 'safari-fields' ),
			'name'  => 'show_hud',
			'type'  => 'true_false',
			'default_value' => 1,
		),
		array(
			'key'   => 'field_show_progress_bar',
			'label' => __( 'Show Progress bar', 'safari-fields' ),
			'name'  => 'show_progress_bar',
			'type'  => 'true_false',
			'default_value' => 1,
		),
		array(
			'key'   => 'field_show_boot_screen',
			'label' => __( 'Show Boot screen', 'safari-fields' ),
			'name'  => 'show_boot_screen',
			'type'  => 'true_false',
			'default_value' => 1,
		),
		// —— Hero ———
		array(
			'key'   => 'field_hero_tab',
			'label' => __( 'Hero (Base Camp)', 'safari-fields' ),
			'name'  => '',
			'type'  => 'tab',
		),
		array(
			'key'   => 'field_hero_badge',
			'label' => __( 'Hero badge', 'safari-fields' ),
			'name'  => 'hero_badge',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_hero_tag',
			'label' => __( 'Hero tag', 'safari-fields' ),
			'name'  => 'hero_tag',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_hero_name',
			'label' => __( 'Hero name', 'safari-fields' ),
			'name'  => 'hero_name',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_hero_title',
			'label' => __( 'Hero title', 'safari-fields' ),
			'name'  => 'hero_title',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_hero_desc',
			'label' => __( 'Hero description', 'safari-fields' ),
			'name'  => 'hero_desc',
			'type'  => 'textarea',
		),
		array(
			'key'   => 'field_hero_mission_title',
			'label' => __( 'Mission title', 'safari-fields' ),
			'name'  => 'hero_mission_title',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_hero_mission_sub',
			'label' => __( 'Mission subtitle', 'safari-fields' ),
			'name'  => 'hero_mission_sub',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_hero_confirm_label',
			'label' => __( 'Confirm button label', 'safari-fields' ),
			'name'  => 'hero_confirm_label',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_hero_mini_log',
			'label' => __( 'Mini log text', 'safari-fields' ),
			'name'  => 'hero_mini_log',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_hero_scroll_hint',
			'label' => __( 'Scroll hint', 'safari-fields' ),
			'name'  => 'hero_scroll_hint',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_hero_location',
			'label' => __( 'Hero location', 'safari-fields' ),
			'name'  => 'hero_location',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_hero_hud_label',
			'label' => __( 'HUD label (mission console)', 'safari-fields' ),
			'name'  => 'hero_hud_label',
			'type'  => 'text',
		),
		// —— Section labels ———
		array(
			'key'   => 'field_sections_tab',
			'label' => __( 'Section labels', 'safari-fields' ),
			'name'  => '',
			'type'  => 'tab',
		),
		array(
			'key'   => 'field_section_toolkit_label',
			'label' => __( 'Toolkit section label', 'safari-fields' ),
			'name'  => 'section_toolkit_label',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_section_toolkit_title',
			'label' => __( 'Toolkit section title', 'safari-fields' ),
			'name'  => 'section_toolkit_title',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_section_toolkit_sub',
			'label' => __( 'Toolkit section subtitle', 'safari-fields' ),
			'name'  => 'section_toolkit_sub',
			'type'  => 'textarea',
		),
		array(
			'key'   => 'field_section_sightings_label',
			'label' => __( 'Sightings section label', 'safari-fields' ),
			'name'  => 'section_sightings_label',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_section_sightings_title',
			'label' => __( 'Sightings section title', 'safari-fields' ),
			'name'  => 'section_sightings_title',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_section_sightings_sub',
			'label' => __( 'Sightings section subtitle', 'safari-fields' ),
			'name'  => 'section_sightings_sub',
			'type'  => 'textarea',
		),
		array(
			'key'   => 'field_section_ranger_label',
			'label' => __( 'Ranger section label', 'safari-fields' ),
			'name'  => 'section_ranger_label',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_section_ranger_title',
			'label' => __( 'Ranger section title', 'safari-fields' ),
			'name'  => 'section_ranger_title',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_section_contact_label',
			'label' => __( 'Contact section label', 'safari-fields' ),
			'name'  => 'section_contact_label',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_section_contact_title',
			'label' => __( 'Contact section title', 'safari-fields' ),
			'name'  => 'section_contact_title',
			'type'  => 'text',
		),
		// —— Contact ———
		array(
			'key'   => 'field_contact_tab',
			'label' => __( 'Contact (Field Notes)', 'safari-fields' ),
			'name'  => '',
			'type'  => 'tab',
		),
		array(
			'key'   => 'field_contact_quote',
			'label' => __( 'Contact quote', 'safari-fields' ),
			'name'  => 'contact_quote',
			'type'  => 'textarea',
		),
		array(
			'key'   => 'field_contact_location',
			'label' => __( 'Contact location', 'safari-fields' ),
			'name'  => 'contact_location',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_contact_website',
			'label' => __( 'Contact website', 'safari-fields' ),
			'name'  => 'contact_website',
			'type'  => 'url',
		),
		array(
			'key'   => 'field_contact_availability',
			'label' => __( 'Contact availability', 'safari-fields' ),
			'name'  => 'contact_availability',
			'type'  => 'text',
		),
		// —— HUD ———
		array(
			'key'   => 'field_hud_tab',
			'label' => __( 'HUD', 'safari-fields' ),
			'name'  => '',
			'type'  => 'tab',
		),
		array(
			'key'   => 'field_hud_logo',
			'label' => __( 'HUD logo text', 'safari-fields' ),
			'name'  => 'hud_logo',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_hud_mission',
			'label' => __( 'HUD mission label', 'safari-fields' ),
			'name'  => 'hud_mission',
			'type'  => 'text',
		),
		array(
			'key'   => 'field_hud_nav_links',
			'label' => __( 'Nav links', 'safari-fields' ),
			'name'  => 'hud_nav_links',
			'type'  => 'repeater',
			'sub_fields' => array(
				array(
					'key'   => 'field_hud_nav_label',
					'label' => __( 'Label', 'safari-fields' ),
					'name'  => 'nav_label',
					'type'  => 'text',
				),
				array(
					'key'   => 'field_hud_nav_anchor',
					'label' => __( 'Anchor / URL', 'safari-fields' ),
					'name'  => 'nav_anchor',
					'type'  => 'text',
				),
			),
		),
		// —— Boot ———
		array(
			'key'   => 'field_boot_tab',
			'label' => __( 'Boot screen', 'safari-fields' ),
			'name'  => '',
			'type'  => 'tab',
		),
		array(
			'key'   => 'field_boot_kicker',
			'label' => __( 'Boot kicker text', 'safari-fields' ),
			'name'  => 'boot_kicker',
			'type'  => 'text',
		),
	),
	'location' => array(
		array(
			array(
				'param'    => 'options_page',
				'operator' => '==',
				'value'    => 'safari-global-settings',
			),
		),
	),
) );
