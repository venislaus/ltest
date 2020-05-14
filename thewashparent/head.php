<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
<meta charset="utf-8">

<title><?php wp_title(); ?></title>

<meta name="HandheldFriendly" content="True" />
<meta name="MobileOptimized" content="320" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="cleartype" content="on" />
<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />

<!-- meta tags should be handled by SEO plugin. -->

<?php if ( of_get_option( 'favicon_logo' ) ) { ?>
    <link rel="shortcut icon" href="<?php echo of_get_option( 'favicon_logo' ); ?>" />
<?php } elseif (of_get_option( 'reseller_favicon_logo' )) { ?>
    <link rel="shortcut icon" href="<?php echo of_get_option( 'reseller_favicon_logo' ); ?>" />
<?php } else { ?>
    <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri() ?>/images/favicon.ico" />
<?php }?>

<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

<?php wp_enqueue_script("jquery"); ?>
<?php wp_head(); ?>
<?php 
	wp_enqueue_script('cloud-image-doc', get_template_directory_uri() . '/js/docs.min.js', array('jquery'), '1.0', true);
	wp_enqueue_script('cloud-bootstrap-js', '//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js', array('jquery'), '1.0', true);
	wp_enqueue_script('lightbox-min', get_template_directory_uri() . '/js/lightbox.min.js', array('jquery'), '1.0', true);
	if ( is_singular() ) wp_enqueue_script( 'comment-reply' );
?>


<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
<![endif]-->

<?php echo of_get_option( 'header_scripts' )?>


</head>