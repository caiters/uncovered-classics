<?php
/**
 * The template for displaying the footer.
 *
 * @package Zuki
 * @since Zuki 1.0
 */
?>

<?php get_sidebar( 'footer' ); ?>

<footer id="colophon" class="site-footer cf">

	<?php if (has_nav_menu( 'footer-social' ) ) : ?>
		<div id="footer-social-nav">
			<?php if ( get_theme_mod( 'footer_socialmenu_title' ) ) : ?>
				<h3 class="social-nav-title"><?php echo wp_kses_post( get_theme_mod( 'footer_socialmenu_title' ) ); ?></h3>
			<?php else : ?>
				<h3 class="social-nav-title"><?php _e('Follow Us', 'zuki') ?></h3>
			<?php endif; ?>
			<?php wp_nav_menu( array('theme_location' => 'footer-social', 'container' => 'false', 'depth' => -1));  ?>
		</div><!-- end #footer-social -->
	<?php endif; ?>

	<div id="site-info">
		<ul class="credit" role="contentinfo">
			<?php if ( get_theme_mod( 'credit_text' ) ) : ?>
				<li><?php echo wp_kses_post( get_theme_mod( 'credit_text' ) ); ?></li>
			<?php else : ?>
			<li class="copyright"><?php _e('Copyright', 'zuki') ?> &copy; <?php echo date('Y'); ?> <a href="<?php echo home_url( '/' ); ?>"><?php bloginfo(); ?>.</a></li>
			<?php endif; ?>
		</ul><!-- end .credit -->
	</div><!-- end #site-info -->

</footer><!-- end #colophon -->
</div><!-- end #main-wrap -->

</div><!-- end #container -->

<?php wp_footer(); ?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-60394866-1', 'auto');
  ga('send', 'pageview');

</script>

</body>
</html>
