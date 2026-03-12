<?php
/**
 * Template Name: Safari Portfolio
 * Description: Full safari portfolio layout with all game sections. Use this on your front page.
 *
 * @package Safari_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function safari_tpl_show_section( $key ) {
	if ( ! class_exists( 'Safari_Settings' ) ) {
		return true;
	}
	$val = Safari_Settings::get( 'show_' . $key, 1 );
	return ! empty( $val );
}

get_header();
?>

  <div class="cursor" id="cursor" aria-hidden="true">
    <svg viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
      <circle cx="18" cy="18" r="14" stroke="#E8A825" stroke-width="1.5" opacity="0.6"/>
      <circle cx="18" cy="18" r="4" fill="#E8A825"/>
      <line x1="18" y1="2" x2="18" y2="10" stroke="#E8A825" stroke-width="1.5" opacity="0.6"/>
      <line x1="18" y1="26" x2="18" y2="34" stroke="#E8A825" stroke-width="1.5" opacity="0.6"/>
      <line x1="2" y1="18" x2="10" y2="18" stroke="#E8A825" stroke-width="1.5" opacity="0.6"/>
      <line x1="26" y1="18" x2="34" y2="18" stroke="#E8A825" stroke-width="1.5" opacity="0.6"/>
    </svg>
  </div>
  <div class="cursor-dot" id="cursorDot" aria-hidden="true"></div>

<?php if ( safari_tpl_show_section( 'hud' ) ) : ?>
  <?php echo safari_block_render_hud( array() ); ?>
<?php endif; ?>

<?php if ( safari_tpl_show_section( 'progress_bar' ) ) : ?>
  <?php echo safari_block_render_progress_bar( array() ); ?>
<?php endif; ?>

  <div class="encounter-popup" id="encounterPopup" role="status" aria-live="polite">
    <div class="encounter-popup-title">&#x26A1; <?php esc_html_e( 'New Sighting!', 'safari-portfolio' ); ?></div>
    <div class="encounter-popup-name" id="encounterName">—</div>
  </div>
  <div class="shutter-overlay" id="shutterOverlay" aria-hidden="true"></div>
  <div class="polaroid-card" id="polaroidCard" aria-hidden="true">
    <div class="polaroid-inner">
      <div class="polaroid-icon">&#x1F4F7;</div>
      <div class="polaroid-name"><?php esc_html_e( 'New Sighting', 'safari-portfolio' ); ?></div>
    </div>
  </div>

<?php if ( safari_tpl_show_section( 'boot_screen' ) ) : ?>
  <?php echo safari_block_render_boot_screen( array() ); ?>
<?php endif; ?>

  <div class="field-guide" id="fieldGuide" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Safari Field Guide', 'safari-portfolio' ); ?>">
    <div class="field-guide-inner">
      <button type="button" class="field-guide-close" id="fieldGuideClose" aria-label="<?php esc_attr_e( 'Close field guide', 'safari-portfolio' ); ?>">&#x2715;</button>
      <h2 class="field-guide-title"><?php esc_html_e( 'Field Guide', 'safari-portfolio' ); ?></h2>
      <p class="field-guide-sub"><?php esc_html_e( 'All known species along this digital safari. Photographed sightings are highlighted.', 'safari-portfolio' ); ?></p>
      <div class="field-guide-grid" id="fieldGuideGrid" aria-label="<?php esc_attr_e( 'Species list', 'safari-portfolio' ); ?>"></div>
    </div>
  </div>

  <main id="main-content">
<?php if ( safari_tpl_show_section( 'hero' ) ) : ?>
    <?php echo safari_block_render_hero( array() ); ?>
<?php endif; ?>

    <?php echo safari_block_render_divider( array() ); ?>

<?php if ( safari_tpl_show_section( 'toolkit' ) ) : ?>
    <?php echo safari_block_render_toolkit( array() ); ?>
<?php endif; ?>

    <?php echo safari_block_render_divider( array( 'variant' => 'alt' ) ); ?>

<?php if ( safari_tpl_show_section( 'sightings' ) ) : ?>
    <?php echo safari_block_render_sightings( array() ); ?>
<?php endif; ?>

    <?php echo safari_block_render_divider( array() ); ?>

<?php if ( safari_tpl_show_section( 'ranger' ) ) : ?>
    <?php echo safari_block_render_ranger( array() ); ?>
<?php endif; ?>

<?php if ( safari_tpl_show_section( 'testimonials' ) ) : ?>
    <?php echo safari_block_render_testimonials( array() ); ?>
<?php endif; ?>

    <?php echo safari_block_render_divider( array( 'variant' => 'alt' ) ); ?>

<?php if ( safari_tpl_show_section( 'achievements' ) ) : ?>
    <?php echo safari_block_render_achievements( array() ); ?>
<?php endif; ?>

    <?php echo safari_block_render_divider( array() ); ?>

<?php if ( safari_tpl_show_section( 'contact' ) ) : ?>
    <?php echo safari_block_render_contact( array() ); ?>
<?php endif; ?>

<?php if ( safari_tpl_show_section( 'dispatches' ) ) : ?>
    <?php echo safari_block_render_dispatches( array() ); ?>
<?php endif; ?>
  </main>

  <footer role="contentinfo">
    <div class="footer-inner">
      <p class="footer-logo"><?php esc_html_e( 'Eric Mutema · Design Nairobi', 'safari-portfolio' ); ?></p>
      <p class="footer-copy">&#x00A9; <?php echo (int) date( 'Y' ); ?> &#x00B7; <?php esc_html_e( 'Crafted on the Digital Savanna', 'safari-portfolio' ); ?></p>
      <nav class="footer-socials" aria-label="<?php esc_attr_e( 'Social links', 'safari-portfolio' ); ?>">
        <a href="https://github.com/Erykko" class="social-link" target="_blank" rel="noopener noreferrer">GitHub</a>
        <a href="https://designnairobi.agency" class="social-link" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Portfolio', 'safari-portfolio' ); ?></a>
      </nav>
    </div>
  </footer>

<?php get_footer(); ?>
