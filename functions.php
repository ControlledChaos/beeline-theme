<?php
/**
 * Beeline Theme functions
 *
 * A basic starter theme for WordPress and ClassicPress.
 *
 * @package    WordPress/ClassicPress
 * @subpackage Beeline_Theme
 * @author     Controlled Chaos Design <greg@ccdzine.com>
 * @copyright  Copyright (c) Controlled Chaos Design
 * @link       https://github.com/ControlledChaos/beeline-theme
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 * @since      1.0.0
 */

/**
 * License & Warranty
 *
 * Beeline Theme is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Beeline Theme is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Beeline Theme. If not, see {URI to Plugin License}.
 */

// Namespace specificity for theme functions & filters.
namespace Beeline_Theme\Functions;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get plugins path to check for active plugins.
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Define the companion plugin path: directory and core file name.
 *
 * @since  1.0.0
 * @return string Returns the plugin path of the companion.
 */
if ( ! defined( 'BEELINE_PLUGIN' ) ) {
	define( 'BEELINE_PLUGIN', 'beeline-plugin/beeline-plugin.php' );
}

/**
 * Beeline Theme functions class
 *
 * @since  1.0.0
 * @access public
 */
final class Functions {

	/**
	 * Return the instance of the class
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {

			$instance = new self;

			// Theme dependencies.
			$instance->dependencies();

		}

		return $instance;
	}

	/**
	 * Constructor magic method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct() {

		// Swap html 'no-js' class with 'js'.
		add_action( 'wp_head', [ $this, 'js_detect' ], 0 );

		// Remove WordPress 5.3 large images.
		remove_action( 'plugins_loaded', '_wp_add_additional_image_sizes', 0 );

		// Theme setup.
		add_action( 'after_setup_theme', [ $this, 'setup' ] );

		// Register widgets.
        add_action( 'widgets_init', [ $this, 'widgets' ] );

		// Remove unpopular meta tags.
		add_action( 'init', [ $this, 'head_cleanup' ] );

		// Frontend scripts.
		add_action( 'wp_enqueue_scripts', [ $this, 'frontend_scripts' ] );

		// Frontend footer scripts.
		add_action( 'wp_footer', [ $this, 'frontend_footer_scripts' ], 20 );

		// Admin scripts.
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );

		// Frontend styles.
		add_action( 'wp_enqueue_scripts', [ $this, 'frontend_styles' ] );

		/**
		 * Admin styles.
		 *
		 * Call late to override plugin styles.
		 */
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_styles' ], 99 );

		// Login styles.
		add_action( 'login_enqueue_scripts', [ $this, 'login_styles' ] );

		// Remove prepend text from archive titles.
		add_filter( 'get_the_archive_title', [ $this, 'archive_title' ] );

		// jQuery UI fallback for HTML5 Contact Form 7 form fields.
		add_filter( 'wpcf7_support_html5_fallback', '__return_true' );

		// Login title.
		add_filter( 'login_headertext', [ $this, 'login_url_title' ] );

		// Admin footer.
		add_action( 'in_admin_footer', [ $this, 'admin_footer' ] );

	}

	/**
	 * JS Replace
	 *
	 * Replaces 'no-js' class with 'js' in the <html> element
	 * when JavaScript is detected.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function js_detect() {

		echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";

	}

	/**
	 * Theme setup
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function setup() {

		/**
		 * Load domain for translation
		 *
		 * @since 1.0.0
		 */
		load_theme_textdomain( 'beeline-theme' );

		/**
		 * Add theme support
		 *
		 * @since 1.0.0
		 */

		// Browser title tag support.
		add_theme_support( 'title-tag' );

		// RSS feed links support.
		add_theme_support( 'automatic-feed-links' );

		// HTML 5 tags support.
		add_theme_support( 'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gscreenery',
			'caption'
		 ] );

		/**
		 * Add theme support.
		 *
		 * @since 1.0.0
		 */

		// Customizer widget refresh support.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Featured image support.
		add_theme_support( 'post-thumbnails' );

		/**
		 * Add image sizes.
		 *
		 * Three sizes per aspect ratio so that WordPress
		 * will use srcset for responsive images.
		 *
		 * @since 1.0.0
		 */

		// 4:3 Standard monitor background slides.
		add_image_size( 'slide-small', 640, 360, true );
		add_image_size( 'slide-medium', 1024, 576, true );
		add_image_size( 'slide-large', 2048, 1152, true );

		// Roster preview grid.
		add_image_size( __( 'roster-preview', 'beeline-theme' ), 80, 80, true );

		 /**
		 * Set content width.
		 *
		 * @since 1.0.0
		 */
		$bs_content_width = apply_filters( 'beeline_content_width', 1280 );

		if ( ! isset( $content_width ) ) {
			$content_width = $bs_content_width;
		}

		/**
		 * Register theme menus.
		 *
		 * @since  1.0.0
		 */
		register_nav_menus( [
			'main'         => __( 'Main Menu', 'beeline-theme' ),
			'admin-header' => __( 'Admin Header', 'beeline-theme' )
		] );

		/**
		 * Add stylesheet for the content editor.
		 *
		 * @since 1.0.0
		 */
		add_editor_style( 'https://use.typekit.net/jyo4had.css', [], '', 'screen' );
		add_editor_style( '/assets/css/editor.min.css', [ 'beeline-admin' ], '', 'screen' );

	}

	/**
	 * Register widgets
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function widgets() {

		register_sidebar( [
			'name'          => esc_html__( 'Sidebar', 'beeline-theme' ),
			'id'            => 'sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'beeline-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		] );

	}

	/**
	 * Clean up meta tags from the <head>
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function head_cleanup() {

		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'wp_generator' );
	}

	/**
	 * Frontend scripts
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function frontend_scripts() {

		wp_enqueue_script( 'jquery' );

		wp_enqueue_script( 'beeline-navigation', get_theme_file_uri( '/assets/js/navigation.min.js' ), [], null, true );

		wp_enqueue_script( 'beeline-theme-skip-link-focus-fix', get_theme_file_uri( '/assets/js/skip-link-focus-fix.min.js' ), [], null, true );

		// Comments scripts.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

	}

	/**
	 * Frontend footer scripts
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function frontend_footer_scripts() {

		if ( is_front_page() ) {
			echo '
			<script>
			jQuery(".intro-slides").slick({
				autoplay: true,
				autoplaySpeed: 4500,
				slidesToShow: 1,
				arrows: false,
				dots: false,
				infinite: true,
				speed: 800,
				adaptiveHeight: true,
				variableWidth: false,
				mobileFirst: true,
				draggable: false,
				fade: true,
				pauseOnHover: false
			});
			</script>';
		}

	}

	/**
	 * Admin scripts
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_scripts() {

		/**
		 * Slick slider for the dashboard intro.
		 *
		 * Only if the Beeline plugin and the Advanced
		 * Custom Fields Pro plugin are active.
		 */
		if ( is_plugin_active( BEELINE_PLUGIN ) && class_exists( 'acf_pro' ) ) {

			wp_enqueue_script( 'beeline-slick', get_theme_file_uri( '/assets/js/slick.min.js' ), [ 'jquery' ], null, true );
			wp_add_inline_script( 'beeline-slick', '
				jQuery(".intro-slides").slick({
					autoplay: true,
					autoplaySpeed: 4500,
					slidesToShow: 1,
					arrows: false,
					dots: false,
					infinite: true,
					speed: 800,
					adaptiveHeight: true,
					variableWidth: false,
					mobileFirst: true,
					draggable: false,
					fade: true,
					pauseOnHover: false
				});
			' );

		}
	}

	/**
	 * Frontend styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function frontend_styles() {

		// Google fonts.
		// wp_enqueue_style( 'beeline-google-fonts', 'add-url-here', [], '', 'screen' );

		// Adobe fonts.
		wp_enqueue_style( 'beeline-adobe-fonts', 'https://use.typekit.net/jyo4had.css', [], '', 'screen' );

		/**
		 * Theme sylesheet
		 *
		 * This enqueues the minified stylesheet compiled from SASS (.scss) files.
		 * The main stylesheet, in the root directory, only contains the theme header but
		 * it is necessary for theme activation. DO NOT delete the main stylesheet!
		 */
		wp_enqueue_style( 'beeline', get_theme_file_uri( '/assets/css/style.min.css' ), [], '' );

		// Print styles.
		wp_enqueue_style( 'bs-print', get_theme_file_uri( '/assets/css/print.min.css' ), [], '', 'print' );

	}

	/**
	 * Admin styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_styles() {

		// Google fonts.
		// wp_enqueue_style( 'beeline-google-fonts', 'add-url-here', [], '', 'screen' );

		// Adobe fonts.
		wp_enqueue_style( 'beeline-adobe-fonts', 'https://use.typekit.net/jyo4had.css', [], '', 'screen' );

		wp_enqueue_style( 'beeline-admin', get_theme_file_uri( '/assets/css/admin.min.css' ), [], '' );

		/**
		 * Slick slider for the dashboard intro.
		 *
		 * Only if the Beeline plugin and the Advanced
		 * Custom Fields Pro plugin are active.
		 */
		if ( is_plugin_active( BEELINE_PLUGIN ) && class_exists( 'acf_pro' ) ) {
			wp_enqueue_style( 'beeline-slick', get_theme_file_uri( '/assets/css/slick.min.css' ), [], '', 'screen' );
		}

	}

	/**
	 * Login styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function login_styles() {

		// Google fonts.
		// wp_enqueue_style( 'beeline-google-fonts', 'add-url-here', [], '', 'screen' );

		// Adobe fonts.
		wp_enqueue_style( 'beeline-adobe-fonts', 'https://use.typekit.net/jyo4had.css', [], '', 'screen' );

		wp_enqueue_style( 'beeline-login', get_theme_file_uri( '/assets/css/login.css' ), [], '', 'screen' );

	}

	/**
	 * Filter archive titles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the filtered titles.
	 */
	public function archive_title( $title ) {

		// Get query vars for search & filter pages.
		$term     = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		$liquor   = get_query_var( 'client_types', '' );

		// If a client type archive.
		if ( is_tax( 'client_type' ) ) {
			$title = single_term_title( '', false );

		} elseif ( is_post_type_archive( 'client' ) ) {
			$title = __( 'Beeline Clients', 'beeline-theme' );

		// If is taxonomy archive.
		} elseif ( is_tax() ) {
			$title = single_cat_title( '', false );

		// If is standard category archive.
		} elseif ( is_category() ) {
			$title = single_cat_title( '', false );

		// If is standard tag archive.
		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );

		} elseif ( is_post_type_archive( 'recipe' ) ) {
            $title = __( 'Explore Recipes', 'mixes-theme' );

		// If is author archive.
		} elseif ( is_author() ) {
			$title = sprintf(
				'%1s <span class="vcard">%2s</span>',
				__( 'Posts by', 'mixes-theme' ),
				get_the_author()
			);
		}

		// Return the ammended title.
    	return $title;

	}

	/**
	 * Theme dependencies
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function dependencies() {

		require get_theme_file_path( '/includes/template-functions.php' );
		require get_theme_file_path( '/includes/template-tags.php' );
		require get_theme_file_path( '/includes/customizer.php' );

		// Disable access to the Customizer.
		require get_theme_file_path( '/includes/class-customizer-remove-all.php' );

	}

	/**
	 * Theme options page
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function theme_options() {

		// Add a submenu page under Themes.
		$this->help_theme_options = add_submenu_page(
			'themes.php',
			__( 'Theme Options', 'beeline-theme' ),
			__( 'Theme Options', 'beeline-theme' ),
			'manage_options',
			'beeline-theme-options',
			[ $this, 'theme_options_output' ]
		);

		// Add sample help tab.
		add_action( 'load-' . $this->help_theme_options, [ $this, 'help_theme_options' ] );

	}

	/**
     * Get output of the theme options page
     *
     * @since  1.0.0
	 * @access public
	 * @return void
     */
    public function theme_options_output() {

        require get_parent_theme_file_path( '/includes/theme-options-page.php' );

	}

	/**
     * Add tabs to the about page contextual help section
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
     */
    public function help_theme_options() {

		// Add to the about page.
		$screen = get_current_screen();
		if ( $screen->id != $this->help_theme_options ) {
			return;
		}

		// More information tab.
		$screen->add_help_tab( [
			'id'       => 'help_theme_options_info',
			'title'    => __( 'More Information', 'beeline-theme' ),
			'content'  => null,
			'callback' => [ $this, 'help_theme_options_info' ]
		] );

        // Add a help sidebar.
		$screen->set_help_sidebar(
			$this->help_theme_options_sidebar()
		);

	}

	/**
     * Get convert plugin help tab content
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
     */
	public function help_theme_options_info() {

		include_once get_theme_file_path( 'includes/partials/help-theme-options-info.php' );

    }

    /**
     * The about page contextual tab sidebar content
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the HTML of the sidebar content.
     */
    public function help_theme_options_sidebar() {

        $html  = sprintf( '<h4>%1s</h4>', __( 'Author Credits', 'beeline-theme' ) );
        $html .= sprintf(
            '<p>%1s %2s.</p>',
            __( 'This theme was created by', 'beeline-theme' ),
            'Your Name'
        );
        $html .= sprintf(
            '<p>%1s <br /><a href="%2s" target="_blank">%3s</a> <br />%4s</p>',
            __( 'Visit', 'beeline-theme' ),
            'https://example.com/',
            'Example Site',
            __( 'for more details.', 'beeline-theme' )
        );
        $html .= sprintf(
            '<p>%1s</p>',
            __( 'Change this sidebar to give yourself credit for the hard work you did customizing this theme.', 'beeline-theme' )
         );

		return $html;

	}

	/**
	 * Login title
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the title attribute text.
	 */
	public function login_url_title() {

		$site_title = sprintf(
			'<span class="screen-reader-text">%1s</span>%2s',
			__( 'Beeline', 'mixes-theme' ),
			'<svg id="beeline-web-logo-header" class="beeline-web-logo beeline-text-logo" width="100%" height="100%" viewBox="0 0 500 63" version="1.0" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/"><path id="path3034" d="M0,31.123l0,-31.123l23.965,0.119c20.003,0.099 24.437,0.189 26.822,0.544c5.418,0.805 8.932,2.121 11.686,4.377c3.211,2.631 4.646,5.887 4.654,10.561c0.008,4.55 -1.237,7.217 -4.829,10.34c-1.723,1.497 -2.807,2.163 -5.072,3.113l-2.881,1.207l2.094,0.487c1.152,0.268 3.151,0.943 4.442,1.501c4.216,1.822 6.769,4.252 8.364,7.961c1.03,2.396 1.309,7.105 0.578,9.768c-1.486,5.421 -6.073,9.214 -13.319,11.017c-4.679,1.164 -6.873,1.249 -32.383,1.25l-24.121,0l0,-31.123l0,0.001Zm53.487,26.898c5.302,-1.278 8.729,-3.531 10.611,-6.977c0.842,-1.541 1.003,-2.178 1.108,-4.382c0.067,-1.419 -0.035,-3.207 -0.227,-3.975c-1.16,-4.648 -5.597,-8.1 -12.21,-9.498c-3.88,-0.821 -8.037,-0.965 -27.868,-0.97l-19.905,-0.004l0,26.571l23.028,-0.089c22.582,-0.086 23.075,-0.099 25.463,-0.675l0,-0.001Zm-3.997,-29.922c8.404,-1.52 12.655,-5.489 12.641,-11.8c-0.008,-2.822 -0.587,-4.884 -1.903,-6.762c-1.256,-1.789 -2.634,-2.787 -5.321,-3.854c-4.24,-1.682 -4.508,-1.699 -28.288,-1.818l-21.623,-0.109l0,24.696l8.977,0.093c17.473,0.179 33.148,-0.017 35.517,-0.446l0,0Zm36.689,3.043l0,-31.104l62.136,0l0,4.022l-28.414,0l-28.414,0l0,23.596l47.461,0l0,3.754l-23.731,0l-23.73,0l0,27.082l57.765,0l0,3.753l-31.537,0l-31.536,0l0,-31.103Zm78.061,0l0,-31.104l62.163,0l-0.091,1.944l-0.092,1.944l-28.492,0.069l-28.493,0.068l0,23.593l47.774,0l0,3.754l-23.887,0l-23.887,0l0,27.081l57.765,0l0,3.754l-31.38,0l-31.38,0l0,-31.103l0,0Zm77.748,0l0,-31.104l5.308,0l0,58.454l55.892,0l0,3.753l-30.6,0l-30.6,0l0,-31.103Zm76.187,0l0,-31.104l4.996,0l0,62.207l-2.498,0l-2.498,0l0,-31.103Zm25.604,0l0,-31.104l5.476,0l23.903,21.652c13.146,11.909 27.053,24.517 30.906,28.019l7.003,6.367l0.08,-28.019l0.08,-28.019l4.993,0l0,62.207l-2.437,0l-2.437,0l-10.425,-9.451c-5.734,-5.199 -19.778,-17.944 -31.208,-28.323l-20.781,-18.871l-0.08,28.323l-0.079,28.322l-2.497,0l-2.496,0l0,-31.103l-0.001,0Zm92.424,0l0,-31.104l62.136,0l0,4.022l-28.57,0l-28.57,0l0,23.596l47.773,0l0,3.754l-23.887,0l-23.886,0l0,27.082l58.077,0l0,3.753l-31.537,0l-31.536,0l0,-31.103Z"/></svg>'
		);

		return $site_title;
	}

	/**
	 * Admin footer
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the footer markup.
	 */
	public function admin_footer() {
		get_template_part( 'template-parts/admin-footer' );
	}

}

/**
 * Get an instance of the Functions class
 *
 * This function is useful for quickly grabbing data
 * used throughout the theme.
 *
 * @since  1.0.0
 * @access public
 * @return object
 */
 function beeline_theme() {

	$beeline_theme = Functions::get_instance();

	return $beeline_theme;

}

// Run the Functions class.
beeline_theme();