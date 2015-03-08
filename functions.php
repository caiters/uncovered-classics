<?php
ini_set('display_errors',1);
error_reporting(E_ALL);


add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}

/*-----------------------------------------------------------------------------------*/
/* Grab the Zuki Custom widgets.
/*-----------------------------------------------------------------------------------*/
require( '/home/ayashi/web/clients/uncovered-classics/wp-content/themes/zuki-child/inc/widgets.php' );

add_image_size( 'uc-homepage', 380, 540, true ); // Homepage thumbnails (cropped)
add_image_size( 'uc-highlights', 151, 214, true ); // Highlights thumbnails (cropped)

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


?>
