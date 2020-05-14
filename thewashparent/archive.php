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


  <?php if (is_category()) { ?>
  <h1 class="archive_title"><span><?php _e( "Posts Categorized:", 'clouddev'  ); ?></span> <?php single_cat_title(); ?></h1>
  <?php } elseif (is_tag()) { ?> 
  <h1 class="archive_title"><span><?php _e( "Posts Tagged:", 'clouddev'  ); ?></span> <?php single_tag_title(); ?></h1>
  <?php } elseif (is_author()) { ?>
  <?php $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author)); ?>	
  <h1 class="archive_title"><span><?php _e( "Posts By:", 'clouddev'  ); ?></span> <?php echo $curauth->display_name; ?></h1>
  <?php } elseif (is_day()) { ?>
  <h1 class="archive_title"><span><?php _e( "Daily Archives:", 'clouddev'  ); ?></span> <?php the_time('l, F j, Y'); ?></h1>
  <?php } elseif (is_month()) { ?>
  <h1 class="archive_title"><span><?php _e( "Monthly Archives:", 'clouddev'  ); ?>:</span> <?php the_time('F Y'); ?></h1>
  <?php } elseif (is_year()) { ?>
  <h1 class="archive_title"><span><?php _e( "Yearly Archives:", 'clouddev'  ); ?>:</span> <?php the_time('Y'); ?></h1>
  <?php } ?>  

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



</div> <!-- end row -->
</section>
</div>
<?php get_footer(); ?>