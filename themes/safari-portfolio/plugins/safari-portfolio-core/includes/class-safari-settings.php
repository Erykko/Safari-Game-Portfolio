<?php
/**
 * Safari Global Settings — native WordPress settings page.
 * No ACF Pro required. Stores all settings as serialized options.
 *
 * @package Safari_Portfolio_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Safari_Settings {

	const OPTION_KEY = 'safari_global_settings';

	private static $defaults = array(
		'show_hero'           => 1,
		'show_toolkit'        => 1,
		'show_sightings'      => 1,
		'show_ranger'         => 1,
		'show_testimonials'   => 1,
		'show_achievements'   => 1,
		'show_contact'        => 1,
		'show_dispatches'     => 1,
		'show_hud'            => 1,
		'show_progress_bar'   => 1,
		'show_boot_screen'    => 1,

		'hero_badge'          => '',
		'hero_tag'            => '',
		'hero_name'           => '',
		'hero_title'          => '',
		'hero_desc'           => '',
		'hero_mission_title'  => '',
		'hero_mission_sub'    => '',
		'hero_confirm_label'  => '',
		'hero_mini_log'       => '',
		'hero_scroll_hint'    => '',
		'hero_location'       => '',
		'hero_hud_label'      => '',

		'section_toolkit_label'      => '',
		'section_toolkit_title'      => '',
		'section_toolkit_sub'        => '',
		'section_sightings_label'    => '',
		'section_sightings_title'    => '',
		'section_sightings_sub'      => '',
		'section_ranger_label'       => '',
		'section_ranger_title'       => '',
		'section_contact_label'      => '',
		'section_contact_title'      => '',
		'section_testimonials_label' => '',
		'section_testimonials_title' => '',
		'section_achievements_label' => '',
		'section_achievements_title' => '',
		'section_dispatches_label'   => '',
		'section_dispatches_title'   => '',

		'contact_quote'        => '',
		'contact_location'     => '',
		'contact_website'      => '',
		'contact_availability' => '',
		'contact_form_source'  => 'built_in',
		'contact_form_shortcode'  => '',
		'contact_form_plugin_id'  => '',

		'hud_logo'    => '',
		'hud_mission' => '',
		'hud_nav_1_label'  => '',
		'hud_nav_1_anchor' => '',
		'hud_nav_2_label'  => '',
		'hud_nav_2_anchor' => '',
		'hud_nav_3_label'  => '',
		'hud_nav_3_anchor' => '',
		'hud_nav_4_label'  => '',
		'hud_nav_4_anchor' => '',
		'hud_nav_5_label'  => '',
		'hud_nav_5_anchor' => '',
		'hud_nav_6_label'  => '',
		'hud_nav_6_anchor' => '',

		'boot_kicker' => '',
	);

	public static function get_defaults() {
		return self::$defaults;
	}

	/**
	 * Get a single setting value.
	 */
	public static function get( $key, $fallback = '' ) {
		$opts = get_option( self::OPTION_KEY, array() );
		if ( isset( $opts[ $key ] ) && '' !== $opts[ $key ] ) {
			return $opts[ $key ];
		}
		if ( '' !== $fallback ) {
			return $fallback;
		}
		return isset( self::$defaults[ $key ] ) ? self::$defaults[ $key ] : '';
	}

	/**
	 * Get all settings merged with defaults.
	 */
	public static function get_all() {
		$opts = get_option( self::OPTION_KEY, array() );
		return wp_parse_args( $opts, self::$defaults );
	}

	/**
	 * Update a single setting.
	 */
	public static function set( $key, $value ) {
		$opts = get_option( self::OPTION_KEY, array() );
		$opts[ $key ] = $value;
		update_option( self::OPTION_KEY, $opts );
	}

	/**
	 * Bulk-update settings.
	 */
	public static function set_many( $data ) {
		$opts = get_option( self::OPTION_KEY, array() );
		foreach ( $data as $key => $value ) {
			if ( array_key_exists( $key, self::$defaults ) ) {
				$opts[ $key ] = $value;
			}
		}
		update_option( self::OPTION_KEY, $opts );
	}

	/**
	 * Get HUD nav links as an array of arrays.
	 */
	public static function get_nav_links() {
		$links = array();
		for ( $i = 1; $i <= 6; $i++ ) {
			$label  = self::get( "hud_nav_{$i}_label" );
			$anchor = self::get( "hud_nav_{$i}_anchor" );
			if ( $label && $anchor ) {
				$links[] = array( 'label' => $label, 'anchor' => $anchor );
			}
		}
		return $links;
	}

	public static function register() {
		add_action( 'admin_init', array( __CLASS__, 'register_setting' ) );
	}

	public static function register_setting() {
		register_setting( 'safari_settings_group', self::OPTION_KEY, array(
			'type'              => 'array',
			'sanitize_callback' => array( __CLASS__, 'sanitize' ),
		) );
	}

	private static $tab_keys = array(
		'modules' => array(
			'show_hero', 'show_toolkit', 'show_sightings', 'show_ranger',
			'show_testimonials', 'show_achievements', 'show_contact',
			'show_dispatches', 'show_hud', 'show_progress_bar', 'show_boot_screen',
		),
		'hero' => array(
			'hero_badge', 'hero_tag', 'hero_name', 'hero_title', 'hero_desc',
			'hero_mission_title', 'hero_mission_sub', 'hero_confirm_label',
			'hero_mini_log', 'hero_scroll_hint', 'hero_location', 'hero_hud_label',
		),
		'labels' => array(
			'section_toolkit_label', 'section_toolkit_title', 'section_toolkit_sub',
			'section_sightings_label', 'section_sightings_title', 'section_sightings_sub',
			'section_ranger_label', 'section_ranger_title',
			'section_contact_label', 'section_contact_title',
			'section_testimonials_label', 'section_testimonials_title',
			'section_achievements_label', 'section_achievements_title',
			'section_dispatches_label', 'section_dispatches_title',
		),
		'contact' => array(
			'contact_form_source', 'contact_form_plugin_id', 'contact_form_shortcode',
			'contact_quote', 'contact_location', 'contact_website', 'contact_availability',
		),
		'hud' => array(
			'hud_logo', 'hud_mission',
			'hud_nav_1_label', 'hud_nav_1_anchor', 'hud_nav_2_label', 'hud_nav_2_anchor',
			'hud_nav_3_label', 'hud_nav_3_anchor', 'hud_nav_4_label', 'hud_nav_4_anchor',
			'hud_nav_5_label', 'hud_nav_5_anchor', 'hud_nav_6_label', 'hud_nav_6_anchor',
		),
		'boot' => array( 'boot_kicker' ),
	);

	private static $toggles = array(
		'show_hero', 'show_toolkit', 'show_sightings', 'show_ranger',
		'show_testimonials', 'show_achievements', 'show_contact',
		'show_dispatches', 'show_hud', 'show_progress_bar', 'show_boot_screen',
	);

	public static function sanitize( $input ) {
		$existing = get_option( self::OPTION_KEY, array() );
		$clean = wp_parse_args( $existing, self::$defaults );

		$tab = isset( $input['_safari_tab'] ) ? sanitize_text_field( $input['_safari_tab'] ) : '';
		$keys_to_update = isset( self::$tab_keys[ $tab ] ) ? self::$tab_keys[ $tab ] : array_keys( self::$defaults );

		foreach ( $keys_to_update as $key ) {
			if ( ! array_key_exists( $key, self::$defaults ) ) {
				continue;
			}
			if ( in_array( $key, self::$toggles, true ) ) {
				$clean[ $key ] = ! empty( $input[ $key ] ) ? 1 : 0;
			} elseif ( 'contact_website' === $key ) {
				$clean[ $key ] = isset( $input[ $key ] ) ? esc_url_raw( $input[ $key ] ) : '';
			} elseif ( in_array( $key, array( 'hero_desc', 'section_toolkit_sub', 'section_sightings_sub', 'contact_quote' ), true ) ) {
				$clean[ $key ] = isset( $input[ $key ] ) ? sanitize_textarea_field( $input[ $key ] ) : '';
			} else {
				$clean[ $key ] = isset( $input[ $key ] ) ? sanitize_text_field( $input[ $key ] ) : '';
			}
		}
		return $clean;
	}

	public static function render_page() {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$opts = self::get_all();
		$tab  = isset( $_GET['tab'] ) ? sanitize_text_field( wp_unslash( $_GET['tab'] ) ) : 'modules';
		$tabs = array(
			'modules'  => __( 'Sections', 'safari-portfolio-core' ),
			'hero'     => __( 'Hero', 'safari-portfolio-core' ),
			'labels'   => __( 'Section Labels', 'safari-portfolio-core' ),
			'contact'  => __( 'Contact', 'safari-portfolio-core' ),
			'hud'      => __( 'HUD', 'safari-portfolio-core' ),
			'boot'     => __( 'Boot Screen', 'safari-portfolio-core' ),
		);
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Safari — Global Settings', 'safari-portfolio-core' ); ?></h1>
			<nav class="nav-tab-wrapper">
				<?php foreach ( $tabs as $slug => $label ) : ?>
					<a href="<?php echo esc_url( add_query_arg( 'tab', $slug ) ); ?>"
					   class="nav-tab <?php echo $tab === $slug ? 'nav-tab-active' : ''; ?>"><?php echo esc_html( $label ); ?></a>
				<?php endforeach; ?>
			</nav>
			<form method="post" action="options.php">
				<?php settings_fields( 'safari_settings_group' ); ?>
				<input type="hidden" name="<?php echo esc_attr( self::OPTION_KEY ); ?>[_safari_tab]" value="<?php echo esc_attr( $tab ); ?>">
				<table class="form-table" role="presentation">
					<?php
					switch ( $tab ) {
						case 'modules':
							self::render_toggles( $opts );
							break;
						case 'hero':
							self::render_hero( $opts );
							break;
						case 'labels':
							self::render_labels( $opts );
							break;
						case 'contact':
							self::render_contact( $opts );
							break;
						case 'hud':
							self::render_hud( $opts );
							break;
						case 'boot':
							self::render_boot( $opts );
							break;
					}
					?>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}

	/* ── Tab renderers ───────────────────────────────── */

	private static function toggle_row( $key, $label, $opts ) {
		$name = self::OPTION_KEY . '[' . $key . ']';
		$checked = ! empty( $opts[ $key ] ) ? 'checked' : '';
		echo '<tr><th scope="row">' . esc_html( $label ) . '</th>';
		echo '<td><label><input type="checkbox" name="' . esc_attr( $name ) . '" value="1" ' . $checked . '> ' . esc_html__( 'Visible', 'safari-portfolio-core' ) . '</label></td></tr>';
	}

	private static function text_row( $key, $label, $opts, $placeholder = '', $type = 'text' ) {
		$name = self::OPTION_KEY . '[' . $key . ']';
		$val  = isset( $opts[ $key ] ) ? $opts[ $key ] : '';
		echo '<tr><th scope="row"><label for="safari_' . esc_attr( $key ) . '">' . esc_html( $label ) . '</label></th>';
		echo '<td><input type="' . esc_attr( $type ) . '" id="safari_' . esc_attr( $key ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $val ) . '" class="regular-text" placeholder="' . esc_attr( $placeholder ) . '"></td></tr>';
	}

	private static function textarea_row( $key, $label, $opts, $placeholder = '' ) {
		$name = self::OPTION_KEY . '[' . $key . ']';
		$val  = isset( $opts[ $key ] ) ? $opts[ $key ] : '';
		echo '<tr><th scope="row"><label for="safari_' . esc_attr( $key ) . '">' . esc_html( $label ) . '</label></th>';
		echo '<td><textarea id="safari_' . esc_attr( $key ) . '" name="' . esc_attr( $name ) . '" rows="3" class="large-text" placeholder="' . esc_attr( $placeholder ) . '">' . esc_textarea( $val ) . '</textarea></td></tr>';
	}

	private static function render_toggles( $opts ) {
		self::toggle_row( 'show_hero', __( 'Hero (Base Camp)', 'safari-portfolio-core' ), $opts );
		self::toggle_row( 'show_toolkit', __( 'Toolkit', 'safari-portfolio-core' ), $opts );
		self::toggle_row( 'show_sightings', __( 'Sightings', 'safari-portfolio-core' ), $opts );
		self::toggle_row( 'show_ranger', __( 'Ranger', 'safari-portfolio-core' ), $opts );
		self::toggle_row( 'show_testimonials', __( 'Testimonials (Animal Tracks)', 'safari-portfolio-core' ), $opts );
		self::toggle_row( 'show_achievements', __( 'Achievements (Field Medals)', 'safari-portfolio-core' ), $opts );
		self::toggle_row( 'show_contact', __( 'Contact (Field Notes)', 'safari-portfolio-core' ), $opts );
		self::toggle_row( 'show_dispatches', __( 'Dispatches (Field Dispatches)', 'safari-portfolio-core' ), $opts );
		self::toggle_row( 'show_hud', __( 'HUD', 'safari-portfolio-core' ), $opts );
		self::toggle_row( 'show_progress_bar', __( 'Progress Bar', 'safari-portfolio-core' ), $opts );
		self::toggle_row( 'show_boot_screen', __( 'Boot Screen', 'safari-portfolio-core' ), $opts );
	}

	private static function render_hero( $opts ) {
		self::text_row( 'hero_badge', __( 'Badge', 'safari-portfolio-core' ), $opts, '🎯 AVAILABLE FOR HIRE' );
		self::text_row( 'hero_tag', __( 'Tag', 'safari-portfolio-core' ), $opts, 'FIELD OPERATIVE • NAIROBI SECTOR' );
		self::text_row( 'hero_name', __( 'Name', 'safari-portfolio-core' ), $opts, 'Eric Mutema' );
		self::text_row( 'hero_title', __( 'Title', 'safari-portfolio-core' ), $opts, 'Full-Stack Developer & Digital Ranger' );
		self::textarea_row( 'hero_desc', __( 'Description', 'safari-portfolio-core' ), $opts );
		self::text_row( 'hero_mission_title', __( 'Mission title', 'safari-portfolio-core' ), $opts );
		self::text_row( 'hero_mission_sub', __( 'Mission subtitle', 'safari-portfolio-core' ), $opts );
		self::text_row( 'hero_confirm_label', __( 'Confirm button', 'safari-portfolio-core' ), $opts, 'Accept Mission' );
		self::text_row( 'hero_mini_log', __( 'Mini log text', 'safari-portfolio-core' ), $opts );
		self::text_row( 'hero_scroll_hint', __( 'Scroll hint', 'safari-portfolio-core' ), $opts );
		self::text_row( 'hero_location', __( 'Location', 'safari-portfolio-core' ), $opts, 'Nairobi, Kenya' );
		self::text_row( 'hero_hud_label', __( 'HUD label', 'safari-portfolio-core' ), $opts );
	}

	private static function render_labels( $opts ) {
		$sections = array(
			'toolkit'      => __( 'Toolkit', 'safari-portfolio-core' ),
			'sightings'    => __( 'Sightings', 'safari-portfolio-core' ),
			'ranger'       => __( 'Ranger', 'safari-portfolio-core' ),
			'contact'      => __( 'Contact', 'safari-portfolio-core' ),
			'testimonials' => __( 'Testimonials', 'safari-portfolio-core' ),
			'achievements' => __( 'Achievements', 'safari-portfolio-core' ),
			'dispatches'   => __( 'Dispatches', 'safari-portfolio-core' ),
		);
		foreach ( $sections as $slug => $name ) {
			self::text_row( "section_{$slug}_label", sprintf( __( '%s — label', 'safari-portfolio-core' ), $name ), $opts );
			self::text_row( "section_{$slug}_title", sprintf( __( '%s — title', 'safari-portfolio-core' ), $name ), $opts );
			if ( in_array( $slug, array( 'toolkit', 'sightings' ), true ) ) {
				self::textarea_row( "section_{$slug}_sub", sprintf( __( '%s — subtitle', 'safari-portfolio-core' ), $name ), $opts );
			}
		}
	}

	private static function render_contact( $opts ) {
		$name_prefix = self::OPTION_KEY;
		$source = isset( $opts['contact_form_source'] ) ? $opts['contact_form_source'] : 'built_in';

		echo '<tr><th scope="row">' . esc_html__( 'Contact form', 'safari-portfolio-core' ) . '</th><td>';
		echo '<fieldset>';
		echo '<label><input type="radio" name="' . esc_attr( $name_prefix ) . '[contact_form_source]" value="built_in" ' . checked( $source, 'built_in', false ) . '> ' . esc_html__( 'Built-in Safari form', 'safari-portfolio-core' ) . '</label><br>';

		if ( function_exists( 'safari_detect_plugin_forms' ) ) {
			$plugin_forms = safari_detect_plugin_forms();
			if ( ! empty( $plugin_forms ) ) {
				echo '<label><input type="radio" name="' . esc_attr( $name_prefix ) . '[contact_form_source]" value="plugin_form" ' . checked( $source, 'plugin_form', false ) . '> ' . esc_html__( 'Plugin form', 'safari-portfolio-core' ) . '</label><br>';
			}
		}

		echo '<label><input type="radio" name="' . esc_attr( $name_prefix ) . '[contact_form_source]" value="shortcode" ' . checked( $source, 'shortcode', false ) . '> ' . esc_html__( 'Custom shortcode', 'safari-portfolio-core' ) . '</label>';
		echo '</fieldset></td></tr>';

		if ( ! empty( $plugin_forms ) ) {
			$selected_plugin = isset( $opts['contact_form_plugin_id'] ) ? $opts['contact_form_plugin_id'] : '';
			echo '<tr><th scope="row"><label for="safari_contact_form_plugin_id">' . esc_html__( 'Select plugin form', 'safari-portfolio-core' ) . '</label></th>';
			echo '<td><select id="safari_contact_form_plugin_id" name="' . esc_attr( $name_prefix ) . '[contact_form_plugin_id]">';
			echo '<option value="">' . esc_html__( '— Select —', 'safari-portfolio-core' ) . '</option>';
			foreach ( $plugin_forms as $val => $lbl ) {
				echo '<option value="' . esc_attr( $val ) . '" ' . selected( $selected_plugin, $val, false ) . '>' . esc_html( $lbl ) . '</option>';
			}
			echo '</select></td></tr>';
		}

		self::text_row( 'contact_form_shortcode', __( 'Form shortcode', 'safari-portfolio-core' ), $opts, '[contact-form-7 id="123"]' );
		self::textarea_row( 'contact_quote', __( 'Quote', 'safari-portfolio-core' ), $opts );
		self::text_row( 'contact_location', __( 'Location', 'safari-portfolio-core' ), $opts, 'Nairobi, Kenya' );
		self::text_row( 'contact_website', __( 'Website', 'safari-portfolio-core' ), $opts, 'designnairobi.agency', 'url' );
		self::text_row( 'contact_availability', __( 'Availability', 'safari-portfolio-core' ), $opts, 'Available for remote & local projects' );
	}

	private static function render_hud( $opts ) {
		self::text_row( 'hud_logo', __( 'Logo text', 'safari-portfolio-core' ), $opts );
		self::text_row( 'hud_mission', __( 'Mission label', 'safari-portfolio-core' ), $opts );
		echo '<tr><th colspan="2"><h3>' . esc_html__( 'Navigation Links (up to 6)', 'safari-portfolio-core' ) . '</h3></th></tr>';
		for ( $i = 1; $i <= 6; $i++ ) {
			self::text_row( "hud_nav_{$i}_label", sprintf( __( 'Link %d — label', 'safari-portfolio-core' ), $i ), $opts, 'e.g. Base Camp' );
			self::text_row( "hud_nav_{$i}_anchor", sprintf( __( 'Link %d — anchor/URL', 'safari-portfolio-core' ), $i ), $opts, 'e.g. #base-camp' );
		}
	}

	private static function render_boot( $opts ) {
		self::text_row( 'boot_kicker', __( 'Kicker text', 'safari-portfolio-core' ), $opts, 'Safari Portfolio · Nairobi, Kenya' );
	}
}
