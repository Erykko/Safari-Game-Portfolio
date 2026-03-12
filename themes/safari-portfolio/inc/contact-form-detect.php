<?php
/**
 * Detect installed contact form plugins and enumerate their forms.
 *
 * Returns arrays suitable for ACF select choices and resolves a
 * stored form key (e.g. "cf7_42") back to a renderable shortcode.
 *
 * @package Safari_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Detect which contact-form plugins are active and list their forms.
 *
 * @return array Keyed by "plugin_postID" => "Form Title (Plugin Name)".
 */
function safari_detect_plugin_forms() {
	$forms = array();

	// Contact Form 7
	if ( class_exists( 'WPCF7' ) ) {
		$cf7_posts = get_posts( array(
			'post_type'      => 'wpcf7_contact_form',
			'posts_per_page' => 50,
			'post_status'    => 'publish',
			'orderby'        => 'title',
			'order'          => 'ASC',
		) );
		foreach ( $cf7_posts as $p ) {
			$forms[ 'cf7_' . $p->ID ] = $p->post_title . ' (Contact Form 7)';
		}
	}

	// WPForms
	if ( function_exists( 'wpforms' ) ) {
		$wpf_posts = get_posts( array(
			'post_type'      => 'wpforms',
			'posts_per_page' => 50,
			'post_status'    => 'publish',
			'orderby'        => 'title',
			'order'          => 'ASC',
		) );
		foreach ( $wpf_posts as $p ) {
			$forms[ 'wpforms_' . $p->ID ] = $p->post_title . ' (WPForms)';
		}
	}

	// Gravity Forms
	if ( class_exists( 'GFAPI' ) ) {
		$gf_forms = GFAPI::get_forms( true, false, 'title', 'ASC' );
		if ( is_array( $gf_forms ) ) {
			foreach ( $gf_forms as $gf ) {
				$forms[ 'gf_' . $gf['id'] ] = $gf['title'] . ' (Gravity Forms)';
			}
		}
	}

	// Ninja Forms
	if ( function_exists( 'Ninja_Forms' ) ) {
		$nf_forms = Ninja_Forms()->form()->get_forms();
		if ( is_array( $nf_forms ) ) {
			foreach ( $nf_forms as $nf ) {
				$id    = $nf->get_id();
				$title = $nf->get_setting( 'title' );
				$forms[ 'ninja_' . $id ] = ( $title ?: "Form #{$id}" ) . ' (Ninja Forms)';
			}
		}
	}

	// Formidable Forms
	if ( class_exists( 'FrmForm' ) ) {
		$ff_forms = FrmForm::getAll( array( 'status' => 'published' ), 'name ASC' );
		if ( is_array( $ff_forms ) ) {
			foreach ( $ff_forms as $ff ) {
				$forms[ 'formidable_' . $ff->id ] = $ff->name . ' (Formidable)';
			}
		}
	}

	// Fluent Forms
	if ( defined( 'FLUENTFORM' ) ) {
		global $wpdb;
		$table = $wpdb->prefix . 'fluentform_forms';
		if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $table ) ) === $table ) {
			$ff_rows = $wpdb->get_results( "SELECT id, title FROM {$table} WHERE status = 'published' ORDER BY title ASC LIMIT 50" );
			if ( $ff_rows ) {
				foreach ( $ff_rows as $row ) {
					$forms[ 'fluent_' . $row->id ] = $row->title . ' (Fluent Forms)';
				}
			}
		}
	}

	return $forms;
}

/**
 * Resolve a stored form key to a shortcode string.
 *
 * @param string $key  e.g. "cf7_42", "wpforms_17", "gf_3".
 * @return string      Shortcode string or empty if unrecognised.
 */
function safari_resolve_form_shortcode( $key ) {
	if ( ! $key || ! is_string( $key ) ) {
		return '';
	}

	if ( preg_match( '/^cf7_(\d+)$/', $key, $m ) ) {
		return '[contact-form-7 id="' . $m[1] . '"]';
	}
	if ( preg_match( '/^wpforms_(\d+)$/', $key, $m ) ) {
		return '[wpforms id="' . $m[1] . '"]';
	}
	if ( preg_match( '/^gf_(\d+)$/', $key, $m ) ) {
		return '[gravityform id="' . $m[1] . '" title="false" description="false" ajax="true"]';
	}
	if ( preg_match( '/^ninja_(\d+)$/', $key, $m ) ) {
		return '[ninja_form id="' . $m[1] . '"]';
	}
	if ( preg_match( '/^formidable_(\d+)$/', $key, $m ) ) {
		return '[formidable id="' . $m[1] . '"]';
	}
	if ( preg_match( '/^fluent_(\d+)$/', $key, $m ) ) {
		return '[fluentform id="' . $m[1] . '"]';
	}

	return '';
}
