<?php
ini_set('display_errors',1);
error_reporting(E_ALL);


add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
  wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
  wp_enqueue_style( 'magnific-popup-css', get_stylesheet_directory_uri() . '/magnific-popup.css' );
  wp_enqueue_script( 'magnific-popup-js', get_stylesheet_directory_uri() . '/js/jquery.magnific-popup.min.js', array( 'jquery' ), '03082015' );
  wp_enqueue_script( 'uc-js', get_stylesheet_directory_uri() . '/js/uncovered-classics.js', array( 'jquery' ), '1', true );
}

/*-----------------------------------------------------------------------------------*/
/* Grab the Zuki Custom widgets.
/*-----------------------------------------------------------------------------------*/
require( '/home/ayashi/web/clients/uncovered-classics/wp-content/themes/zuki-child/inc/widgets.php' );

add_image_size( 'uc-homepage', 380, 540, true ); // Homepage thumbnails (cropped)
add_image_size( 'uc-highlights', 151, 214, true ); // Highlights thumbnails (cropped)
add_image_size( 'uc-gallery-thumb', 219, 310, true ); // Gallery thumbnails (cropped)

add_filter( 'the_content_more_link', 'modify_read_more_link' );
  function modify_read_more_link() {
    return '<a class="more-link" href="' . get_permalink() . '">Read More</a>';
}

register_sidebar(array(
	'name'=> 'Article top',
	'id' => 'content-page-top',
  'before_widget' => '<aside id="%1$s" class="widget %2$s">',
  'after_widget' => "</aside>",
  'before_title' => '<h3 class="widget-title">',
  'after_title' => '</h3>'
));

function custom_wp_trim_excerpt($text) {
$raw_excerpt = $text;
if ( '' == $text ) {
    //Retrieve the post content.
    $text = get_the_content('');

    //Delete all shortcode tags from the content.
    $text = strip_shortcodes( $text );

    $text = apply_filters('the_content', $text);
    $text = str_replace(']]>', ']]&gt;', $text);

    $allowed_tags = 'p, br, a'; /*** MODIFY THIS. Add the allowed HTML tags separated by a comma.***/
    $text = strip_tags($text, $allowed_tags);

    $excerpt_word_count = 105; /*** MODIFY THIS. change the excerpt word count to any integer you like.***/
    $excerpt_length = apply_filters('excerpt_length', $excerpt_word_count);

    $excerpt_end = '[...]'; /*** MODIFY THIS. change the excerpt endind to something else.***/
    $excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end);

    $words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
    if ( count($words) > $excerpt_length ) {
        array_pop($words);
        $text = implode(' ', $words);
        $text = $text . $excerpt_more;
    } else {
        $text = implode(' ', $words);
    }
}
return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'custom_wp_trim_excerpt');

// Custom filter function to modify default gallery shortcode output
function my_post_gallery( $output, $attr ) {

	// Initialize
	global $post, $wp_locale;

	// Gallery instance counter
	static $instance = 0;
	$instance++;

	// Validate the author's orderby attribute
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( ! $attr['orderby'] ) unset( $attr['orderby'] );
	}

	// Get attributes from shortcode
	extract( shortcode_atts( array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'dl',
		'icontag'    => 'dt',
		'captiontag' => 'dd',
		'columns'    => 4,
		'size'       => 'uc-gallery-thumb',
		'include'    => '',
		'exclude'    => '',
    'titletag'   => 'p',
    'descriptiontag' => 'p'
	), $attr ) );

	// Initialize
	$id = intval( $id );
	$attachments = array();
	if ( $order == 'RAND' ) $orderby = 'none';

	if ( ! empty( $include ) ) {

		// Include attribute is present
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array( 'include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );

		// Setup attachments array
		foreach ( $_attachments as $key => $val ) {
			$attachments[ $val->ID ] = $_attachments[ $key ];
		}

	} else if ( ! empty( $exclude ) ) {

		// Exclude attribute is present
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );

		// Setup attachments array
		$attachments = get_children( array( 'post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
	} else {
		// Setup attachments array
		$attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby ) );
	}

	if ( empty( $attachments ) ) return '';

	// Filter gallery differently for feeds
	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment ) $output .= wp_get_attachment_link( $att_id, $size, true ) . "\n";
		return $output;
	}

	// Filter tags and attributes
	$itemtag = tag_escape( $itemtag );
	$captiontag = tag_escape( $captiontag );
	$columns = intval( $columns );
	$itemwidth = $columns > 0 ? floor( 100 / $columns ) : 100;
	$float = is_rtl() ? 'right' : 'left';
	$selector = "gallery-{$instance}";

	// Filter gallery CSS
	$output = apply_filters( 'gallery_style', "
		<style type='text/css'>
			#{$selector} {
				margin: auto;
			}
			#{$selector} .gallery-item {
				float: {$float};
				margin-top: 10px;
				text-align: center;
				width: {$itemwidth}%;
			}
			#{$selector} img {
				border: 2px solid #cfcfcf;
			}
			#{$selector} .gallery-caption {
				margin-left: 0;
			}
		</style>
		<!-- see gallery_shortcode() in wp-includes/media.php -->
		<div id='$selector' class='gallery galleryid-{$id}'>"
	);

	// Iterate through the attachments in this gallery instance
	$i = 0;
	foreach ( $attachments as $id => $attachment ) {

		// Attachment link
		$link = isset( $attr['link'] ) && 'file' == $attr['link'] ? wp_get_attachment_link( $id, $size, false, false ) : wp_get_attachment_link( $id, $size, true, false );

		// Start itemtag
		$output .= "<{$itemtag} class='gallery-item'>";

		// icontag
		$output .= "
		<{$icontag} class='gallery-icon'>
			$link
		</{$icontag}>";

		if ( $captiontag && trim( $attachment->post_excerpt ) ) {

			// captiontag
			$output .= "
			<{$captiontag} class='gallery-caption'>
				" . wptexturize($attachment->post_excerpt) . "
			</{$captiontag}>";

      // The TITLE, if we've not made the 'titletag' param blank
      if ( $titletag ){
          $output .= "
              <{$titletag} class=\"gallery-item-title\">" . $attachment->post_title . "</{$titletag}>";
      }

      // The DESCRIPTION, if we've not specified a blank 'descriptiontag'
      if ( $descriptiontag ){
          $output .= "
              <{$descriptiontag} class=\"gallery-item-description\">" . wptexturize( $attachment->post_content ) . "</{$descriptiontag}>";
      }

		}

		// End itemtag
		$output .= "</{$itemtag}>";

		// Line breaks by columns set
		if($columns > 0 && ++$i % $columns == 0) $output .= '<br style="clear: both">';

	}

	// End gallery output
	$output .= "
		<br style='clear: both;'>
	</div>\n";

	return $output;

}

// Apply filter to default gallery shortcode
add_filter( 'post_gallery', 'my_post_gallery', 10, 2 );

?>
