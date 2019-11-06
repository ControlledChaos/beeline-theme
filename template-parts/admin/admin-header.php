<?php
/**
 * Admin header template.
 *
 * @package    WordPress/ClassicPress
 * @subpackage Beeline_Theme
 * @since      1.0.0
 */

/**
 * Admin header variables.
 *
 * @since 1.0.0
 */

// Get the site title.
$title = get_bloginfo( 'name' );

// Get the site tagline.
$description = get_bloginfo( 'description' );

// Return null if no site title.
if ( ! empty( $title ) ) {
    $title = get_bloginfo( 'name' );
} else {
    $title = __( 'Beeline', 'beeline-plugin' );
}

// Return a reminder if no site tagline.
if ( ! empty( $description ) ) {
    $description = get_bloginfo( 'description' );
} else {
    $description = __( 'Add a tagline in Settings > General or change this in', 'beeline-plugin' ) . ' <code>beeline-plugin/admin/partials/admin-header.php</code>';
}
?>
<?php do_action( 'blp_before_admin_header' ); ?>
<div class="content-wrapper header-content-wrapper">
	<div class="header-nav-wrapper">
		<nav id="admin-navigation" class="main-navigation admin-navigation">
			<?php wp_nav_menu(
				[
					'theme_location'  => 'admin-header',
					'menu_id'         => 'admin-navigation-list',
					'menu_class'      => 'admin-navigation-list'
				]
			); ?>
		</nav>
		<header class="blp-admin-header">
			<?php do_action( 'blp_before_admin_site_branding' ); ?>
			<div class="admin-site-branding">
				<p class="site-title admin-site-title screen-reader-text" itemprop="name"><a href="<?php echo admin_url(); ?>"><?php echo $title; ?></a></p>
				<p class="site-description admin-site-description screen-reader-text"><?php echo $description; ?></p>
				<svg id="beeline-web-logo-header" role="img" aria-labelledby="beeline-web-logo-title beeline-web-logo-desc" class="beeline-web-logo beeline-text-logo" width="100%" height="100%" viewBox="0 0 500 63" version="1.0" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/"><path id="path3034" d="M0,31.123l0,-31.123l23.965,0.119c20.003,0.099 24.437,0.189 26.822,0.544c5.418,0.805 8.932,2.121 11.686,4.377c3.211,2.631 4.646,5.887 4.654,10.561c0.008,4.55 -1.237,7.217 -4.829,10.34c-1.723,1.497 -2.807,2.163 -5.072,3.113l-2.881,1.207l2.094,0.487c1.152,0.268 3.151,0.943 4.442,1.501c4.216,1.822 6.769,4.252 8.364,7.961c1.03,2.396 1.309,7.105 0.578,9.768c-1.486,5.421 -6.073,9.214 -13.319,11.017c-4.679,1.164 -6.873,1.249 -32.383,1.25l-24.121,0l0,-31.123l0,0.001Zm53.487,26.898c5.302,-1.278 8.729,-3.531 10.611,-6.977c0.842,-1.541 1.003,-2.178 1.108,-4.382c0.067,-1.419 -0.035,-3.207 -0.227,-3.975c-1.16,-4.648 -5.597,-8.1 -12.21,-9.498c-3.88,-0.821 -8.037,-0.965 -27.868,-0.97l-19.905,-0.004l0,26.571l23.028,-0.089c22.582,-0.086 23.075,-0.099 25.463,-0.675l0,-0.001Zm-3.997,-29.922c8.404,-1.52 12.655,-5.489 12.641,-11.8c-0.008,-2.822 -0.587,-4.884 -1.903,-6.762c-1.256,-1.789 -2.634,-2.787 -5.321,-3.854c-4.24,-1.682 -4.508,-1.699 -28.288,-1.818l-21.623,-0.109l0,24.696l8.977,0.093c17.473,0.179 33.148,-0.017 35.517,-0.446l0,0Zm36.689,3.043l0,-31.104l62.136,0l0,4.022l-28.414,0l-28.414,0l0,23.596l47.461,0l0,3.754l-23.731,0l-23.73,0l0,27.082l57.765,0l0,3.753l-31.537,0l-31.536,0l0,-31.103Zm78.061,0l0,-31.104l62.163,0l-0.091,1.944l-0.092,1.944l-28.492,0.069l-28.493,0.068l0,23.593l47.774,0l0,3.754l-23.887,0l-23.887,0l0,27.081l57.765,0l0,3.754l-31.38,0l-31.38,0l0,-31.103l0,0Zm77.748,0l0,-31.104l5.308,0l0,58.454l55.892,0l0,3.753l-30.6,0l-30.6,0l0,-31.103Zm76.187,0l0,-31.104l4.996,0l0,62.207l-2.498,0l-2.498,0l0,-31.103Zm25.604,0l0,-31.104l5.476,0l23.903,21.652c13.146,11.909 27.053,24.517 30.906,28.019l7.003,6.367l0.08,-28.019l0.08,-28.019l4.993,0l0,62.207l-2.437,0l-2.437,0l-10.425,-9.451c-5.734,-5.199 -19.778,-17.944 -31.208,-28.323l-20.781,-18.871l-0.08,28.323l-0.079,28.322l-2.497,0l-2.496,0l0,-31.103l-0.001,0Zm92.424,0l0,-31.104l62.136,0l0,4.022l-28.57,0l-28.57,0l0,23.596l47.773,0l0,3.754l-23.887,0l-23.886,0l0,27.082l58.077,0l0,3.753l-31.537,0l-31.536,0l0,-31.103Z"/>
					<title id="beeline-web-logo-title"><?php _e( 'Beeline', 'beeline-theme' ); ?></title>
					<desc id="beeline-web-logo-desc"><?php _e( 'Logo consisting of simply the word "Beeline" in thin, wide typography', 'beeline-theme' ); ?></desc>
					<text class="screen-reader-text"><?php _e( 'Beeline', 'beeline-theme' ); ?></text>
				</svg>
			</div>
		</header>
	</div>
	<div class="bee-flourish"><?php echo file_get_contents( get_theme_file_path( '/assets/images/bee.svg' ) ); ?></div>
</div>
<?php do_action( 'blp_after_admin_header' ); ?>