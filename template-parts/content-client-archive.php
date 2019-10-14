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
	<div class="entry-content client-archive-content" itemprop="articleBody">

		<?php if ( class_exists( 'acf_pro' ) ) :
		$image  = get_field( 'client_featured_image' );
		$size   = 'video';
		$src    = $image['sizes'][ $size ];
		$width  = $image['sizes'][ $size . '-width' ];
		$height = $image['sizes'][ $size . '-height' ]; ?>
		<figure class="client-archive-image">
			<a href="<?php the_field( 'client_website' ); ?>" target="_blank" rel="nofollow">
				<img src="<?php echo esc_url( $src ); ?>" />
				<figcaption>
					<header><h2><?php the_title(); ?></h2></header>
				</figcaption>
			</a>
		</figure>
		<?php else : ?>
		<?php Beeline_Theme\Tags\post_thumbnail(); ?>
		<?php endif; ?>

	</div>
</article>
