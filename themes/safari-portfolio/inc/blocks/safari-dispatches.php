<?php
/**
 * Safari Dispatches (Field Dispatches) block — recent blog posts grid.
 *
 * @package Safari_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function safari_block_render_dispatches( $attributes ) {
	$attributes = is_array( $attributes ) ? $attributes : array();

	$label_source = isset( $attributes['sectionLabel'] ) ? $attributes['sectionLabel'] : Safari_Settings::get( 'section_dispatches_label' );
	$title_source = isset( $attributes['sectionTitle'] ) ? $attributes['sectionTitle'] : Safari_Settings::get( 'section_dispatches_title' );

	$label = $label_source ?: 'From the Field';
	$title = $title_source ?: 'Field Dispatches';

	$count = isset( $attributes['count'] ) ? absint( $attributes['count'] ) : 3;

	if ( ! post_type_exists( 'safari_dispatch' ) ) {
		return '';
	}

	$query = new WP_Query( array(
		'post_type'      => 'safari_dispatch',
		'posts_per_page' => $count,
		'post_status'    => 'publish',
		'orderby'        => 'date',
		'order'          => 'DESC',
	) );

	if ( ! $query->have_posts() ) {
		return '';
	}

	$archive_url = get_post_type_archive_link( 'safari_dispatch' );

	ob_start();
	?>
	<section class="section" id="dispatches" aria-labelledby="dispatches-heading">
		<div class="section-inner">
			<p class="section-label"><?php echo esc_html( $label ); ?></p>
			<h2 class="section-title" id="dispatches-heading"><?php echo esc_html( $title ); ?></h2>
			<div class="dispatches-grid" role="list" aria-label="<?php esc_attr_e( 'Recent blog posts', 'safari-portfolio' ); ?>">
				<?php while ( $query->have_posts() ) : $query->the_post(); ?>
					<?php
					$pid       = get_the_ID();
					$icon      = safari_read_field( 'dispatch_icon', $pid ) ?: '📝';
					$read_time = safari_read_field( 'dispatch_read_time', $pid );
					$topic     = safari_read_field( 'dispatch_topic', $pid );
					?>
					<a href="<?php echo esc_url( get_permalink() ); ?>" class="dispatch-card" role="listitem">
						<div class="dispatch-icon" aria-hidden="true"><?php echo esc_html( $icon ); ?></div>
						<div class="dispatch-body">
							<h3 class="dispatch-title"><?php echo esc_html( get_the_title() ); ?></h3>
							<?php if ( has_excerpt() ) : ?>
								<p class="dispatch-excerpt"><?php echo esc_html( get_the_excerpt() ); ?></p>
							<?php endif; ?>
							<div class="dispatch-meta">
								<?php if ( $topic ) : ?>
									<span class="dispatch-topic"><?php echo esc_html( $topic ); ?></span>
								<?php endif; ?>
								<?php if ( $read_time ) : ?>
									<span class="dispatch-read-time"><?php echo esc_html( $read_time ); ?></span>
								<?php endif; ?>
								<time class="dispatch-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
							</div>
						</div>
					</a>
				<?php endwhile; ?>
				<?php wp_reset_postdata(); ?>
			</div>
			<?php if ( $archive_url ) : ?>
				<div class="dispatches-more">
					<a href="<?php echo esc_url( $archive_url ); ?>" class="dispatches-more-link"><?php esc_html_e( 'View All Dispatches →', 'safari-portfolio' ); ?></a>
				</div>
			<?php endif; ?>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
