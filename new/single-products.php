<?php get_header();
the_post();
$p_collection_id = get_collections_id();
$terms = get_the_terms(get_the_ID(), 'product_category');
$collection = '';
if(!empty($terms)) {
  foreach($terms as $term){
    if($term->parent == $p_collection_id){
      $collection = $term;
    }
  }
}
$product_data = array(
  'title' => get_the_title(),
  'hero_image' => get_field('hero_image', get_the_ID()),
  'summary' => get_field('summary', get_the_ID()),
  'price_starting' => get_field('price_starting', get_the_ID()),
  'desc_data_type' => get_field('desc_data_type', get_the_ID()),
  'description_row_1' => get_field('description_row_1', get_the_ID()),
  'quote' => get_field('quote', $collection),
  'full_width_image' => get_field('desc_full_width_image', get_the_ID()),
  'description_row_2' => get_field('description_row_2', get_the_ID()),
  'vertical_descriptor' => get_field('vertical_descriptor', $collection),
  'tech_icons' => get_field('tech_icons', get_the_ID()),
  'technical_drawings' => get_field('technical_drawings', get_the_ID()),
  'technical_information' => get_field('technical_information', get_the_ID()),
  'mat_summary' => get_field('mat_summary', get_the_ID()),
  'mat_options' => get_field('material_options', get_the_ID()),
); ?>
<div class="nav-spacer"></div>
<div class="product-header">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <?php $categories = getBreadcrumb($terms); ?>
        <div class="ob-breadcrumb d-block d-lg-none">
          Home / <?php
          if(!empty($categories)){
            foreach($categories AS $category) {
              if($category->term_id != $p_collection_id && $category->parent != $p_collection_id){
                echo $category->name.' / '; // category name
              }
            }
          } ?> Bulle Sofa
        </div>
      </div>
      <div class="col-12 col-lg-8">
        <img src="<?php echo $product_data['hero_image']['url']; ?>" class="img-fluid w-100" />
      </div>
      <div class="col-12 col-lg-4">
        <div class="ob-breadcrumb d-none d-lg-block">
          Home / <?php
          if(!empty($categories)){
            foreach($categories AS $category) {
              if($category->term_id != $p_collection_id && $category->parent != $p_collection_id){
                echo $category->name.' / '; // category name
              }
            }
          } ?> Bulle Sofa
        </div>
        <h1><?php echo $product_data['title']; ?></h1>
        <div class="summary">
          <?php echo $product_data['summary']; ?>
        </div>
        <div class="pricing">
          Price starting from: <span><?php echo $product_data['price_starting']; ?></span>
        </div>
        <div class="enquiry-btn">
          <a href="<?php echo home_url(); ?>/contact-us" class="btn btn-black-border">Enquire Now</a>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="product-tabs">
  <div class="container">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">Description</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="technical-information-tab" data-toggle="tab" href="#technical-information" role="tab" aria-controls="technical-information" aria-selected="false">Technical Information</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="materials-tab" data-toggle="tab" href="#materials" role="tab" aria-controls="materials" aria-selected="false">Materials</a>
      </li>
    </ul>
  </div>
  <div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
      <div class="tab-description">
        <div class="container">
          <div class="row row-1">
            <div class="col-12 col-lg-6">
              <img src="<?php echo $product_data['description_row_1']['image_1']['url']; ?>" class="img-fluid" />
            </div>
            <div class="col-12 col-lg-6">
              <img src="<?php echo $product_data['description_row_1']['image_2']['url']; ?>" class="img-fluid" />
              <div class="info">
                <?php echo $product_data['quote']; ?>
              </div>
            </div>
          </div>
        </div>
        <?php if( $product_data['desc_data_type'] == '5-image'){ ?>
          <div class="container-full">
            <div class="row row-2">
              <img src="<?php echo $product_data['full_width_image']['url']; ?>" class="img-fluid w-100" />
            </div>
          </div>
          <div class="container">
            <div class="row row-3 d-flex align-items-center">
              <div class="col-12 col-lg-5 order-1">
                <img src="<?php echo $product_data['description_row_2']['desc_image_4']['url']; ?>" class="img-fluid" />
              </div>
              <div class="col-3 col-lg-1 order-3 order-lg-2">
                <div class="title">
                  <?php echo $product_data['vertical_descriptor']; ?>
                </div>
              </div>
              <div class="col-9 col-lg-6 order-2 order-lg-3">
                <img src="<?php echo $product_data['description_row_2']['desc_image_5']['url']; ?>" class="img-fluid" />
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
    <div class="tab-pane fade" id="technical-information" role="tabpanel" aria-labelledby="technical-information-tab">
      <div class="tab-technical-information">
        <div class="row-1">
          <div class="container icons-list">
            <?php if(!empty($product_data['tech_icons'])) {
              foreach($product_data['tech_icons'] as $icon){ ?>
                <div class="item">
                  <div class="icon"><img src="<?php echo get_template_directory_uri(); ?>/img/icons/<?php echo $icon['value']; ?>.png" class="img-fluid" /></div>
                  <div class="label"><?php echo $icon['label']; ?></div>
                </div>
              <?php }
            } ?>
          </div>
        </div>
        <div class="container row-2">
          <div class="row">
            <div class="col-lg-5 tech-drawings">
              <div class="technical-drawings">
                <?php if(!empty($product_data['technical_drawings'])){
                  foreach($product_data['technical_drawings'] as $drawing){ ?>
                    <div class="image-item">
                      <img src="<?php echo $drawing['image_desktop']['url']; ?>" class="img-fluid d-none d-lg-block" />
                      <img src="<?php echo $drawing['image_mobile']['url']; ?>" class="img-fluid d-block d-lg-none" />
                      <div class="image-label"><?php echo $drawing['label']; ?></div>
                    </div>
                  <?php }
                } ?>
              </div>
            </div>
            <div class="col-lg-7">
              <div class="row">
                <?php if(!empty($product_data['technical_information'])){
                  $count = count($product_data['technical_information']);
                  $mid = floor($count/2); ?>
                  <div class="col-md-6">
                    <?php for($i=0; $i<$mid; $i++) {
                      $info = $product_data['technical_information'][$i]; ?>
                      <div class="item">
                        <?php if(!empty($info['title'])) { ?>
                          <div class="label"><?php echo $info['title']; ?>:</div>
                        <?php } ?>
                        <div class="summary"><?php echo $info['summary']; ?></div>
                      </div>
                    <?php } ?>
                  </div>
                  <div class="col-md-6">
                    <?php for($i=$mid; $i<$count; $i++) {
                      $info = $product_data['technical_information'][$i]; ?>
                      <div class="item">
                        <?php if(!empty($info['title'])) { ?>
                          <div class="label"><?php echo $info['title']; ?>:</div>
                        <?php } ?>
                        <div class="summary"><?php echo $info['summary']; ?></div>
                      </div>
                    <?php } ?>
                  </div>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="tab-pane fade" id="materials" role="tabpanel" aria-labelledby="materials-tab">
      <div class="tab-materials">
        <div class="container">
          <div class="row row-1">
            <div class="col-lg-9">
              <?php echo $product_data['mat_summary']; ?>
            </div>
          </div>
          <?php if(!empty($product_data['mat_options'])){
            foreach($product_data['mat_options'] as $option){ ?>
              <div class="row row-2 expand-material" data-target="<?php echo $option->post_name; ?>">
                <div class="col-12">
                  <div class="title">
                    <?php echo $option->post_title; ?>
                  </div>
                </div>
              </div>
              <div class="row-3" id="<?php echo $option->post_name; ?>">
                <div class="d-flex row">
                  <?php $size = get_field('size', $option->ID);
                  $class = 'col-6 col-sm-3 col-lg-2';
                  if($size == 'wide'){
                    $class = 'col-12 col-sm-6 col-lg-4';
                  }
                  $material_collection = get_field('material_collection', $option->ID);
                  if(!empty($material_collection)){
                    foreach($material_collection as $coll){ ?>
                      <div class="<?php echo $class; ?>">
                        <div class="material-item">
                          <img src="<?php echo $coll['image']['url']; ?>" />
                          <div class="label"><?php echo $coll['label']; ?></div>
                        </div>
                      </div>
                    <?php }
                  } else { ?>
                    <div class="col-12">
                      <p class="text-muted">No options available</p>
                    </div>
                  <?php } ?>
                </div>
              </div>
            <?php }
          } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="finish-collection">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h2>Finish the Collection</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="finish-collection-slider">
          <div class="item">
            <a href="#" class="thumb">
              <img src="<?php echo get_template_directory_uri(); ?>/img/temp-img-1.jpg" class="img-fluid" />
            </a>
            <div class="title">Bulle Chaise Lounge</div>
          </div>
          <div class="item">
            <a href="#" class="thumb">
              <img src="<?php echo get_template_directory_uri(); ?>/img/temp-img-1.jpg" class="img-fluid" />
            </a>
            <div class="title">Bulle Sofa</div>
          </div>
          <div class="item">
            <a href="#" class="thumb">
              <img src="<?php echo get_template_directory_uri(); ?>/img/temp-img-1.jpg" class="img-fluid" />
            </a>
            <div class="title">Bulle Armchair</div>
          </div>
          <div class="item">
            <a href="#" class="thumb">
              <img src="<?php echo get_template_directory_uri(); ?>/img/temp-img-1.jpg" class="img-fluid" />
            </a>
            <div class="title">Bulle Armchair</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
