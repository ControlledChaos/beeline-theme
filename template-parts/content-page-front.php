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
	if ( get_field( 'roster_front_heading' ) ) :

	// Layout changes if there is roster content.
	if ( ! empty( get_field( 'roster_front_content' ) ) ) {
		$preview_size = 'thumbnail';
		$grid_class   = 'roster-has-content';
	} else {
		$preview_size = 'video-sm';
		$grid_class   = 'roster-no-content';
	}

	// Class for yellow grid image filter.
	if ( get_field( 'roster_front_yellow' ) ) {
		$filter = ' yellow';
	} else {
		$filter = ' no-filter';
	}
	?>
	<div class="roster-front">
		<div class="roster-front-wrap">
			<div>
				<h2><?php the_field( 'roster_front_heading' ); ?></h2>
				<?php the_field( 'roster_front_content' ); ?>
				<?php
				// Client type taxonomy links.
				$types = get_field( 'roster_front_links' );

				if ( $types ) : ?>
				<p class="roster-links">
				<?php foreach( $types as $type ) : ?>
					<a class="button call-to-action" href="<?php echo get_term_link( $type ); ?>"><?php echo $type->name; ?></a>
				<?php endforeach; ?>
				</p>
				<?php endif; ?>
			</div>
			<div>
				<?php
				// Query clients for grid.
				$args = [
					'post_type'      => [ 'client' ],
					'orderby'        => 'rand',
					'posts_per_page' => 9
				];
				$query = new WP_Query( $args );

				if ( $query->have_posts() ) : ?>
				<ul class="roster-preview-grid <?php echo $grid_class . $filter; ?>">
					<?php while ( $query->have_posts() ) : $query->the_post();
					$image  = get_field( 'client_featured_image' );
					$size   = $preview_size;
					$src    = $image['sizes'][ $size ];
					$width  = $image['sizes'][ $size . '-width' ];
					$height = $image['sizes'][ $size . '-height' ]; ?>
					<li>
						<figure>
							<img src="<?php echo esc_url( $src ); ?>" alt="<?php the_title(); ?>" />
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