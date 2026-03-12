<?php
/**
 * Safari Boot Screen block — overlay with kicker, title, subtitle.
 *
 * @package Safari_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function safari_block_render_boot_screen( $attributes ) {
	$kicker_source = isset( $attributes['kicker'] ) ? $attributes['kicker'] : Safari_Settings::get( 'boot_kicker' );
	$kicker        = $kicker_source ?: 'Safari Portfolio · Nairobi, Kenya';
	$title  = isset( $attributes['title'] ) ? $attributes['title'] : '';
	$sub    = isset( $attributes['subtitle'] ) ? $attributes['subtitle'] : '';
	if ( ! $title ) {
		$title = __( 'Initializing Field Equipment…', 'safari-portfolio' );
	}
	if ( ! $sub ) {
		$count = 0;
		if ( function_exists( 'safari_portfolio_format_projects' ) ) {
			$count = count( safari_portfolio_format_projects() );
		}
		$sub = sprintf( __( 'Calibrating compass, loading wildlife database (%d species detected).', 'safari-portfolio' ), $count );
	}
	ob_start();
	?>
	<div class="boot-screen" id="bootScreen" aria-hidden="true">
		<div class="boot-inner">
			<div class="boot-kicker"><?php echo esc_html( $kicker ); ?></div>
			<div class="boot-title" id="bootTitle"><?php echo esc_html( $title ); ?></div>
			<div class="boot-sub" id="bootSubtitle"><?php echo esc_html( $sub ); ?></div>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
