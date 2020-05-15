<?php $footer_data = array(
  'footer_logo' => get_field('footer_logo', 'options'),
  'footer_subtitle' => get_field('footer_subtitle', 'options'),
  'footer_left_column' => get_field('footer_left_column', 'options'),
  'footer_center_column' => get_field('footer_center_column', 'options'),
  'footer_right_column' => get_field('footer_right_column', 'options'),
  'footer_social_links' => get_field('footer_social_links', 'options'),
); ?>
    <footer>
      <div class="footer-1">
        <div class="container text-center">
          <img src="<?php echo $footer_data['footer_logo']; ?>" class="logo" />
          <div class="line"><?php echo $footer_data['footer_subtitle']; ?></div>
        </div>
      </div>
      <div class="footer-2">
        <div class="container">
          <div class="row">
            <div class="col-12 col-lg-3 contact-info">
              <div class="address">
                <?php echo $footer_data['footer_left_column']['address']; ?>
              </div>
              <div class="email"><a href="mailto:<?php echo $footer_data['footer_left_column']['email']; ?>"><?php echo $footer_data['footer_left_column']['email']; ?></a></div>
              <div class="phone"><?php echo $footer_data['footer_left_column']['phone']; ?></div>
            </div>
            <div class="col-12 col-lg-4 design-consultation">
              <h5><?php echo $footer_data['footer_center_column']['title']; ?></h5>
              <div class="summary"><?php echo $footer_data['footer_center_column']['summary']; ?></div>
              <a href="<?php echo home_url(); ?>/contact-us" class="btn btn-black-border">Book a Consultation</a>
            </div>
            <div class="col-12 col-lg-5 subscribe">
              <h5><?php echo $footer_data['footer_right_column']['title']; ?></h5>
              <div class="summary"><?php echo $footer_data['footer_right_column']['summary']; ?></div>
              <?php echo do_shortcode('[contact-form-7 id="226" title="Footer Subscribe"]'); ?>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-3">
        <div class="container">
          <div class="row">
            <div class="col-12">
              <ul>
                <li><a href="<?php echo $footer_data['footer_social_links']['facebook']; ?>">Facebook</a></li>
                <li><a href="<?php echo $footer_data['footer_social_links']['instagram']; ?>">Instagram</a></li>
                <li><a href="<?php echo $footer_data['footer_social_links']['pinterest']; ?>">Pinterest</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script
      src="https://code.jquery.com/jquery-3.5.0.min.js"
      integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ="
      crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/vendor/slick/slick.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/main.js?v=<?php echo rand(); ?>"></script>
    <?php wp_footer(); ?>
    <script>
    $(document).ready(function(){
      catFilters();
      fetchSearch();
    });
    var catFilter = [];
    // manage category filters
    function catFilters(){
      var queryVars = getUrlVars();
      if(queryVars['subcategory'] != undefined){
        if( queryVars['subcategory'].length > 0){
          var subCats = queryVars['subcategory'].split('+');
        }
        $.each(subCats, function(i, item){
          catFilter.push({value: item});
        });
        updateFilteredProducts();
      }
      $('body').delegate('li.filter-item-remove a','click', function(){
        var itemVal = $(this).parent().data('value');
        $('li.filter-item[data-value="'+itemVal+'"]').removeClass('active');
        catFilter = $.grep(catFilter, function(item) {
          return item.value != itemVal;
        });
        updateFilteredProducts();
      });
      $('li.filter-item').click(function(){
        var itemVal = $(this).data('value');
        if( $(this).hasClass('active') ){
          catFilter = $.grep(catFilter, function(item) {
            return item.value != itemVal;
          });
        } else {
          catFilter.push({value: itemVal});
        }
        updateFilteredProducts();
      });
    }
    function updateFilteredProducts(){
      // ajax call
      var data = {
        'action' : 'get_category_products',
        'category': catFilter
      };
      $.post( '<?php echo admin_url( 'admin-ajax.php' ); ?>', data, function( response ) {
        var query = '?subcategory=';
        $('li.filter-item-remove').removeClass('active');
        $('li.filter-item').removeClass('active');
        $.each(catFilter, function(i, item){
          query += item.value+'+';
          $('li.filter-item[data-value="'+item.value+'"]').addClass('active');
          $('li.filter-item-remove[data-value="'+item.value+'"]').addClass('active');
        });
        query = query.slice(0,-1);

        let newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + query;
        window.history.pushState({path: newurl}, '', newurl);

        //location.hash = query;
      });
    }
    function fetchSearch(){
      $('#findProduct').on('keyup', function(){
        var val = $(this).val();
        if( val.length >= 3){
          $('.search-result').fadeIn();
          $('#resultDisplay').html('<div class="py-4">Searching...</div>');
          var data = {
            'action' : 'search_products',
            'find': val
          };
          $.post( '<?php echo admin_url( 'admin-ajax.php' ); ?>', data, function( response ) {
            response = JSON.parse(response);
            if(response.length > 0) {
              var html = '<ul>';
              $.each(response,function(index, item){
                html +='<li><a href="'+item.link+'"><span>'+item.title+'</span><span>'+item.category+'</span></a></li>';
              });
              html +='</ul>';
            } else {
              html = '<div class="py-4">No products found</div>';
            }
            $('#resultDisplay').html(html);
          });
        } else {
          $('.search-result').fadeOut();
          $('#resultDisplay').html('');
        }
      });
      $('#mobFindProduct').on('keyup', function(){
        var val = $(this).val();
        if( val.length >= 3){
          $('.mob-search-result').fadeIn();
          $('#mobResultDisplay').html('<div class="py-4 text-center text-white">Searching...</div>');
          var data = {
            'action' : 'search_products',
            'find': val
          };
          $.post( '<?php echo admin_url( 'admin-ajax.php' ); ?>', data, function( response ) {
            response = JSON.parse(response);
            if(response.length > 0) {
              var html = '<ul>';
              $.each(response,function(index, item){
                html +='<li><a href="'+item.link+'"><span>'+item.title+'</span><span>'+item.category+'</span></a></li>';
              });
              html +='</ul>';
            } else {
              html = '<div class="py-4 text-center text-white">No products found</div>';
            }
            $('#mobResultDisplay').html(html);
          });
        } else {
          $('.mob-search-result').fadeOut();
          $('#mobResultDisplay').html('');
        }
      });
    }
    </script>
  </body>
</html>
