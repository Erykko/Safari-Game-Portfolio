<?php
/**
 * Safari Sightings block — section + grid placeholder (game.js fills #projectsGrid from SafariData.projects).
 *
 * @package Safari_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function safari_block_render_sightings( $attributes ) {
	$label = isset( $attributes['sectionLabel'] ) ? $attributes['sectionLabel'] : ( function_exists( 'get_field' ) ? get_field( 'section_sightings_label', 'option' ) : null ) ?: 'Wildlife Encounters';
	$title = isset( $attributes['sectionTitle'] ) ? $attributes['sectionTitle'] : ( function_exists( 'get_field' ) ? get_field( 'section_sightings_title', 'option' ) : null ) ?: 'Safari Sightings';
	$sub   = isset( $attributes['sectionSub'] ) ? $attributes['sectionSub'] : ( function_exists( 'get_field' ) ? get_field( 'section_sightings_sub', 'option' ) : null ) ?: 'Each project — a rare creature encountered on the trail. Click to get closer.';
	$log_label = isset( $attributes['logCountLabel'] ) ? $attributes['logCountLabel'] : 'SIGHTINGS LOG';
	$total = 0;
	$count_query = new WP_Query( array( 'post_type' => 'safari_project', 'posts_per_page' => -1, 'post_status' => 'publish', 'fields' => 'ids' ) );
	if ( $count_query->found_posts ) {
		$total = $count_query->found_posts;
	}
	ob_start();
	?>
	<section class="section" id="sightings" aria-labelledby="sightings-heading">
		<div class="section-inner">
			<div class="sightings-header">
				<div>
					<p class="section-label"><?php echo esc_html( $label ); ?></p>
					<h2 class="section-title" id="sightings-heading"><?php echo esc_html( $title ); ?></h2>
					<p class="section-sub"><?php echo esc_html( $sub ); ?></p>
				</div>
				<p class="sightings-log-count"><?php echo esc_html( $log_label ); ?>: <span id="logCount">0</span>/<?php echo (int) $total; ?> RECORDED</p>
			</div>
			<div class="projects-grid" id="projectsGrid" role="list" aria-label="Portfolio projects"></div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
