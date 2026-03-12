<?php
/**
 * Seed logic for skills, projects, ranger, and global defaults.
 * Used by WP-CLI and the one-click admin button.
 *
 * @package Safari_CPTs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Safari_Seed {

	const SEED_KEY_META = '_safari_seed_key';

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
			$existing = get_page_by_title( $item['name'], OBJECT, 'safari_skill' );
			$post_data = array(
				'post_type'    => 'safari_skill',
				'post_title'   => $item['name'],
				'post_excerpt' => isset( $item['desc'] ) ? $item['desc'] : '',
				'post_status'  => 'publish',
				'menu_order'   => $menu_order++,
			);
			if ( $existing ) {
				$post_data['ID'] = $existing->ID;
				wp_update_post( $post_data );
				$post_id = $existing->ID;
			} else {
				$post_id = wp_insert_post( $post_data );
			}
			if ( $post_id && ! is_wp_error( $post_id ) ) {
				update_post_meta( $post_id, self::SEED_KEY_META, 'seed-v1' );
				if ( function_exists( 'update_field' ) ) {
					update_field( 'skill_icon_emoji', isset( $item['icon'] ) ? $item['icon'] : '', $post_id );
					$level = isset( $item['level'] ) ? ( is_numeric( $item['level'] ) ? (int) $item['level'] : (int) str_replace( '%', '', $item['level'] ) ) : 0;
					update_field( 'skill_proficiency', $level, $post_id );
				}
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
			$existing = get_page_by_title( $item['name'], OBJECT, 'safari_project' );
			$post_data = array(
				'post_type'    => 'safari_project',
				'post_title'   => $item['name'],
				'post_excerpt' => isset( $item['desc'] ) ? $item['desc'] : '',
				'post_content' => '',
				'post_status'  => 'publish',
			);
			if ( $existing ) {
				$post_data['ID'] = $existing->ID;
				wp_update_post( $post_data );
				$post_id = $existing->ID;
			} else {
				$post_id = wp_insert_post( $post_data );
			}
			if ( $post_id && ! is_wp_error( $post_id ) ) {
				update_post_meta( $post_id, self::SEED_KEY_META, 'seed-v1' );
				if ( function_exists( 'update_field' ) ) {
					update_field( 'project_animal_emoji', isset( $item['animal'] ) ? $item['animal'] : '', $post_id );
					update_field( 'project_live_url', isset( $item['url'] ) ? $item['url'] : '', $post_id );
					update_field( 'project_featured', ! empty( $item['featured'] ), $post_id );
					if ( ! empty( $item['tools'] ) && is_array( $item['tools'] ) ) {
						update_field( 'project_tools_display', implode( ', ', $item['tools'] ), $post_id );
					}
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
		$title = isset( $data['title'] ) ? $data['title'] : 'Eric Mutema';
		$existing = get_page_by_title( $title, OBJECT, 'safari_ranger' );
		$post_data = array(
			'post_type'    => 'safari_ranger',
			'post_title'   => $title,
			'post_content' => '',
			'post_status'  => 'publish',
		);
		if ( $existing ) {
			$post_data['ID'] = $existing->ID;
			wp_update_post( $post_data );
			$post_id = $existing->ID;
		} else {
			$post_id = wp_insert_post( $post_data );
		}
		if ( ! $post_id || is_wp_error( $post_id ) ) {
			return array( 'success' => false, 'message' => 'Failed to create ranger post', 'count' => 0 );
		}
		update_post_meta( $post_id, self::SEED_KEY_META, 'seed-v1' );
		if ( function_exists( 'update_field' ) ) {
			update_field( 'ranger_avatar_emoji', isset( $data['avatar_emoji'] ) ? $data['avatar_emoji'] : '🦒', $post_id );
			if ( ! empty( $data['stats'] ) && is_array( $data['stats'] ) ) {
				$stats_rows = array_map( function ( $row ) {
					return array(
						'stat_value' => isset( $row['value'] ) ? $row['value'] : '',
						'stat_label' => isset( $row['label'] ) ? $row['label'] : '',
					);
				}, $data['stats'] );
				update_field( 'ranger_stats', $stats_rows, $post_id );
			}
			if ( ! empty( $data['bio_paragraphs'] ) && is_array( $data['bio_paragraphs'] ) ) {
				$bio_rows = array_map( function ( $p ) { return array( 'paragraph' => $p ); }, $data['bio_paragraphs'] );
				update_field( 'ranger_bio_paragraphs', $bio_rows, $post_id );
			}
			if ( ! empty( $data['specialties'] ) && is_array( $data['specialties'] ) ) {
				$spec = array_map( function ( $s ) { return array( 'specialty_text' => $s ); }, $data['specialties'] );
				update_field( 'ranger_specialties', $spec, $post_id );
			}
			if ( isset( $data['location'] ) ) {
				update_field( 'ranger_location', $data['location'], $post_id );
			}
			if ( isset( $data['website'] ) ) {
				update_field( 'ranger_website', $data['website'], $post_id );
			}
			if ( isset( $data['availability'] ) ) {
				update_field( 'ranger_availability', $data['availability'], $post_id );
			}
		}
		return array( 'success' => true, 'count' => 1 );
	}

	public static function seed_defaults( $options = array() ) {
		$path = SAFARI_CPTS_PATH . 'seed-data/global-defaults.json';
		if ( ! is_readable( $path ) ) {
			return array( 'success' => false, 'message' => 'global-defaults.json not found', 'count' => 0 );
		}
		$data = json_decode( file_get_contents( $path ), true );
		if ( ! is_array( $data ) ) {
			return array( 'success' => false, 'message' => 'Invalid global-defaults.json', 'count' => 0 );
		}
		$count = 0;
		if ( function_exists( 'update_field' ) ) {
			if ( ! empty( $data['hero'] ) ) {
				foreach ( $data['hero'] as $key => $value ) {
					update_field( 'hero_' . $key, $value, 'option' );
					$count++;
				}
			}
			if ( ! empty( $data['sections'] ) ) {
				foreach ( $data['sections'] as $key => $value ) {
					update_field( 'section_' . $key, $value, 'option' );
					$count++;
				}
			}
			if ( ! empty( $data['contact'] ) ) {
				foreach ( $data['contact'] as $key => $value ) {
					update_field( 'contact_' . $key, $value, 'option' );
					$count++;
				}
			}
			if ( ! empty( $data['hud'] ) ) {
				foreach ( $data['hud'] as $key => $value ) {
					if ( $key === 'nav_links' && is_array( $value ) ) {
						$rows = array_map( function ( $link ) {
							return array(
								'nav_label'  => isset( $link['label'] ) ? $link['label'] : '',
								'nav_anchor' => isset( $link['anchor'] ) ? $link['anchor'] : '',
							);
						}, $value );
						update_field( 'hud_nav_links', $rows, 'option' );
					} else {
						update_field( 'hud_' . $key, $value, 'option' );
					}
					$count++;
				}
			}
			if ( ! empty( $data['boot'] ) ) {
				foreach ( $data['boot'] as $key => $value ) {
					update_field( 'boot_' . $key, $value, 'option' );
					$count++;
				}
			}
		}
		return array( 'success' => true, 'count' => $count );
	}

	public static function seed_all() {
		$results = array();
		$results['skills']   = self::seed_skills();
		$results['projects'] = self::seed_projects();
		$results['ranger']  = self::seed_ranger();
		$results['defaults'] = self::seed_defaults();
		return $results;
	}

	public static function register_ajax_seed() {
		add_action( 'wp_ajax_safari_seed_all', array( __CLASS__, 'ajax_seed_all' ) );
	}

	public static function ajax_seed_all() {
		check_ajax_referer( 'safari_seed_all', 'nonce' );
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( array( 'message' => __( 'Permission denied.', 'safari-cpts' ) ) );
		}
		$results = self::seed_all();
		$skills_count   = isset( $results['skills']['count'] ) ? $results['skills']['count'] : 0;
		$projects_count = isset( $results['projects']['count'] ) ? $results['projects']['count'] : 0;
		$ranger_count   = isset( $results['ranger']['count'] ) ? $results['ranger']['count'] : 0;
		wp_send_json_success( array(
			'results' => $results,
			'message' => sprintf(
				__( 'Default content seeded: %d skills, %d projects, %d ranger profile, and global defaults.', 'safari-cpts' ),
				$skills_count,
				$projects_count,
				$ranger_count
			),
		) );
	}

	public static function add_tools_page() {
		add_submenu_page(
			'edit.php?post_type=safari_project',
			__( 'Seed Content', 'safari-cpts' ),
			__( 'Seed Content', 'safari-cpts' ),
			'manage_options',
			'safari-seed-content',
			array( __CLASS__, 'render_tools_page' )
		);
	}

	public static function render_tools_page() {
		$nonce = wp_create_nonce( 'safari_seed_all' );
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Safari Seed Content', 'safari-cpts' ); ?></h1>
			<p><?php esc_html_e( 'Load the default prototype content: skills (Field Equipment), projects (Wildlife Sightings), one Ranger profile, and global copy (hero, sections, contact, HUD). Safe to run again; existing items are skipped or updated.', 'safari-cpts' ); ?></p>
			<p>
				<button type="button" id="safari-seed-all" class="button button-primary button-hero" data-nonce="<?php echo esc_attr( $nonce ); ?>">
					<?php esc_html_e( 'Seed all content', 'safari-cpts' ); ?>
				</button>
			</p>
			<div id="safari-seed-result" style="margin-top:1em;"></div>
		</div>
		<script>
		document.getElementById('safari-seed-all').addEventListener('click', function() {
			var btn = this;
			var result = document.getElementById('safari-seed-result');
			btn.disabled = true;
			result.innerHTML = '<p><?php esc_html_e( 'Seeding…', 'safari-cpts' ); ?></p>';
			fetch(ajaxurl, {
				method: 'POST',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
				body: 'action=safari_seed_all&nonce=' + encodeURIComponent(btn.dataset.nonce)
			})
			.then(function(r) { return r.json(); })
			.then(function(data) {
				btn.disabled = false;
				if (data.success && data.data.message) {
					result.innerHTML = '<p style="color:green;">' + data.data.message + '</p>';
				} else {
					result.innerHTML = '<p style="color:red;">' + (data.data && data.data.message ? data.data.message : '<?php esc_html_e( 'Seed failed.', 'safari-cpts' ); ?>') + '</p>';
				}
			})
			.catch(function() {
				btn.disabled = false;
				result.innerHTML = '<p style="color:red;"><?php esc_html_e( 'Request failed.', 'safari-cpts' ); ?></p>';
			});
		});
		</script>
		<?php
	}
}
