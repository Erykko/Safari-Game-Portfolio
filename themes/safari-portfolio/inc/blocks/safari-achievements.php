<?php
/**
 * Safari Achievements (Field Medals) block — collectable badge panel.
 *
 * Renders an empty container that game.js populates with badge cards.
 * Achievement data is passed to JS via SafariData.achievements.
 *
 * @package Safari_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function safari_block_render_achievements( $attributes ) {
	$attributes = is_array( $attributes ) ? $attributes : array();

	$label_source = isset( $attributes['sectionLabel'] ) ? $attributes['sectionLabel'] : Safari_Settings::get( 'section_achievements_label' );
	$title_source = isset( $attributes['sectionTitle'] ) ? $attributes['sectionTitle'] : Safari_Settings::get( 'section_achievements_title' );

	$label = $label_source ?: 'Trophies Earned';
	$title = $title_source ?: 'Field Medals';

	if ( ! post_type_exists( 'safari_achievement' ) ) {
		return '';
	}

	$query = new WP_Query( array(
		'post_type'      => 'safari_achievement',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	) );

	if ( ! $query->have_posts() ) {
		return '';
	}

	ob_start();
	?>
	<section class="section" id="field-medals" aria-labelledby="medals-heading">
		<div class="section-inner">
			<p class="section-label"><?php echo esc_html( $label ); ?></p>
			<h2 class="section-title" id="medals-heading"><?php echo esc_html( $title ); ?></h2>
			<p class="section-sub medals-sub"><?php esc_html_e( 'Unlock badges by exploring the safari. Greyed-out medals are still waiting to be discovered.', 'safari-portfolio' ); ?></p>
			<div class="medals-grid" id="medalsGrid" role="list" aria-label="<?php esc_attr_e( 'Achievement badges', 'safari-portfolio' ); ?>">
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
					<?php
					$pid        = get_the_ID();
					$icon       = safari_read_field( 'achievement_icon', $pid ) ?: '🏆';
					$trigger_id = safari_read_field( 'achievement_trigger_id', $pid );
					$desc       = safari_read_field( 'achievement_description', $pid ) ?: get_the_excerpt();
					$rarity     = safari_read_field( 'achievement_rarity', $pid ) ?: 'common';
					$xp         = (int) safari_read_field( 'achievement_xp_reward', $pid );
					$xp         = $xp ?: 100;
					?>
					<div class="medal-card medal-locked"
						 role="listitem"
						 data-trigger="<?php echo esc_attr( $trigger_id ); ?>"
						 data-rarity="<?php echo esc_attr( $rarity ); ?>">
						<div class="medal-icon"><?php echo esc_html( $icon ); ?></div>
						<div class="medal-name"><?php echo esc_html( get_the_title() ); ?></div>
						<div class="medal-desc"><?php echo esc_html( $desc ); ?></div>
						<div class="medal-meta">
							<span class="medal-rarity medal-rarity--<?php echo esc_attr( $rarity ); ?>"><?php echo esc_html( ucfirst( $rarity ) ); ?></span>
							<span class="medal-xp">+<?php echo (int) $xp; ?> XP</span>
						</div>
					</div>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
