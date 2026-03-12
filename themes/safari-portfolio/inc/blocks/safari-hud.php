<?php
/**
 * Safari HUD block — fixed header (logo, nav, rank, icons).
 *
 * @package Safari_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function safari_block_render_hud( $attributes ) {
	$attributes = is_array( $attributes ) ? $attributes : array();
	$logo    = isset( $attributes['logo'] ) ? sanitize_text_field( $attributes['logo'] ) : Safari_Settings::get( 'hud_logo' );
	$mission = isset( $attributes['mission'] ) ? sanitize_text_field( $attributes['mission'] ) : Safari_Settings::get( 'hud_mission' );
	$logo    = is_string( $logo ) && $logo ? $logo : 'Eric Mutema';
	$mission = is_string( $mission ) && $mission ? $mission : 'SAFARI PORTFOLIO';
	$nav_links = Safari_Settings::get_nav_links();
	$nav_links = array_filter( array_map( function ( $link ) {
		if ( ! is_array( $link ) ) {
			return null;
		}
		return array(
			'label'  => isset( $link['label'] ) ? sanitize_text_field( $link['label'] ) : '',
			'anchor' => isset( $link['anchor'] ) ? sanitize_text_field( $link['anchor'] ) : '#',
		);
	}, $nav_links ) );
	if ( empty( $nav_links ) ) {
		$nav_links = array(
			array( 'label' => 'Toolkit', 'anchor' => '#toolkit' ),
			array( 'label' => 'Sightings', 'anchor' => '#sightings' ),
			array( 'label' => 'The Ranger', 'anchor' => '#ranger' ),
			array( 'label' => 'Contact', 'anchor' => '#field-notes' ),
		);
	}
	ob_start();
	?>
	<header class="hud" role="banner">
		<div class="hud-left">
			<span class="hud-logo"><?php echo esc_html( $logo ); ?></span>
			<div class="hud-sep" aria-hidden="true"></div>
			<span class="hud-mission"><?php echo esc_html( $mission ); ?></span>
		</div>
		<div class="hud-right">
			<button type="button" class="hud-menu-toggle" id="hudMenuToggle" aria-label="<?php esc_attr_e( 'Toggle menu', 'safari-portfolio' ); ?>" aria-expanded="false" aria-controls="hudNav">
				<span class="hud-menu-icon" aria-hidden="true">☰</span>
			</button>
			<nav class="nav-links" id="hudNav" aria-label="<?php esc_attr_e( 'Main navigation', 'safari-portfolio' ); ?>">
				<?php foreach ( $nav_links as $link ) : ?>
					<a href="<?php echo esc_url( isset( $link['anchor'] ) ? $link['anchor'] : '#' ); ?>" class="nav-link"><?php echo esc_html( isset( $link['label'] ) ? $link['label'] : '' ); ?></a>
				<?php endforeach; ?>
			</nav>
			<button type="button" class="hud-icon-button" id="fieldGuideToggle" aria-label="<?php esc_attr_e( 'Open field guide', 'safari-portfolio' ); ?>">📖</button>
			<button type="button" class="hud-icon-button" id="audioToggle" aria-label="<?php esc_attr_e( 'Toggle ambient audio', 'safari-portfolio' ); ?>">🔈</button>
			<div class="hud-rank" aria-label="<?php esc_attr_e( 'Safari rank and experience', 'safari-portfolio' ); ?>">
				<div class="hud-rank-label" id="hudRankLabel"><?php esc_html_e( 'Rank 1 · Day Tripper', 'safari-portfolio' ); ?></div>
				<div class="hud-rank-bar" aria-hidden="true">
					<div class="hud-rank-fill" id="hudRankFill"></div>
				</div>
			</div>
			<div class="sightings-counter" role="status" aria-live="polite" aria-label="<?php esc_attr_e( 'Wildlife sightings count', 'safari-portfolio' ); ?>">
				<span class="icon" aria-hidden="true">🦁</span>
				<span class="count" id="sightingCount">0/9</span>
			</div>
			<div class="compass" aria-hidden="true">
				<div class="compass-needle"></div>
			</div>
		</div>
	</header>
	<?php
	return ob_get_clean();
}
