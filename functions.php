<?php
/**
 * BS Theme functions
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
 * BS Theme is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * BS Theme is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with BS Theme. If not, see {URI to Plugin License}.
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
 * BS Theme functions class
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

		// Theme options page.
		// add_action( 'admin_menu', [ $this, 'theme_options' ] );

		// Theme info page.
		// add_action( 'admin_menu', [ $this, 'theme_info' ] );

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
			'main'   => __( 'Main Menu', 'beeline-theme' ),
			// 'footer' => __( 'Footer Menu', 'beeline-theme' ),
			// 'social' => __( 'Social Menu', 'beeline-theme' )
		] );

		/**
		 * Add stylesheet for the content editor.
		 *
		 * @since 1.0.0
		 */
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
		remove_action( 'wp_head', 'wp_site_icon', 99 );
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
	public function admin_scripts() {}

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
		// wp_enqueue_style( 'beeline-adobe-fonts', 'https://use.typekit.net/jyo4had.css', [], '', 'screen' );

		wp_enqueue_style( 'beeline-admin', get_theme_file_uri( '/assets/css/admin.min.css' ), [], '' );

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
			$title = single_term_title( '', false ) . __( ' Clients', 'beeline-theme' );

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
	 * Theme info page
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function theme_info() {

		// Add a submenu page under Themes.
		add_submenu_page(
			'themes.php',
			__( 'Theme Info', 'beeline-theme' ),
			__( 'Theme Info', 'beeline-theme' ),
			'manage_options',
			'beeline-theme-info',
			[ $this, 'theme_info_output' ]
		);

	}

	/**
     * Get output of the theme info page
     *
     * @since  1.0.0
	 * @access public
	 * @return void
     */
    public function theme_info_output() {

        require get_theme_file_path( '/includes/theme-info-page.php' );

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
function bs_theme() {

	$bs_theme = Functions::get_instance();

	return $bs_theme;

}

// Run the Functions class.
bs_theme();