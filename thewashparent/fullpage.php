<?php
/*

Template Name: Fullwidth Page

*/

get_header(); ?>
<div id="callout2">
<section class="container clearfix">

<?php if ( of_get_option( 'header_breadcrumb' ) ) {  if(function_exists('cloud_breadcrumbs')) cloud_breadcrumbs(); } ?> 
  
<?php
  // Start the Loop.
  while ( have_posts() ) : the_post();

    // Include the page content template.
    get_template_part( 'content/content', 'page' );

    endwhile;
?>

</section>
</div>
<?php get_footer(); ?>