<?php get_header();
$service_data=array(
  'hero_image' => get_field('hero_image', get_the_ID()),
  'page_title' => get_field('page_title', get_the_ID()),
  'sub-title' => get_field('sub-title', get_the_ID()),
  'interiors_designers_architects' => get_field('interiors_designers_architects', get_the_ID()),
); ?>
<div class="nav-spacer"></div>
<h2 class="head2-1 text-left d-block d-lg-none text-center"><?php echo $service_data['page_title']; ?></h2>
<div class="header">
  <img src="<?php echo $service_data['hero_image']; ?>" class="img-fluid" />
</div>
<div class="brief">
  <div class="container">
    <div class="row row-1">
      <div class="col-12">
        <h2 class="head2-1 text-center d-none d-lg-block"><?php echo $service_data['page_title']; ?></h2>
        <div class="sub-title"><?php echo $service_data['sub-title']; ?></div>
      </div>
    </div>
  </div>
</div>
<div class="interior-designers-architects">
  <div class="container">
    <div class="row row-1">
      <div class="col-12">
        <h3><?php echo $service_data['interiors_designers_architects']['title']; ?></h2>
        <div class="summary"><?php echo $service_data['interiors_designers_architects']['summary']; ?></div>
      </div>
    </div>
  </div>
</div>
<div class="application-form">
  <div class="container">
    <div class="row row-1">
      <div class="col-12">
        <h3>Application Form</h2>
        <?php echo do_shortcode('[contact-form-7 id="283" title="Application Form"]'); ?>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
