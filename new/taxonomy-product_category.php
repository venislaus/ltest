<?php get_header(); ?>
<div class="nav-spacer"></div>
<h2 class="head2-1 text-left d-block d-lg-none text-center">Sofas and Lounges</h2>
<div class="header">
  <img src="<?php echo get_template_directory_uri(); ?>/img/sofas-and-lounges-banner.jpg" class="img-fluid mh-300" />
</div>

<div class="product-cat-page">
  <div class="container d-none d-lg-block">
    <div class="row title">
      <div class="col-12">
        <h2 class="head2-1 text-left">Sofas and Lounges</h2>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-12">
        <div class="toggle-filter">
          <a href="JavaScript:void(0);">
            <div class="bars">
              <span></span>
              <span></span>
              <span></span>
            </div> Filter
          </a>
        </div>
        <div class="sidebar">
          <div class="filters">
            <h5>Category</h5>
            <ul>
              <li class="filter-item" data-value="sofas" data-label="Sofas"><input type="checkbox" /> <span class="mark"></span> <span>Sofas</span></li>
              <li class="filter-item" data-value="long-corner" data-label="Long Corner"><input type="checkbox" /> <span class="mark"></span> <span>Long Corner</span></li>
              <li class="filter-item" data-value="long-middle" data-label="Long Middle"><input type="checkbox" /> <span class="mark"></span> <span>Long Middle</span></li>
              <li class="filter-item" data-value="chasie-lounge" data-label="Chasie Lounge"><input type="checkbox" /> <span class="mark"></span> <span>Chasie Lounge</span></li>
              <li class="filter-item" data-value="others" data-label="Others"><input type="checkbox" /> <span class="mark"></span> <span>Others</span></li>
            </ul>
          </div>
          <div class="active-filters">
            <h5>Active Filter</h5>
            <ul class="active-filters-list">
              <li class="filter-item-remove" data-value="sofas" data-label="Sofas"><a href="Javascript:void(0);">X</a> Sofas</li>
              <li class="filter-item-remove" data-value="long-corner" data-label="Long Corner"><a href="Javascript:void(0);">X</a> Long Corner</li>
              <li class="filter-item-remove" data-value="long-middle" data-label="Long Middle"><a href="Javascript:void(0);">X</a> Long Middle</li>
              <li class="filter-item-remove" data-value="chasie-lounge" data-label="Chasie Lounge"><a href="Javascript:void(0);">X</a> Chasie Lounge</li>
              <li class="filter-item-remove" data-value="others" data-label="Others"><a href="Javascript:void(0);">X</a> Others</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-lg-9 col-12">
        <div class="row products-list">
          <?php for($i = 1; $i <= 9; $i++){ ?>
            <div class="col-lg-4 col-md-6 col-6 px-0">
              <div class="item">
                <div class="thumb" style="background-image:url('<?php echo get_template_directory_uri(); ?>/img/product-image.jpg');"></div>
                <div class="product-title">Teak Long Corner</div>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="pagination">
          <ul>
            <li class="angle-icon"><a href="#"><i class="fa fa-angle-left"></i></a></li>
            <li><a href="#" class="active">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li class="angle-icon"><a href="#"><i class="fa fa-angle-right"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
