<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package    WordPress/ClassicPress
 * @subpackage Beeline_Theme
 * @since      1.0.0
 *
 * @todo       Add hooks for nav above or below header.
 */

if ( is_home() && ! is_front_page() ) {
    $canonical = get_permalink( get_option( 'page_for_posts' ) );
} elseif ( is_archive() ) {
    $canonical = get_permalink( get_option( 'page_for_posts' ) );
} else {
    $canonical = get_permalink();
}

?>
<!doctype html>
<?php do_action( 'before_html' ); ?>
<html <?php language_attributes(); ?> class="no-js">
<head id="<?php echo get_bloginfo( 'wpurl' ); ?>" data-template-set="<?php echo get_template(); ?>">
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<!--[if IE ]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open() ) {
		echo sprintf( '<link rel="pingback" href="%s" />', get_bloginfo( 'pingback_url' ) );
	} ?>
	<link href="<?php echo $canonical; ?>" rel="canonical" />
	<?php if ( is_search() ) { echo '<meta name="robots" content="noindex,nofollow" />'; } ?>

	<!-- Prefetch font URLs -->
	<link rel='dns-prefetch' href='//fonts.adobe.com'/>
	<link rel='dns-prefetch' href='//fonts.google.com'/>

	<?php do_action( 'before_wp_head' ); ?>
	<?php wp_head(); ?>
	<?php do_action( 'after_wp_head' ); ?>
</head>

<body <?php body_class(); ?>>
<?php Beeline_Theme\Tags\before_page(); ?>
<div id="page" class="site" itemscope="itemscope" itemtype="<?php Beeline_Theme\Tags\site_schema(); ?>">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'beeline-theme' ); ?></a>
	<div class="content-wrapper header-content-wrapper">
		<div class="header-nav-wrapper">
			<nav id="site-navigation" class="main-navigation" role="directory" itemscope itemtype="http://schema.org/SiteNavigationElement">
			<div class="menu-toggle-wrap">
				<button id="menu-toggle-button" class="menu-toggle" aria-controls="main-menu" aria-expanded="false">
					<!-- Start open menu icon -->
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="theme-icon menu-icon menu-open-icon"><path d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"/></svg>
					<!-- End open menu icon -->
					<!-- Start close menu icon -->
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 352 512" class="theme-icon menu-icon menu-close-icon"><path d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"/></svg>
					<!-- Start close menu icon -->
					<span><?php esc_html_e( 'Menu', 'mixes-theme' ); ?></span>
				</button>
			</div>
				<?php
				wp_nav_menu( [
					'theme_location' => 'main',
					'menu_id'        => 'main-menu',
				] );
				?>
			</nav>

			<header id="masthead" class="site-header" role="banner" itemscope="itemscope" itemtype="http://schema.org/Organization">
				<div class="site-branding">
					<?php

					// Site title, hidden by screen-reader-text class.
					if ( is_front_page() ) : ?>
						<h1 class="site-title screen-reader-text"><?php bloginfo( 'name' ); ?></h1>
						<?php else : ?>
						<p class="site-title screen-reader-text"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
					endif;
					// Header logo SVG, "Beeline" text, not linked if front page.
					if ( ! is_front_page() ) {
						echo sprintf(
							'<a href="%1s" rel="home">',
							esc_url( home_url( '/' ) )
						);
					} ?>
					<svg id="beeline-web-logo-header" role="img" aria-labelledby="beeline-web-logo-title beeline-web-logo-desc" class="beeline-web-logo beeline-text-logo" width="100%" height="100%" viewBox="0 0 500 63" version="1.0" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/"><path id="path3034" d="M0,31.123l0,-31.123l23.965,0.119c20.003,0.099 24.437,0.189 26.822,0.544c5.418,0.805 8.932,2.121 11.686,4.377c3.211,2.631 4.646,5.887 4.654,10.561c0.008,4.55 -1.237,7.217 -4.829,10.34c-1.723,1.497 -2.807,2.163 -5.072,3.113l-2.881,1.207l2.094,0.487c1.152,0.268 3.151,0.943 4.442,1.501c4.216,1.822 6.769,4.252 8.364,7.961c1.03,2.396 1.309,7.105 0.578,9.768c-1.486,5.421 -6.073,9.214 -13.319,11.017c-4.679,1.164 -6.873,1.249 -32.383,1.25l-24.121,0l0,-31.123l0,0.001Zm53.487,26.898c5.302,-1.278 8.729,-3.531 10.611,-6.977c0.842,-1.541 1.003,-2.178 1.108,-4.382c0.067,-1.419 -0.035,-3.207 -0.227,-3.975c-1.16,-4.648 -5.597,-8.1 -12.21,-9.498c-3.88,-0.821 -8.037,-0.965 -27.868,-0.97l-19.905,-0.004l0,26.571l23.028,-0.089c22.582,-0.086 23.075,-0.099 25.463,-0.675l0,-0.001Zm-3.997,-29.922c8.404,-1.52 12.655,-5.489 12.641,-11.8c-0.008,-2.822 -0.587,-4.884 -1.903,-6.762c-1.256,-1.789 -2.634,-2.787 -5.321,-3.854c-4.24,-1.682 -4.508,-1.699 -28.288,-1.818l-21.623,-0.109l0,24.696l8.977,0.093c17.473,0.179 33.148,-0.017 35.517,-0.446l0,0Zm36.689,3.043l0,-31.104l62.136,0l0,4.022l-28.414,0l-28.414,0l0,23.596l47.461,0l0,3.754l-23.731,0l-23.73,0l0,27.082l57.765,0l0,3.753l-31.537,0l-31.536,0l0,-31.103Zm78.061,0l0,-31.104l62.163,0l-0.091,1.944l-0.092,1.944l-28.492,0.069l-28.493,0.068l0,23.593l47.774,0l0,3.754l-23.887,0l-23.887,0l0,27.081l57.765,0l0,3.754l-31.38,0l-31.38,0l0,-31.103l0,0Zm77.748,0l0,-31.104l5.308,0l0,58.454l55.892,0l0,3.753l-30.6,0l-30.6,0l0,-31.103Zm76.187,0l0,-31.104l4.996,0l0,62.207l-2.498,0l-2.498,0l0,-31.103Zm25.604,0l0,-31.104l5.476,0l23.903,21.652c13.146,11.909 27.053,24.517 30.906,28.019l7.003,6.367l0.08,-28.019l0.08,-28.019l4.993,0l0,62.207l-2.437,0l-2.437,0l-10.425,-9.451c-5.734,-5.199 -19.778,-17.944 -31.208,-28.323l-20.781,-18.871l-0.08,28.323l-0.079,28.322l-2.497,0l-2.496,0l0,-31.103l-0.001,0Zm92.424,0l0,-31.104l62.136,0l0,4.022l-28.57,0l-28.57,0l0,23.596l47.773,0l0,3.754l-23.887,0l-23.886,0l0,27.082l58.077,0l0,3.753l-31.537,0l-31.536,0l0,-31.103Z"/>
						<title id="beeline-web-logo-title"><?php _e( 'Beeline', 'beeline-theme' ); ?></title>
						<desc id="beeline-web-logo-desc"><?php _e( 'Logo consisting of simply the word "Beeline" in thin, wide typography', 'beeline-theme' ); ?></desc>
						<text class="screen-reader-text"><?php _e( 'Beeline', 'beeline-theme' ); ?></text>
					</svg>
					<?php
					// Close conditional logo link.
					if ( ! is_front_page() ) { echo '</a>'; }

					// Site description.
					$site_description = get_bloginfo( 'description', 'display' );
					if ( $site_description || is_customize_preview() ) :
					?>
					<p class="site-description screen-reader-text"><?php echo $site_description; ?></p>
					<?php endif; ?>
				</div>
			</header>
		</div>
		<div class="bee-flourish"><?php echo file_get_contents( get_theme_file_path( '/assets/images/bee.svg' ) ); ?></div>
	</div>
	<div id="content" class="site-content">