<?php
/**
 * Safari Ranger block — section + portrait, stats, bio, specialties from safari_ranger CPT + ACF.
 *
 * @package Safari_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function safari_block_render_ranger( $attributes ) {
	$label = isset( $attributes['sectionLabel'] ) ? $attributes['sectionLabel'] : ( function_exists( 'get_field' ) ? get_field( 'section_ranger_label', 'option' ) : null ) ?: 'Field Guide';
	$title = isset( $attributes['sectionTitle'] ) ? $attributes['sectionTitle'] : ( function_exists( 'get_field' ) ? get_field( 'section_ranger_title', 'option' ) : null ) ?: 'The Ranger';

	$ranger = new WP_Query( array(
		'post_type'      => 'safari_ranger',
		'posts_per_page' => 1,
		'post_status'    => 'publish',
		'orderby'        => 'date',
		'order'          => 'DESC',
	) );
	$avatar = '🦒';
	$stats  = array();
	$bio_paragraphs = array();
	$specialties = array();
	$location = '';
	$website = '';
	$availability = '';
	if ( $ranger->have_posts() ) {
		$post_id = $ranger->posts[0]->ID;
		if ( function_exists( 'get_field' ) ) {
			$avatar         = get_field( 'ranger_avatar_emoji', $post_id ) ?: '🦒';
			$stats          = get_field( 'ranger_stats', $post_id ) ?: array();
			$bio_paragraphs = get_field( 'ranger_bio_paragraphs', $post_id ) ?: array();
			$specialties_raw = get_field( 'ranger_specialties', $post_id ) ?: array();
			foreach ( $specialties_raw as $row ) {
				$specialties[] = isset( $row['specialty_text'] ) ? $row['specialty_text'] : '';
			}
			$location    = get_field( 'ranger_location', $post_id ) ?: '';
			$website     = get_field( 'ranger_website', $post_id ) ?: '';
			$availability = get_field( 'ranger_availability', $post_id ) ?: '';
		}
	}

	ob_start();
	?>
	<section class="section" id="ranger" aria-labelledby="ranger-heading">
		<div class="section-inner">
			<p class="section-label"><?php echo esc_html( $label ); ?></p>
			<h2 class="section-title" id="ranger-heading"><?php echo esc_html( $title ); ?></h2>
			<div class="ranger-grid">
				<div class="ranger-portrait">
					<div class="ranger-frame">
						<div class="ranger-avatar" aria-label="<?php esc_attr_e( 'Ranger portrait', 'safari-portfolio' ); ?>"><?php echo esc_html( $avatar ); ?></div>
					</div>
					<div class="ranger-stats" role="list" aria-label="<?php esc_attr_e( 'Key statistics', 'safari-portfolio' ); ?>">
						<?php foreach ( $stats as $stat ) : ?>
							<div class="stat-box" role="listitem">
								<span class="stat-num"><?php echo esc_html( isset( $stat['stat_value'] ) ? $stat['stat_value'] : '' ); ?></span>
								<span class="stat-lbl"><?php echo esc_html( isset( $stat['stat_label'] ) ? $stat['stat_label'] : '' ); ?></span>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="ranger-bio">
					<?php foreach ( $bio_paragraphs as $row ) : ?>
						<?php $p = isset( $row['paragraph'] ) ? $row['paragraph'] : ''; ?>
						<?php if ( $p ) : ?>
							<p class="bio-text"><?php echo wp_kses_post( $p ); ?></p>
						<?php endif; ?>
					<?php endforeach; ?>
					<?php if ( ! empty( $specialties ) ) : ?>
						<ul class="specialty-list" aria-label="<?php esc_attr_e( 'Specialties', 'safari-portfolio' ); ?>">
							<?php foreach ( $specialties as $s ) : ?>
								<li><?php echo esc_html( $s ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
					<?php if ( $location || $website || $availability ) : ?>
						<div class="ranger-contact-snippet">
							<?php if ( $location ) : ?><span>📍 <?php echo esc_html( $location ); ?></span><?php endif; ?>
							<?php if ( $website ) : ?><span>🌐 <a href="<?php echo esc_url( strpos( $website, 'http' ) === 0 ? $website : 'https://' . $website ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $website ); ?></a></span><?php endif; ?>
							<?php if ( $availability ) : ?><span>🧭 <?php echo esc_html( $availability ); ?></span><?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
