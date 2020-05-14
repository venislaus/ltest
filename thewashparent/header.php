<?php get_template_part( 'head' ); ?>

<body <?php body_class(); ?>>
<div id="wrap">
<div id="header" class="<?php echo of_get_option( 'nav_position' ); ?>">
<header class="container clearfix">

<nav class="navbar navbar-default" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- <a class="navbar-brand" href="<?php echo home_url(); ?>">
                <?php bloginfo('name'); ?>
            </a> -->
        </div> 

    <?php /* // this code is used to show shopping cart totals in the header ?>
    <!-- cloud Cart -->
    <div class="cart-top">
    <?php global $woocommerce; ?>
    <?php if (sizeof($woocommerce->cart->cart_contents)>0) { ?>
    <a class="cartcheckout" href="<?php echo $woocommerce->cart->get_checkout_url()?>" title="<?php _e('Checkout','woothemes') ?>"><?php _e('My Cart:','woothemes') ?>
    <a class="cartcontents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
    <?php }
    else { ?>
    <a class="cartcheckout" href="<?php echo $woocommerce->cart->get_checkout_url()?>" title="<?php _e('Checkout','woothemes') ?>"><?php _e('My Cart','woothemes') ?></a>
    <?php } ?>
    </div>
    <?php */ ?>

        <?php
            wp_nav_menu( array(
                'menu'              => 'primary',
                'theme_location'    => 'primary',
                'depth'             => 2,
                'container'         => 'div',
                'container_class'   => 'collapse navbar-collapse navbar-ex1-collapse',
                'menu_class'        => 'nav navbar-nav primary-nav',
                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                'walker'            => new wp_bootstrap_navwalker())
            );
        ?>
        <?php
             wp_nav_menu( array(
                'menu'              => 'secondary',
                'theme_location'    => 'secondary',
                'depth'             => 2,
                'container'         => 'div',
                'container_class'   => 'collapse navbar-collapse navbar-ex1-collapse',
                'menu_class'        => 'nav navbar-nav secondary-nav',
                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                'walker'            => new wp_bootstrap_navwalker())
        
            ); 
        ?>
</nav>

<h1 class="logo"><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
    <?php if ( of_get_option( 'branding_logo' ) ) { ?>
        <img src="<?php echo of_get_option( 'branding_logo' ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
    <?php } elseif (of_get_option( 'reseller_branding_logo' )) { ?>
        <img src="<?php echo of_get_option( 'reseller_branding_logo' ); ?>" alt="<?php bloginfo( 'name' ); ?>" />
    <?php } else { ?>
        <img src="<?php echo get_stylesheet_directory_uri() ?>/images/cloudlogo.png" alt="<?php bloginfo( 'name' ); ?>" />
    <?php }?>
</a></h1>

<?php if ( of_get_option( 'call_to_action_editor' ) || of_get_option( 'header_search_bar' ) || of_get_option( 'header_social_media' ) ) { ?>

<div class="call-to-action-header">

<?php if ( of_get_option( 'call_to_action_editor' ) ) { ?> <div class="call-to-action-text"><?php echo apply_filters('the_content', of_get_option( 'call_to_action_editor', 'no entry')); ?></div><?php } ?> 

<?php if ( of_get_option( 'header_search_bar' ) ) {  get_search_form(); } ?> 

<?php if ( of_get_option( 'header_social_media' ) ) { ?>
    <div class="social-media <?php if ( of_get_option( 'footer_social_color' ) ) {  echo 'social_color'; } ?> ">
        <?php if ( of_get_option( 'facebook_url' ) ) { ?><a href="<?php echo of_get_option( 'facebook_url' ); ?>" target="_blank"><span class="fa fa-facebook-square fa-2x social-facebook"></span></a><?php } ?>
        <?php if ( of_get_option( 'twitter_url' ) ) { ?><a href="<?php echo of_get_option( 'twitter_url' ); ?>" target="_blank"><span class="fa fa-twitter-square fa-2x social-twitter"></span></a><?php } ?>
        <?php if ( of_get_option( 'googleplus_url' ) ) { ?><a href="<?php echo of_get_option( 'googleplus_url' ); ?>" target="_blank"><span class="fa fa-google-plus-square fa-2x social-google"></span></a><?php } ?>
        <?php if ( of_get_option( 'linkedin_url' ) ) { ?><a href="<?php echo of_get_option( 'linkedin_url' ); ?>" target="_blank"><span class="fa fa-linkedin-square fa-2x social-linkedin"></span></a><?php } ?>
        <?php if ( of_get_option( 'youtube_url' ) ) { ?><a href="<?php echo of_get_option( 'youtube_url' ); ?>" target="_blank"><span class="fa fa-youtube-square fa-2x social-youtube"></span></a><?php } ?>
        <?php if ( of_get_option( 'vimeo_url' ) ) { ?><a href="<?php echo of_get_option( 'vimeo_url' ); ?>" target="_blank"><span class="fa fa-vimeo-square fa-lg social-vimeo"></span></a><?php } ?>
        <?php if ( of_get_option( 'pinterest_url' ) ) { ?><a href="<?php echo of_get_option( 'pinterest_url' ); ?>" target="_blank"><span class="fa fa-pinterest-square fa-2x social-pinterest"></span></a><?php } ?>
        <?php if ( of_get_option( 'instagram_url' ) ) { ?><a href="<?php echo of_get_option( 'instagram_url' ); ?>" target="_blank"><span class="fa fa-instagram fa-2x social-instagram"></span></a><?php } ?>
        <?php if ( of_get_option( 'rss_social_media' ) ) { ?><a href="/feed/" target="_blank"><span class="fa fa-rss-square fa-2x social-rss"></span></a><?php } ?>
    </div>

<?php } ?>
</div><!-- end call to action -->
<?php } ?>

</header>
</div>