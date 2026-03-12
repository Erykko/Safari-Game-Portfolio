<?php
/**
 * Safari Toolkit block — section + grid placeholder (game.js fills #toolkitGrid from SafariData.skills).
 *
 * @package Safari_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function safari_block_render_toolkit( $attributes ) {
	$label = isset( $attributes['sectionLabel'] ) ? $attributes['sectionLabel'] : ( function_exists( 'get_field' ) ? get_field( 'section_toolkit_label', 'option' ) : null ) ?: "Ranger's Equipment";
	$title = isset( $attributes['sectionTitle'] ) ? $attributes['sectionTitle'] : ( function_exists( 'get_field' ) ? get_field( 'section_toolkit_title', 'option' ) : null ) ?: 'The Toolkit';
	$sub   = isset( $attributes['sectionSub'] ) ? $attributes['sectionSub'] : ( function_exists( 'get_field' ) ? get_field( 'section_toolkit_sub', 'option' ) : null ) ?: "Every skilled ranger carries the right tools. Here's the arsenal that brings digital life to the savanna.";
	ob_start();
	?>
	<section class="section" id="toolkit" aria-labelledby="toolkit-heading">
		<div class="section-inner">
			<p class="section-label"><?php echo esc_html( $label ); ?></p>
			<h2 class="section-title" id="toolkit-heading"><?php echo esc_html( $title ); ?></h2>
			<p class="section-sub"><?php echo esc_html( $sub ); ?></p>
			<div class="toolkit-grid" id="toolkitGrid" role="list" aria-label="Skills and technologies"></div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
