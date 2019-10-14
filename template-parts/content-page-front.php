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
		<div class="roster-front-wrap">
			<div>
				<h2><?php the_field( 'roster_front_heading' ); ?></h2>
				<?php the_field( 'roster_front_content' ); ?>
				<p class="roster-links">
					<a class="button call-to-action" href="<?php echo site_url( 'client-type/' ) . 'production'; ?>"><?php _e( 'Production' ); ?></a>
					<a class="button call-to-action" href="<?php echo site_url( 'client-type/' ) . 'post-production'; ?>"><?php _e( 'Post Production' ); ?></a>
				</p>
			</div>
			<div>
				<?php
				// Query clients for grid.
				$args = [
					'post_type'      => [ 'client' ],
					'orderby'        => 'rand',
					'nopaging'       => true,
					'posts_per_page' => '9'
				];
				$query = new WP_Query( $args );

				if ( $query->have_posts() ) : ?>
				<script>
					jQuery(document).ready(function($) {
						$('.tooltip').tooltipster({
							theme : 'beeline-tooltip'
						});
					});
				</script>
				<ul class="roster-preview-grid">
					<?php while ( $query->have_posts() ) : $query->the_post();
					$image  = get_field( 'client_featured_image' );
					$size   = 'thumbnail';
					$src    = $image['sizes'][ $size ];
					$width  = $image['sizes'][ $size . '-width' ];
					$height = $image['sizes'][ $size . '-height' ]; ?>
					<li class="tooltip" title="<?php the_title(); ?>">
						<figure>
							<img src="<?php echo esc_url( $src ); ?>" />
							<figcaption class="screen-reader-text"><?php the_title(); ?></figcaption>
						</figure>
					</li>
					<?php endwhile; wp_reset_postdata(); ?>
				</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<?php
	// Contact section.
	if ( get_field( 'add_contact_front' ) ) : ?>
	<div class="contact-front">
		
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