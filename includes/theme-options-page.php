<?php
/**
 * Theme options page output
 *
 * @package    WordPress/ClassicPress
 * @subpackage Beeline_Theme
 * @since      1.0.0
 */

namespace Beeline_Theme\Includes\Options;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Page title.
$title = sprintf(
	'<h1 class="wp-heading-inline">%1s %2s</h1>',
	get_bloginfo( 'name' ),
	__( 'Display Options', 'beeline-theme' )
);

// Page description.
$description = sprintf(
	'<p class="description">%1s</p>',
	__( 'This is a starter/example page. Use it or remove it.', 'beeline-theme' )
);

// Begin page output.
?>

<div class="wrap beeline-theme-options-page">
	<?php echo $title; ?>
	<?php echo $description; ?>
	<hr />
</div><!-- End .wrap -->