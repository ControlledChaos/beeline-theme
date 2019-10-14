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

	// Intro slides and content.
	$slides = get_field( 'beeline_intro_gallery' );
	$size = 'slide-large';
    if ( $slides ) : ?>
    <div class="intro-image">
        <div id="slick-flexbox-fix"><!-- Stops SlickJS from getting original image rather than the intro-large size" -->
            <ul class="intro-slides">
				<?php foreach( $slides as $slide ) :
					$thumb  = $slide['sizes'][ $size ];
					$width  = $slide['sizes'][ $size . '-width' ];
					$height = $slide['sizes'][ $size . '-height' ];
				?>
                <li class="slide">
                    <figure>
						<img src="<?php echo $thumb; ?>" alt="<?php echo $slide['alt'] ?>" width="<?php echo $width; ?>" height="<?php echo $height; ?>" />
						<figcaption class="screen-reader-text"><?php echo $slide['caption'] ?></figcaption>
					</figure>
                </li>
			<?php endforeach; ?>
            </ul>
		</div>
		<div class="intro-content">
			<div class="intro-content-inner">
				<?php if ( get_field( 'beeline_intro_heading' ) ) {
					echo sprintf(
						'<h2>%1s</h2>',
						get_field( 'beeline_intro_heading' )
					);
				} ?>
				<?php if ( get_field( 'beeline_intro_content' ) ) {
					echo get_field( 'beeline_intro_content' );
				} ?>
			</div>
		</div>
    </div>
	<?php endif; ?>

	<?php
	// Roster section.
	if ( get_field( 'roster_front_heading' ) && get_field( 'roster_front_content' ) ) : ?>
	<div class="roster-front">
		<h2><?php the_field( 'roster_front_heading' ); ?></h2>
		<?php the_field( 'roster_front_content' ); ?>
		<?php
		// Loop client post type for thumbnail display.
		?>
	</div>
	<?php endif; ?>

	<?php
	// Roster section.
	if ( get_field( 'additional_content_front' ) ) : ?>
	<div class="additional-content-front">
		<?php the_field( 'additional_content_front' ); ?>
		<?php if ( get_field( 'front_call_to_action_text' ) ) : ?>
		<p><a class="button call-to-action" href="<?php the_field( 'front_call_to_action_link' ); ?>" target="_blank" rel="nofollow"><?php the_field( 'front_call_to_action_text' ); ?></a></p>
		<?php endif; ?>
	</div>
	<?php endif; ?>

<?php

// If Advanced Custom Fields is not active.
else : ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
	<header class="entry-header">
		<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
	</header>

	<div class="entry-content" itemprop="articleBody">
		<?php the_content(); ?>
	</div>
</article>
<?php

// End check for the Advanced Custom Fields plugin.
endif; ?>