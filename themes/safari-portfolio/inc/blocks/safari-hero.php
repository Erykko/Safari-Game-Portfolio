<?php
/**
 * Safari Hero (Base Camp) block — render callback.
 * Output matches index.html #base-camp structure.
 *
 * @package Safari_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function safari_block_render_hero( $attributes ) {
	$attributes = is_array( $attributes ) ? $attributes : array();
	$badge   = isset( $attributes['badge'] ) ? sanitize_text_field( $attributes['badge'] ) : Safari_Settings::get( 'hero_badge', 'Est. Digital Safari' );
	$tag     = isset( $attributes['tag'] ) ? sanitize_text_field( $attributes['tag'] ) : Safari_Settings::get( 'hero_tag', 'Welcome to Base Camp' );
	$name    = isset( $attributes['name'] ) ? sanitize_text_field( $attributes['name'] ) : Safari_Settings::get( 'hero_name', 'Eric Mutema' );
	$title   = isset( $attributes['title'] ) ? sanitize_text_field( $attributes['title'] ) : Safari_Settings::get( 'hero_title', 'WordPress Developer' );
	$desc    = isset( $attributes['desc'] ) ? sanitize_textarea_field( $attributes['desc'] ) : Safari_Settings::get( 'hero_desc', "In the vast digital savanna, ideas roam wild. This base camp is your briefing tent — choose your mission and I'll guide you through the terrain: toolkit, sightings, or the ranger's story." );
	$mission_title = isset( $attributes['missionTitle'] ) ? sanitize_text_field( $attributes['missionTitle'] ) : Safari_Settings::get( 'hero_mission_title', 'Select Your First Safari Mission' );
	$mission_sub   = isset( $attributes['missionSub'] ) ? sanitize_text_field( $attributes['missionSub'] ) : Safari_Settings::get( 'hero_mission_sub', 'A short briefing that shapes how you enter the trail.' );
	$confirm_label = isset( $attributes['confirmLabel'] ) ? sanitize_text_field( $attributes['confirmLabel'] ) : Safari_Settings::get( 'hero_confirm_label', 'Confirm Safari & Begin' );
	$mini_log = isset( $attributes['miniLog'] ) ? sanitize_text_field( $attributes['miniLog'] ) : Safari_Settings::get( 'hero_mini_log', 'Choose a time of day and mission to begin your safari.' );
	$scroll_hint = isset( $attributes['scrollHint'] ) ? sanitize_text_field( $attributes['scrollHint'] ) : Safari_Settings::get( 'hero_scroll_hint', 'Scroll to explore' );
	$location = isset( $attributes['location'] ) ? sanitize_text_field( $attributes['location'] ) : Safari_Settings::get( 'hero_location', 'Nairobi, Kenya' );
	$hud_label = isset( $attributes['hudLabel'] ) ? sanitize_text_field( $attributes['hudLabel'] ) : Safari_Settings::get( 'hero_hud_label', 'Digital Safari Mission Console' );
	if ( '' === $badge ) {
		$badge = 'Est. Digital Safari';
	}
	if ( '' === $name ) {
		$name = 'Eric Mutema';
	}

	$name_br = str_replace( ' ', '<br>', esc_html( $name ) );
	ob_start();
	?>
	<section id="base-camp" aria-label="Base Camp — Hero">
		<div class="stars" aria-hidden="true" id="starsContainer"></div>
		<div class="dust-container" aria-hidden="true" id="dustContainer"></div>
		<div class="hero-balloons" aria-hidden="true">
			<div class="balloon balloon-1"></div>
			<div class="balloon balloon-2"></div>
		</div>
		<div class="hero-birds" aria-hidden="true">
			<div class="bird bird-1"></div>
			<div class="bird bird-2"></div>
			<div class="bird bird-3"></div>
		</div>
		<div class="hero-frame">
			<div class="hero-hud-bar">
				<div class="hero-hud-meta">
					<span class="hero-hud-location">🌍 <?php echo esc_html( $location ); ?></span>
					<span class="hero-hud-sep">·</span>
					<span class="hero-hud-label"><?php echo esc_html( $hud_label ); ?></span>
				</div>
				<div class="hero-hud-rank-mini" id="heroHudRankMini">Rank 1 · Day Tripper · 0 XP</div>
			</div>
			<div class="hero-main">
				<div class="hero-content">
					<p class="hero-badge"><?php echo esc_html( $badge ); ?></p>
					<div class="hero-tag"><span aria-hidden="true">🧭</span><span><?php echo esc_html( $tag ); ?></span></div>
					<h1 class="hero-name"><?php echo $name_br; ?></h1>
					<p class="hero-title-line"><?php echo esc_html( $title ); ?></p>
					<p class="hero-desc"><?php echo esc_html( $desc ); ?></p>
				</div>
				<section class="hero-mission-console" id="heroMission" aria-label="Safari mission setup">
					<header class="hero-mission-header">
						<p class="hero-mission-title"><?php echo esc_html( $mission_title ); ?></p>
						<p class="hero-mission-sub"><?php echo esc_html( $mission_sub ); ?></p>
					</header>
					<div class="hero-mission-steps" aria-hidden="true">
						<div class="hero-mission-step is-active" data-step="1">1 · Time of Day</div>
						<div class="hero-mission-step" data-step="2">2 · Mission Type</div>
						<div class="hero-mission-step" data-step="3">3 · Confirm Safari</div>
					</div>
					<div class="hero-mission-body">
						<div class="hero-mission-group">
							<p class="hero-mission-label">Step 1 · Choose Time of Day</p>
							<div class="hero-pill-row" role="radiogroup" aria-label="Time of day">
								<button type="button" class="hero-pill" data-time="dawn">Dawn Patrol</button>
								<button type="button" class="hero-pill" data-time="golden">Golden Hour</button>
								<button type="button" class="hero-pill" data-time="night">Night Safari</button>
							</div>
						</div>
						<div class="hero-mission-group">
							<p class="hero-mission-label">Step 2 · Choose Mission</p>
							<div class="hero-pill-row" role="radiogroup" aria-label="Mission type">
								<button type="button" class="hero-pill" data-mission="toolkit">Explore Toolkit</button>
								<button type="button" class="hero-pill" data-mission="sightings">Track Sightings</button>
								<button type="button" class="hero-pill" data-mission="ranger">Meet The Ranger</button>
							</div>
						</div>
						<button type="button" class="hero-mission-confirm" id="heroMissionConfirm" disabled><?php echo esc_html( $confirm_label ); ?></button>
					</div>
				</section>
			</div>
			<div class="hero-mini-log" id="heroMissionLog" role="status" aria-live="polite"><?php echo esc_html( $mini_log ); ?></div>
		</div>
		<div class="scroll-hint" id="scrollHint" aria-hidden="true">
			<span><?php echo esc_html( $scroll_hint ); ?></span>
			<div class="scroll-arrow"></div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
