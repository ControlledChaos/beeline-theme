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

	<?php
	if ( has_post_thumbnail() ) {
		get_template_part( 'template-parts/hero' );
	} else { ?>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header>
	<?php } ?>

	<div class="entry-content" itemprop="articleBody">
		<?php the_content(); ?>
	</div>

</article>