<?php get_header(); ?>
<div id="callout2">
<section class="container clearfix">

<?php  $layout = of_get_option( 'example_images_blog' ); ?>



<?php if ( $layout == '2c-r-fixed' ) { ?>
<div class="row">
  <div class="col-md-8">
<?php } elseif ( $layout == '2c-l-fixed' ) { ?>

  <div class="row">
  <div class="col-md-8 col-md-push-4">
<?php } else { }?>

<?php if ( of_get_option( 'header_breadcrumb' ) ) {  if(function_exists('cloud_breadcrumbs')) cloud_breadcrumbs(); } ?> 

<?php
	if ( have_posts() ) :
		// Start the Loop.
		while ( have_posts() ) : the_post();

			/*
			 * Include the post format-specific template for the content. If you want to
			 * use this in a child theme, then include a file called called content-___.php
			 * (where ___ is the post format) and that will be used instead.
			 */
			get_template_part( 'content/content', get_post_format() );

		endwhile;
		// Previous/next post navigation.
		twentyfourteen_paging_nav();

	else :
		// If no content, include the "No posts found" template.
		get_template_part( 'content', 'none' );

	endif;
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