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
	$label = isset( $attributes['sectionLabel'] ) ? $attributes['sectionLabel'] : ( function_exists( 'get_field' ) ? get_field( 'section_contact_label', 'option' ) : null ) ?: 'Dispatch from the Field';
	$title = isset( $attributes['sectionTitle'] ) ? $attributes['sectionTitle'] : ( function_exists( 'get_field' ) ? get_field( 'section_contact_title', 'option' ) : null ) ?: 'Leave a Field Note';
	$quote = isset( $attributes['quote'] ) ? $attributes['quote'] : ( function_exists( 'get_field' ) ? get_field( 'contact_quote', 'option' ) : null ) ?: 'The wilderness of the web is vast — but with the right guide, every journey ends at a destination worth the trek.';
	$location = isset( $attributes['location'] ) ? $attributes['location'] : ( function_exists( 'get_field' ) ? get_field( 'contact_location', 'option' ) : null ) ?: 'Nairobi, Kenya';
	$website = isset( $attributes['website'] ) ? $attributes['website'] : ( function_exists( 'get_field' ) ? get_field( 'contact_website', 'option' ) : null ) ?: 'designnairobi.agency';
	$availability = isset( $attributes['availability'] ) ? $attributes['availability'] : ( function_exists( 'get_field' ) ? get_field( 'contact_availability', 'option' ) : null ) ?: 'Available for remote & local projects';

	$website_url = ( strpos( $website, 'http' ) === 0 ) ? $website : 'https://' . $website;
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
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
}
