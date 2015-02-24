<?php
/**
 * Available Zuki Custom Widgets
 *
 * Learn more: http://codex.wordpress.org/Widgets_API#Developing_Widgets
 *
 * @package Zuki
 * @since Zuki 1.0
 */

/*-----------------------------------------------------------------------------------*/
/* Custom UC Widget: Recent Posts Medium One (copy of Zuki widget)
/*-----------------------------------------------------------------------------------*/

class uc_recentposts_medium_one extends WP_Widget {

	function uc_recentposts_medium_one() {
		$widget_ops = array('description' => __( 'Medium-sized Recents Posts with featured image and excerpt.', 'zuki') );

		parent::WP_Widget(false, __('UC: Recent Posts (Medium 1)', 'zuki'),$widget_ops);
	}

	function widget($args, $instance) {
		$title = $instance['title'];
		$postnumber = $instance['postnumber'];
		$category = apply_filters('widget_title', $instance['category']);

		echo $args['before_widget']; ?>

		<?php if( ! empty( $title ) )
			echo '<div class="widget-title-wrap"><h3 class="widget-title"><span>'. esc_html($title) .'</span></h3></div>'; ?>

<?php
// The Query
$mediumone_query = new WP_Query(array (
		'post_status'    => 'publish',
		'posts_per_page' => $postnumber,
		'category_name' => $category,
		'ignore_sticky_posts' => 1
	) );
?>

<?php
// The Loop
if($mediumone_query->have_posts()) : ?>

   <?php while($mediumone_query->have_posts()) : $mediumone_query->the_post() ?>
    <article class="uc-medium-one">


      <div class="uc-medium-one-content <?php if ( '' != get_the_post_thumbnail() ) : ?>has-thumbnail<?php endif; ?>">
				<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'zuki' ), the_title_attribute( 'echo=0' ) ) ); ?>">
        <?php if ( '' != get_the_post_thumbnail() ) : ?>
			 		<div class="entry-thumb">
			 			<?php the_post_thumbnail('zuki-medium-landscape'); ?>
			 		</div><!-- end .entry-thumb -->
			  <?php endif; ?>
				<div class="medium-one-text">
					<h3 class="entry-title"><?php zuki_title_limit( 85, '...'); ?></h3>
					<div class="entry-author">
						<?php
							printf( __( '%3$s', 'zuki' ),
							esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
							sprintf( esc_attr__( 'All posts by %s', 'zuki' ), get_the_author() ),
							get_the_author() );
						?>
					</div><!-- end .entry-author -->
				</div>
			</a>
		</div><!--end .uc-medium-one -->


	</article><!--end .uc-medium-one -->

   <?php endwhile ?>

<?php endif ?>

	   <?php
	   echo $args['after_widget'];

	    // Reset the post globals as this query will have stomped on it
	   wp_reset_postdata();
	   }

   function update($new_instance, $old_instance) {
   		$instance['title'] = $new_instance['title'];
   		$instance['postnumber'] = $new_instance['postnumber'];
   		$instance['category'] = $new_instance['category'];

       return $new_instance;
   }

   function form($instance) {
   		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
   		$postnumber = isset( $instance['postnumber'] ) ? esc_attr( $instance['postnumber'] ) : '';
   		$category = isset( $instance['category'] ) ? esc_attr( $instance['category'] ) : '';
   	?>

	<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','zuki'); ?></label>
		<input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" /></p>

	<p><label for="<?php echo $this->get_field_id('postnumber'); ?>"><?php _e('Number of posts to show:','zuki'); ?></label>
		<input type="text" name="<?php echo $this->get_field_name('postnumber'); ?>" value="<?php echo esc_attr($postnumber); ?>" class="widefat" id="<?php echo $this->get_field_id('postnumber'); ?>" /></p>

	<p><label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category slug (optional):','zuki'); ?></label>
		<input type="text" name="<?php echo $this->get_field_name('category'); ?>" value="<?php echo esc_attr($category); ?>" class="widefat" id="<?php echo $this->get_field_id('category'); ?>" /></p>

	<?php
	}
}

register_widget('uc_recentposts_medium_one');



/*-----------------------------------------------------------------------------------*/
/* Uncovered Classics Widget: Recent Posts Full
/*-----------------------------------------------------------------------------------*/

class uc_recentposts_full extends WP_Widget {

	function uc_recentposts_full() {
		$widget_ops = array('description' => __( 'Large-sized Recents Posts in a 1-column layout with featured image and excerpt.', 'zuki') );

		parent::WP_Widget(false, __('UC: Recent Posts (Large)', 'zuki'),$widget_ops);
	}

	function widget($args, $instance) {
		$title = $instance['title'];
		$postnumber = $instance['postnumber'];
		$category = apply_filters('widget_title', $instance['category']);

		echo $args['before_widget']; ?>

		<?php if( ! empty( $title ) )
			echo '<div class="widget-title-wrap"><h3 class="widget-title"><span>'. esc_html($title) .'</span></h3></div>'; ?>

<?php
// The Query
$uclarge_query = new WP_Query(array (
		'post_status'    => 'publish',
		'posts_per_page' => $postnumber,
		'category_name' => $category,
		'ignore_sticky_posts' => 1
	) );
?>

<?php
// The Loop
if($uclarge_query->have_posts()) : ?>

   <?php while($uclarge_query->have_posts()) : $uclarge_query->the_post() ?>
   <article class="uc-post-container cf">
      <div class="uc-post-content">

         <?php if ( '' != get_the_post_thumbnail() ) : ?>
			 <div class="entry-thumb">
				 <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'zuki' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php the_post_thumbnail('uc-homepage'); ?></a>
			</div><!-- end .entry-thumb -->
		<?php endif; ?>

			<div class="story">
				<h3 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'zuki' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php the_title(); ?></a></h3>
				<div class="entry-author">
				<?php
					printf( __( '<a href="%1$s" title="%2$s">%3$s</a>', 'zuki' ),
					esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					sprintf( esc_attr__( 'All posts by %s', 'zuki' ), get_the_author() ),
					get_the_author() );
				?>
				</div><!-- end .entry-author -->
				<div class="entry-info">
					<a href="<?php the_permalink(); ?>" class="entry-date"><?php echo get_the_date(); ?></a> <?php if ( comments_open() ) : ?>&mdash; <?php comments_popup_link( '<span class="leave-reply">' . __( '0 comments', 'zuki' ) . '</span>', __( '1 comment', 'zuki' ), __( '% comments', 'zuki' ) ); ?><?php endif; // comments_open() ?>
				</div>
				<p class="summary"><?php echo the_content(); ?></p>
			</div><!--end .story -->
		</div><!--end .uc-medium-two-content -->
	</article><!--end .uc-medium-two -->

   <?php endwhile ?>

<?php endif ?>

	   <?php
	   echo $args['after_widget'];

	    // Reset the post globals as this query will have stomped on it
	   wp_reset_postdata();
	   }

   function update($new_instance, $old_instance) {
   		$instance['title'] = $new_instance['title'];
   		$instance['postnumber'] = $new_instance['postnumber'];
   		$instance['category'] = $new_instance['category'];

       return $new_instance;
   }

   function form($instance) {
   		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
   		$postnumber = isset( $instance['postnumber'] ) ? esc_attr( $instance['postnumber'] ) : '';
   		$category = isset( $instance['category'] ) ? esc_attr( $instance['category'] ) : '';
   	?>

	<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','zuki'); ?></label>
		<input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" /></p>

	<p><label for="<?php echo $this->get_field_id('postnumber'); ?>"><?php _e('Number of posts to show:','zuki'); ?></label>
		<input type="text" name="<?php echo $this->get_field_name('postnumber'); ?>" value="<?php echo esc_attr($postnumber); ?>" class="widefat" id="<?php echo $this->get_field_id('postnumber'); ?>" /></p>

	<p><label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Category slug (optional):','zuki'); ?></label>
		<input type="text" name="<?php echo $this->get_field_name('category'); ?>" value="<?php echo esc_attr($category); ?>" class="widefat" id="<?php echo $this->get_field_id('category'); ?>" /></p>

	<?php
	}
}

register_widget('uc_recentposts_full');
