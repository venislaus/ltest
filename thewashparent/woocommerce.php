<?php get_header(); ?>
<div id="callout2">
<section class="container clearfix">

<?php  $layout = of_get_option( 'example_images_woo' ) ?>

<?php if ( $layout == '2c-r-fixed' ) { ?>
<div class="row">
  <div class="col-md-8">
<?php } elseif ( $layout == '2c-l-fixed' ) { ?>

  <div class="row">
  <div class="col-md-8 col-md-push-4">
<?php } else { }?>

<?php if ( of_get_option( 'header_breadcrumb' ) ) {  if(function_exists('cloud_breadcrumbs')) cloud_breadcrumbs(); } ?> 

<article class="woo_cart_page">

<?php 

	if (is_product_category()){
	    global $wp_query;
	    // get the query object
	    $cat = $wp_query->get_queried_object();
	    // get the thumbnail id user the term_id
	    $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true ); 
	    // get the image URL
	    $image = wp_get_attachment_url( $thumbnail_id ); 
	    // print the IMG HTML
	    echo '<img src="'.$image.'" />';
	}

woocommerce_content(); ?>

</article>

<?php if ( $layout == '2c-r-fixed' ) { ?>
</div><!-- end col-8 -->
  <aside class="col-md-4">
  <section class="sidebar clearfix">
    <?php get_sidebar(); ?>
  </section>
  </aside>
</div><!-- end row -->
<?php } elseif ( $layout == '2c-l-fixed' ) { ?>
</div><!-- end col-8 -->
  <aside class="col-md-4 col-md-pull-8">
  <section class="sidebar clearfix">
    <?php get_sidebar(); ?>
  </section>
  </aside>
</div><!-- end row -->
<?php } else { }?>

</section>
</div>
<?php get_footer(); ?>