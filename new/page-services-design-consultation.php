<?php get_header();
$service_data=array(
  'hero_image' => get_field('hero_image', get_the_ID()),
  'page_title' => get_field('page_title', get_the_ID()),
  'summary_1' => get_field('summary_1', get_the_ID()),
  'image_1' => get_field('image_1', get_the_ID()),
  'image_2' => get_field('image_2', get_the_ID()),
  'summary_2' => get_field('summary_2', get_the_ID()),
  'summary_3' => get_field('summary_3', get_the_ID()),
  'full_width_image' => get_field('full_width_image', get_the_ID()),
  'image_3' => get_field('image_3', get_the_ID()),
  'image_4' => get_field('image_4', get_the_ID()),
  'future_rental_services' => get_field('future_rental_services', get_the_ID())
); ?>
<div class="nav-spacer"></div>
<h2 class="head2-1 text-left d-block d-lg-none text-center"><?php echo $service_data['page_title']; ?></h2>
<div class="header">
  <img src="<?php echo $service_data['hero_image']; ?>" class="img-fluid" />
</div>
<div class="brief">
  <div class="container">
    <div class="row row-1">
      <div class="col-12 col-lg-6 offset-lg-6">
        <h2 class="head2-1 text-left d-none d-lg-block"><?php echo $service_data['page_title']; ?></h2>
        <div class="summary"><?php echo $service_data['summary_1']; ?></div>
        <a href="<?php echo home_url(); ?>/contact-us" class="btn btn-black-border">Book a Consultation</a>
      </div>
    </div>
    <div class="row row-2">
      <div class="col-12 col-lg-6">
        <img src="<?php echo $service_data['image_1']; ?>" class="img-fluid" />
      </div>
      <div class="col-12 col-lg-6">
        <img src="<?php echo $service_data['image_2']; ?>" class="img-fluid" />
      </div>
    </div>
    <div class="row row-3">
      <div class="col-12 col-lg-4">
        <div class="summary">
          <?php echo $service_data['summary_2']; ?>
        </div>
      </div>
      <div class="col-12 col-lg-4">
        <div class="summary">
          <?php echo $service_data['summary_3']; ?>
        </div>
      </div>
    </div>
  </div>
  <div class="container-full">
    <div class="row row-4">
      <div class="col-12">
        <img src="<?php echo $service_data['full_width_image']; ?>" class="img-fluid" />
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row row-5">
      <div class="col-9 col-lg-6">
        <img src="<?php echo $service_data['image_3']; ?>" class="img-fluid" />
      </div>
      <div class="col-9 offset-3 offset-lg-0 col-lg-6">
        <img src="<?php echo $service_data['image_4']; ?>" class="img-fluid" />
      </div>
    </div>
  </div>
</div>
<div class="future-rental-services">
  <div class="container">
    <div class="row row-1">
      <div class="col-12 col-lg-5 offset-lg-7">
        <div class="content-temp-1">
          <h3><?php echo $service_data['future_rental_services']['title']; ?></h3>
          <div class="summary"><?php echo $service_data['future_rental_services']['summary']; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
