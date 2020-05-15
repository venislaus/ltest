<?php get_header();
$about_data=array(
  'hero_image' => get_field('hero_image', get_the_ID()),
  'our_story' => get_field('our_story', get_the_ID()),
  'our_team' => get_field('our_team', get_the_ID()),
  'our_process' => get_field('our_process', get_the_ID()),
  'our_factory' => get_field('our_factory', get_the_ID()),
  'materials_we_use' => get_field('materials_we_use', get_the_ID()),
); ?>
<div class="nav-spacer"></div>
<h2 class="head2-1 text-left d-block d-lg-none text-center">Our Story</h2>
<div class="header">
  <img src="<?php echo $about_data['hero_image']['url']; ?>" class="img-fluid" />
</div>
<div class="brief">
  <div class="container">
    <div class="row row-1">
      <div class="col-12 col-lg-6 offset-lg-6">
        <h2 class="head2-1 text-left d-none d-lg-block">Our Story</h2>
        <div class="summary"><?php echo $about_data['our_story']['summary_1']; ?></div>
      </div>
    </div>
    <div class="row row-2">
      <div class="col-12 col-lg-9 offset-lg-3">
        <img src="<?php echo $about_data['our_story']['image_1']; ?>" class="img-fluid" />
      </div>
    </div>
    <div class="row row-3">
      <div class="col-12 col-lg-6 offset-lg-1">
        <div class="summary">
          <?php echo $about_data['our_story']['summary_2']; ?>
        </div>
      </div>
    </div>
    <div class="row row-4">
      <div class="col-12 col-lg-6">
        <img src="<?php echo $about_data['our_story']['image_2']; ?>" class="img-fluid" />
      </div>
      <div class="col-12 col-lg-6">
        <img src="<?php echo $about_data['our_story']['image_3']; ?>" class="img-fluid" />
      </div>
    </div>
  </div>
</div>
<div class="our-team">
  <div class="container">
    <div class="row row-1">
      <div class="col-12 col-lg-4">
        <div class="content-temp-1">
          <h3>Our Team</h3>
          <div class="summary"><?php echo $about_data['our_team']['summary_1']; ?></div>
        </div>
      </div>
      <div class="col-12 col-lg-8">
        <img src="<?php echo $about_data['our_team']['image_1']; ?>" class="img-fluid" />
      </div>
    </div>
    <div class="row row-2">
      <div class="col-12 col-lg-7 offset-lg-5">
        <div class="summary"><?php echo $about_data['our_team']['summary_2']; ?></div>
        <a href="<?php echo home_url(); ?>/contact-us" class="btn btn-black-border">Book a Consultation</a>
      </div>
    </div>
    <div class="row row-3">
      <div class="col-12 col-lg-5">
        <img src="<?php echo $about_data['our_team']['image_2']; ?>" class="img-fluid" />
      </div>
      <div class="col-12 col-lg-7">
        <img src="<?php echo $about_data['our_team']['image_3']; ?>" class="img-fluid" />
      </div>
    </div>
  </div>
</div>
<div class="our-process">
  <div class="container">
    <div class="row row-1">
      <div class="col-12 col-lg-6 offset-lg-6">
        <div class="content-temp-1">
          <h3>Our Process</h3>
          <div class="summary">
            <?php echo $about_data['our_process']['summary']; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="row row-2">
      <div class="col-12">
        <img src="<?php echo $about_data['our_process']['image']; ?>" class="img-fluid" />
      </div>
    </div>
  </div>
</div>
<div class="our-factory">
  <div class="container">
    <div class="row row-1">
      <div class="col-12 col-lg-9">
        <div class="content-temp-1">
          <h3>Our Factory</h3>
          <div class="summary col-part-2">
            <?php echo $about_data['our_factory']['summary']; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container-full">
    <div class="row row-2">
      <img src="<?php echo $about_data['our_factory']['image']; ?>" class="img-fluid" />
    </div>
  </div>
  <div class="container">
    <div class="row row-3">
      <div class="col-12 col-lg-6">
        <img src="<?php echo $about_data['materials_we_use']['image_1']; ?>" class="img-fluid" />
      </div>
      <div class="col-12 col-lg-6">
        <img src="<?php echo $about_data['materials_we_use']['image_2']; ?>" class="img-fluid" />
      </div>
    </div>
  </div>
</div>
<div class="materials-we-use">
  <div class="container">
    <div class="row row-1">
      <div class="col-12 col-lg-6 offset-lg-6">
        <div class="content-temp-1">
          <h3>Materials We Use</h3>
          <div class="summary">
            <?php echo $about_data['materials_we_use']['summary_1']; ?>
          </div>
          <div class="read-more">
            <a href="<?php echo home_url(); ?>/materials">More on our materials</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
