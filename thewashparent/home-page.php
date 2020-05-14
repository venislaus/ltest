<?php 
/*
Template Name: Home Page
*/
get_header(); ?>

<div id="callout">
<section class="container clearfix">

    <?php if (of_get_option( 'cycle_fx', 'no entry' ) == 'none' ) { ?>

    <div class="slide1"> 
        <?php if ( of_get_option( 'slider_1_image' ) ) { ?><style>.slide1 {background-image: url(<?php echo of_get_option( 'slider_1_image' ) ?>);}</style><?php } ?>
        <?php if (of_get_option( 'slider_1_link' ) ) { ?><a href="<?php echo of_get_option( 'slider_1_link' ) ?>"><?php } ?>
        <?php if ( of_get_option( 'slider_1_content' ) ) { ?><div class="slider_content container"><?php echo apply_filters('the_content', of_get_option( 'slider_1_content', 'no entry')); ?></div><?php } ?>
        <?php if (of_get_option( 'slider_1_link' ) ) { ?></a><?php } ?>
    </div>

    <?php } //else { get_template_part('callout'); } ?>

</section>
</div>

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

<?php 
$showbars = get_post_meta($post->ID, '_cmb_show_bars_checkbox', true );

if ($showbars == "" ){} else {
 get_template_part( 'inc/bars' ); 
} ?>


<?php get_footer(); ?>