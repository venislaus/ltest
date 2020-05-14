<?php 
/*
Template Name: With Sidebar
*/
get_header(); ?>

<div id="callout2">
<section class="container clearfix">

<?php  $layout = of_get_option( 'example_images' ) ?>


<div class="row">
  <div class="col-md-8">


<?php if ( of_get_option( 'header_breadcrumb' ) ) {  if(function_exists('cloud_breadcrumbs')) cloud_breadcrumbs(); } ?> 
  
<?php
  // Start the Loop.
  while ( have_posts() ) : the_post();

    // Include the page content template.
    get_template_part( 'content/content', 'page' );

    endwhile;
?>


</div><!-- end col-8 -->
  <aside class="col-md-4">
  <section class="sidebar clearfix">
    <?php get_sidebar(); ?>
  </section>
  </aside>
</div><!-- end row -->


</section>
</div>
<?php get_footer(); ?>