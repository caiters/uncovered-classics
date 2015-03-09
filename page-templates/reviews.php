<?php
/**
 * Template Name: Reviews
 *
 * Description: Reviews template
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
		query_posts('category_name=reviews&showposts=5');
		// Start the Loop.

		while ( have_posts() ) : the_post();

			// Include the page content template.
			?><article class="uc-post-container cf">
				<div class="uc-post-content"><?php
			if ( has_post_thumbnail() ) {
				?><div class="entry-thumb"><a href="<?php the_permalink() ?>"><?php the_post_thumbnail(); ?></a></div><?php
		  } ?>
			<div class="story">
				<h3 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			<?php the_content();
		  ?></div></div></article><?php
			// Disabling comments on pages - uncomment these if you want to add them back
			//if ( comments_open() || get_comments_number() ) {
				//comments_template();
			//}
		endwhile;
	?>

</div><!-- end #primary -->

</div><!-- end #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
