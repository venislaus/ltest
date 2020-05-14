<?php
if (function_exists('register_sidebar')) {
  register_sidebar(array(
    'name'=> 'Main Sidebar',
    'id' => 'sidebar',
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2>',
    'after_title' => '</h2>',
  ));
add_action('init', 'process_post');
function process_post(){

$widget_number = of_get_option( 'widget_number', 'no entry' );

if ($widget_number == one) {$i = 1;}
if ($widget_number == two) {$i = 2;}
if ($widget_number == three) {$i = 3;}
if ($widget_number == four) {$i = 4;}
if ($widget_number == five) {$i = 5;}
if ($i) {
	if($i>0){
  register_sidebar(array(
    'name'=> 'Footer Col 1',
    'id' => 'one',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ));
}
if($i>1){
  register_sidebar(array(
    'name'=> 'Footer Col 2',
    'id' => 'two',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h3>',
    'after_title' => '</h3>',

  ));
}
if($i>2){
  register_sidebar(array(
    'name'=> 'Footer Col 3',
    'id' => 'three',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ));
}
if($i>3){
  register_sidebar(array(
    'name'=> 'Footer Col 4',
    'id' => 'four',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ));
}
if($i>4){
  register_sidebar(array(
    'name'=> 'Footer Col 5',
    'id' => 'five',
    'before_widget' => '',
    'after_widget' => '',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
  ));
  }
 }
}
}// end init function
function register_my_menus() {
  register_nav_menus(
    array(
      'primary' => __( 'Header Menu', 'cloud' ),
      'secondary' => __( 'Secondary Header Menu', 'cloud' ),
      'footer_menu' => __( 'Footer Menu', 'cloud' )
    )
  );
}
add_action( 'init', 'register_my_menus' );

add_theme_support( 'post-thumbnails' ); 
add_editor_style();
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
remove_action('wp_head', 'start_post_rel_link', 10, 0 );
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

add_theme_support( 'woocommerce' );
add_filter('widget_text', 'do_shortcode');

require_once ( get_template_directory() . '/inc/shortcodes.php' );
require_once ( get_template_directory() . '/inc/wp_bootstrap_navwalker.php' );
require_once ( get_template_directory() . '/inc/custom_css.php' );
require_once ( get_template_directory() . '/inc/visualeditor.php' );
require_once ( get_template_directory() . '/inc/woocommerce.php' );
require_once ( get_template_directory() . '/inc/breadcrumb.php' );
require_once ( get_template_directory() . '/inc/template-tags.php' );
require_once ( get_template_directory() . '/inc/bars-new.php' );
require_once ( get_template_directory() . '/inc/meta.php' );

// add options framework to admin area and to site 
define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/' );
require_once dirname( __FILE__ ) . '/inc/options-framework.php';


function add_more_buttons($buttons) {
 $buttons[] = 'hr';
 $buttons[] = 'del';
 $buttons[] = 'fontselect';
 $buttons[] = 'fontsizeselect';
 $buttons[] = 'cleanup';
 return $buttons;
}
add_filter("mce_buttons_3", "add_more_buttons");

// Add default posts and comments RSS feed links to head
add_theme_support( 'automatic-feed-links' );

function my_login_logo() {

if ( of_get_option( 'reseller_branding_logo' ) ) {

$reseller_url = of_get_option( 'reseller_url' );

  echo '
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url('.$reseller_url.');
            padding-bottom: 0px;
            background-size: 320px 80px;
            width: 320px;
        }
    </style>
    ';

} else {

  $logo_url = get_stylesheet_directory_uri();

echo '
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url('.$logo_url.'/images/wplogo.png);
            padding-bottom: 0px;
            background-size: 320px 80px;
            width: 320px;
        }
    </style>
    ';
}

 }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function my_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {

  if ( of_get_option( 'reseller_name' ) ) { return of_get_option( 'reseller_name' ); } else { return 'cloud'; }

}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

// Excerpt Improvements
function cloud_trim_excerpt($text) {
  global $post;
  if ( '' == $text ) {
    $text = get_the_content('');
    $text = apply_filters('the_content', $text);
    $text = str_replace('\]\]\>', ']]&gt;', $text);
    $text = strip_tags($text, '<p> <br>');
    $excerpt_length = 25;
    $words = explode(' ', $text, $excerpt_length + 1);
    if (count($words)> $excerpt_length) {
      array_pop($words);
      array_push($words, '...<br/><a class="moretag" href="' .get_permalink(). '">more</a>');
      $text = implode(' ', $words);
    }
  }
return $text;
}

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'cloud_trim_excerpt');

function ShortenText($text) { // Function name ShortenText
  $chars_limit = 35; // Character length
  $chars_text = strlen($text);
  $text = $text." ";
  $text = substr($text,0,$chars_limit);
  $text = substr($text,0,strrpos($text,' '));
 
  if ($chars_text > $chars_limit)
     { $text = $text."..."; } // Ellipsis
     return $text;
}

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
function filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}
add_filter('the_content', 'filter_ptags_on_images');

// remove version info from head and feeds
function complete_version_removal() {
  return '';
}
add_filter('the_generator', 'complete_version_removal');

// spam & delete links for all versions of wordpress
function delete_comment_link($id) {
  if (current_user_can('edit_post')) {
    echo '| <a href="'.get_bloginfo('wpurl').'/wp-admin/comment.php?action=cdc&c='.$id.'">del</a> ';
    echo '| <a href="'.get_bloginfo('wpurl').'/wp-admin/comment.php?action=cdc&dt=spam&c='.$id.'">spam</a>';
  }
}

//Strips out trackbacks/pingbacks
function notb_strip_trackback( $var ) {
if ( $var->comment_type == 'trackback' || $var->comment_type == 'pingback' ) {
return false;
}
return true;
}

//Updates the comment number for posts with trackbacks
function notb_filter_post_comments( $posts ) {
foreach ($posts as $key => $p) {
if ($p->comment_count <= 0) {
return $posts;
}
$comments = get_approved_comments( (int)$p->ID );
$comments = array_filter( $comments, 'notb_strip_trackback' );
$posts[$key]->comment_count = sizeof($comments);
}
return $posts;
}

//Updates the count for comments and trackbacks
function notb_filter_trackbacks( $comms ) {
global $comments, $trackbacks;
$comments = array_filter( $comms, 'notb_strip_trackback' );
return $comments;
}

add_filter( 'comments_array', 'notb_filter_trackbacks', 0 );
add_filter( 'the_posts', 'notb_filter_post_comments', 0 );

// this is a helper to remove empty p tags caused by shortcodes
function remove_empty_p($content){
$content = force_balance_tags($content);
return preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content);
}
add_filter('the_content', 'remove_empty_p', 20, 1);

// this is a helper to not wrap shortcodes in p tags
function simonbattersby_shortcode_format($content){
$content = preg_replace('/(<p>)\s*(<div)/','<div',$content);
$content =  preg_replace('/(<\/div>)\s*(<\/p>)/', '</div>', $content);
return $content;
}
add_filter('the_content','simonbattersby_shortcode_format',11);

// Disable jump in 'read more' link
function remove_more_jump_link( $link ) {
  $offset = strpos($link, '#more-');
  if ( $offset ) {
    $end = strpos( $link, '"',$offset );
  }
  if ( $end ) {
    $link = substr_replace( $link, '', $offset, $end-$offset );
  }
  return $link;
}
add_filter( 'the_content_more_link', 'remove_more_jump_link' );


// add custom class to images 
function add_image_class($class){
  $class .= ' img-responsive';
  return $class;
}
add_filter('get_image_tag_class','add_image_class');

// Add new image sizes
function lc_insert_custom_image_sizes( $image_sizes ) {
// get the custom image sizes
global $_wp_additional_image_sizes;
// if there are none, just return the built-in sizes
if ( empty( $_wp_additional_image_sizes ) )
return $image_sizes;
 
// add all the custom sizes to the built-in sizes
foreach ( $_wp_additional_image_sizes as $id => $data ) {
// take the size ID (e.g., 'my-name'), replace hyphens with spaces,
// and capitalise the first letter of each word
if ( !isset($image_sizes[$id]) )
$image_sizes[$id] = ucfirst( str_replace( '-', ' ', $id ) );
}
 
return $image_sizes;
}
 
function lc_custom_image_setup () {
add_image_size('one-half', 547, 999, FALSE);
add_image_size('one-third', 350, 999, FALSE);
add_image_size('one-fourth', 251, 999, FALSE);
add_image_size('two-third', 745, 999, FALSE);
add_filter( 'image_size_names_choose', 'lc_insert_custom_image_sizes' );
}
add_action( 'after_setup_theme', 'lc_custom_image_setup' );

// Stop Compressing JPEG Files
// add_filter( 'jpeg_quality', create_function( '', 'return 100;' ) );

// Add Twitter Bootstrap's standard 'active' class name to the active nav link item
add_filter('nav_menu_css_class', 'add_active_class', 10, 2 );

function add_active_class($classes, $item) {
  if( $item->menu_item_parent == 0 && in_array('current-menu-item', $classes) ) {
    $classes[] = "active";
  }
  
  return $classes;
}

// Add lead class to first paragraph
function first_paragraph( $content ){
    global $post;

    // if we're on the homepage, don't add the lead class to the first paragraph of text
    if( is_page_template( 'home-fullpage.php' ) )
        return $content;
    else
        return preg_replace('/<p([^>]+)?>/', '<p$1 class="lead">', $content, 1);
}
// add_filter( 'the_content', 'first_paragraph' );

// Add thumbnail class to thumbnail links
function add_class_attachment_link( $html ) {
    $postid = get_the_ID();
    $html = str_replace( '<a','<a class="thumbnail"',$html );
    return $html;
}
add_filter( 'wp_get_attachment_link', 'add_class_attachment_link', 10, 1 );

if ( ! isset( $content_width ) )
    $content_width = 800;