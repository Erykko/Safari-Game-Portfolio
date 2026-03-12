<?php
/**
 * Single page template.
 *
 * @package Safari_Portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main-content" class="site-main">
	<?php
	while ( have_posts() ) {
		the_post();
		get_template_part( 'template-parts/content', 'page' );
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	}
	?>
</main>

<?php
get_footer();
