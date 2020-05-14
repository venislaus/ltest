<div id="footer">
<footer class="container clearfix">

<?php $footernav = of_get_option( 'footer_menu', 'no entry' ); 

if ($footernav == left) { wp_nav_menu( array( 'theme_location' => 'footer_menu', 'container' => 'nav', 'menu_class' => 'footer_nav left', 'depth' => '1'  ) ); }
if ($footernav == right) { wp_nav_menu( array( 'theme_location' => 'footer_menu', 'container' => 'nav', 'menu_class' => 'footer_nav right', 'depth' => '1'  ) ); }
if ($footernav == center) { ?>
 
<nav id="menu-footer-top" class="footer_nav">
<?php 
//Use this menu when you need to center the footer navigation
// this creates <nav><a href="">link1</a><a href="">link2</a><a href="">link3</a></nav> code
// still controled with the appearances -- menus page
$menuParameters = array(
  'theme_location' => 'footer_menu',
  'container'       => false,
  'echo'            => false,
  'items_wrap'      => '%3$s',
  'depth'           => 1,
);

echo strip_tags(wp_nav_menu( $menuParameters ), '<a>' );
?>
</nav>

<?php } /* end of footer nav */ ?> 

<?php $widget_number = of_get_option( 'widget_number', 'no entry' ); 

if ($widget_number == one) {$i = 1;}
if ($widget_number == two) {$i = 2;}
if ($widget_number == three) {$i = 4;}
if ($widget_number == four) {$i = 4;}
if ($widget_number == five) {$i = 5;}
if ($i) {
for ($x=1; $x<=$i; $x++) { ?>
	<div class="footer-widget-<?php echo $x?> col-sm-<?php echo $i?>">
	<?php 
		if ($x == 1) {$j = one;}
		if ($x == 2) {$j = two;}
		if ($x == 3) {$j = three;}
		if ($x == 4) {$j = four;}
		if ($x == 5) {$j = five;}
	
	?>
		<?php dynamic_sidebar( $j ) ?>
	</div>
<?php }} else {} ?>


</footer>
</div>

<div id="footer2">
<div class="container clearfix">

<p class="copy">Copyright &copy; <?php echo date("Y"); ?> <?php bloginfo('name'); ?>. All Rights Reserved.</p>
<?php if ( of_get_option( 'footer_search_bar' ) || of_get_option( 'footer_social_media' ) || of_get_option( 'call_to_action_footer' ) ) { ?>

<div class="call-to-action-footer">

<?php if ( of_get_option( 'call_to_action_footer' ) ) { ?> <div class="call-to-action-text-footer"><?php echo apply_filters('the_content', of_get_option( 'call_to_action_footer', 'no entry')); ?></div><?php } ?> 

<?php if ( of_get_option( 'footer_search_bar' ) ) {  get_search_form(); } ?> 

<?php if ( of_get_option( 'footer_social_media' ) ) { ?>
	<div class="social-media-footer <?php if ( of_get_option( 'footer_social_color' ) ) {  echo 'social_color'; } ?> ">
		<?php if ( of_get_option( 'facebook_url' ) ) { ?><a href="<?php echo of_get_option( 'facebook_url' ); ?>" target="_blank"><span class="fa fa-facebook fa-2x social-facebook"></span></a><?php } ?>
		<?php if ( of_get_option( 'twitter_url' ) ) { ?><a href="<?php echo of_get_option( 'twitter_url' ); ?>" target="_blank"><span class="fa fa-twitter fa-2x social-twitter"></span></a><?php } ?>
		<?php if ( of_get_option( 'googleplus_url' ) ) { ?><a href="<?php echo of_get_option( 'googleplus_url' ); ?>" target="_blank"><span class="fa fa-google-plus fa-2x social-google"></span></a><?php } ?>
		<?php if ( of_get_option( 'linkedin_url' ) ) { ?><a href="<?php echo of_get_option( 'linkedin_url' ); ?>" target="_blank"><span class="fa fa-linkedin fa-2x social-linkedin"></span></a><?php } ?>
		<?php if ( of_get_option( 'youtube_url' ) ) { ?><a href="<?php echo of_get_option( 'youtube_url' ); ?>" target="_blank"><span class="fa fa-youtube fa-2x social-youtube"></span></a><?php } ?>
		<?php if ( of_get_option( 'vimeo_url' ) ) { ?><a href="<?php echo of_get_option( 'vimeo_url' ); ?>" target="_blank"><span class="fa fa-vimeo fa-lg social-vimeo"></span></a><?php } ?>
		<?php if ( of_get_option( 'pinterest_url' ) ) { ?><a href="<?php echo of_get_option( 'pinterest_url' ); ?>" target="_blank"><span class="fa fa-pinterest fa-2x social-pinterest"></span></a><?php } ?>
		<?php if ( of_get_option( 'instagram_url' ) ) { ?><a href="<?php echo of_get_option( 'instagram_url' ); ?>" target="_blank"><span class="fa fa-instagram fa-2x social-instagram"></span></a><?php } ?>
		<?php if ( of_get_option( 'rss_social_media' ) ) { ?><a href="/feed/" target="_blank"><span class="fa fa-rss fa-2x social-rss"></span></a><?php } ?>
	</div>

<?php } ?>

</div><!-- end call to action -->

<?php } ?>
</div>
</div>
</div> <!-- end wrap -->

<?php echo of_get_option( 'footer_scripts' )?>

<?php wp_footer(); ?>
</body>
</html>