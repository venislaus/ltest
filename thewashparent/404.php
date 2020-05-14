<?php get_header(); ?>
<div id="callout2">
<section class="container clearfix">

<?php  $layout = of_get_option( 'example_images' ) ?>

<?php if ( $layout == '2c-r-fixed' ) { ?>
<div class="row">
  <div class="col-md-8">
<?php } elseif ( $layout == '2c-l-fixed' ) { ?>

  <div class="row">
  <div class="col-md-8 col-md-push-4">
<?php } else { }?>

<?php if ( of_get_option( 'header_breadcrumb' ) ) {  if(function_exists('cloud_breadcrumbs')) cloud_breadcrumbs(); } ?> 

<h1><?php printf( __( 'Search Results for: %s', 'clouddev' ), '' . get_search_query() . '' , 'clouddev'  ); ?></h1>
<p>&nbsp;</p>

<?php
  // Start the Loop.
  while ( have_posts() ) : the_post();

    // Include the page content template.
    get_template_part( 'content/content', 'none' );

    endwhile;
?>
            
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