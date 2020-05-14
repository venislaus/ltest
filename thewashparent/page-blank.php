<?php
/*
Template Name: LP Template
*/
 get_header('blank'); ?>
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

  
<?php
  // Start the Loop.
  while ( have_posts() ) : the_post();

    // Include the page content template.
    get_template_part( 'content/content', 'page' );

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
<?php get_footer('blank'); ?>