<?php
/**
 * Main template file. Used when no more specific template applies.
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
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			get_template_part( 'template-parts/content', get_post_type() );
		}
		the_posts_pagination();
	} else {
		get_template_part( 'template-parts/content', 'none' );
	}
	?>
</main>

<?php
get_footer();
