<?php
/**
 * Safari Contact (Field Notes) block — section + quote, contact details, form.
 *
 * @package Safari_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function safari_block_render_contact( $attributes ) {
	$attributes = is_array( $attributes ) ? $attributes : array();
	$label       = isset( $attributes['sectionLabel'] ) ? sanitize_text_field( $attributes['sectionLabel'] ) : Safari_Settings::get( 'section_contact_label', 'Dispatch from the Field' );
	$title       = isset( $attributes['sectionTitle'] ) ? sanitize_text_field( $attributes['sectionTitle'] ) : Safari_Settings::get( 'section_contact_title', 'Leave a Field Note' );
	$quote       = isset( $attributes['quote'] ) ? sanitize_textarea_field( $attributes['quote'] ) : Safari_Settings::get( 'contact_quote', 'The wilderness of the web is vast — but with the right guide, every journey ends at a destination worth the trek.' );
	$location    = isset( $attributes['location'] ) ? sanitize_text_field( $attributes['location'] ) : Safari_Settings::get( 'contact_location', 'Nairobi, Kenya' );
	$website     = isset( $attributes['website'] ) ? sanitize_text_field( $attributes['website'] ) : Safari_Settings::get( 'contact_website', 'designnairobi.agency' );
	$availability = isset( $attributes['availability'] ) ? sanitize_text_field( $attributes['availability'] ) : Safari_Settings::get( 'contact_availability', 'Available for remote & local projects' );

	$website_url = esc_url_raw( 0 === strpos( $website, 'http' ) ? $website : 'https://' . $website );
	if ( '' === $website_url ) {
		$website_url = 'https://';
	}

	$form_source = Safari_Settings::get( 'contact_form_source', 'built_in' );
	$external_shortcode = '';

	if ( 'plugin_form' === $form_source ) {
		$plugin_id = Safari_Settings::get( 'contact_form_plugin_id', '' );
		if ( $plugin_id && function_exists( 'safari_resolve_form_shortcode' ) ) {
			$external_shortcode = safari_resolve_form_shortcode( $plugin_id );
		}
	} elseif ( 'shortcode' === $form_source ) {
		$raw = Safari_Settings::get( 'contact_form_shortcode', '' );
		if ( $raw ) {
			$external_shortcode = wp_kses( $raw, array() );
		}
	}

	ob_start();
	?>
	<section class="section" id="field-notes" aria-labelledby="contact-heading">
		<div class="section-inner">
			<p class="section-label"><?php echo esc_html( $label ); ?></p>
			<h2 class="section-title" id="contact-heading"><?php echo esc_html( $title ); ?></h2>
			<div class="contact-wrap">
				<div class="contact-info">
					<blockquote class="contact-quote">"<?php echo esc_html( $quote ); ?>"</blockquote>
					<div class="contact-detail">
						<div class="contact-item">
							<span class="contact-item-icon" aria-hidden="true">📍</span>
							<span><?php echo esc_html( $location ); ?></span>
						</div>
						<div class="contact-item">
							<span class="contact-item-icon" aria-hidden="true">🌐</span>
							<span><a href="<?php echo esc_url( $website_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $website ); ?></a></span>
						</div>
						<div class="contact-item">
							<span class="contact-item-icon" aria-hidden="true">🧭</span>
							<span><?php echo esc_html( $availability ); ?></span>
						</div>
					</div>
				</div>
				<?php if ( $external_shortcode ) : ?>
					<div class="contact-form contact-form--plugin">
						<?php echo do_shortcode( $external_shortcode ); ?>
					</div>
				<?php else : ?>
					<div class="contact-form" role="form" aria-label="<?php esc_attr_e( 'Contact form', 'safari-portfolio' ); ?>">
						<div class="form-group">
							<label class="form-label" for="contact-name"><?php esc_html_e( 'Your Name', 'safari-portfolio' ); ?></label>
							<input type="text" id="contact-name" name="name" class="form-input" placeholder="<?php esc_attr_e( "Explorer's name...", 'safari-portfolio' ); ?>" autocomplete="name">
						</div>
						<div class="form-group">
							<label class="form-label" for="contact-email"><?php esc_html_e( 'Email', 'safari-portfolio' ); ?></label>
							<input type="email" id="contact-email" name="email" class="form-input" placeholder="your@email.com" autocomplete="email">
						</div>
						<div class="form-group">
							<label class="form-label" for="contact-message"><?php esc_html_e( 'Your Message', 'safari-portfolio' ); ?></label>
							<textarea id="contact-message" name="message" class="form-input" placeholder="<?php esc_attr_e( 'Describe your safari mission...', 'safari-portfolio' ); ?>"></textarea>
						</div>
						<button type="button" class="form-submit" aria-label="<?php esc_attr_e( 'Send contact form', 'safari-portfolio' ); ?>"><?php esc_html_e( 'Send Dispatch', 'safari-portfolio' ); ?></button>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
