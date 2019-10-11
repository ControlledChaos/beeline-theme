<?php
/**
 * Template part for displaying page content in page.php
 *
 * @package    WordPress/ClassicPress
 * @subpackage Beeline_Theme
 * @since      1.0.0
 */

?>

<?php
// Check for the Advanced Custom Fields plugin.
if ( class_exists( 'acf_pro' ) ) :
    if ( have_rows( 'beeline_intro_slides' ) ) : ?>
    <div class="intro-image">
        <div id="slick-flexbox-fix"><!-- Stops SlickJS from getting original image rather than the intro-large size" -->
            <ul class="intro-slides">
				<?php while ( have_rows( 'beeline_intro_slides' ) ) : the_row();
				$image  = get_sub_field( 'beeline_intro_image' );
				if ( has_image_size( 'slide-large' ) ) {
					$size = 'slide-large';
					$thumb  = $image['sizes'][ $size ];
					$width  = $image['sizes'][ $size . '-width' ];
					$height = $image['sizes'][ $size . '-height' ];
				} else {
					$size = '';
					$thumb  = $image['url'];
					$width  = '';
					$height = '';
				} ?>
                <li class="slide">
                    <figure>
						<img src="<?php echo $thumb; ?>" alt="<?php echo $image['alt'] ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" />
						<figcaption class="screen-reader-text"><?php echo $image['caption'] ?></figcaption>
					</figure>
                </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
    <?php endif;
endif;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
	<header class="entry-header">
		<?php the_title( '<h2 class="entry-title screen-reader-text">', '</h2>' ); ?>
	</header>

	<div class="entry-content" itemprop="articleBody">
		<?php the_content(); ?>
	</div>
</article>