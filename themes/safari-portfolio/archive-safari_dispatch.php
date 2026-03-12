<?php
/**
 * Archive template for Field Dispatches (safari_dispatch).
 *
 * @package Safari_Portfolio
 */

get_header();
?>

<main id="main-content" class="dispatches-archive">
	<div class="section-inner">
		<p class="section-label"><?php esc_html_e( 'From the Field', 'safari-portfolio' ); ?></p>
		<h1 class="section-title"><?php esc_html_e( 'Field Dispatches', 'safari-portfolio' ); ?></h1>
		<p class="section-sub"><?php esc_html_e( 'Technical notes, tips, and observations from the digital savanna.', 'safari-portfolio' ); ?></p>

		<?php if ( have_posts() ) : ?>
			<div class="dispatches-grid" role="list">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php
					$pid       = get_the_ID();
					$icon      = safari_read_field( 'dispatch_icon', $pid ) ?: '📝';
					$read_time = safari_read_field( 'dispatch_read_time', $pid );
					$topic     = safari_read_field( 'dispatch_topic', $pid );
					?>
					<a href="<?php echo esc_url( get_permalink() ); ?>" class="dispatch-card" role="listitem">
						<div class="dispatch-icon" aria-hidden="true"><?php echo esc_html( $icon ); ?></div>
						<div class="dispatch-body">
							<h2 class="dispatch-title"><?php echo esc_html( get_the_title() ); ?></h2>
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
			</div>
			<div class="dispatches-pagination">
				<?php the_posts_pagination( array(
					'prev_text' => __( '← Previous', 'safari-portfolio' ),
					'next_text' => __( 'Next →', 'safari-portfolio' ),
				) ); ?>
			</div>
		<?php else : ?>
			<p class="dispatches-empty"><?php esc_html_e( 'No dispatches have been filed yet. Check back soon.', 'safari-portfolio' ); ?></p>
		<?php endif; ?>
	</div>
</main>

<?php get_footer(); ?>
