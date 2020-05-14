<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
<meta charset="utf-8">

<title><?php wp_title(' | ', true, 'right'); ?><?php bloginfo('name'); ?></title>

<?php
$responsive = of_get_option( 'responsive');
 if ( $responsive == 'two' ) { ?>

<meta name="HandheldFriendly" content="True" />
<meta name="MobileOptimized" content="320" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php } else {}?>

<meta http-equiv="cleartype" content="on" />
<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
<!-- meta tags should be handled by SEO plugin. -->

<?php if ( of_get_option( 'favicon_logo' ) ) { ?>
    <link rel="shortcut icon" href="<?php echo of_get_option( 'favicon_logo' ); ?>" />
<?php } else { ?>
    <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri() ?>/images/favicon.ico" />
<?php }?>

<!-- 
<link rel="apple-touch-icon" href="images/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
-->

<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">

<?php wp_enqueue_script("jquery"); ?>
<?php wp_head(); ?>
<?php 
//wp_enqueue_script('my-script23', get_template_directory_uri() . '/js/modernizr.js', array('jquery'), '1.0', true);
//wp_enqueue_script('my-script24', get_template_directory_uri() . '/js/selectivizr.js', array('jquery'), '1.0', true);
wp_enqueue_script('my-script26', get_template_directory_uri() . '/js/docs.min.js', array('jquery'), '1.0', true);
wp_enqueue_script('my-script28', get_template_directory_uri() . '/js/equalizer.js', array('jquery'), '1.0', true);
wp_enqueue_script('my-script27', '//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js', array('jquery'), '1.0', true);
// wp_enqueue_script('my-script28', get_template_directory_uri() . '/js/fluidvids.min.js', array('jquery'), '1.0', true);

if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
?>


<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->


</head>

<body <?php body_class(); ?>>
<div id="wrap">