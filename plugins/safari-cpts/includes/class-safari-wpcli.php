<?php
/**
 * WP-CLI commands for seeding Safari content.
 *
 * @package Safari_CPTs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Safari_WPCLI_Commands {

	/**
	 * Seed all skills (Field Equipment) from seed-data/skills.json.
	 *
	 * ## EXAMPLES
	 *
	 *     wp safari seed-skills
	 *
	 * @when after_wp_load
	 */
	public function seed_skills( $args, $assoc_args ) {
		$result = Safari_Seed::seed_skills();
		if ( ! empty( $result['success'] ) ) {
			WP_CLI::success( sprintf( 'Seeded %d skills.', $result['count'] ) );
		} else {
			WP_CLI::error( isset( $result['message'] ) ? $result['message'] : 'Seed failed.' );
		}
	}

	/**
	 * Seed all projects (Wildlife Sightings) from seed-data/projects.json.
	 *
	 * ## EXAMPLES
	 *
	 *     wp safari seed-projects
	 *
	 * @when after_wp_load
	 */
	public function seed_projects( $args, $assoc_args ) {
		$result = Safari_Seed::seed_projects();
		if ( ! empty( $result['success'] ) ) {
			WP_CLI::success( sprintf( 'Seeded %d projects.', $result['count'] ) );
		} else {
			WP_CLI::error( isset( $result['message'] ) ? $result['message'] : 'Seed failed.' );
		}
	}

	/**
	 * Seed the Ranger profile from seed-data/ranger.json.
	 *
	 * ## EXAMPLES
	 *
	 *     wp safari seed-ranger
	 *
	 * @when after_wp_load
	 */
	public function seed_ranger( $args, $assoc_args ) {
		$result = Safari_Seed::seed_ranger();
		if ( ! empty( $result['success'] ) ) {
			WP_CLI::success( 'Ranger profile seeded.' );
		} else {
			WP_CLI::error( isset( $result['message'] ) ? $result['message'] : 'Seed failed.' );
		}
	}

	/**
	 * Seed global defaults (hero, sections, contact, HUD) from seed-data/global-defaults.json.
	 *
	 * ## EXAMPLES
	 *
	 *     wp safari seed-defaults
	 *
	 * @when after_wp_load
	 */
	public function seed_defaults( $args, $assoc_args ) {
		$result = Safari_Seed::seed_defaults();
		if ( ! empty( $result['success'] ) ) {
			WP_CLI::success( sprintf( 'Seeded %d option fields.', $result['count'] ) );
		} else {
			WP_CLI::error( isset( $result['message'] ) ? $result['message'] : 'Seed failed.' );
		}
	}

	/**
	 * Seed all content: skills, projects, ranger, and global defaults.
	 *
	 * ## EXAMPLES
	 *
	 *     wp safari seed-all
	 *
	 * @when after_wp_load
	 */
	public function seed_all( $args, $assoc_args ) {
		$results = Safari_Seed::seed_all();
		WP_CLI::success( sprintf(
			'Seeded: %d skills, %d projects, %d ranger, %d default options.',
			isset( $results['skills']['count'] ) ? $results['skills']['count'] : 0,
			isset( $results['projects']['count'] ) ? $results['projects']['count'] : 0,
			isset( $results['ranger']['count'] ) ? $results['ranger']['count'] : 0,
			isset( $results['defaults']['count'] ) ? $results['defaults']['count'] : 0
		) );
	}
}
