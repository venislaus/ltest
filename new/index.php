<?php get_header();
$home_data = array(
  'hero_image' => get_field('hero_image', get_the_ID()),
  'main_heading' => get_field('main_heading', get_the_ID()),
  'sub_heading' => get_field('sub_heading', get_the_ID()),
  'our_collections_section' => get_field('our_collections_section', get_the_ID()),
  'craftsmanship_section' => get_field('craftsmanship_section', get_the_ID()),
  'featured_ranges' => get_field('featured_ranges', get_the_ID()),
  'our_premium_services' => get_field('our_premium_services', get_the_ID()),
  'why_choose_osierbelle' => get_field('why_choose_osierbelle', get_the_ID()),
  'customer_testimonials' => get_field('customer_testimonials', get_the_ID()),
); ?>
  <header class="home-header" style="background-image:url('<?php echo $home_data['hero_image']['url']; ?>');">
    <div class="caption text-center px-4">
      <h1><?php echo $home_data['main_heading']; ?></h1>
      <div class="sub-heading"><?php echo $home_data['sub_heading']; ?></div>
    </div>
  </header>
  <div class="home-our-collections">
    <div class="container">
      <div class="row">
        <div class="col-12 col-lg-4 order-3 order-lg-1">
          <div class="content-temp-1">
            <h3><?php echo $home_data['our_collections_section']['label']; ?></h3>
            <div class="summary">
              <?php echo $home_data['our_collections_section']['summary']; ?>
            </div>
            <div class="read-more">
              <a href="<?php echo home_url(); ?>/collections"><?php echo $home_data['our_collections_section']['link_label']; ?></a>
            </div>
          </div>
        </div>
        <div class="col-6 col-lg-3 offset-lg-1 left-images order-1 order-lg-2">
          <img src="<?php echo $home_data['our_collections_section']['image_1']['url']; ?>" class="img-fluid" />
        </div>
        <div class="col-6 col-lg-3 right-images order-2 order-lg-3">
          <img src="<?php echo $home_data['our_collections_section']['image_2']['url']; ?>" class="img-fluid" />
          <img src="<?php echo $home_data['our_collections_section']['image_3']['url']; ?>" class="img-fluid" />
        </div>
      </div>
  </div>
</div>
<div class="weather-resistant" style="background-image:url('<?php echo $home_data['craftsmanship_section']['background_image_desktop']['url']; ?>');">
  <div class="container-full">
    <div class="row">
      <div class="col-6 col order-2 order-lg-1">
        <div class="head text-lg-left">
          <?php echo $home_data['craftsmanship_section']['left_text']; ?>
        </div>
        <img src="<?php echo $home_data['craftsmanship_section']['left_image_mobile']['url']; ?>" class="img-fluid d-block d-lg-none" />
      </div>
      <div class="col-6 col order-1 order-lg-2">
        <img src="<?php echo $home_data['craftsmanship_section']['right_image_mobile']['url']; ?>" class="img-fluid d-block d-lg-none" />
        <div class="head text-md-right">
          <?php echo $home_data['craftsmanship_section']['right_text']; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="ranges">
  <div class="container container-full">
    <div class="ranges-slider">
      <div class="item">
        <a href="#" class="thumb">
          <img src="<?php echo get_template_directory_uri(); ?>/img/lounges-and-seating.jpg" class="img-fluid" />
        </a>
        <div class="title">Sofas and Lounges</div>
        <div class="read-more"><a href="#">Browse Range</a></div>
      </div>
      <div class="item">
        <a href="#" class="thumb">
          <img src="<?php echo get_template_directory_uri(); ?>/img/dining.jpg" class="img-fluid" />
        </a>
        <div class="title">Dining</div>
        <div class="read-more"><a href="#">Browse Range</a></div>
      </div>
      <div class="item">
        <a href="#" class="thumb">
          <img src="<?php echo get_template_directory_uri(); ?>/img/accessories.jpg" class="img-fluid" />
        </a>
        <div class="title">Accessories</div>
        <div class="read-more"><a href="#">Browse Range</a></div>
      </div>
    </div>
    <div class="row book-consultation-btn">
      <div class="col-12 text-center">
        <a href="<?php echo home_url(); ?>/contact-us" class="btn btn-black-border">Book a Consultation</a>
      </div>
    </div>
  </div>
</div>
<div class="our-premium-services">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h2 class="head2-1">Our Premium Services</h2>
      </div>
    </div>
    <div class="row ops-content">
      <div class="col-12 col-md-6 col">
        <div class="item">
          <div class="image">
            <img src="<?php echo $home_data['our_premium_services'][0]['image']['url']; ?>" class="img-fluid" />
          </div>
          <div class="content-temp-1">
            <h3><?php echo $home_data['our_premium_services'][0]['title']; ?></h3>
            <div class="summary">
              <?php echo $home_data['our_premium_services'][0]['summary']; ?>
            </div>
            <div class="read-more"><a href="<?php echo $home_data['our_premium_services'][0]['read_more_link']; ?>">Read more</a></div>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-6 col">
        <div class="item">
          <div class="image">
            <img src="<?php echo $home_data['our_premium_services'][1]['image']['url']; ?>" class="img-fluid" />
          </div>
          <div class="content-temp-1">
            <h3><?php echo $home_data['our_premium_services'][1]['title']; ?></h3>
            <div class="summary">
              <?php echo $home_data['our_premium_services'][1]['summary']; ?>
            </div>
            <div class="read-more"><a href="<?php echo $home_data['our_premium_services'][1]['read_more_link']; ?>">Read more</a></div>
          </div>
        </div>
        <div class="item">
          <div class="image">
            <img src="<?php echo $home_data['our_premium_services'][2]['image']['url']; ?>" class="img-fluid" />
          </div>
          <div class="content-temp-1">
            <h3><?php echo $home_data['our_premium_services'][2]['title']; ?></h3>
            <div class="summary">
              <?php echo $home_data['our_premium_services'][2]['summary']; ?>
            </div>
            <div class="read-more"><a href="<?php echo $home_data['our_premium_services'][2]['read_more_link']; ?>">Read more</a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="why-choose-osierbelle">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h2 class="head2-1 text-left text-md-center">Why Choose Osier Belle?</h2>
      </div>
    </div>
    <div class="row content">
      <div class="col-12">
        <nav>
					<div class="nav nav-tabs" id="nav-tab" role="tablist">
						<a class="nav-link active" id="nav-about-us-tab" data-toggle="tab" href="#nav-about-us" role="tab" aria-controls="nav-about-us" aria-selected="true">About Us</a>
						<a class="nav-link" id="nav-our-process-tab" data-toggle="tab" href="#nav-our-process" role="tab" aria-controls="nav-our-process" aria-selected="false">Our Process</a>
						<a class="nav-link" id="nav-our-material-tab" data-toggle="tab" href="#nav-our-material" role="tab" aria-controls="nav-our-material" aria-selected="false">Our Material</a>
					</div>
				</nav>
				<div class="tab-content" id="nav-tabContent">
					<div class="tab-pane fade show active" id="nav-about-us" role="tabpanel" aria-labelledby="nav-about-us-tab">
            <div class="row">
              <div class="col-12 col-md-5">
                <img src="<?php echo $home_data['why_choose_osierbelle']['about_us']['image']; ?>" class="img-fluid" />
              </div>
              <div class="col-12 col-md-5 offset-md-1">
                <h3>About Us</h3>
                <div class="summary">
                  <?php echo $home_data['why_choose_osierbelle']['about_us']['summary']; ?>
                </div>
                <div class="read-more"><a href="<?php echo $home_data['why_choose_osierbelle']['about_us']['read_more_link']; ?>">Read more</a></div>
              </div>
            </div>
					</div>
					<div class="tab-pane fade" id="nav-our-process" role="tabpanel" aria-labelledby="nav-our-process-tab">
            <div class="row">
              <div class="col-12 col-md-5">
                <img src="<?php echo $home_data['why_choose_osierbelle']['our_process']['image']; ?>" class="img-fluid" />
              </div>
              <div class="col-12 col-md-5 offset-md-1">
                <h3>Our Process</h3>
                <div class="summary">
                  <?php echo $home_data['why_choose_osierbelle']['our_process']['summary']; ?>
                </div>
                <div class="read-more"><a href="<?php echo $home_data['why_choose_osierbelle']['our_process']['read_more_link']; ?>">Read more</a></div>
              </div>
            </div>
					</div>
					<div class="tab-pane fade" id="nav-our-material" role="tabpanel" aria-labelledby="nav-our-material-tab">
            <div class="row">
              <div class="col-12 col-md-5">
                <img src="<?php echo $home_data['why_choose_osierbelle']['our_material']['image']; ?>" class="img-fluid" />
              </div>
              <div class="col-12 col-md-5 offset-md-1">
                <h3>Our Material</h3>
                <div class="summary">
                  <?php echo $home_data['why_choose_osierbelle']['our_material']['summary']; ?>
                </div>
                <div class="read-more"><a href="<?php echo $home_data['why_choose_osierbelle']['our_material']['read_more_link']; ?>">Read more</a></div>
              </div>
            </div>
					</div>
				</div>
			</div>
    </div>
  </div>
</div>
<div class="client-testimonials">
  <div class="container">
    <div class="row">
      <div class="col-12 col-lg-6">
        <img src="<?php echo $home_data['customer_testimonials']['image']['url']; ?>" class="img-fluid client-testimonials-image" />
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-lg-6 offset-lg-6">
        <h3>Customer Testimonials</h3>
        <div id="testimonialsIndicators" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <?php if(!empty($home_data['customer_testimonials']['testimonial'])) {
              $i=0;
              $count=count($home_data['customer_testimonials']['testimonial']);
              foreach($home_data['customer_testimonials']['testimonial'] as $t){ $i++; ?>
                <div class="carousel-item quote <?php if($i == 1) { echo 'active'; } ?>">
                  <?php echo $t['quote']; ?>
                </div>
              <?php }
            } ?>
          </div>
          <ol class="carousel-indicators">
            <?php for($i=0;$i<$count;$i++) { ?>
              <li data-target="#testimonialsIndicators" data-slide-to="0" class="<?php if($i==0) echo 'active'; ?>"></li>
            <?php } ?>
            <a href="#testimonialsIndicators" role="button" data-slide="next">
              <img src="<?php echo get_template_directory_uri(); ?>/img/arrow.png" class="img-fluid" />
            </a>
          </ol>
        </div>

      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
