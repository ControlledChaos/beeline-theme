<?php
/**
 * Template tags
 *
 * @package    WordPress/ClassicPress
 * @subpackage Beeline_Theme
 * @since      1.0.0
 */

// Namespace specificity for theme functions & filters.
namespace Beeline_Theme\Tags;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if WordPress is 5.0 or greater.
 *
 * @since  1.0.0
 * @access public
 * @return bool Returns true if the WordPress version is 5.0 or greater.
 */
function theme_new_cms() {

	// Get the WordPress version.
	$version = get_bloginfo( 'version' );

	if ( $version >= 5.0 ) {
		return true;
	} else {
		return false;
	}

}

/**
 * Check if the CMS is ClassicPress.
 *
 * @since  1.0.0
 * @access public
 * @return bool Returns true if ClassicPress is running.
 */
function theme_classicpress() {

	if ( function_exists( 'classicpress_version' ) ) {
		return true;
	} else {
		return false;
	}

}

/**
 * Check for Advanced Custom Fields
 *
 * @since  1.0.0
 * @access public
 * @return bool Returns true if the ACF free or Pro plugin is active.
 */
function theme_acf() {

	if ( class_exists( 'acf' ) ) {
		return true;
	} else {
		return false;
	}

}

/**
 * Check for Advanced Custom Fields Pro
 *
 * @since  1.0.0
 * @access public
 * @return bool Returns true if the ACF Pro plugin is active.
 */
function theme_acf_pro() {

	if ( class_exists( 'acf_pro' ) ) {
		return true;
	} else {
		return false;
	}

}

/**
 * Check for Advanced Custom Fields options page
 *
 * @since  1.0.0
 * @access public
 * @return bool Returns true if ACF 4.0 free plus the
 *              Options Page addon or Pro plugin is active.
 */
function theme_acf_options() {

	if ( class_exists( 'acf_pro' ) ) {
		return true;
	} elseif ( ( class_exists( 'acf' ) && class_exists( 'acf_options_page' ) ) ) {
		return true;
	} else {
		return false;
	}

}

/**
 * Site Schema
 *
 * Conditional Schema attributes for `<div id="page"`.
 *
 * @since  1.0.0
 * @access public
 * @return string Returns the relevant itemtype.
 */
function site_schema() {

	// Change page slugs and template names as needed.
	if ( is_page( 'about' ) || is_page( 'about-us' ) || is_page_template( 'page-about.php' ) || is_page_template( 'about.php' ) ) {
		$itemtype = esc_attr( 'AboutPage' );
	} elseif ( is_page( 'contact' ) || is_page( 'contact-us' ) || is_page_template( 'page-contact.php' ) || is_page_template( 'contact.php' ) ) {
		$itemtype = esc_attr( 'ContactPage' );
	} elseif ( is_page( 'faq' ) || is_page( 'faqs' ) || is_page_template( 'page-faq.php' ) || is_page_template( 'faq.php' ) ) {
		$itemtype = esc_attr( 'QAPage' );
	} elseif ( is_page( 'cart' ) || is_page( 'shopping-cart' ) || is_page( 'checkout' ) || is_page_template( 'cart.php' ) || is_page_template( 'checkout.php' ) ) {
		$itemtype = esc_attr( 'CheckoutPage' );
	} elseif ( is_front_page() || is_page() ) {
		$itemtype = esc_attr( 'WebPage' );
	} elseif ( is_author() || is_plugin_active( 'buddypress/bp-loader.php' ) && bp_is_home() || is_plugin_active( 'bbpress/bbpress.php' ) && bbp_is_user_home() ) {
		$itemtype = esc_attr( 'ProfilePage' );
	} elseif ( is_search() ) {
		$itemtype = esc_attr( 'SearchResultsPage' );
	} else {
		$itemtype = esc_attr( 'Blog' );
	}

	echo $itemtype;

}

/**
 * Posted on
 *
 * Prints HTML with meta information for the current post-date/time.
 *
 * @since  1.0.0
 * @access public
 * @return string Returns the date posted.
 */
function posted_on() {

	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( DATE_W3C ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		/* translators: %s: post date. */
		esc_html_x( 'Posted on %s', 'post date', 'beeline-theme' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

}

/**
 * Posted by
 *
 * Prints HTML with meta information for the current author.
 *
 * @since  1.0.0
 * @access public
 * @return string Returns the author name.
 */
function posted_by() {

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'beeline-theme' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}

/**
 * Entry footer
 *
 * Prints HTML with meta information for the categories, tags and comments.
 *
 * @since  1.0.0
 * @access public
 * @return string Returns various post-related links.
 */
function entry_footer() {

	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {

		$categories_list = get_the_category_list( esc_html__( ', ', 'beeline-theme' ) );
		if ( $categories_list ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'beeline-theme' ) . '</span>', $categories_list );
		}

		$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'beeline-theme' ) );

		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'beeline-theme' ) . '</span>', $tags_list );
		}

	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {

		echo '<span class="comments-link">';
		comments_popup_link(
			sprintf(
				wp_kses(
					__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'beeline-theme' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);
		echo '</span>';
	}

}

/**
 * Post thumbnail
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 *
 * @since  1.0.0
 * @access public
 * @return string Returns HTML for the post thumbnail.
 */
function post_thumbnail() {

	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
		?>

		<div class="post-thumbnail post-thumbnail-full-width">
			<?php
			// Check for the slide image size.
			if ( has_image_size( 'banner' ) ) {
				echo get_the_post_thumbnail( '', 'banner', [ 'class' => 'alignnone' ] );
			} elseif ( has_image_size( 'slide-large' ) ) {
				echo get_the_post_thumbnail( '', 'slide-large', [ 'class' => 'alignnone' ] );
			} else {
				the_post_thumbnail();
			} ?>
		</div>

	<?php else : ?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
		<?php
		echo get_the_post_thumbnail( '', 'medium', [ 'class' => 'alignright' ] );
		?>
	</a>

	<?php
	endif;
}

/**
 * Open template tags.
 *
 * Following are template tags for further development
 * by the theme author, child themes, or plugins.
 *
 * These are primarily provided as examples.
 *
 * @todo Possibly add more open tags but perhaps not,
 *       as this is a starter theme.
 *
 * @since  1.0.0
 * @access public
 */

// Fires after opening `body` and before `#page`.
function before_page() {
	do_action( 'before_page' );
}

// Fires after `#page` and before `wp_footer`.
function after_page() {
	do_action( 'after_page' );
}

/**
 * Posts navigation for index and archive pages
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function posts_navigation() {

	// Nav text for clients.
	if ( is_post_type_archive( 'client' ) ) {
		$prev_text = __( 'Previous Clients', 'mixes-theme' );
		$next_text = __( 'Next Clients', 'mixes-theme' );

	// Nav text for posts.
	} else {
		$prev_text = __( 'Older Posts', 'mixes-theme' );
		$next_text = __( 'Newer Posts', 'mixes-theme' );
	}

	// Previous icon.
	$prev_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="theme-icon menu-prev"><path d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8.4 34.3z"/></svg>';

	// Next icon.
	$next_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="theme-icon menu-next"><path d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"/></svg>';

	// Array to return.
	$posts_navigation = the_posts_navigation( [
		'prev_text' => $prev_icon . $prev_text,
		'next_text' => $next_text . $next_icon
	] );

	return $posts_navigation;

}

/**
 * Posts navigation for singular pages
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function post_navigation() {

	// Nav text for clients.
	if ( is_post_type_archive( 'client' ) ) {
		$prev_text = __( 'Previous Client', 'mixes-theme' );
		$next_text = __( 'Next Client', 'mixes-theme' );

	// Nav text for posts.
	} else {
		$prev_text = __( '', 'mixes-theme' );
		$next_text = __( '', 'mixes-theme' );
	}

	// Previous icon.
	$prev_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="theme-icon menu-prev"><path d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8.4 34.3z"/></svg>';

	// Next icon.
	$next_icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="theme-icon menu-next"><path d="M190.5 66.9l22.2-22.2c9.4-9.4 24.6-9.4 33.9 0L441 239c9.4 9.4 9.4 24.6 0 33.9L246.6 467.3c-9.4 9.4-24.6 9.4-33.9 0l-22.2-22.2c-9.5-9.5-9.3-25 .4-34.3L311.4 296H24c-13.3 0-24-10.7-24-24v-32c0-13.3 10.7-24 24-24h287.4L190.9 101.2c-9.8-9.3-10-24.8-.4-34.3z"/></svg>';

	// Array to return.
	$posts_navigation = the_post_navigation( [
		'prev_text' => $prev_icon . get_the_title(),
		'next_text' => get_the_title() . $next_icon
	] );

	return $posts_navigation;

}