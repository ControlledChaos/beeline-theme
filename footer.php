<?php
/**
 * The template for displaying the footer
 *
 * @package    WordPress/ClassicPress
 * @subpackage Beeline_Theme
 * @since      1.0.0
 */

// Get the site name.
$site_name = esc_attr( get_bloginfo( 'name' ) );

// Copyright HTML.
$copyright = sprintf(
	'<p class="copyright-text" itemscope="itemscope" itemtype="http://schema.org/CreativeWork">&copy; <span class="screen-reader-text">%1s</span><span itemprop="copyrightYear">%2s</span> <span itemprop="copyrightHolder">%3s.</span> %4s.</p>',
	esc_html__( 'Copyright ', 'beeline-theme' ),
	get_the_time( 'Y' ),
	$site_name,
	esc_html__( 'All rights reserved', 'beeline-theme' )
); ?>

	</div>

	<footer id="colophon" class="site-footer">
		<div class="footer-content global-wrapper footer-wrapper">
			<div class="bee-flourish"><?php echo file_get_contents( get_theme_file_path( '/assets/images/bee.svg' ) ); ?></div>
			<?php echo $copyright; ?>
		</div>
	</footer>
</div>

<?php Beeline_Theme\Tags\after_page(); ?>
<?php wp_footer(); ?>

</body>
</html>