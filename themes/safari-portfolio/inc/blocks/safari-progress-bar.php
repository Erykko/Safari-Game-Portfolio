<?php
/**
 * Safari Progress Bar block — bottom scroll bar + leopard.
 *
 * @package Safari_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function safari_block_render_progress_bar( $attributes ) {
	ob_start();
	?>
	<div class="progress-bar" role="progressbar" aria-label="<?php esc_attr_e( 'Scroll progress', 'safari-portfolio' ); ?>" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
		<div class="progress-fill" id="progressFill"></div>
		<div class="progress-leopard" id="progressLeopard" aria-hidden="true">
			<span class="progress-leopard-emoji" aria-hidden="true">🐆</span>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
