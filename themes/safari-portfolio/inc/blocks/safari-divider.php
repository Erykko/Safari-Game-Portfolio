<?php
/**
 * Safari Divider block — wave divider between sections.
 *
 * @package Safari_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function safari_block_render_divider( $attributes ) {
	$variant = isset( $attributes['variant'] ) ? $attributes['variant'] : 'default';
	$style = ( $variant === 'alt' ) ? ' style="background:#0D1A08"' : '';
	$path  = ( $variant === 'alt' ) ? 'M0,30 Q180,-10 360,40 Q540,70 720,20 Q900,-10 1080,45 Q1260,70 1440,20 L1440,60 L0,60 Z' : 'M0,0 Q180,60 360,20 Q540,-20 720,40 Q900,80 1080,20 Q1260,-20 1440,30 L1440,60 L0,60 Z';
	$fill  = ( $variant === 'alt' ) ? '#0A1506' : '#0D1A08';
	ob_start();
	?>
	<div class="savanna-divider"<?php echo $style; ?> aria-hidden="true">
		<svg viewBox="0 0 1440 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
			<path d="<?php echo esc_attr( $path ); ?>" fill="<?php echo esc_attr( $fill ); ?>"/>
		</svg>
	</div>
	<?php
	return ob_get_clean();
}
