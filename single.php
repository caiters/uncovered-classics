<?php
/**
 * The Template for displaying single posts.
 *
 * @package Zuki
 * @since Zuki 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content cf" role="main">
		<?php if (is_active_sidebar('content-page-top')): ?>
		<div class="widget-area">
		<?php dynamic_sidebar( 'content-page-top' ); ?>
		</div>
		<?php endif;?>
		<?php
			// Start the Loop.
			while ( have_posts() ) : the_post();

				get_template_part( 'content', 'single' );
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
			endwhile;
		?>

		<?php
		// Previous/next post navigation.
		zuki_post_nav( 'nav-single' ); ?>

	</div><!-- end #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
