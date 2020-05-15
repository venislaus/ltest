<?php
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Website Settings',
		'menu_title'	=> 'Website Settings',
		'menu_slug' 	=> 'website-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false,
    'position'    => 3
	));
}
function theme_enqueue_scripts() {
  wp_localize_script( 'report-a-bug', 'settings', array(
    'ajaxurl'    => admin_url( 'admin-ajax.php' ),
    'send_label' => __( 'Get Category Products', 'getcategoryproducts' )
  ) );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );

add_action('init', 'theme_init');
function theme_init(){
  if(is_taxonomy('product_category')){
    add_action( 'wp_ajax_nopriv_get_category_products', 'get_category_products' );
    add_action( 'wp_ajax_get_category_products', 'get_category_products' );
  }
  add_action( 'wp_ajax_nopriv_search_products', 'search_products' );
  add_action( 'wp_ajax_search_products', 'search_products' );
}
function get_category_products(){
  $data = $_POST['category'];
  print_r(($data));
  die();
}
function search_products(){
  $find = $_POST['find'];
  $data = array(
    'post_type' => 'products',
    's' => $find
  );
  $results = new WP_Query($data);
  $return = array();
  if($results->have_posts()): while($results->have_posts()): $results->the_post();
    $p_collection_id = get_collections_id();
    $terms = get_the_terms(get_the_ID(), 'product_category');
    $p_category = array();
    if(!empty($terms)) {
      foreach($terms as $term){
        if($term->parent == 0 && $term->term_id != $p_collection_id){
          $p_category = $term;
        }
      }
    }
    $return[] = array(
      'title' => get_the_title(),
      'link' => get_the_permalink(),
      'category' => $p_category->name
    );
  endwhile; endif;
  wp_reset_query();
  echo json_encode($return);
  die();
}
/*
function wpa_product_link( $post_link, $id = 0 ){
    $post = get_post($id);
    if ( is_object( $post ) ){
        $terms = wp_get_object_terms( $post->ID, 'product_category' );
        $path = array();
        if( $terms ){
          foreach($terms as $term){
            if($term->parent == 0){
              $path['parent'] = $term->slug;
            } else {
              $path['child'] = $term->slug;
            }
          }
          $path_str = '';
          if(isset($path['parent'])) $path_str .= $path['parent'].'/';
          if(isset($path['child'])) $path_str .= $path['child'];
        }
        $path_str = rtrim($path_str, '/');
        return str_replace( '%product_category%' , $path_str , $post_link );
    }
    return $post_link;
}
add_filter( 'post_type_link', 'wpa_product_link', 1, 3 );*/

// get categories of post in sorted order


function getBreadcrumb($categories) { // Sorting the category
    usort($categories, "cmpCategories");
    return $categories;
}

function cmpCategories($category_1,$category_2) { // Sort function
    foreach(get_categories(array("parent" => $category_1->cat_ID)) AS $sub) {
        if($category_2->cat_ID == $sub->cat_ID) return -1;
    }
    return 1;
}
/*
add_filter('wpcf7_form_elements', function( $content ) {
  $dom = new DOMDocument();
  $dom->preserveWhiteSpace = false;
  $dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

  $xpath = new DomXPath($dom);
  $spans = $xpath->query("//span[contains(@class, 'wpcf7-form-control-wrap')]" );

  foreach ( $spans as $span ) :
    $children = $span->firstChild;
    $span->parentNode->replaceChild( $children, $span );
  endforeach;

  return $dom->saveHTML();
});*/

function get_collections_id(){
  $field = 'name';
  $value = 'Collections';
  $taxonomy = 'product_category';
  $term = get_term_by( $field, $value, $taxonomy );
  return $term->term_id;
}
