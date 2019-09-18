<?php
/**
 * The sidebar containing the main widget area
 *
 * @package    WordPress/ClassicPress
 * @subpackage Beeline_Theme
 * @since      1.0.0
 */

?>
<aside id="secondary" class="widget-area">
	<?php
		if ( is_active_sidebar( 'sidebar' ) ) {
			dynamic_sidebar( 'sidebar' );
		} ?>
</aside>