
<?php 
	wp_enqueue_script("jquery");
  	wp_enqueue_script('my-script', get_template_directory_uri() . '/js/jquery.cycle2.min.js', array('jquery'), '1.0', true);
?>


<div class="slideshow cycle-slideshow slideshow-main-slider" data-cycle-fx="<?php echo of_get_option( 'cycle_fx', 'no entry' ); ?>" data-cycle-pause-on-hover="<?php echo of_get_option( 'cycle_pause', 'no entry' ); ?>" data-cycle-speed="<?php echo of_get_option( 'cycle_speed', 'no entry' ); ?>" data-cycle-timeout="<?php echo of_get_option( 'cycle_timeout', 'no entry' ); ?>" data-cycle-slides="> div" data-cycle-prev="#prev" data-cycle-next="#next" data-cycle-pager="#main-slider-pager" data-cycle-pager-template="<a href=#> {{slideNum}} </a>">
 <?php $slideramount = (int)of_get_option('slider_amount', 0); ?>
   
  <?php for($i = 1; $i <= $slideramount; $i++){  
       ?>

    
    <?php if (of_get_option( "slider_{$i}_link}" ) || of_get_option( "slider_{$i}_image" ) || of_get_option( "slider_{$i}_content" ) ) { ?>

    <div class="slide<?php echo $i; ?>"> 
                    <?php if ( of_get_option( "slider_{$i}_image" ) ) { ?><style>.slide<?php echo $i;?>{background-image: url(<?php echo of_get_option( "slider_{$i}_image" ) ?>);}</style><?php } ?>
                    <?php if (of_get_option( "slider_{$i}_link" ) ) { ?><a href="<?php echo of_get_option( "slider_{$i}_link" ); ?>"><?php } ?>
                    <?php if ( of_get_option( "slider_{$i}_content" ) ) { ?><div class="slider_content container"><?php echo apply_filters('the_content', of_get_option( "slider_{$i}_content", 'no entry')); ?></div><?php } else { ?><div class="slider_content container">&nbsp;</div> <?php } ?>
                    <?php if (of_get_option( "slider_{$i}_link" ) ) { ?></a><?php } ?>
    </div>

    <?php } else { ?>
            <div><img src="<?php echo get_stylesheet_directory_uri() ?>/images/slide.jpg"></div>
    <?php } ?>
<?php }?>

	


</div><!-- end of slider -->
<?php if(of_get_option('pagination')) { ?><div id="main-slider-pager" class="center"></div><?php } ?>
<?php if(of_get_option('nav-arrows')) { ?><div class="prev-next" id="main-slider-prev-next"><span id="prev">&laquo; Prev </span><span id="next"> Next &raquo;</span></div><?php } ?>