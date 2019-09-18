<?php
/**
 * Template part for displaying page content in page.php
 *
 * @package    WordPress/ClassicPress
 * @subpackage Beeline_Theme
 * @since      1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header>

	<?php Beeline_Theme\Tags\post_thumbnail(); ?>

	<div class="entry-content" itemprop="articleBody">
		<?php
		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'beeline-theme' ),
			'after'  => '</div>',
		) );
		?>
	</div>
</article>