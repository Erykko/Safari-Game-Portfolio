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
	$label_source = isset( $attributes['sectionLabel'] ) ? $attributes['sectionLabel'] : Safari_Settings::get( 'section_ranger_label' );
	$title_source = isset( $attributes['sectionTitle'] ) ? $attributes['sectionTitle'] : Safari_Settings::get( 'section_ranger_title' );

	$label = $label_source ?: 'Field Guide';
	$title = $title_source ?: 'The Ranger';

	$ranger = new WP_Query( array(
		'post_type'      => 'safari_ranger',
		'posts_per_page' => 1,
		'post_status'    => 'publish',
		'orderby'        => 'date',
		'order'          => 'DESC',
	) );
	$avatar = '🦒';
	$stats  = array();
	$bio    = '';
	$specialties = array();
	$location = '';
	$website = '';
	$availability = '';
	if ( $ranger->have_posts() ) {
		$post_id = $ranger->posts[0]->ID;
		$avatar       = safari_read_field( 'ranger_avatar_emoji', $post_id ) ?: '🦒';
		$location     = safari_read_field( 'ranger_location', $post_id ) ?: '';
		$website      = safari_read_field( 'ranger_website', $post_id ) ?: '';
		$availability = safari_read_field( 'ranger_availability', $post_id ) ?: '';

		for ( $i = 1; $i <= 6; $i++ ) {
			$val = safari_read_field( "ranger_stat_{$i}_value", $post_id );
			$lbl = safari_read_field( "ranger_stat_{$i}_label", $post_id );
			if ( $val || $lbl ) {
				$stats[] = array( 'stat_value' => $val ?: '', 'stat_label' => $lbl ?: '' );
			}
		}

		$bio = safari_read_field( 'ranger_bio', $post_id ) ?: '';

		for ( $i = 1; $i <= 10; $i++ ) {
			$s = safari_read_field( "ranger_specialty_{$i}", $post_id );
			if ( $s ) {
				$specialties[] = $s;
			}
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
				<?php if ( $bio ) : ?>
					<div class="bio-text"><?php echo wp_kses_post( $bio ); ?></div>
				<?php endif; ?>
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
