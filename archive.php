<?php
/**
 * The template for displaying archive pages
 *
 * @package    WordPress/ClassicPress
 * @subpackage Beeline_Theme
 * @since      1.0.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" itemscope itemprop="mainContentOfPage">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				?>
			</header>

			<?php while ( have_posts() ) :
				the_post();

				if ( is_post_type_archive( 'client' ) || is_tax( 'client_type' ) ) {
					get_template_part( 'template-parts/content', 'client-archive' );
				} elseif ( is_archive() ) {
					get_template_part( 'template-parts/content', 'archive' );
				} else {
					get_template_part( 'template-parts/content', get_post_type() );
				}

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main>
	</div>

<?php
get_sidebar();
get_footer();