<?php
/**
 * Seed logic for skills, projects, ranger, and global defaults.
 * Used by WP-CLI and the one-click admin button.
 *
 * @package Safari_Portfolio_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Safari_Seed {

	const SEED_KEY_META = '_safari_seed_key';

	/**
	 * Find an existing post by title and post type (replaces deprecated get_page_by_title).
	 */
	private static function find_post_by_title( $title, $post_type ) {
		$query = new WP_Query( array(
			'post_type'              => $post_type,
			'title'                  => $title,
			'posts_per_page'         => 1,
			'post_status'            => array( 'publish', 'draft', 'pending', 'private' ),
			'no_found_rows'          => true,
			'update_post_term_cache' => false,
		) );
		return ! empty( $query->posts ) ? $query->posts[0] : null;
	}

	/**
	 * Write a field to post meta. Uses update_field() if ACF is active, falls back to update_post_meta.
	 */
	private static function write_field( $key, $value, $post_id ) {
		if ( function_exists( 'update_field' ) ) {
			update_field( $key, $value, $post_id );
		} else {
			update_post_meta( $post_id, $key, $value );
		}
	}

	public static function seed_skills( $options = array() ) {
		$path = SAFARI_CPTS_PATH . 'seed-data/skills.json';
		if ( ! is_readable( $path ) ) {
			return array( 'success' => false, 'message' => 'skills.json not found', 'count' => 0 );
		}
		$items = json_decode( file_get_contents( $path ), true );
		if ( ! is_array( $items ) ) {
			return array( 'success' => false, 'message' => 'Invalid skills.json', 'count' => 0 );
		}
		$count = 0;
		$menu_order = 0;
		foreach ( $items as $item ) {
			$title = isset( $item['name'] ) ? sanitize_text_field( $item['name'] ) : '';
			if ( '' === $title ) {
				continue;
			}
			$existing = self::find_post_by_title( $title, 'safari_skill' );
			$post_data = array(
				'post_type'    => 'safari_skill',
				'post_title'   => $title,
				'post_excerpt' => isset( $item['desc'] ) ? sanitize_textarea_field( $item['desc'] ) : '',
				'post_status'  => 'publish',
				'menu_order'   => $menu_order++,
			);
			if ( $existing ) {
				$post_data['ID'] = (int) $existing->ID;
				wp_update_post( $post_data );
				$post_id = $existing->ID;
			} else {
				$post_id = wp_insert_post( $post_data );
			}
			if ( $post_id && ! is_wp_error( $post_id ) ) {
				update_post_meta( $post_id, self::SEED_KEY_META, 'seed-v1' );
				self::write_field( 'skill_icon_emoji', isset( $item['icon'] ) ? sanitize_text_field( $item['icon'] ) : '', $post_id );
				$level = isset( $item['level'] ) ? ( is_numeric( $item['level'] ) ? (int) $item['level'] : (int) str_replace( '%', '', $item['level'] ) ) : 0;
				$level = max( 0, min( 100, $level ) );
				self::write_field( 'skill_proficiency', $level, $post_id );
				$count++;
			}
		}
		return array( 'success' => true, 'count' => $count );
	}

	public static function seed_projects( $options = array() ) {
		$path = SAFARI_CPTS_PATH . 'seed-data/projects.json';
		if ( ! is_readable( $path ) ) {
			return array( 'success' => false, 'message' => 'projects.json not found', 'count' => 0 );
		}
		$items = json_decode( file_get_contents( $path ), true );
		if ( ! is_array( $items ) ) {
			return array( 'success' => false, 'message' => 'Invalid projects.json', 'count' => 0 );
		}
		$count = 0;
		foreach ( $items as $item ) {
			$title = isset( $item['name'] ) ? sanitize_text_field( $item['name'] ) : '';
			if ( '' === $title ) {
				continue;
			}
			$existing = self::find_post_by_title( $title, 'safari_project' );
			$post_data = array(
				'post_type'    => 'safari_project',
				'post_title'   => $title,
				'post_excerpt' => isset( $item['desc'] ) ? sanitize_textarea_field( $item['desc'] ) : '',
				'post_content' => '',
				'post_status'  => 'publish',
			);
			if ( $existing ) {
				$post_data['ID'] = (int) $existing->ID;
				wp_update_post( $post_data );
				$post_id = $existing->ID;
			} else {
				$post_id = wp_insert_post( $post_data );
			}
			if ( $post_id && ! is_wp_error( $post_id ) ) {
				update_post_meta( $post_id, self::SEED_KEY_META, 'seed-v1' );
				self::write_field( 'project_animal_emoji', isset( $item['animal'] ) ? sanitize_text_field( $item['animal'] ) : '', $post_id );
				$url = isset( $item['url'] ) ? esc_url_raw( $item['url'] ) : '';
				self::write_field( 'project_live_url', $url, $post_id );
				self::write_field( 'project_featured', ! empty( $item['featured'] ), $post_id );
				if ( ! empty( $item['tools'] ) && is_array( $item['tools'] ) ) {
					$tools_sanitized = array_map( 'sanitize_text_field', $item['tools'] );
					self::write_field( 'project_tools_display', implode( ', ', $tools_sanitized ), $post_id );
				}
				$count++;
			}
		}
		return array( 'success' => true, 'count' => $count );
	}

	public static function seed_ranger( $options = array() ) {
		$path = SAFARI_CPTS_PATH . 'seed-data/ranger.json';
		if ( ! is_readable( $path ) ) {
			return array( 'success' => false, 'message' => 'ranger.json not found', 'count' => 0 );
		}
		$data = json_decode( file_get_contents( $path ), true );
		if ( ! is_array( $data ) ) {
			return array( 'success' => false, 'message' => 'Invalid ranger.json', 'count' => 0 );
		}
		$title = isset( $data['title'] ) ? sanitize_text_field( $data['title'] ) : 'Eric Mutema';
		if ( '' === $title ) {
			$title = 'Eric Mutema';
		}
		$existing = self::find_post_by_title( $title, 'safari_ranger' );
		$post_data = array(
			'post_type'    => 'safari_ranger',
			'post_title'   => $title,
			'post_content' => '',
			'post_status'  => 'publish',
		);
		if ( $existing ) {
			$post_data['ID'] = (int) $existing->ID;
			wp_update_post( $post_data );
			$post_id = $existing->ID;
		} else {
			$post_id = wp_insert_post( $post_data );
		}
		if ( ! $post_id || is_wp_error( $post_id ) ) {
			return array( 'success' => false, 'message' => 'Failed to create ranger post', 'count' => 0 );
		}
		update_post_meta( $post_id, self::SEED_KEY_META, 'seed-v1' );
		self::write_field( 'ranger_avatar_emoji', isset( $data['avatar_emoji'] ) ? sanitize_text_field( $data['avatar_emoji'] ) : '🦒', $post_id );

		if ( ! empty( $data['stats'] ) && is_array( $data['stats'] ) ) {
			foreach ( array_values( $data['stats'] ) as $i => $row ) {
				$n = $i + 1;
				if ( $n > 6 ) {
					break;
				}
				self::write_field( "ranger_stat_{$n}_value", isset( $row['value'] ) ? sanitize_text_field( $row['value'] ) : '', $post_id );
				self::write_field( "ranger_stat_{$n}_label", isset( $row['label'] ) ? sanitize_text_field( $row['label'] ) : '', $post_id );
			}
		}

		if ( ! empty( $data['bio_paragraphs'] ) && is_array( $data['bio_paragraphs'] ) ) {
			$bio_html = implode( "\n\n", array_map( function ( $p ) {
				return '<p>' . wp_kses_post( is_string( $p ) ? $p : '' ) . '</p>';
			}, $data['bio_paragraphs'] ) );
			self::write_field( 'ranger_bio', $bio_html, $post_id );
		}

		if ( ! empty( $data['specialties'] ) && is_array( $data['specialties'] ) ) {
			foreach ( array_values( $data['specialties'] ) as $i => $s ) {
				$n = $i + 1;
				if ( $n > 10 ) {
					break;
				}
				self::write_field( "ranger_specialty_{$n}", sanitize_text_field( is_string( $s ) ? $s : '' ), $post_id );
			}
		}

		if ( isset( $data['location'] ) ) {
			self::write_field( 'ranger_location', sanitize_text_field( $data['location'] ), $post_id );
		}
		if ( isset( $data['website'] ) ) {
			self::write_field( 'ranger_website', esc_url_raw( $data['website'] ), $post_id );
		}
		if ( isset( $data['availability'] ) ) {
			self::write_field( 'ranger_availability', sanitize_text_field( $data['availability'] ), $post_id );
		}
		return array( 'success' => true, 'count' => 1 );
	}

	/**
	 * Allowed option key prefixes for seed_defaults.
	 */
	private static $allowed_option_prefixes = array(
		'hero_'     => array( 'badge', 'tag', 'name', 'title', 'desc', 'mission_title', 'mission_sub', 'confirm_label', 'mini_log', 'scroll_hint', 'location', 'hud_label' ),
		'section_'  => array( 'toolkit_label', 'toolkit_title', 'toolkit_sub', 'sightings_label', 'sightings_title', 'sightings_sub', 'ranger_label', 'ranger_title', 'contact_label', 'contact_title', 'testimonials_label', 'testimonials_title', 'achievements_label', 'achievements_title', 'dispatches_label', 'dispatches_title' ),
		'show_'     => array( 'hero', 'toolkit', 'sightings', 'ranger', 'testimonials', 'achievements', 'contact', 'dispatches', 'hud', 'progress_bar', 'boot_screen' ),
		'contact_'  => array( 'quote', 'location', 'website', 'availability', 'form_source', 'form_shortcode', 'form_plugin_id' ),
		'hud_'      => array( 'logo', 'mission' ),
		'boot_'     => array( 'kicker' ),
	);

	public static function seed_defaults( $options = array() ) {
		$path = SAFARI_CPTS_PATH . 'seed-data/global-defaults.json';
		if ( ! is_readable( $path ) ) {
			return array( 'success' => false, 'message' => 'global-defaults.json not found', 'count' => 0 );
		}
		$data = json_decode( file_get_contents( $path ), true );
		if ( ! is_array( $data ) ) {
			return array( 'success' => false, 'message' => 'Invalid global-defaults.json', 'count' => 0 );
		}
		if ( ! class_exists( 'Safari_Settings' ) ) {
			return array( 'success' => false, 'message' => 'Safari_Settings not loaded', 'count' => 0 );
		}
		$count  = 0;
		$values = array(
			'show_hero'         => 1,
			'show_toolkit'      => 1,
			'show_sightings'    => 1,
			'show_ranger'       => 1,
			'show_testimonials' => 1,
			'show_achievements' => 1,
			'show_contact'      => 1,
			'show_dispatches'   => 1,
			'show_hud'          => 1,
			'show_progress_bar' => 1,
			'show_boot_screen'  => 1,
		);
		$count += count( $values );
		$group_prefixes = array(
			'hero'     => 'hero_',
			'sections' => 'section_',
			'contact'  => 'contact_',
			'boot'     => 'boot_',
		);
		foreach ( $group_prefixes as $group => $prefix ) {
			$allowed = isset( self::$allowed_option_prefixes[ $prefix ] ) ? self::$allowed_option_prefixes[ $prefix ] : array();
			if ( empty( $data[ $group ] ) || ! is_array( $data[ $group ] ) ) {
				continue;
			}
			foreach ( $data[ $group ] as $key => $value ) {
				if ( ! in_array( $key, $allowed, true ) ) {
					continue;
				}
				$field_name = $prefix . $key;
				$sanitized  = is_string( $value ) ? sanitize_text_field( $value ) : $value;
				if ( 'contact_website' === $field_name ) {
					$sanitized = is_string( $value ) ? esc_url_raw( $value ) : $value;
				}
				if ( 'contact_quote' === $field_name ) {
					$sanitized = is_string( $value ) ? sanitize_textarea_field( $value ) : $value;
				}
				$values[ $field_name ] = $sanitized;
				$count++;
			}
		}
		if ( ! empty( $data['hud'] ) && is_array( $data['hud'] ) ) {
			if ( isset( $data['hud']['logo'] ) ) {
				$values['hud_logo'] = sanitize_text_field( $data['hud']['logo'] );
				$count++;
			}
			if ( isset( $data['hud']['mission'] ) ) {
				$values['hud_mission'] = sanitize_text_field( $data['hud']['mission'] );
				$count++;
			}
			if ( ! empty( $data['hud']['nav_links'] ) && is_array( $data['hud']['nav_links'] ) ) {
				foreach ( array_values( $data['hud']['nav_links'] ) as $i => $link ) {
					$n = $i + 1;
					if ( $n > 6 ) {
						break;
					}
					$values[ "hud_nav_{$n}_label" ]  = isset( $link['label'] ) ? sanitize_text_field( $link['label'] ) : '';
					$values[ "hud_nav_{$n}_anchor" ] = isset( $link['anchor'] ) ? sanitize_text_field( $link['anchor'] ) : '';
				}
				$count++;
			}
		}
		Safari_Settings::set_many( $values );
		return array( 'success' => true, 'count' => $count );
	}

	public static function seed_all() {
		$results = array();
		$results['skills']   = self::seed_skills();
		$results['projects'] = self::seed_projects();
		$results['ranger']   = self::seed_ranger();
		$results['defaults'] = self::seed_defaults();
		return $results;
	}

	public static function register_ajax_seed() {
		add_action( 'wp_ajax_safari_seed_all', array( __CLASS__, 'ajax_seed_all' ) );
	}

	public static function ajax_seed_all() {
		check_ajax_referer( 'safari_seed_all', 'nonce' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => __( 'Permission denied.', 'safari-portfolio-core' ) ) );
		}
		$results = self::seed_all();
		$skills_count   = isset( $results['skills']['count'] ) ? $results['skills']['count'] : 0;
		$projects_count = isset( $results['projects']['count'] ) ? $results['projects']['count'] : 0;
		$ranger_count   = isset( $results['ranger']['count'] ) ? $results['ranger']['count'] : 0;
		$defaults_count = isset( $results['defaults']['count'] ) ? $results['defaults']['count'] : 0;
		wp_send_json_success( array(
			'results' => $results,
			'message' => sprintf(
				__( 'Seeded: %d skills, %d projects, %d ranger, %d global settings.', 'safari-portfolio-core' ),
				$skills_count,
				$projects_count,
				$ranger_count,
				$defaults_count
			),
		) );
	}

	public static function render_tools_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'safari-portfolio-core' ), 403 );
		}
		$nonce = wp_create_nonce( 'safari_seed_all' );
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Safari Seed Content', 'safari-portfolio-core' ); ?></h1>
			<p><?php esc_html_e( 'Load the default prototype content: skills (Field Equipment), projects (Wildlife Sightings), one Ranger profile, and global copy (hero, sections, contact, HUD).', 'safari-portfolio-core' ); ?></p>
			<p><?php esc_html_e( 'Safe to run again — existing items are updated, not duplicated.', 'safari-portfolio-core' ); ?></p>
			<p>
				<button type="button" id="safari-seed-all" class="button button-primary button-hero" data-nonce="<?php echo esc_attr( $nonce ); ?>">
					<?php esc_html_e( 'Seed all content', 'safari-portfolio-core' ); ?>
				</button>
			</p>
			<div id="safari-seed-result" style="margin-top:1em;" role="status" aria-live="polite"></div>
		</div>
		<script>
		(function() {
			var btn = document.getElementById('safari-seed-all');
			var result = document.getElementById('safari-seed-result');
			if (!btn || !result) return;
			btn.addEventListener('click', function() {
				btn.disabled = true;
				result.innerHTML = '<p>Seeding…</p>';
				fetch(ajaxurl, {
					method: 'POST',
					headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
					body: 'action=safari_seed_all&nonce=' + encodeURIComponent(btn.getAttribute('data-nonce'))
				})
				.then(function(r) { return r.json(); })
				.then(function(data) {
					btn.disabled = false;
					var msg = (data.success && data.data && data.data.message) ? data.data.message : 'Seed failed.';
					var color = data.success ? 'green' : 'red';
					result.innerHTML = '<p style="color:' + color + ';">' + msg + '</p>';
					if (data.data && data.data.results) {
						var details = [];
						var r = data.data.results;
						for (var k in r) {
							if (r[k] && !r[k].success && r[k].message) {
								details.push('<li style="color:red;">' + k + ': ' + r[k].message + '</li>');
							}
						}
						if (details.length) {
							result.innerHTML += '<ul>' + details.join('') + '</ul>';
						}
					}
				})
				.catch(function(err) {
					btn.disabled = false;
					result.innerHTML = '<p style="color:red;">Request failed: ' + err.message + '</p>';
				});
			});
		})();
		</script>
		<?php
	}
}
