<?php
/**
 * Template part for displaying posts
 *
 * @package    WordPress/ClassicPress
 * @subpackage Beeline_Theme
 * @since      1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
	<header class="entry-header">
		<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
	</header>

	<div class="entry-content" itemprop="articleBody">
		<?php Beeline_Theme\Tags\post_thumbnail(); ?>
		<?php the_content(); ?>
	</div>

	<footer class="entry-footer">
		<?php Beeline_Theme\Tags\entry_footer(); ?>
	</footer>
</article>
