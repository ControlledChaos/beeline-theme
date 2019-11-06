<?php
/**
 * Custom welcome panel
 *
 * The companion plugin looks for this file first then
 * defaults to the template in the plugin.
 *
 * @see beeline-plugin/admin/dashboards/partials/welcome-panel.php
 *
 * @package    WordPress/ClassicPress
 * @subpackage Beeline_Theme
 * @since      1.0.0
 */

/**
 * Check for the companion plugin
 *
 * Stop here if the Beeline plugin is not active.
 *
 * @since  1.0.0
 * @return void
 */
if ( ! is_plugin_active( BEELINE_PLUGIN ) ) {
	return;
}

// Get the current user name for the greeting.
$current_user = wp_get_current_user();
$user_name    = $current_user->display_name;

// Add a filterable description.
$about_desc = apply_filters( 'beeline_welcome_about', __( 'Following are some handy links to help you publish content and manage the website.', 'beeline-plugin' ) );

// Get static front page ID.
$front_page = get_option( 'page_on_front' );

// Get pages by slug.
$about_page   = get_page_by_path( 'about' );
$contact_page = get_page_by_path( 'contact' );

if ( $about_page ) {
    $about_link = admin_url( 'post.php?post=' . $about_page->ID . '&action=edit' );
} else {
    $about_link = '';
}

if ( $contact_page ) {
    $contact_link = admin_url( 'post.php?post=' . $contact_page->ID . '&action=edit' );
} else {
    $contact_link = '';
}

/**
 * Begin intro slides from front page
 *
 * Checks for the Advanced Custom Fields Pro plugin.
 *
 */
if ( class_exists( 'acf_pro' ) ) :

	// Intro slides and content.
	$slides = get_field( 'beeline_intro_gallery', $front_page );
	$size   = 'slide-large';
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
			<?php echo sprintf(
				'<h2>%1s %2s.</h2>',
				esc_html__( 'Welcome,', 'beeline-plugin' ),
				$user_name
			); ?>
			</div>
		</div>
    </div>
	<?php endif; ?>
<?php
// End check for the Advanced Custom Fields Pro plugin.
endif; ?>

<div class="beeline-dashboard-post-managment">
    <header class="beeline-dashboard-section-header">
		<h3><?php _e( 'Manage Content', 'beeline-plugin' ); ?></h3>
		<p class="about-description"><?php echo $about_desc; ?></p>
	</header>
    <ul class="beeline-dashboard-post-type-actions">
		<li>
            <h4><?php _e( 'Media', 'beeline-plugin' ); ?></h4>
            <div class="beeline-dashboard-content-actions-icon front-icon"><span class="dashicons dashicons-format-image"></span></div>
            <p>
                <a href="<?php echo admin_url( 'media-new.php' ); ?>"><?php _e( 'Add New', 'beeline-plugin' ); ?></a>
                <a href="<?php echo admin_url( 'upload.php' ); ?>"><?php _e( 'Manage', 'beeline-plugin' ); ?></a>
            </p>
		</li>
        <li>
            <h4><?php _e( 'Clients', 'beeline-plugin' ); ?></h4>
            <div class="beeline-dashboard-post-type-actions-icon clients-icon"><span class="dashicons dashicons-archive"></span></div>
            <p>
                <a href="<?php echo admin_url( 'post-new.php?post_type=client' ); ?>"><?php _e( 'Add New', 'beeline-plugin' ); ?></a>
                <a href="<?php echo admin_url( 'edit.php?post_type=client' ); ?>"><?php _e( 'View List', 'beeline-plugin' ); ?></a>
            </p>
        </li>
		<li>
            <h4><?php _e( 'Client Types', 'beeline-plugin' ); ?></h4>
            <div class="beeline-dashboard-post-type-actions-icon client-types-icon"><span class="dashicons dashicons-category"></span></div>
            <p>
                <a href="<?php echo admin_url( 'edit-tags.php?taxonomy=client_type&post_type=client' ); ?>"><?php _e( 'Manage Types', 'beeline-plugin' ); ?></a>
            </p>
        </li>
		<li>
            <h4><?php _e( 'Team', 'beeline-plugin' ); ?></h4>
            <div class="beeline-dashboard-post-type-actions-icon team-icon"><span class="dashicons dashicons-groups"></span></div>
            <p>
                <a href="<?php echo admin_url( 'post-new.php?post_type=team' ); ?>"><?php _e( 'Add New', 'beeline-plugin' ); ?></a>
                <a href="<?php echo admin_url( 'edit.php?post_type=team' ); ?>"><?php _e( 'View List', 'beeline-plugin' ); ?></a>
            </p>
        </li>
		<li>
            <h4><?php _e( 'Contact', 'beeline-plugin' ); ?></h4>
            <div class="beeline-dashboard-content-actions-icon email-icon"><span class="dashicons dashicons-email"></span></div>
            <p>
                <a href="<?php echo admin_url( 'admin.php?page=wpcf7' ); ?>"><?php _e( 'Forms', 'beeline-plugin' ); ?></a>
				<a href="<?php echo $contact_link; ?>"><?php _e( 'Page', 'beeline-plugin' ); ?></a>
            </p>
        </li>
		<li>
            <h4><?php _e( 'About', 'beeline-plugin' ); ?></h4>
            <div class="beeline-dashboard-content-actions-icon about-icon"><span class="dashicons dashicons-info"></span></div>
            <p>
                <a href="<?php echo $about_link; ?>"><?php _e( 'Edit Content', 'beeline-plugin' ); ?></a>
            </p>
        </li>
		<li>
            <h4><?php _e( 'News Posts', 'beeline-plugin' ); ?></h4>
            <div class="beeline-dashboard-post-type-actions-icon posts-icon"><span class="dashicons dashicons-megaphone"></span></div>
            <p>
                <a href="<?php echo admin_url( 'post-new.php' ); ?>"><?php _e( 'Add New', 'beeline-plugin' ); ?></a>
                <a href="<?php echo admin_url( 'edit.php' ); ?>"><?php _e( 'View List', 'beeline-plugin' ); ?></a>
            </p>
		</li>
		<li>
            <h4><?php _e( 'Users', 'beeline-plugin' ); ?></h4>
            <div class="beeline-dashboard-content-actions-icon users-icon"><span class="dashicons dashicons-admin-users"></span></div>
            <p>
                <a href="<?php echo admin_url( 'edit-comments.php' ); ?>"><?php _e( 'Comments', 'beeline-plugin' ); ?></a>
				<a href="<?php echo admin_url( 'users.php' ); ?>"><?php _e( 'Profiles', 'beeline-plugin' ); ?></a>
            </p>
        </li>
    </ul>
</div>