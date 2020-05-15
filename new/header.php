<?php $body_class = "";
if(is_page()) {
  $page_name = get_post_field( 'post_name', get_the_ID() );
  $body_class .= "page-".$page_name." ";
}
$header_data = array(
  'logo' => get_field('header_logo', 'options'),
  'white_logo' => get_field('header_white_logo', 'options'),
);
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/vendor/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/vendor/slick/slick-theme.css"/>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/style.min.css?v=<?php echo rand(); ?>" />
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
  </head>
  <body <?php echo body_class( $body_class ); ?>>
    <div class="overlay"></div>
    <div class="nav-bar">
      <div class="toggle-nav">
        <a href="Javascript:void(0);" class="toggle-navigation">
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
        </a>
      </div>
      <div class="search-box">
        <div class="search-form-container container">
          <img src="<?php echo get_template_directory_uri(); ?>/img/search-icon-white.png" />
          <input type="text" class="search-field form-control" id="findProduct" placeholder="Type here..." />
          <a href="JavaScript:void(0);" class="toggle-top-search">Close</a>
        </div>
        <div class="search-result">
          <div class="container" id="resultDisplay">
          </div>
        </div>
      </div>
      <a href="<?php echo home_url(); ?>" class="top-logo"><img src="<?php echo $header_data['logo']; ?>" class="img-fluid" /></a>
      <div class="navigation">
        <a href="Javascript:void(0);" class="close-mob-nav toggle-navigation"><i class="fa fa-times"></i></a>
        <div class="mob-nav-logo mb-5"><img src="<?php echo $header_data['white_logo']; ?>" class="img-fluid" /></div>
        <ul class="nav">
          <li><a href="#">Home</a></li>
          <li class="expandable"><a href="#">Collections</a>
            <ul class="sub-menu">
              <?php $params = array(
                'post_type' => 'collection'
              );
              $collections_arr = new WP_Query($params);
              if($collections_arr->have_posts()) {
                while($collections_arr->have_posts()){
                  $collections_arr->the_post();
                  echo '<li><a href="'.get_the_permalink().'">'.get_the_title().'</a></li>';
                }
              }
              wp_reset_query(); ?>
            </ul>
          </li>
          <li class="expandable"><a href="#">Products</a>
            <ul class="sub-menu">
              <?php $terms = get_terms( array(
                  'taxonomy' => 'product_category',
                  'hide_empty' => false,
                  'parent' => 0
              ) );
              if(!empty($terms)) {
                foreach($terms as $term){
                  echo '<li><a href="'.get_term_link($term->term_id).'">'.$term->name.'</a></li>';
                }
              } ?>
            </ul>
          </li>
          <li class="expandable"><a href="#">Services</a>
            <ul class="sub-menu">
              <li><a href="<?php echo home_url(); ?>/services-design-consultation">Design Consultation</a></li>
              <li><a href="<?php echo home_url(); ?>/services-trade">Trade</a></li>
            </ul>
          </li>
          <li><a href="#">Materials</a></li>
          <li><a href="<?php echo home_url(); ?>/about-us">About Us</a></li>
          <li><a href="<?php echo home_url(); ?>/contact-us">Contact Us</a></li>
          <li class="search-icon"><a href="JavaScript:void(0);" class="toggle-top-search"><img src="<?php echo get_template_directory_uri(); ?>/img/search-icon.png" /></a></li>
          <li class="mob-search-icon">
            <div class="mob-search-field">
              <img src="<?php echo get_template_directory_uri(); ?>/img/search-icon-white.png" />
              <input type="text" class="search-field form-control" id="mobFindProduct" placeholder="Type here..." />
              <a href="JavaScript:void(0);" class="close-mob-search"><i class="fa fa-times"></i></a>
            </div>
            <div class="mob-search-result" id="mobResultDisplay">
            </div>
          </li>
        </ul>
      </div>
    </div>
