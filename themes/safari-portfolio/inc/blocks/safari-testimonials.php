<?php
/**
 * Safari Testimonials (Animal Tracks) block — client quotes shown as "tracks in the mud".
 *
 * @package Safari_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function safari_block_render_testimonials( $attributes ) {
	$attributes = is_array( $attributes ) ? $attributes : array();

	$label_source = isset( $attributes['sectionLabel'] ) ? $attributes['sectionLabel'] : Safari_Settings::get( 'section_testimonials_label' );
	$title_source = isset( $attributes['sectionTitle'] ) ? $attributes['sectionTitle'] : Safari_Settings::get( 'section_testimonials_title' );

	$label = $label_source ?: 'Tracks in the Mud';
	$title = $title_source ?: 'Animal Tracks';

	$count = isset( $attributes['count'] ) ? absint( $attributes['count'] ) : 6;

	if ( ! post_type_exists( 'safari_testimonial' ) ) {
		return '';
	}

	$query = new WP_Query( array(
		'post_type'      => 'safari_testimonial',
		'posts_per_page' => $count,
		'post_status'    => 'publish',
		'meta_key'       => 'testimonial_featured',
		'orderby'        => array( 'meta_value_num' => 'DESC', 'date' => 'DESC' ),
	) );

	if ( ! $query->have_posts() ) {
		return '';
	}

	ob_start();
	?>
	<section class="section" id="animal-tracks" aria-labelledby="tracks-heading">
		<div class="section-inner">
			<p class="section-label"><?php echo esc_html( $label ); ?></p>
			<h2 class="section-title" id="tracks-heading"><?php echo esc_html( $title ); ?></h2>
			<div class="tracks-grid" role="list" aria-label="<?php esc_attr_e( 'Client testimonials', 'safari-portfolio' ); ?>">
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
					<?php
					$pid    = get_the_ID();
					$icon   = safari_read_field( 'testimonial_animal_icon', $pid ) ?: '🐾';
					$quote  = safari_read_field( 'testimonial_quote', $pid ) ?: get_the_content();
					$author = safari_read_field( 'testimonial_author_name', $pid ) ?: get_the_title();
					$role   = safari_read_field( 'testimonial_author_title', $pid );
					$rating = (int) safari_read_field( 'testimonial_rating', $pid );
					$rating = max( 1, min( 5, $rating ?: 5 ) );
					?>
					<div class="track-card" role="listitem">
						<div class="track-icon" aria-hidden="true"><?php echo esc_html( $icon ); ?></div>
						<blockquote class="track-quote"><?php echo esc_html( $quote ); ?></blockquote>
						<div class="track-author">
							<span class="track-author-name"><?php echo esc_html( $author ); ?></span>
							<?php if ( $role ) : ?>
								<span class="track-author-role"><?php echo esc_html( $role ); ?></span>
							<?php endif; ?>
						</div>
						<div class="track-rating" aria-label="<?php echo esc_attr( sprintf( __( '%d out of 5 stars', 'safari-portfolio' ), $rating ) ); ?>">
							<?php echo str_repeat( '★', $rating ) . str_repeat( '☆', 5 - $rating ); ?>
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
